<div class="container py-4">
  <h3 class="mb-3">My Orders</h3>
  <div class="table-responsive" data-aos="fade-up">
    <table class="table align-middle">
      <thead>
        <tr><th>#</th><th>Date</th><th>Status</th><th>Total</th><th>Items</th></tr>
      </thead>
      <tbody>
        <?php $i=1; foreach (($orders ?? []) as $o): ?>
          <tr>
            <td>#<?php echo (int)$o['id']; ?></td>
            <td><?php echo e($o['created_at']); ?></td>
            <td><span class="badge text-bg-secondary"><?php echo e($o['status']); ?></span></td>
            <td>₹<?php echo number_format((float)$o['total_amount'], 2); ?></td>
            <td>
              <?php foreach (($o['items'] ?? []) as $it): ?>
                <div class="small text-muted d-flex align-items-center gap-2">
                  <img src="<?php echo e((json_decode($it['images'] ?? '[]', true)[0] ?? 'https://picsum.photos/seed/'.intval($it['product_id']).'/60/45')); ?>" style="width:40px;height:30px;object-fit:cover;border:1px solid var(--border)" />
                  <span><?php echo e($it['name']); ?> × <?php echo (int)$it['quantity']; ?></span>
                </div>
              <?php endforeach; ?>
            </td>
          </tr>
        <?php endforeach; ?>
        <?php if (empty($orders)): ?>
          <tr><td colspan="5" class="text-center text-muted">No orders yet.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
