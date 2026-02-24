<div class="container py-4">
  <h3 class="mb-3">Your Cart</h3>
  <form method="post" action="<?php echo base_url('cart/update'); ?>">
    <div class="table-responsive">
      <table class="table align-middle">
        <thead>
          <tr><th>Product</th><th>Price</th><th>Qty</th><th>Subtotal</th></tr>
        </thead>
        <tbody>
        <?php $total=0; foreach (($cart ?? []) as $item): $sub=$item['price']*$item['qty']; $total+=$sub; ?>
          <tr>
            <td><?php echo e($item['name']); ?></td>
            <td>₹<?php echo number_format($item['price'],2); ?></td>
            <td style="max-width:120px"><input class="form-control" type="number" name="qty[<?php echo (int)$item['id']; ?>]" min="0" value="<?php echo (int)$item['qty']; ?>"></td>
            <td>₹<?php echo number_format($sub,2); ?></td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <div class="d-flex justify-content-between align-items-center">
      <a href="<?php echo base_url('product'); ?>" class="btn btn-outline-secondary">Continue Shopping</a>
      <div>
        <span class="me-3 fw-semibold">Total: ₹<?php echo number_format($total,2); ?></span>
        <a href="<?php echo base_url('cart/checkout'); ?>" class="btn btn-primary">Checkout</a>
        <button class="btn btn-light ms-2" type="submit">Update</button>
      </div>
    </div>
  </form>
</div>
