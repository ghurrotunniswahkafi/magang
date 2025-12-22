<?php $__env->startSection('content'); ?>
<div style="padding:20px">
  <h3>Edit Data Pengunjung: <?php echo e($p->nama); ?></h3>
  
  <?php if($errors->any()): ?>
    <div style="background:#fee;padding:12px;border-radius:6px;margin-bottom:16px">
      <strong>Error:</strong>
      <ul style="margin:8px 0 0 20px">
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $err): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <li><?php echo e($err); ?></li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </ul>
    </div>
  <?php endif; ?>

  <form action="<?php echo e(route('pengunjung.update', $p->id)); ?>" method="POST" style="background:#fff;padding:24px;border-radius:8px;max-width:800px" id="editForm">
    <?php echo csrf_field(); ?>
    
    <div style="margin-bottom:16px">
      <label style="display:block;margin-bottom:4px;font-weight:600">Nama PIC <span style="color:red">*</span></label>
      <input type="text" name="nama_pic" value="<?php echo e(old('nama_pic', $p->nama_pic ?: $p->nama)); ?>" required style="width:100%;padding:10px;border:1px solid #ddd;border-radius:6px">
      <input type="hidden" name="nama" value="<?php echo e($p->nama_pic ?: $p->nama); ?>">
    </div>

    <div style="margin-bottom:16px">
      <label style="display:block;margin-bottom:4px;font-weight:600">Jenis Tamu</label>
      <select name="jenis_tamu" style="width:100%;padding:10px;border:1px solid #ddd;border-radius:6px">
        <option value="corporate" <?php echo e(old('jenis_tamu', $p->jenis_tamu) == 'corporate' ? 'selected' : ''); ?>>Corporate</option>
        <option value="individu" <?php echo e(old('jenis_tamu', $p->jenis_tamu) == 'individu' ? 'selected' : ''); ?>>Individu</option>
      </select>
    </div>

    <div style="margin-bottom:16px">
      <label style="display:block;margin-bottom:4px;font-weight:600">No Identitas</label>
      <input type="text" name="no_identitas" value="<?php echo e(old('no_identitas', $p->no_identitas)); ?>" style="width:100%;padding:10px;border:1px solid #ddd;border-radius:6px">
    </div>

    <div style="margin-bottom:16px">
      <label style="display:block;margin-bottom:4px;font-weight:600">No HP PIC</label>
      <input type="text" name="no_telp_pic" value="<?php echo e(old('no_telp_pic', $p->no_telp_pic ?: $p->no_telp)); ?>" style="width:100%;padding:10px;border:1px solid #ddd;border-radius:6px">
      <input type="hidden" name="no_telp" value="<?php echo e($p->no_telp_pic ?: $p->no_telp); ?>">
    </div>

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px">
      <div>
        <label style="display:block;margin-bottom:4px;font-weight:600">Check-in <span style="color:red">*</span></label>
        <input type="date" name="check_in" value="<?php echo e(old('check_in', $p->check_in)); ?>" required style="width:100%;padding:10px;border:1px solid #ddd;border-radius:6px">
      </div>
      <div>
        <label style="display:block;margin-bottom:4px;font-weight:600">Check-out <span style="color:red">*</span></label>
        <input type="date" name="check_out" value="<?php echo e(old('check_out', $p->check_out)); ?>" required style="width:100%;padding:10px;border:1px solid #ddd;border-radius:6px">
      </div>
    </div>

    <div style="margin-bottom:16px">
      <label style="display:block;margin-bottom:4px;font-weight:600">Kode Kamar</label>
      <?php
        $currentKamars = $p->kode_kamar ? explode(',', str_replace(' ', '', $p->kode_kamar)) : [];
      ?>
      <select name="kode_kamar[]" multiple style="width:100%;padding:10px;border:1px solid #ddd;border-radius:6px;min-height:150px">
        <?php $__currentLoopData = $kamars; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <?php
            $kodeKamar = $k->kode_kamar;
            $isSelected = in_array($kodeKamar, $currentKamars);
            $isAvailable = $k->status === 'kosong' || $isSelected;
          ?>
          <option 
            value="<?php echo e($kodeKamar); ?>" 
            <?php echo e($isSelected ? 'selected' : ''); ?>

            <?php echo e(!$isAvailable ? 'disabled' : ''); ?>

            style="<?php echo e(!$isAvailable ? 'color:#999' : ($isSelected ? 'background:#dbeafe;font-weight:600' : '')); ?>"
          >
            <?php echo e($kodeKamar); ?> — <?php echo e($k->jenis_kamar); ?> — <?php echo e($k->gedung); ?>

            <?php if(!$isAvailable): ?> (Terisi) <?php endif; ?>
            <?php if($isSelected): ?> (Terpilih) <?php endif; ?>
          </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </select>
      <small style="display:block;margin-top:6px;color:#666">
        Tekan <strong>Ctrl</strong> (Windows) atau <strong>Cmd</strong> (Mac) untuk pilih beberapa kamar. 
        <span style="color:#10b981;font-weight:600"><?php echo e($kamars->where('status', 'kosong')->count()); ?></span> kamar kosong tersedia.
      </small>
      
      <script>
        window.roomPrices = <?php echo json_encode($kamars->pluck('harga','kode_kamar')); ?>;
      </script>
    </div>

    <div style="margin-bottom:16px">
      <label style="display:block;margin-bottom:4px;font-weight:600">Jumlah Kamar</label>
      <input type="number" name="jumlah_kamar" value="<?php echo e(old('jumlah_kamar', $p->jumlah_kamar)); ?>" min="1" style="width:100%;padding:10px;border:1px solid #ddd;border-radius:6px">
    </div>

    <div style="margin-bottom:16px">
      <label style="display:block;margin-bottom:4px;font-weight:600">Status Pembayaran</label>
      <select name="payment_status" style="width:100%;padding:10px;border:1px solid #ddd;border-radius:6px">
        <option value="pending" <?php echo e(old('payment_status', $p->payment_status) == 'pending' ? 'selected' : ''); ?>>Pending</option>
        <option value="konfirmasi_booking" <?php echo e(old('payment_status', $p->payment_status) == 'konfirmasi_booking' ? 'selected' : ''); ?>>Konfirmasi Booking</option>
        <option value="paid" <?php echo e(old('payment_status', $p->payment_status) == 'paid' ? 'selected' : ''); ?>>Paid</option>
        <option value="lunas" <?php echo e(old('payment_status', $p->payment_status) == 'lunas' ? 'selected' : ''); ?>>Lunas</option>
        <option value="rejected" <?php echo e(old('payment_status', $p->payment_status) == 'rejected' ? 'selected' : ''); ?>>Rejected</option>
      </select>
    </div>

    <div style="border-top:2px solid #e5e7eb;margin:24px 0;padding-top:24px">
      <h4 style="margin-bottom:16px">Data Kegiatan</h4>
      
      <div style="margin-bottom:16px">
        <label style="display:block;margin-bottom:4px;font-weight:600">Nama Kegiatan</label>
        <input type="text" name="nama_kegiatan" value="<?php echo e(old('nama_kegiatan', $p->nama_kegiatan)); ?>" style="width:100%;padding:10px;border:1px solid #ddd;border-radius:6px">
      </div>


    <div style="display:flex;gap:12px;margin-top:24px">
      <button type="submit" class="pill-btn" style="background:#2563eb;color:#fff;padding:12px 32px;border:none;cursor:pointer">
        Simpan Perubahan
      </button>
      
      <a href="<?php echo e(route('pengunjung.show', $p->id)); ?>" class="pill-btn" style="background:#6b7280;color:#fff;padding:12px 32px">
        Batal
      </a>
    </div>
  </form>
