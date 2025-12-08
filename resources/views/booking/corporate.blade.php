@extends('layouts.app')

@section('content')
<style>
  :root{
    --peach:#f1cfc4;
    --primary:#a0203c;
    --primary-20:#e0b6c0;
    --page:#fbf7f6;
    --white:#fff;
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
  .form-control,.form-select,textarea{ border:2px solid rgba(160,32,60,.45)!important; border-radius:var(--radius)!important; padding:.7rem .9rem; }
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

<form action="{{ route('booking.corporate.store') }}" method="POST" enctype="multipart/form-data">
  @csrf
  <input type="hidden" name="jenis_tamu" value="corporate">

  <div class="row g-4">

    <div class="col-lg-7">
      <div class="card-outline">
        
        <div class="row">
          <div class="col-md-6 mb-3">
            <label>Nama Lengkap PIC</label>
            <input type="text" name="nama_pic" class="form-control" placeholder="Tulis nama lengkap PIC" value="{{ old('nama_pic') }}" required>
            @error('nama_pic') <div class="text-danger small">{{ $message }}</div> @enderror
          </div>
          <div class="col-md-6 mb-3">
            <label>No Telepon PIC</label>
            <input type="text" name="no_telp_pic" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '');" class="form-control" placeholder="Nomor WhatsApp" value="{{ old('no_telp_pic') }}" required>
            @error('no_telp_pic') <div class="text-danger small">{{ $message }}</div> @enderror
          </div>
        </div>

        <div class="row">
          <div class="col-md-6 mb-3">
            <label>No Identitas PIC</label>
            <input type="text" name="no_identitas" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '');" class="form-control" placeholder="KTP/Paspor" value="{{ old('no_identitas') }}" required>
            @error('no_identitas') <div class="text-danger small">{{ $message }}</div> @enderror
          </div>
          <div class="col-md-6 mb-3">
            <label>Upload Bukti Identitas <span style="color:red">*</span></label>
            <input type="file" name="bukti_identitas" class="form-control" accept=".jpg,.jpeg,.png" required>
            @error('bukti_identitas') <div class="text-danger small">{{ $message }}</div> @enderror
          </div>
        </div>

        <div class="mb-3">
          <label>Nama Instansi / Persyarikatan</label>
          <input type="text" name="asal_persyarikatan" class="form-control" placeholder="Contoh: UMS, Muhammadiyah..." value="{{ old('asal_persyarikatan') }}">
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Nama Kegiatan</label>
                <input type="text" name="nama_kegiatan" class="form-control" placeholder="Contoh: Workshop..." value="{{ old('nama_kegiatan') }}">
            </div>
            <div class="col-md-6 mb-3">
                <label>Tanggal Kegiatan</label>
                <input type="date" name="tanggal_persyarikatan" class="form-control" value="{{ old('tanggal_persyarikatan') }}">
            </div>
        </div>

        <div class="mb-3">
          <label>Jumlah Peserta</label>
          <input type="number" name="jumlah_peserta" class="form-control" min="1" placeholder="Total orang" value="{{ old('jumlah_peserta') }}" required>
          @error('jumlah_peserta') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
          <label>Special Request</label>
          <textarea name="special_request" rows="3" class="form-control" placeholder="Tulis permintaan khusus (opsional)">{{ old('special_request') }}</textarea>
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
          $foto = $selectedRoom ? ($fotoMap[$selectedRoom->jenis_kamar] ?? 'default.jpg') : 'default.jpg';
        @endphp

        <img src="{{ asset('images/'.$foto) }}" class="img-room mb-3">

        <div class="d-flex justify-content-between mb-2">
          <h4 class="fw-bold">{{ $selectedRoom->jenis_kamar }}</h4>
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
          <small class="text-muted">Tanggal sesuai pilihan di Beranda</small>
        </div>

        <div class="mb-3">
          <label>Check-out</label>
          <input type="date" name="check_out" id="check_out" class="form-control" value="{{ old('check_out', $checkout) }}" required readonly style="background-color: #f8f9fa; pointer-events: none;">
          <small class="text-muted">Tanggal sesuai pilihan di Beranda</small>
        </div>

      </div>
    </div>
  </div>
</form>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const checkIn = document.getElementById("check_in");
    const checkOut = document.getElementById("check_out");
    const form = document.querySelector('form');
    
    if (form) {
        form.addEventListener('submit', function(e) {
            const namaPic = document.querySelector('[name="nama_pic"]').value.trim();
            const bukti = document.querySelector('[name="bukti_identitas"]').files.length;

            if (!namaPic || bukti === 0) {
                e.preventDefault();
                // Use Swal if available, otherwise alert
                if(typeof Swal !== 'undefined') {
                    Swal.fire({ icon: 'warning', title: 'Data Belum Lengkap', text: 'Mohon lengkapi data wajib (Nama PIC, Bukti Identitas)!', confirmButtonColor: '#a0203c' });
                } else {
                    alert('Mohon lengkapi data wajib (Nama PIC, Bukti Identitas)!');
                }
                return false;
            }
            
            if (new Date(checkOut.value) <= new Date(checkIn.value)) {
                e.preventDefault();
                if(typeof Swal !== 'undefined') {
                    Swal.fire({ icon: 'error', title: 'Tanggal Tidak Valid', text: 'Tanggal check-out harus setelah tanggal check-in', confirmButtonColor: '#a0203c' });
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