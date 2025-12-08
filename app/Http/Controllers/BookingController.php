<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use App\Models\Pengunjung;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class BookingController extends Controller
{
    // ==================================================
    // =================== INDIVIDU =====================
    // ==================================================

    public function bookingIndividu(Request $request)
    {
        // 1. Tangkap parameter dari URL
        $roomId = $request->query('kamar');
        $checkinParam = $request->query('checkin');
        $checkoutParam = $request->query('checkout');
        $jumlahKamarParam = $request->query('jumlah_kamar');

        // 2. LOGIKA PENCARIAN KAMAR
        // Coba cari berdasarkan kode_kamar (misal "STD-01")
        $selectedRoom = \App\Models\Kamar::where('kode_kamar', $roomId)->first();
        
        // Jika tidak ketemu, coba cari berdasarkan ID angka (misal "4")
        if (!$selectedRoom && is_numeric($roomId)) {
            $selectedRoom = \App\Models\Kamar::find($roomId);
        }

        // 3. VALIDASI TERAKHIR
        if (!$selectedRoom) {
            return redirect('/')->with('error', 'Kamar tidak ditemukan.');
        }

        // 4. KIRIM KE VIEW
        return view('booking.individu', [
            'selectedRoom' => $selectedRoom,
            'checkin'      => $checkinParam,
            'checkout'     => $checkoutParam,
            'jumlah_kamar' => $jumlahKamarParam
        ]);
    }

    public function storeIndividu(Request $request)
    {
        $request->validate([
            'nama'            => 'required|string',
            'no_identitas'    => ['required','string','regex:/^[0-9]+$/'],
            'check_in'        => 'required|date',
            'check_out'       => 'required|date|after:check_in',
            'no_telp'         => ['required','string','regex:/^[0-9+\- ]+$/'],
            'jumlah_peserta'  => 'nullable|integer|min:1',
            'jumlah_kamar'    => 'required|integer|min:1', 
            'special_request' => 'nullable|string',
            'bukti_identitas' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'kode_kamar'      => 'required', 
        ]);

        // 1. Upload Bukti Identitas
        $buktiIdentitasPath = null;
        if ($request->hasFile('bukti_identitas')) {
            $buktiIdentitasPath = $request->file('bukti_identitas')->store('bukti_identitas', 'public');
        }

        // 2. Ambil Kamar Utama (Yang dipilih user di awal)
        $kamarUtama = Kamar::where('kode_kamar', $request->kode_kamar)->first();
        if (!$kamarUtama && is_numeric($request->kode_kamar)) {
            $kamarUtama = Kamar::find($request->kode_kamar);
        }

        if (!$kamarUtama) {
            return back()->withErrors(['kode_kamar' => 'Kamar utama tidak ditemukan.']);
        }

        // 3. LOGIKA OTOMATIS CARI KAMAR TAMBAHAN
        // Ini agar jika user pesan 3 kamar, sistem mencarikan 2 kamar lain.
        $jumlahDiminta = (int) $request->jumlah_kamar;
        $kamarFinalList = [$kamarUtama->kode_kamar]; // Mulai dengan kamar utama

        // Jika minta lebih dari 1 kamar
        if ($jumlahDiminta > 1) {
            $butuhTambahan = $jumlahDiminta - 1;

            // Cari kamar lain: Jenis SAMA, Status KOSONG, Bukan Kamar Utama
            $kamarTambahan = Kamar::where('jenis_kamar', $kamarUtama->jenis_kamar)
                ->where('status', 'kosong') 
                ->where('kode_kamar', '!=', $kamarUtama->kode_kamar)
                ->take($butuhTambahan)
                ->pluck('kode_kamar')
                ->toArray();

            // Cek apakah jumlahnya cukup?
            if (count($kamarTambahan) < $butuhTambahan) {
                // KEMBALIKAN ERROR jika kamar tidak cukup
                $sisa = count($kamarTambahan) + 1; // +1 punya dia sendiri
                return back()->withErrors([
                    'jumlah_kamar' => "Mohon maaf, stok kamar tidak cukup. Anda meminta $jumlahDiminta kamar, tapi hanya tersedia $sisa kamar untuk tipe ini."
                ])->withInput();
            }

            // Gabungkan kamar utama + tambahan
            $kamarFinalList = array_merge($kamarFinalList, $kamarTambahan);
        }

        // 4. Buat String Kode Kamar (Contoh: "STD-01,STD-02,STD-03")
        $kamarString = implode(',', $kamarFinalList);

        // 5. Simpan ke Database
        $pengunjung = Pengunjung::create([
            'nama'            => $request->nama,
            'jenis_tamu'      => 'individu',
            'no_identitas'    => $request->no_identitas,
            'check_in'        => $request->check_in,
            'check_out'       => $request->check_out,
            'no_telp'         => $this->normalizePhone($request->no_telp),
            'jumlah_peserta'  => $request->input('jumlah_peserta', 1),
            'jumlah_kamar'    => $jumlahDiminta, // Simpan jumlah sesuai permintaan
            'kode_kamar'      => $kamarString,   // Simpan list semua kamar
            'special_request' => $request->special_request,
            'bukti_identitas' => $buktiIdentitasPath,
            'payment_status'  => 'pending',
            
        ]);

        // 6. Update Status Semua Kamar Jadi Terisi
        Kamar::whereIn('kode_kamar', $kamarFinalList)->update(['status' => 'terisi']);

        return redirect()->route('booking.payment', $pengunjung->id);
    }

    private function normalizePhone($phone)
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);
        if (substr($phone, 0, 1) === '0') {
            $phone = '62' . substr($phone, 1);
        }
        if (!str_starts_with($phone, '62')) {
            $phone = '62' . $phone;
        }
        return $phone;
    }

    // ==================================================
    // =================== CORPORATE ====================
    // ==================================================

    public function bookingCorporate(Request $request)
    {
        $roomId = $request->query('kamar');
        $checkinParam = $request->query('checkin');
        $checkoutParam = $request->query('checkout');
        $jumlahKamarParam = $request->query('jumlah_kamar');

        $selectedRoom = Kamar::where('kode_kamar', $roomId)->first();
        if (!$selectedRoom && is_numeric($roomId)) {
            $selectedRoom = Kamar::find($roomId);
        }

        if (!$selectedRoom) {
            return redirect('/')->with('error', 'Kamar tidak ditemukan.');
        }

        $kamars = Kamar::where('status', 'kosong')->get();

        return view('booking.corporate', [
            'kamars'       => $kamars,
            'selectedRoom' => $selectedRoom,
            'checkin'      => $checkinParam,
            'checkout'     => $checkoutParam,      
            'jumlah_kamar' => $jumlahKamarParam   
        ]);
    }

