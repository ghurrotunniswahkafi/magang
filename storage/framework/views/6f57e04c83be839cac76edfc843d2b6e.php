<?php $__env->startSection('content'); ?>
<style>
  :root {
    --primary: #3b82f6;
    --primary-dark: #2563eb;
    --success: #10b981;
    --danger: #ef4444;
    --warning: #f59e0b;
    --gray: #6b7280;
    --light: #f9fafb;
  }

  .report-container {
    padding: 32px 24px;
    max-width: 1400px;
    margin: auto;
  }

  .report-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    flex-wrap: wrap;
    gap: 16px;
    margin-bottom: 24px;
  }

  .report-header h2 {
    color: #1f2937;
    font-size: 24px;
    margin: 0;
  }

  .report-header p {
    color: var(--gray);
    margin-top: 4px;
    font-size: 14px;
  }

  .month-selector {
    display: flex;
    gap: 12px;
    align-items: center;
  }

  .month-selector select {
    padding: 10px 14px;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    background: white;
    font-size: 14px;
    outline: none;
    transition: border 0.2s;
  }

  .month-selector select:focus {
    border-color: var(--primary);
  }

  .month-selector button {
    background: var(--primary);
    color: white;
    border: none;
    padding: 10px 20px;
    font-weight: 600;
    border-radius: 8px;
    cursor: pointer;
    transition: background 0.2s;
  }

  .month-selector button:hover {
    background: var(--primary-dark);
  }

  .btn-export {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 18px;
    font-weight: 600;
    font-size: 14px;
    border-radius: 8px;
    cursor: pointer;
    text-decoration: none;
    transition: all 0.2s ease;
  }

  .btn-pdf { background: var(--danger); color: #fff; }
  .btn-pdf:hover { background: #dc2626; }
  .btn-csv { background: var(--success); color: #fff; }
  .btn-csv:hover { background: #059669; }
  .btn-back { background: var(--gray); color: #fff; }
  .btn-back:hover { background: #4b5563; }

  .export-buttons {
    display: flex;
    gap: 10px;
    margin-bottom: 24px;
  }

  .stat-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 16px;
    margin-bottom: 32px;
  }

  .stat-card {
    background: #fff;
    padding: 20px;
    border-radius: 12px;
    border-left: 5px solid var(--primary);
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
  }

  .stat-value {
    font-size: 28px;
    font-weight: 700;
    color: #1f2937;
  }

  .stat-label {
    font-size: 14px;
    color: var(--gray);
    margin-top: 6px;
  }

  .table-wrapper {
    background: #fff;
    border-radius: 12px;
    padding: 24px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.05);
  }

  .data-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 14px;
  }

  .data-table thead {
    background: var(--light);
  }

  .data-table th {
    padding: 12px 16px;
    text-align: left;
    font-weight: 600;
    color: #374151;
    border-bottom: 2px solid #e5e7eb;
  }

  .data-table td {
    padding: 12px 16px;
    border-bottom: 1px solid #f3f4f6;
  }

  .data-table tbody tr:hover {
    background: #f9fafb;
  }

  .empty-state {
    text-align: center;
    padding: 40px 0;
    color: #9ca3af;
  }

  .empty-state div:first-child {
    font-size: 48px;
  }
</style>

<div class="report-container">

  <!-- Header -->
  <div class="report-header">
    <div>
      <h2 class="text-bold">Unduh Laporan Bulanan</h2>
      <p><?php echo e(\Carbon\Carbon::parse($monthStart)->format('F Y')); ?></p>
    </div>

    <div class="month-selector">
      <form method="GET" action="<?php echo e(route('report.monthly')); ?>" style="display:flex; gap:12px;">
        <select name="month" required>
          <option value="">-- Pilih Bulan --</option>
          <?php for($i = 0; $i < 12; $i++): ?>
            <?php
              $date = now()->subMonths($i);
              $value = $date->format('Y-m');
            ?>
            <option value="<?php echo e($value); ?>" <?php echo e($selectedMonth == $value ? 'selected' : ''); ?>>
              <?php echo e($date->format('F Y')); ?>

            </option>
          <?php endfor; ?>
        </select>
        <button type="submit">Tampilkan</button>
      </form>
    </div>
  </div>

  <!-- Export Buttons -->
  <div class="export-buttons">
    <a href="<?php echo e(route('report.monthly.pdf', ['month' => $selectedMonth])); ?>" class="btn-export btn-pdf">Export PDF</a>
    <a href="<?php echo e(route('report.monthly.csv', ['month' => $selectedMonth])); ?>" class="btn-export btn-csv">Export CSV</a>
  </div>

  <!-- Stats -->
  <div class="stat-grid">
    <div class="stat-card" style="border-left-color:#3b82f6;">
      <div class="stat-value"><?php echo e($totalKamar); ?></div>
      <div class="stat-label">Total Kamar</div>
    </div>

    <div class="stat-card" style="border-left-color:#10b981;">
      <div class="stat-value"><?php echo e($kamarKosong); ?></div>
      <div class="stat-label">Kamar Kosong</div>
    </div>

    <div class="stat-card" style="border-left-color:#f59e0b;">
      <div class="stat-value"><?php echo e($kamarTerisi); ?></div>
      <div class="stat-label">Kamar Terisi</div>
    </div>

    <div class="stat-card" style="border-left-color:#8b5cf6;">
      <div class="stat-value"><?php echo e($bookingsThisMonth->count()); ?></div>
      <div class="stat-label">Booking Bulan Ini</div>
    </div>
  </div>

  <!-- Table -->
  <div class="table-wrapper">
    <h3 style="color:#1f2937; margin-bottom:16px;">Daftar Booking Bulan Ini</h3>

    <div style="overflow-x:auto;">
      <table class="data-table">
        <thead>
          <tr>
            <th>#</th>
            <th>Nama</th>
            <th>Jenis Tamu</th>
            <th>Check-in</th>
            <th>Check-out</th>
            <th>Kamar Kode</th>
            <th>Kamar Dipilih</th>
            <th>Jumlah Kamar</th>
            <th>Jumlah Orang</th>
            <th>Total Harga</th>
            <th>Status Pembayaran</th>
            <th>Bukti Identitas</th>
            <th>Bukti Pembayaran</th>
            <th>Asal Persyarikatan</th>
            <th>No. Telp</th>
          </tr>
        </thead>

        <tbody>
          <?php $__empty_1 = true; $__currentLoopData = $bookingsThisMonth; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <tr>
            <td><?php echo e($i + 1); ?></td>
            <td><strong><?php echo e($b->nama); ?></strong></td>

            <td>
              <span style="padding:4px 8px;border-radius:4px;
                background:<?php echo e($b->jenis_tamu == 'Corporate' ? '#dbeafe' : '#fef3c7'); ?>;
                color:<?php echo e($b->jenis_tamu == 'Corporate' ? '#1e40af' : '#92400e'); ?>;
                font-size:12px; font-weight:600;">
                <?php echo e($b->jenis_tamu); ?>

              </span>
            </td>

            <td><?php echo e(\Carbon\Carbon::parse($b->check_in)->format('d M Y')); ?></td>
            <td><?php echo e(\Carbon\Carbon::parse($b->check_out)->format('d M Y')); ?></td>

            <td><?php echo e($b->kode_kamar ?? $b->nomor_kamar ?? '-'); ?></td>

            <!-- Kamar Dipilih -->
            <td>
              <?php
                $raw = $b->kode_kamar ?? $b->nomor_kamar ?? '';
                $kamarIds = array_filter(array_map('trim', explode(',', $raw)));

                $jenisKamars = [];

                foreach ($kamarIds as $kamarId) {
                    $kamar = null;

                    if ($kamarId !== '') {
                        $kamar = \App\Models\Kamar::where('kode_kamar', $kamarId)->first();

                        if (!$kamar && is_numeric($kamarId)) {
                            $kamar = \App\Models\Kamar::find(intval($kamarId));
                        }
                        if (!$kamar) {
                            $kamar = \App\Models\Kamar::where('nomor_kamar', $kamarId)->first();
                        }
                    }

                    if ($kamar && !in_array($kamar->jenis_kamar, $jenisKamars)) {
                        $jenisKamars[] = $kamar->jenis_kamar;
                    }
                }
              ?>
              <strong><?php echo e(implode(', ', $jenisKamars) ?: '-'); ?></strong>
            </td>

            <td><strong><?php echo e($b->jumlah_kamar ?? '-'); ?></strong></td>
            <td><strong><?php echo e($b->jumlah_peserta ?? '-'); ?></strong></td>

            

            <!-- Total Harga -->
            <td>
              <?php if($b->total_harga): ?>
                <strong style="color:#10b981">
                  Rp <?php echo e(number_format($b->total_harga, 0, ',', '.')); ?>

                </strong>
              <?php else: ?>
                <span style="color:#999">-</span>
              <?php endif; ?>
            </td>

            <!-- Payment Status -->
            <td>
              <span style="padding:4px 8px;border-radius:4px;font-size:12px;font-weight:600;
                <?php if($b->payment_status == 'lunas' || $b->payment_status == 'paid'): ?> background:#d1fae5;color:#065f46;
                <?php elseif($b->payment_status == 'pending'): ?> background:#fef3c7;color:#92400e;
                <?php elseif($b->payment_status == 'rejected'): ?> background:#fee2e2;color:#991b1b;
                <?php else: ?> background:#e5e7eb;color:#374151;
                <?php endif; ?>">
                <?php echo e($b->payment_status_label); ?>

              </span>
            </td>

            <!-- Bukti Identitas -->
            <td>
              <?php if($b->bukti_identitas): ?>
                <?php
                  $relPath = Str::startsWith($b->bukti_identitas, 'public/')
                    ? substr($b->bukti_identitas, 7)
                    : $b->bukti_identitas;

                  $fileExists = Storage::disk('public')->exists($relPath);
                ?>

                <?php if($fileExists): ?>
                  <a href="<?php echo e(Storage::url($relPath)); ?>" target="_blank"
                    style="color:#2563eb;text-decoration:underline;font-size:12px">Lihat</a>
                <?php else: ?>
                  <span style="color:#dc2626;font-size:12px">⚠️ Hilang</span>
                <?php endif; ?>

              <?php else: ?>
                <span style="color:#999;font-size:12px">-</span>
              <?php endif; ?>
            </td>

            <!-- Bukti Pembayaran -->
            <td>
              <?php if($b->bukti_pembayaran): ?>
                <?php
                  $relPath = Str::startsWith($b->bukti_pembayaran, 'public/')
                    ? substr($b->bukti_pembayaran, 7)
                    : $b->bukti_pembayaran;

                  $fileExists = Storage::disk('public')->exists($relPath);
                ?>

                <?php if($fileExists): ?>
                  <a href="<?php echo e(Storage::url($relPath)); ?>" target="_blank"
                    style="color:#2563eb;text-decoration:underline;font-size:12px">Lihat</a>
                <?php else: ?>
                  <span style="color:#dc2626;font-size:12px">⚠️ Hilang</span>
                <?php endif; ?>

              <?php else: ?>
                <span style="color:#999;font-size:12px">-</span>
              <?php endif; ?>
            </td>

            <td><?php echo e($b->asal_persyarikatan ?? '-'); ?></td>
            <td><?php echo e($b->no_telp_pic ?? $b->no_telp ?? '-'); ?></td>
          </tr>

          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <tr>
            <td colspan="17" class="empty-state">
              <div>📭</div>
              <div>Tidak ada booking pada bulan ini</div>
            </td>
          </tr>
          <?php endif; ?>
        </tbody>

      </table>
    </div>
  </div>

</div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script>
  // Additional JS if needed
</script>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/pbtcmasmansur-main/resources/views/admin/report_monthly.blade.php ENDPATH**/ ?>