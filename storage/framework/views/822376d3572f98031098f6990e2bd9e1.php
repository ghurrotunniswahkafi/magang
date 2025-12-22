<?php $__env->startSection('content'); ?>
<div class="max-w-2xl mx-auto">
  <div class="bg-white rounded-lg p-6 shadow">
    <h3 class="text-lg font-bold mb-4">Edit Kamar</h3>
    <form action="<?php echo e(route('kamar.update', $kamar->id)); ?>" method="POST">
      <?php echo csrf_field(); ?>
      <div class="mb-3">
        <label class="block text-sm font-medium">Nomor Kamar</label>
  <input name="kode_kamar" value="<?php echo e($kamar->kode_kamar ?? $kamar->nomor_kamar); ?>" class="w-full border rounded px-3 py-2" readonly>
      </div>
      <div class="mb-3 grid grid-cols-2 gap-3">
        <div>
          <label class="block text-sm font-medium">Jenis Kamar</label>
          <input name="jenis_kamar" value="<?php echo e($kamar->jenis_kamar); ?>" class="w-full border rounded px-3 py-2" required>
        </div>
        <div>
          <label class="block text-sm font-medium">Gedung</label>
          <input name="gedung" value="<?php echo e($kamar->gedung); ?>" class="w-full border rounded px-3 py-2">
        </div>
      </div>
      <div class="mb-3">
        <label class="block text-sm font-medium">Harga (Rp)</label>
        <input name="harga" type="number" value="<?php echo e($kamar->harga); ?>" class="w-full border rounded px-3 py-2">
      </div>
      <div class="mb-3">
        <label class="block text-sm font-medium">Fasilitas</label>
        <input name="fasilitas" value="<?php echo e($kamar->fasilitas); ?>" class="w-full border rounded px-3 py-2">
      </div>
      <div class="mb-3">
        <label class="block text-sm font-medium">Status</label>
        <select name="status" class="w-full border rounded px-3 py-2">
          <option value="kosong" <?php echo e($kamar->status=='kosong'?'selected':''); ?>>kosong</option>
          <option value="terisi" <?php echo e($kamar->status=='terisi'?'selected':''); ?>>terisi</option>
        </select>
      </div>
      <div class="flex gap-3 justify-end">
        <a href="<?php echo e(route('kamar.index')); ?>" class="px-4 py-2 bg-gray-200 rounded">Batal</a>
        <button class="px-4 py-2 bg-[var(--brand)] text-white rounded">Simpan</button>
      </div>
    </form>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/pbtcmasmansur-main 3/resources/views/admin/kamar/edit.blade.php ENDPATH**/ ?>