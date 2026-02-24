<div class="container py-4">
  <div class="d-flex align-items-center justify-content-between mb-3">
    <h3>My Wishlist</h3>
  </div>
  <div class="row g-3" data-aos="fade-up">
    <?php foreach (($items ?? []) as $w): ?>
      <div class="col-6 col-md-4 col-lg-3">
        <div class="product-card">
          <a href="<?php echo base_url('product/detail/'.$w['product_id']); ?>">
            <img class="product-thumb" src="<?php echo e((json_decode($w['images'] ?? '[]', true)[0] ?? 'https://picsum.photos/seed/'.intval($w['product_id']).'/600/450')); ?>" alt="thumb">
          </a>
          <div class="product-body">
            <a class="text-decoration-none d-block fw-semibold" href="<?php echo base_url('product/detail/'.$w['product_id']); ?>"><?php echo e($w['name']); ?></a>
            <div class="d-flex justify-content-between align-items-center">
              <div class="price">₹<?php echo number_format((float)$w['price'], 2); ?></div>
              <a class="btn btn-sm btn-outline-secondary" href="<?php echo base_url('wishlist/remove/'.$w['product_id']); ?>"><i class="fa-solid fa-heart-crack"></i></a>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
    <?php if (empty($items)): ?>
      <div class="col-12 text-center text-muted">Your wishlist is empty.</div>
    <?php endif; ?>
  </div>
</div>
