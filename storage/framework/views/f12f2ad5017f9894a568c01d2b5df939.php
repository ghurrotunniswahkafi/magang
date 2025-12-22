<?php $__env->startSection('content'); ?>
<style>
  .detail-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 24px;
  }
  
  .detail-header {
    background: linear-gradient(135deg, var(--brand) 0%, var(--brand-2) 100%);
    color: #fff;
    padding: 24px;
    border-radius: 16px;
    margin-bottom: 24px;
    box-shadow: 0 4px 12px rgba(179, 18, 59, 0.15);
  }
  
  .detail-header h2 {
    margin: 0 0 8px 0;
    font-size: 28px;
    font-weight: 700;
  }
  
  .detail-header .subtitle {
    opacity: 0.9;
    font-size: 14px;
  }
  
  .badge-status {
    display: inline-block;
    padding: 6px 16px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 600;
    margin-top: 8px;
  }
  
  .badge-paid { background: #10b981; color: #fff; }
  .badge-pending { background: #f59e0b; color: #fff; }
  .badge-rejected { background: #ef4444; color: #fff; }
  
  .card-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
    gap: 20px;
    margin-bottom: 24px;
  }
  
  .detail-card {
    background: #fff;
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    transition: transform 0.2s, box-shadow 0.2s;
  }
  
  .detail-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.12);
  }
  
  .detail-card h4 {
    margin: 0 0 16px 0;
    font-size: 18px;
    font-weight: 700;
    color: var(--brand);
    border-bottom: 2px solid var(--brand);
    padding-bottom: 8px;
  }
  
  .detail-row {
    display: flex;
    padding: 10px 0;
    border-bottom: 1px solid #f0f0f0;
    gap: 12px;
  }
  
  .detail-row:last-child {
    border-bottom: none;
  }
  
  .detail-label {
    font-weight: 600;
    color: #666;
    min-width: 140px;
    flex-shrink: 0;
    font-size: 14px;
  }
  
  .detail-value {
    color: #333;
    flex: 1;
    font-size: 14px;
  }
  
  .full-width-card {
    grid-column: 1 / -1;
  }
  
  .image-preview {
    margin-top: 12px;
    border-radius: 8px;
    overflow: hidden;
    border: 2px solid #e5e7eb;
  }
  
  .image-preview img {
    width: 100%;
    max-width: 500px;
    height: auto;
    display: block;
  }
  
  .action-buttons {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
    margin-top: 24px;
  }
  
  .btn {
    padding: 12px 24px;
    border-radius: 8px;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    border: none;
    cursor: pointer;
    font-size: 14px;
    transition: all 0.2s;
  }
  
  .btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
  }
  
  .btn-back { background: #6b7280; color: #fff; }
  .btn-checkin { background: #10b981; color: #fff; }
  .btn-checkout { background: #ef4444; color: #fff; }
  .btn-edit { background: #f59e0b; color: #fff; }
  
  .wa-link {
    background: #25D366;
    color: #fff;
    padding: 8px 16px;
    border-radius: 8px;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 13px;
    font-weight: 600;
  }
  
  .wa-link:hover {
    background: #1DA855;
  }
  
  .dropdown-toggle {
    width: 100%;
    padding: 12px 16px;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border: 2px solid #dee2e6;
    border-radius: 8px;
    cursor: pointer;
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-weight: 600;
    color: #495057;
    transition: all 0.3s;
  }
  
  .dropdown-toggle:hover {
    background: linear-gradient(135deg, #e9ecef 0%, #dee2e6 100%);
    border-color: var(--brand);
  }
  
  .dropdown-toggle .arrow {
    transition: transform 0.3s;
    font-size: 12px;
  }
  
  .dropdown-toggle.active .arrow {
    transform: rotate(180deg);
  }
  
  .dropdown-content {
    display: none;
    margin-top: 8px;
    padding: 12px;
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    width: 100%;
  }
  
  .dropdown-content.show {
    display: block;
    animation: slideDown 0.3s ease-out;
  }
  
  @keyframes slideDown {
    from {
      opacity: 0;
      transform: translateY(-10px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }
  
  .menu-item {
    padding: 10px;
    margin-bottom: 8px;
    background: #f8f9fa;
    border-radius: 6px;
    border-left: 3px solid var(--brand);
  }
  
  .menu-item:last-child {
    margin-bottom: 0;
  }
  
  .menu-name {
    display: block;
    font-weight: 600;
    color: #333;
    margin-bottom: 4px;
  }
  
  .menu-detail {
    display: block;
    font-size: 13px;
    color: #666;
  }
  
  .no-data {
    padding: 16px;
    text-align: center;
    color: #999;
    font-style: italic;
  }
  
  .doc-link {
    display: inline-block;
    padding: 10px 20px;
    background: var(--brand);
    color: #fff;
    text-decoration: none;
    border-radius: 8px;
    font-weight: 600;
    margin-bottom: 12px;
    transition: all 0.2s;
  }
  
  .doc-link:hover {
    background: var(--brand-2);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(179, 18, 59, 0.3);
  }

  @media (max-width: 768px) {
    .detail-container { padding: 16px; }
    .detail-header { padding: 16px; }
    .detail-header h2 { font-size: 22px; }
    .card-grid { grid-template-columns: 1fr; }
    .detail-row { flex-direction: column; gap: 4px; }
    .detail-label { min-width: auto; }
    .action-buttons { flex-direction: column; }
    .btn { width: 100%; justify-content: center; }
  }
</style>

<div class="detail-container">
  <?php
    $isCheckedOut = false;
    if(!empty($p->check_out)){
      try{
        $co = \Carbon\Carbon::parse($p->check_out)->startOfDay();
        $td = \Carbon\Carbon::now()->startOfDay();
        $isCheckedOut = $co->lte($td);
      }catch(\Exception $e){
        $isCheckedOut = false;
      }
    }
  ?>
  <!-- Header -->
  <div class="detail-header">
    <h2>
      <?php if(strtolower($p->jenis_tamu) == 'corporate'): ?>
        <?php echo e($p->nama_pic ?? 'PIC'); ?>

      <?php else: ?>
        <?php echo e($p->nama); ?>

      <?php endif; ?>
    </h2>
    <div class="subtitle">
      
      Jenis: <?php echo e(ucfirst($p->jenis_tamu)); ?> • 
      Check-in: <?php echo e(\Carbon\Carbon::parse($p->check_in)->format('d M Y')); ?>

    </div>
    <span class="badge-status <?php echo e($p->payment_status == 'paid' || $p->payment_status == 'lunas' ? 'badge-paid' : ($p->payment_status == 'rejected' ? 'badge-rejected' : 'badge-pending')); ?>">
      <?php echo e($p->payment_status_label ?? $p->payment_status); ?>

    </span>
    <?php if($isCheckedOut): ?>
      <span class="badge-status badge-rejected" style="margin-left:10px;">Telah checkout • <?php echo e(\Carbon\Carbon::parse($p->check_out)->format('d M Y H:i')); ?></span>
    <?php endif; ?>
  </div>

  <!-- Cards Grid -->
  <div class="card-grid">
    <!-- Info Tamu -->
    <div class="detail-card">
      <h4>Informasi Tamu</h4>
      <?php if(strtolower($p->jenis_tamu) == 'corporate'): ?>
        <div class="detail-row">
          <span class="detail-label">Nama PIC</span>
          <span class="detail-value"><?php echo e($p->nama_pic ?? '-'); ?></span>
        </div>
        <div class="detail-row">
          <span class="detail-label">No. Telp PIC</span>
          <span class="detail-value">
            <?php echo e($p->no_telp_pic ?? '-'); ?>

            <?php if($p->no_telp_pic): ?>
              <?php $wa = 'https://wa.me/' . preg_replace('/[^0-9]/', '', $p->no_telp_pic); ?>
              <br><a href="<?php echo e($wa); ?>" target="_blank" class="wa-link">💬 Chat WhatsApp</a>
            <?php endif; ?>
          </span>
        </div>
      <?php else: ?>
        <div class="detail-row">
          <span class="detail-label">Nama Lengkap</span>
          <span class="detail-value"><?php echo e($p->nama); ?></span>
        </div>
        <div class="detail-row">
          <span class="detail-label">No. Identitas</span>
          <span class="detail-value"><?php echo e($p->no_identitas ?? '-'); ?> <small>(<?php echo e(strtoupper($p->identity_type ?? 'KTP')); ?>)</small></span>
        </div>
        <div class="detail-row">
          <span class="detail-label">No. Telepon</span>
          <span class="detail-value"><?php echo e($p->no_telp ?? '-'); ?></span>
        </div>
      <?php endif; ?>
      <div class="detail-row">
        <span class="detail-label">Jenis Tamu</span>
        <span class="detail-value">
          <span style="background:<?php echo e(strtolower($p->jenis_tamu) == 'corporate' ? '#28a745' : '#007bff'); ?>;color:#fff;padding:4px 10px;border-radius:12px;font-size:12px">
            <?php echo e(ucfirst($p->jenis_tamu)); ?>

          </span>
        </span>
      </div>
    </div>

    <!-- Info Booking -->
    <div class="detail-card">
      <h4>Informasi Booking</h4>
      <div class="detail-row">
        <span class="detail-label">Check-in</span>
        <span class="detail-value"><?php echo e(\Carbon\Carbon::parse($p->check_in)->format('d M Y')); ?></span>
      </div>
      <div class="detail-row">
        <span class="detail-label">Check-out</span>
        <span class="detail-value"><?php echo e(\Carbon\Carbon::parse($p->check_out)->format('d M Y')); ?></span>
      </div>
      <div class="detail-row">
        <span class="detail-label">Kode Kamar</span>
        <span class="detail-value"><strong style="color:var(--brand)"><?php echo e($p->kode_kamar ?? '-'); ?></strong></span>
      </div>
      <?php if(strtolower($p->jenis_tamu) == 'corporate'): ?>
        <div class="detail-row">
          <span class="detail-label">Jumlah Kamar</span>
          <span class="detail-value"><?php echo e($p->jumlah_kamar ?? '-'); ?> kamar</span>
        </div>
        <div class="detail-row">
          <span class="detail-label">Jumlah Peserta</span>
          <span class="detail-value"><?php echo e($p->jumlah_peserta ?? '-'); ?> orang</span>
        </div>
      <?php endif; ?>
    </div>

    <?php if(strtolower($p->jenis_tamu) == 'corporate'): ?>
    <!-- Info Corporate -->
    <div class="detail-card">
      <h4>Detail Corporate</h4>
      <div class="detail-row">
        <span class="detail-label">Nama Kegiatan</span>
        <span class="detail-value"><?php echo e($p->nama_kegiatan ?? '-'); ?></span>
      </div>
      <div class="detail-row">
        <span class="detail-label">Asal Persyarikatan</span>
        <span class="detail-value"><?php echo e($p->asal_persyarikatan ?? '-'); ?></span>
      </div>
      <div class="detail-row">
        <span class="detail-label">Tanggal Persyarikatan</span>
        <span class="detail-value">
          <?php echo e($p->tanggal_persyarikatan ? \Carbon\Carbon::parse($p->tanggal_persyarikatan)->format('d M Y') : '-'); ?>

        </span>
      </div>
    </div>
    <?php endif; ?>

    <!-- Bukti Identitas -->
    <div class="detail-card">
      <h4>Bukti Identitas</h4>
      <?php if($p->bukti_identitas): ?>
        <?php 
          $fileUrl = \Illuminate\Support\Facades\Storage::url($p->bukti_identitas);
          $isPdf = strtolower(pathinfo($p->bukti_identitas, PATHINFO_EXTENSION)) === 'pdf';
        ?>
        <a href="<?php echo e($fileUrl); ?>" target="_blank" class="doc-link">
          <?php echo e($isPdf ? '📄 Lihat PDF' : '🖼️ Lihat Gambar'); ?>

        </a>
        <?php if(!$isPdf): ?>
          <div class="image-preview">
            <img src="<?php echo e($fileUrl); ?>" alt="Bukti Identitas" onerror="this.parentElement.innerHTML='<p style=padding:20px;color:#999>Gambar tidak dapat dimuat</p>'">
          </div>
        <?php endif; ?>
      <?php else: ?>
        <div class="no-data">Belum diupload</div>
      <?php endif; ?>
    </div>

    <!-- Bukti Pembayaran -->
    <div class="detail-card">
      <h4>Bukti Pembayaran</h4>
      <?php if($p->bukti_pembayaran): ?>
        <?php 
          $fileUrl = \Illuminate\Support\Facades\Storage::url($p->bukti_pembayaran);
          $isPdf = strtolower(pathinfo($p->bukti_pembayaran, PATHINFO_EXTENSION)) === 'pdf';
        ?>
        <a href="<?php echo e($fileUrl); ?>" target="_blank" class="doc-link">
          <?php echo e($isPdf ? '📄 Lihat PDF' : '🖼️ Lihat Gambar'); ?>

        </a>
        <?php if(!$isPdf): ?>
          <div class="image-preview">
            <img src="<?php echo e($fileUrl); ?>" alt="Bukti Pembayaran" onerror="this.parentElement.innerHTML='<p style=padding:20px;color:#999>Gambar tidak dapat dimuat</p>'">
          </div>
        <?php endif; ?>
      <?php else: ?>
        <div class="no-data">Belum diupload</div>
      <?php endif; ?>
    </div>
  </div>

  <!-- Action Buttons -->
  <div class="action-buttons">
    <a href="<?php echo e(route('pengunjung.index')); ?>" class="btn btn-back">
      Kembali
    </a>
    
<?php
    $today = now()->format('Y-m-d');
    $isAutoCheckout = $p->check_out <= $today;   // checkout otomatis
    $isManualCheckout = $p->checked_out == true; // checkout manual admin

    $isCheckedOut = $isAutoCheckout || $isManualCheckout;
?>


<?php if($isCheckedOut): ?>
    <button class="btn btn-checkout" disabled style="opacity:.9">
        Sudah Check-Out
    </button>
<?php else: ?>
    <?php if(!$p->bukti_identitas): ?>
        <a href="<?php echo e(route('pengunjung.checkin', $p->id)); ?>" class="btn btn-checkin">
            Check-In
        </a>
    <?php else: ?>
        <form action="<?php echo e(route('pengunjung.checkout', $p->id)); ?>" method="POST" class="checkout-form" style="margin:0">
            <?php echo csrf_field(); ?>
            <button type="submit" class="btn btn-checkout">
                Check-Out
            </button>
        </form>
    <?php endif; ?>
<?php endif; ?>

    
    <a href="<?php echo e(route('pengunjung.edit', $p->id)); ?>" class="btn btn-edit">
      Edit Data
    </a>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const checkoutForm = document.querySelector('.checkout-form');
  if (checkoutForm) {
    checkoutForm.addEventListener('submit', function(e) {
      e.preventDefault();
      Swal.fire({
        title: 'Check-Out?',
        text: 'Kamar akan dikembalikan ke status kosong',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Check-Out!',
        cancelButtonText: 'Batal',
        reverseButtons: true
      }).then((result) => {
        if (result.isConfirmed) {
          this.submit();
        }
      });
    });
  }
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\RA\PESMA\pbtcmasmansur-main\resources\views/admin/pengunjung/show.blade.php ENDPATH**/ ?>