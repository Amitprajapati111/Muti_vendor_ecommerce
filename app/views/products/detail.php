<div class="container py-4">
  <div class="row g-4">
    <div class="col-md-6" data-aos="zoom-in">
      <div class="ratio ratio-4x3 rounded-4 overflow-hidden" style="border:1px solid var(--border)">
        <img id="mainImg" src="<?php echo e(($images[0] ?? 'https://picsum.photos/seed/'.intval($product['id']).'/800/600')); ?>" class="w-100 h-100" style="object-fit:cover" alt="image">
      </div>
      <div class="d-flex gap-2 mt-2">
        <?php foreach ($images as $img): ?>
          <img src="<?php echo e($img); ?>" class="rounded" style="width:70px;height:70px;object-fit:cover;cursor:pointer;border:1px solid var(--border)" onclick="document.getElementById('mainImg').src=this.src" />
        <?php endforeach; ?>
      </div>
    </div>
    <div class="col-md-6" data-aos="fade-left">
      <span class="badge badge-soft mb-2"><?php echo e($product['category_name'] ?? ''); ?></span>
      <h2 class="fw-bold"><?php echo e($product['name']); ?></h2>
      <div class="text-muted">by <?php echo e($product['shop_name'] ?? 'Vendor'); ?></div>
      <?php $avg = (float)($product['avg_rating'] ?? 0); $rc = (int)($product['rating_count'] ?? 0); ?>
      <div class="d-flex align-items-center gap-2 mt-2">
        <div class="display-6 price">₹<?php echo number_format($product['price'], 2); ?></div>
        <div class="small d-flex align-items-center gap-1">
          <span class="text-warning">
            <?php for ($s=1;$s<=5;$s++): ?>
              <?php if ($s <= round($avg)): ?>
                <i class="fa-solid fa-star"></i>
              <?php else: ?>
                <i class="fa-regular fa-star"></i>
              <?php endif; ?>
            <?php endfor; ?>
          </span>
          <span class="text-muted">(<?php echo $rc; ?>)</span>
        </div>
      </div>
      <p class="mt-3"><?php echo nl2br(e($product['description'])); ?></p>
      <form class="d-flex gap-2" method="post" action="<?php echo base_url('cart/add'); ?>">
        <input type="hidden" name="product_id" value="<?php echo (int)$product['id']; ?>">
        <input type="number" name="qty" class="form-control" style="max-width:120px" value="1" min="1">
        <button class="btn btn-primary">Add to Cart</button>
      </form>
      <?php if (($u = current_user()) && (($u['role'] ?? '') === 'customer')): ?>
        <div class="mt-2">
          <?php if (!empty($wishlisted)): ?>
            <a class="btn btn-outline-secondary btn-sm" href="<?php echo base_url('wishlist/remove/'.$product['id']); ?>"><i class="fa-solid fa-heart-crack"></i> Remove from Wishlist</a>
          <?php else: ?>
            <a class="btn btn-outline-primary btn-sm" href="<?php echo base_url('wishlist/add/'.$product['id']); ?>"><i class="fa-regular fa-heart"></i> Add to Wishlist</a>
          <?php endif; ?>
        </div>
      <?php endif; ?>

      <div class="mt-4">
        <h5>Related Products</h5>
        <div class="small text-muted">Explore similar items in category</div>
        <div class="row g-3 mt-2">
          <?php foreach (($related ?? []) as $rp): ?>
          <div class="col-6 col-lg-4">
            <div class="product-card">
              <a href="<?php echo base_url('product/detail/'.$rp['id']); ?>">
                <img class="product-thumb" src="<?php echo e((json_decode($rp['images'] ?? '[]', true)[0] ?? 'https://picsum.photos/seed/'.intval($rp['id']).'/600/450')); ?>" alt="thumb">
              </a>
              <div class="product-body">
                <a class="text-decoration-none d-block fw-semibold" href="<?php echo base_url('product/detail/'.$rp['id']); ?>"><?php echo e($rp['name']); ?></a>
                <div class="price">₹<?php echo number_format($rp['price'] ?? 0, 2); ?></div>
              </div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>

  <div class="row mt-5">
    <div class="col-md-8" data-aos="fade-up">
      <h5 class="mb-3">Customer Reviews</h5>
      <div class="list-group">
        <?php foreach (($reviews ?? []) as $rv): ?>
          <div class="list-group-item" style="background: var(--card); color: var(--fg); border-color: var(--border)">
            <div class="d-flex justify-content-between align-items-center">
              <strong><?php echo e($rv['name']); ?></strong>
              <span class="text-warning small">
                <?php for ($s=1;$s<=5;$s++): ?>
                  <?php if ($s <= (int)$rv['rating']): ?>
                    <i class="fa-solid fa-star"></i>
                  <?php else: ?>
                    <i class="fa-regular fa-star"></i>
                  <?php endif; ?>
                <?php endfor; ?>
              </span>
            </div>
            <div class="mt-1 small text-muted">Rating: <?php echo (int)$rv['rating']; ?>/5</div>
            <p class="mb-0 mt-2"><?php echo nl2br(e($rv['comment'] ?? '')); ?></p>
          </div>
        <?php endforeach; ?>
        <?php if (empty($reviews)): ?>
          <div class="list-group-item text-muted" style="background: var(--card); color: var(--fg); border-color: var(--border)">No reviews yet.</div>
        <?php endif; ?>
      </div>
      <?php if (($u = current_user()) && (($u['role'] ?? '') === 'customer')): ?>
      <div class="mt-4 p-3 rounded-4" style="background: var(--card); border:1px solid var(--border)">
        <h6 class="mb-2">Write a review</h6>
        <form method="post" action="<?php echo base_url('product/addReview/'.$product['id']); ?>">
          <div class="row g-2">
            <div class="col-md-3">
              <select class="form-select" name="rating" required>
                <option value="5">5 - Excellent</option>
                <option value="4">4 - Good</option>
                <option value="3">3 - Average</option>
                <option value="2">2 - Poor</option>
                <option value="1">1 - Terrible</option>
              </select>
            </div>
            <div class="col-md-9">
              <input class="form-control" name="comment" placeholder="Share your experience (optional)">
            </div>
          </div>
          <button class="btn btn-primary mt-2">Submit Review</button>
        </form>
      </div>
      <?php endif; ?>
    </div>
  </div>
</div>
