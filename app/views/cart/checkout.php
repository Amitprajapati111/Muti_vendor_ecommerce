<div class="container py-4">
  <h3 class="mb-3">Checkout</h3>
  <div class="row g-4">
    <div class="col-md-7">
      <div class="p-3 rounded-4" style="background: var(--card); border:1px solid var(--border)">
        <h5>Shipping Address</h5>
        <form>
          <div class="row g-3">
            <div class="col-md-6"><input class="form-control" placeholder="Full Name"></div>
            <div class="col-md-6"><input class="form-control" placeholder="Phone"></div>
            <div class="col-12"><input class="form-control" placeholder="Address Line 1"></div>
            <div class="col-12"><input class="form-control" placeholder="Address Line 2"></div>
            <div class="col-md-4"><input class="form-control" placeholder="City"></div>
            <div class="col-md-4"><input class="form-control" placeholder="State"></div>
            <div class="col-md-4"><input class="form-control" placeholder="PIN Code"></div>
          </div>
        </form>
      </div>
      <div class="p-3 rounded-4 mt-3" style="background: var(--card); border:1px solid var(--border)">
        <h5>Payment</h5>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="pay" id="cod" checked>
          <label class="form-check-label" for="cod">Cash on Delivery (COD)</label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="pay" id="online" disabled>
          <label class="form-check-label" for="online">Online Payment (Placeholder)</label>
        </div>
      </div>
    </div>
    <div class="col-md-5">
      <div class="p-3 rounded-4" style="background: var(--card); border:1px solid var(--border)">
        <h5>Order Summary</h5>
        <ul class="list-group list-group-flush">
          <?php $total=0; foreach (($cart ?? []) as $item): $sub=$item['price']*$item['qty']; $total+=$sub; ?>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <span><?php echo e($item['name']); ?> × <?php echo (int)$item['qty']; ?></span>
            <span>₹<?php echo number_format($sub,2); ?></span>
          </li>
          <?php endforeach; ?>
          <li class="list-group-item d-flex justify-content-between align-items-center fw-bold">
            <span>Total</span>
            <span>₹<?php echo number_format($total,2); ?></span>
          </li>
        </ul>
        <form class="mt-3" method="post" action="<?php echo base_url('cart/placeOrder'); ?>">
          <button class="btn btn-primary w-100">Place Order</button>
        </form>
      </div>
    </div>
  </div>
</div>