public function storeCorporate(Request $request)
    {
        $request->validate([
            'nama_pic'              => 'required|string',
            'no_identitas'          => 'required|string',
            'asal_persyarikatan'    => 'nullable|string',
            'tanggal_persyarikatan' => 'nullable|date',
            'nama_kegiatan'         => 'nullable|string',
            'no_telp_pic'           => ['required','string','regex:/^[0-9+\- ]+$/'],
            'check_in'              => 'required|date',
            'check_out'             => 'required|date|after:check_in',
            'jumlah_peserta'        => 'nullable|integer|min:1',
            'jumlah_kamar'          => 'required|integer|min:1', // Wajib ada jumlahnya
            'bukti_identitas'       => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'jenis_tamu'            => 'required|in:individu,corporate',
            'special_request'       => 'nullable|string',
            'kode_kamar'            => 'required', // Cukup kode kamar utama
        ]);

        // 1. Upload Bukti Identitas
        $buktiIdentitasPath = null;
        if ($request->hasFile('bukti_identitas')) {
            $buktiIdentitasPath = $request->file('bukti_identitas')->store('bukti_identitas', 'public');
        }

        // 2. Ambil Kamar Utama (Yang dipilih user di awal)
        $kamarUtama = Kamar::where('kode_kamar', $request->kode_kamar)->first();
        if (!$kamarUtama && is_numeric($request->kode_kamar)) {
            $kamarUtama = Kamar::find($request->kode_kamar);
        }

        if (!$kamarUtama) {
            return back()->withErrors(['kode_kamar' => 'Kamar utama tidak ditemukan.']);
        }

        // 3. LOGIKA OTOMATIS CARI KAMAR TAMBAHAN (Sama seperti Individu)
        $jumlahDiminta = (int) $request->jumlah_kamar;
        $kamarFinalList = [$kamarUtama->kode_kamar]; // Mulai dengan kamar utama

        // Jika minta lebih dari 1 kamar
        if ($jumlahDiminta > 1) {
            $butuhTambahan = $jumlahDiminta - 1;

            // Cari kamar lain: Jenis SAMA, Status KOSONG, Bukan Kamar Utama
            $kamarTambahan = Kamar::where('jenis_kamar', $kamarUtama->jenis_kamar)
                ->where('status', 'kosong') 
                ->where('kode_kamar', '!=', $kamarUtama->kode_kamar)
                ->take($butuhTambahan)
                ->pluck('kode_kamar')
                ->toArray();

            // Cek Stok: Kalau cuma ketemu dikit padahal butuh banyak, Error!
            if (count($kamarTambahan) < $butuhTambahan) {
                $sisa = count($kamarTambahan) + 1;
                return back()->withErrors([
                    'jumlah_kamar' => "Mohon maaf, stok kamar tidak cukup. Anda meminta $jumlahDiminta kamar, tapi hanya tersedia $sisa kamar untuk tipe ini."
                ])->withInput();
            }

            $kamarFinalList = array_merge($kamarFinalList, $kamarTambahan);
        }

        $kamarString = implode(',', $kamarFinalList);

        // 4. Simpan ke Database
        $pengunjung = Pengunjung::create([
            'nama_pic'              => $request->nama_pic,
            'no_identitas'          => $request->no_identitas,
            'jenis_tamu'            => 'corporate',
            'asal_persyarikatan'    => $request->asal_persyarikatan,
            'tanggal_persyarikatan' => $request->tanggal_persyarikatan,
            'nama_kegiatan'         => $request->nama_kegiatan,
            'no_telp'               => $this->normalizePhone($request->no_telp_pic),
            'check_in'              => $request->check_in,
            'check_out'             => $request->check_out,
            'jumlah_peserta'        => $request->jumlah_peserta ?? 1,
            
            'jumlah_kamar'          => $jumlahDiminta, // Simpan jumlah sesuai permintaan
            'kode_kamar'            => $kamarString,   // Simpan list kamar otomatis "GR-01,GR-02,..."
            
            'special_request'       => $request->special_request,
            'bukti_identitas'       => $buktiIdentitasPath,
            'payment_status'        => 'pending',
            // Metode pembayaran nanti di halaman payment
        ]);

        // 5. Update Status Kamar
        Kamar::whereIn('kode_kamar', $kamarFinalList)->update(['status' => 'terisi']);

        return redirect()->route('booking.payment', $pengunjung->id);
    }

    // ==================================================
    // ====================== PAYMENT ===================
    // ==================================================

    public function payment($id)
    {
        $pengunjung = Pengunjung::findOrFail($id);
        
        // Ambil kamar pertama untuk referensi harga/tipe
        $kodeList = array_map('trim', explode(',', $pengunjung->kode_kamar));
        $kodePertama = $kodeList[0] ?? null;

        $kamar = Kamar::where('kode_kamar', $kodePertama)->first();
        // Fallback cari by ID
        if (!$kamar && is_numeric($kodePertama)) {
            $kamar = Kamar::find($kodePertama);
        }

        // Hitung durasi menginap
        $durasi = Carbon::parse($pengunjung->check_in)
                    ->diffInDays(Carbon::parse($pengunjung->check_out));
        if ($durasi == 0) $durasi = 1;

        // AMBIL jumlah kamar
        $jumlahKamar = $pengunjung->jumlah_kamar ?? 1;

        // Hitung harga kamar TOTAL
        $totalKamar = 0;
        if ($kamar) {
            $totalKamar = $kamar->harga * $durasi * $jumlahKamar;
        }

        return view('booking.payment', [
            'pengunjung'      => $pengunjung,
            'kamar'           => $kamar,
            'durasi'          => $durasi,
            'totalKamar'      => $totalKamar,
            'totalPembayaran' => $totalKamar,
        ]);
    }

    // ==================================================
    // ====================== SUCCESS ===================
    // ==================================================

    public function success($id)
    {
        $pengunjung = Pengunjung::findOrFail($id);

        // Ambil kamar pertama (untuk info tampilan)
        $kamarIds = explode(',', $pengunjung->kode_kamar);
        $first = trim($kamarIds[0]);

        $kamar = Kamar::where('kode_kamar', $first)->first() 
                ?? Kamar::find($first);

        // Hitung durasi
        $durasi = Carbon::parse($pengunjung->check_in)
                    ->diffInDays(Carbon::parse($pengunjung->check_out));
        if ($durasi == 0) $durasi = 1;

        // TOTAL FIX
        $totalPembayaran = 0;
        if($kamar) {
            $totalPembayaran = $kamar->harga * $pengunjung->jumlah_kamar * $durasi;
        }

        return view('booking.success', compact(
            'pengunjung',
            'kamar',
            'durasi',
            'totalPembayaran'
        ));
    }

    // ==================================================
    // =================== UPLOAD PAYMENT ===============
    // ==================================================

    public function uploadBuktiPembayaran(Request $request, $id)
    {
        $request->validate([
            'bukti_pembayaran'  => 'required|mimes:jpg,jpeg,png,pdf|max:2048',
            'metode_pembayaran' => 'nullable|string', 
        ]);

        $pengunjung = Pengunjung::findOrFail($id);

        $path = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');

        // Hitung total harga kamar
        $totalHarga = $this->calculateTotalHarga($pengunjung);

        $pengunjung->update([
            'bukti_pembayaran'  => $path,
            'payment_status'    => 'konfirmasi_booking',
            'total_harga'       => $totalHarga,
            // Simpan metode spesifik (Via ATM / Mobile Banking) yang dikirim view
            'metode_pembayaran' => $request->metode_pembayaran ?? 'Transfer Bank', 
        ]);

        return redirect()->route('booking.success', $id)->with('upload_success', true);
    }

    // ==================================================
    // =================== CONFIRM CASH =================
    // ==================================================
    
    public function confirmCash(Request $request, $id)
    {
        $pengunjung = Pengunjung::findOrFail($id);
        
        // Hitung total harga
        $totalHarga = $this->calculateTotalHarga($pengunjung);

        $pengunjung->update([
            'payment_status'    => 'konfirmasi_booking', // Langsung masuk antrian konfirmasi
            'total_harga'       => $totalHarga,
            'metode_pembayaran' => 'Via Cash', // Set manual
            'bukti_pembayaran'  => null,
        ]);

        return redirect()->route('booking.success', $id);
    }

    // ==================================================
    // =================== HELPER & PDF =================
    // ==================================================

    private function calculateTotalHarga(Pengunjung $pengunjung)
    {
        $kamarIds = explode(',', $pengunjung->kode_kamar);

        $checkIn  = Carbon::parse($pengunjung->check_in);
        $checkOut = Carbon::parse($pengunjung->check_out);
        $durasi   = $checkIn->diffInDays($checkOut);
        if ($durasi == 0) $durasi = 1;

        $totalKamar = 0;
        foreach ($kamarIds as $kid) {
            $km = Kamar::where('kode_kamar', trim($kid))->first();
            if (!$km && is_numeric($kid)) {
                $km = Kamar::find($kid);
            }
            if ($km) {
                $totalKamar += $km->harga * $durasi;
            }
        }

        return $totalKamar;
    }

    public function voucher($id)
    {
        $pengunjung = Pengunjung::findOrFail($id);

        $kamarIds = explode(',', $pengunjung->kode_kamar);
        $first = trim($kamarIds[0]);

        $kamar = Kamar::where('kode_kamar', $first)->first()
                ?? Kamar::find($first);

        $durasi = Carbon::parse($pengunjung->check_in)
                    ->diffInDays(Carbon::parse($pengunjung->check_out));
        if ($durasi == 0) $durasi = 1;

        $totalPembayaran = 0;
        if ($kamar) {
            $totalPembayaran = $kamar->harga * $pengunjung->jumlah_kamar * $durasi;
        }

        // Generate PDF
        $pdf = Pdf::loadView('booking.voucher', [
            'pengunjung' => $pengunjung,
            'kamar' => $kamar,
            'durasi' => $durasi,
            'totalPembayaran' => $totalPembayaran
        ])->setPaper('a4', 'portrait');

        $namaFile = 'INVOICE-' . ($pengunjung->nama ?? $pengunjung->nama_pic ?? 'tanpa-nama') . '.pdf';
        return $pdf->download($namaFile);
    }
}