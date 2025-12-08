@extends('layouts.app')

@section('content')
<style>
  :root{
    --peach:#f1cfc4;
    --primary:#a0203c;
    --primary-20:#e0b6c0;
    --white:#fff;
    --page:#fbf7f6;
    --radius:14px;
  }
  body{ background:var(--page); }

  /* Stepper */
  .stepper-box{ border:3px solid var(--primary); border-radius:18px; background:#fff; padding:14px 18px; display:flex; align-items:center; gap:22px; }
  .step{display:flex;align-items:center;gap:10px;flex:1;}
  .dot{width:20px;height:20px;border-radius:999px;background:var(--primary);}
  .dot.hollow{background:#fff;border:3px solid var(--primary);}
  .bar{height:10px;flex:1;background:var(--primary-20);border-radius:999px;position:relative;}
  .bar .fill{position:absolute;inset:0;background:var(--primary);}
  .step-pending .fill{background:var(--primary-20);}

  /* Cards */
  .card-outline{ background:#fff; border:2px solid rgba(160,32,60,.35); border-radius:18px; padding:18px; }
  .img-room{width:100%;height:230px;object-fit:cover;border-radius:14px;}
  label{font-weight:700;}
  .form-control,.form-select{ border:2px solid rgba(160,32,60,.45)!important; border-radius:var(--radius)!important; padding:.7rem .9rem; }
  .form-control[readonly] { background-color: #f8f9fa; cursor: not-allowed; }
  .btn-primary-maroon{ background:var(--primary);color:#fff;border:none; border-radius:12px;padding:.7rem 1.2rem;font-weight:700; }
  .btn-outline-maroon { display: inline-block; padding: 10px 24px; border-radius: 18px; border: 3px solid #9a2d3b; color: #9a2d3b !important; font-weight: 600; text-decoration: none; background-color: transparent; transition: 0.2s ease-in-out; }
  .btn-outline-maroon:hover { background-color: #9a2d3b; color: white !important; }
</style>

<div class="stepper-box mb-4">
  <div class="step step-complete">
    <span class="dot"></span><strong>Isi Data</strong>
    <div class="bar"><span class="fill"></span></div>
  </div>
  <div class="step step-complete">
    <span class="dot"></span><strong>Booking</strong>
    <div class="bar"><span class="fill"></span></div>
  </div>
  <div class="step step-pending">
    <span class="dot hollow"></span><strong>Payment</strong>
    <div class="bar"><span class="fill"></span></div>
  </div>
</div>

<form action="{{ route('booking.individu.store') }}" method="POST" enctype="multipart/form-data">
  @csrf
  <input type="hidden" name="jenis_tamu" value="individu">

  <div class="row g-4">

    <div class="col-lg-7">
      <div class="card-outline">
        <div class="mb-3">
          <label>Nama Lengkap</label>
          <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" required placeholder="Tulis nama lengkap">
          @error('nama') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="row">
          <div class="col-md-6 mb-3">
            <label>No Identitas (KTP/Paspor)</label>
            <input type="text" name="no_identitas" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '');" class="form-control" value="{{ old('no_identitas') }}" required placeholder="Nomor identitas">
            @error('no_identitas') <div class="text-danger small">{{ $message }}</div> @enderror
          </div>

          <div class="col-md-6 mb-3">
            <label>No Telepon</label>
            <input type="text" name="no_telp" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '');" class="form-control" value="{{ old('no_telp') }}" required placeholder="08xxxxxxxxxx">
            @error('no_telp') <div class="text-danger small">{{ $message }}</div> @enderror
          </div>
        </div>

        <div class="mb-3">
          <label>Jumlah Orang</label>
          <input type="number" name="jumlah_peserta" class="form-control" min="1" value="{{ old('jumlah_peserta', 1) }}" placeholder="Jumlah orang yang menginap">
          @error('jumlah_peserta') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
          <label>Upload Bukti Identitas <span style="color:red">*</span></label>
          <input type="file" name="bukti_identitas" class="form-control" accept=".jpg,.jpeg,.png" required>
          <small class="text-muted">Format: JPG, JPEG, PNG (Maks 2MB)</small>
          @error('bukti_identitas') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
          <label>Special Request</label>
          <textarea name="special_request" rows="4" class="form-control" placeholder="Tulis permintaan khusus (opsional)">{{ old('special_request') }}</textarea>
        </div>
        
        <div class="d-flex gap-3 mt-2">
             <button type="submit" class="btn-primary-maroon">Book now</button>
             <a href="{{ url()->previous() }}" class="btn-outline-maroon">Cancel</a>
        </div>
      </div>
    </div>

    <div class="col-lg-5">
      <div class="card-outline h-100">

        @php
          $fotoMap = [
            'Deluxe' => 'deluxe.jpg',
            'Guestroom AC' => 'Guestroom AC.jpeg',
            'Standard' => 'Standar Room.jpg',
            'Student AC' => 'Student AC.jpeg',
            'Student Non AC' => 'Student Non AC.jpg',
          ];
          $fotoKamar = $selectedRoom ? ($fotoMap[$selectedRoom->jenis_kamar] ?? 'default.jpg') : 'default.jpg';
        @endphp

        <img src="{{ asset('images/' . $fotoKamar) }}" class="img-room mb-3">

        <div class="d-flex justify-content-between align-items-center mb-2">
          <h4 class="fw-bold m-0">{{ $selectedRoom->jenis_kamar }}</h4>
          <span class="fw-bold">{{ number_format($selectedRoom->harga,0,',','.') }}/malam</span>
        </div>

        <input type="hidden" name="kode_kamar" value="{{ $selectedRoom->kode_kamar }}">
        <input type="hidden" name="jumlah_kamar" value="{{ $jumlah_kamar ?? 1 }}">

        <div class="alert alert-info py-2" style="font-size:0.9rem; background-color: #d1ecf1; border-color: #bee5eb; color: #0c5460;">
            <i class="fas fa-building"></i> Memesan: <strong>{{ $jumlah_kamar ?? 1 }} Kamar</strong>
        </div>

        <hr>
        
        <div class="mb-3">
          <label>Check-in</label>
          <input type="date" name="check_in" id="check_in" class="form-control" value="{{ old('check_in', $checkin) }}" required readonly style="background-color: #f8f9fa; pointer-events: none;">
          @error('check_in') <div class="text-danger small">{{ $message }}</div> @enderror
          <small class="text-muted">Tanggal sesuai pilihan di Beranda</small>
        </div>

        <div class="mb-3">
          <label>Check-out</label>
          <input type="date" name="check_out" id="check_out" class="form-control" value="{{ old('check_out', $checkout) }}" required readonly style="background-color: #f8f9fa; pointer-events: none;">
          @error('check_out') <div class="text-danger small">{{ $message }}</div> @enderror
          <small class="text-muted">Tanggal sesuai pilihan di Beranda</small>
        </div>

      </div>
    </div>

  </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const checkIn = document.getElementById("check_in");
    const checkOut = document.getElementById("check_out");
    const form = document.querySelector('form');
    
    if (form) {
        form.addEventListener('submit', function(e) {
            const nama = document.querySelector('[name="nama"]').value.trim();
            const noIdentitas = document.querySelector('[name="no_identitas"]').value.trim();
            const noTelp = document.querySelector('[name="no_telp"]').value.trim();
            const buktiIdentitas = document.querySelector('[name="bukti_identitas"]').files.length;

            if (!nama || !noIdentitas || !noTelp || buktiIdentitas === 0) {
                e.preventDefault();
                // Gunakan Swal jika ada, atau alert biasa
                if(typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Data Belum Lengkap',
                        text: 'Mohon lengkapi semua field wajib (Nama, Identitas, Bukti)',
                        confirmButtonColor: '#a0203c'
                    });
                } else {
                    alert('Mohon lengkapi semua field yang wajib diisi!');
                }
                return false;
            }
            
            const checkInDate = new Date(checkIn.value);
            const checkOutDate = new Date(checkOut.value);
            
            if (checkOutDate <= checkInDate) {
                e.preventDefault();
                if(typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Tanggal Tidak Valid',
                        text: 'Tanggal check-out harus setelah tanggal check-in',
                        confirmButtonColor: '#a0203c'
                    });
                } else {
                    alert('Tanggal check-out harus setelah tanggal check-in');
                }
                return false;
            }
        });
    }
});
</script>
@endsection