<div class="container py-4">
  <div class="d-flex align-items-center justify-content-between mb-3">
    <h3>Orders</h3>
    <a class="btn btn-outline-secondary" href="<?php echo base_url('vendor/products'); ?>">Manage Products</a>
  </div>

  <?php if (empty($orders)): ?>
    <div class="alert alert-info">No orders yet.</div>
  <?php else: ?>
    <?php foreach ($orders as $order): ?>
      <div class="p-3 rounded-4 mb-3" style="background: var(--card); border:1px solid var(--border)" data-aos="fade-up">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <strong>Order #<?php echo (int)$order['order_id']; ?></strong>
            <div class="small text-muted">Placed: <?php echo e($order['created_at']); ?> • Customer: <?php echo e($order['customer_name']); ?></div>
          </div>
          <span class="badge text-bg-secondary"><?php echo e($order['order_status']); ?></span>
        </div>
        <div class="table-responsive mt-2">
          <table class="table align-middle mb-0">
            <thead><tr><th>Item</th><th>Qty</th><th>Price</th><th>Status</th><th>Action</th></tr></thead>
            <tbody>
              <?php foreach ($order['items'] as $it): ?>
                <tr>
                  <td class="d-flex align-items-center gap-2">
                    <img src="<?php echo e((json_decode($it['images'] ?? '[]', true)[0] ?? 'https://picsum.photos/seed/'.intval($it['item_id']).'/60/45')); ?>" style="width:60px;height:45px;object-fit:cover;border:1px solid var(--border)">
                    <div>
                      <div class="fw-semibold"><?php echo e($it['product_name']); ?></div>
                      <div class="small text-muted">Item #<?php echo (int)$it['item_id']; ?></div>
                    </div>
                  </td>
                  <td><?php echo (int)$it['quantity']; ?></td>
                  <td>₹<?php echo number_format((float)$it['price'], 2); ?></td>
                  <td><span class="badge text-bg-light"><?php echo e($it['item_status']); ?></span></td>
                  <td>
                    <div class="btn-group btn-group-sm">
                      <a class="btn btn-outline-secondary" href="<?php echo base_url('vendor/updateItemStatus/'.$it['item_id'].'/pending'); ?>">Pending</a>
                      <a class="btn btn-outline-primary" href="<?php echo base_url('vendor/updateItemStatus/'.$it['item_id'].'/shipped'); ?>">Shipped</a>
                      <a class="btn btn-outline-success" href="<?php echo base_url('vendor/updateItemStatus/'.$it['item_id'].'/completed'); ?>">Completed</a>
                    </div>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>
</div>