</div>


<?php $__env->stopSection(); ?>
<script>
// Enable/disable qty inputs based on checkbox and collect structured data on submit
document.addEventListener('DOMContentLoaded', function(){
  function toggleInput(cb, qtySelector){
    const qty = cb.parentElement.querySelector(qtySelector);
    if(!qty) return;
    qty.disabled = !cb.checked;
  }

  document.querySelectorAll('.menu-snack-cb').forEach(cb => {
    toggleInput(cb, '.menu-snack-qty');
    cb.addEventListener('change', function(){ toggleInput(this, '.menu-snack-qty'); });
  });
  document.querySelectorAll('.menu-meal-cb').forEach(cb => {
    toggleInput(cb, '.menu-meal-qty');
    cb.addEventListener('change', function(){ toggleInput(this, '.menu-meal-qty'); });
  });

  document.getElementById('editForm').addEventListener('submit', function(e){
    // build snack array
    const snacks = [];
    document.querySelectorAll('.menu-snack-cb').forEach(cb => {
      if(cb.checked){
        const name = cb.getAttribute('data-name');
        const qty = parseInt(cb.parentElement.querySelector('.menu-snack-qty').value || 0);
        const price = parseFloat(cb.parentElement.querySelector('.menu-snack-qty').getAttribute('data-price') || 0);
        snacks.push({nama: name, porsi: qty, harga: price});
      }
    });

    const meals = [];
    document.querySelectorAll('.menu-meal-cb').forEach(cb => {
      if(cb.checked){
        const name = cb.getAttribute('data-name');
        const qty = parseInt(cb.parentElement.querySelector('.menu-meal-qty').value || 0);
        const price = parseFloat(cb.parentElement.querySelector('.menu-meal-qty').getAttribute('data-price') || 0);
        meals.push({nama: name, porsi: qty, harga: price});
      }
    });

    // compute room total from selected kode_kamar[] using roomPrices exposed above
    let roomTotal = 0;
    const kodeSelect = document.querySelector('select[name="kode_kamar[]"]');
    if(kodeSelect){
      Array.from(kodeSelect.selectedOptions).forEach(opt => {
        const code = opt.value;
        const price = parseFloat(window.roomPrices[code] || 0);
        if(!isNaN(price)) roomTotal += price;
      });
    }

    // compute total harga (rooms + snacks + meals)
    let total = roomTotal;
    document.getElementById('total_harga_input').value = total;

    // allow original submit to continue
  });
});
</script>

<?php echo $__env->make('layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\RA\PESMA\pbtcmasmansur-main\resources\views/admin/pengunjung/edit.blade.php ENDPATH**/ ?>