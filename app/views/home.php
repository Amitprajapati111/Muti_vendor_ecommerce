<div class="container mt-4">
  <div class="p-4 p-md-5 hero" data-aos="fade-up">
    <div id="homeCarousel" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-inner">
        <div class="carousel-item active">
          <div class="row align-items-center g-4">
            <div class="col-md-6">
              <h1 class="display-6 fw-bold">Discover Trending Products</h1>
              <p class="lead text-muted">Shop top categories from verified vendors. Smooth experience with a modern, responsive UI.</p>
              <a href="<?php echo base_url('product'); ?>" class="btn btn-primary btn-lg">Shop Now</a>
            </div>
            <div class="col-md-6 text-center">
              <img src="https://images.unsplash.com/photo-1542291026-7eec264c27ff?q=80&w=1080&auto=format&fit=crop" class="img-fluid rounded-4 shadow" alt="Banner">
            </div>
          </div>
        </div>
        <div class="carousel-item">
          <div class="row align-items-center g-4">
            <div class="col-md-6">
              <h2 class="fw-bold">Multi‑Vendor Marketplace</h2>
              <p class="text-muted">Vendors manage products and orders. Admin oversees approvals and analytics.</p>
              <a href="<?php echo base_url('auth/register'); ?>" class="btn btn-outline-primary">Become a Vendor</a>
            </div>
            <div class="col-md-6 text-center">
              <img src="https://images.unsplash.com/photo-1525904097878-94fb15835963?q=80&w=1080&auto=format&fit=crop" class="img-fluid rounded-4 shadow" alt="Banner 2">
            </div>
          </div>
        </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#homeCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#homeCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
  </div>

  <section class="mt-5" data-aos="fade-up">
    <h3 class="fw-semibold mb-3">Featured Categories</h3>
    <div class="d-flex flex-wrap gap-2">
      <?php foreach (($categories ?? []) as $c): ?>
        <a href="<?php echo base_url('product?category_id='.$c['id']); ?>" class="category-chip"># <?php echo e($c['name']); ?></a>
      <?php endforeach; ?>
    </div>
  </section>

  <section class="mt-5" data-aos="fade-up" data-aos-delay="100">
    <div class="d-flex align-items-center justify-content-between mb-3">
      <h3 class="fw-semibold">Trending Products</h3>
      <a href="<?php echo base_url('product'); ?>" class="text-decoration-none">View All</a>
    </div>
    <div class="row g-3 g-md-4">
      <?php foreach (($featured ?? []) as $p): ?>
      <div class="col-6 col-md-3">
        <div class="product-card" data-aos="zoom-in">
          <a href="<?php echo base_url('product/detail/'.$p['id']); ?>"><img class="product-thumb" src="<?php echo e((json_decode($p['images'] ?? '[]', true)[0] ?? 'https://picsum.photos/seed/'.intval($p['id']).'/600/450')); ?>" alt="thumb"></a>
          <div class="product-body">
            <div class="small text-muted"><?php echo e($p['category_name'] ?? ''); ?></div>
            <a class="text-decoration-none d-block fw-semibold" href="<?php echo base_url('product/detail/'.$p['id']); ?>"><?php echo e($p['name']); ?></a>
            <div class="d-flex align-items-center justify-content-between">
              <div class="price">₹<?php echo number_format($p['price'] ?? 0, 2); ?></div>
              <form method="post" action="<?php echo base_url('cart/add'); ?>">
                <input type="hidden" name="product_id" value="<?php echo (int)$p['id']; ?>">
                <button class="btn btn-sm btn-primary">Add</button>
              </form>
            </div>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </section>

  <section class="mt-5" data-aos="fade-up" data-aos-delay="150">
    <div class="row g-4 align-items-center">
      <div class="col-md-6">
        <div class="p-4 rounded-4" style="background: var(--card); border:1px solid var(--border)">
          <h4 class="fw-semibold">What our customers say</h4>
          <div id="testimonials" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
              <div class="carousel-item active">
                <blockquote class="blockquote">“Beautiful UI and smooth experience. Love the quick checkout.”</blockquote>
                <figcaption class="blockquote-footer">Priya S.</figcaption>
              </div>
              <div class="carousel-item">
                <blockquote class="blockquote">“Vendor dashboard is simple yet powerful. Adding products is easy.”</blockquote>
                <figcaption class="blockquote-footer">Amit K.</figcaption>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="p-4 rounded-4" style="background: var(--card); border:1px solid var(--border)">
          <h4 class="fw-semibold">Subscribe to our newsletter</h4>
          <form class="row g-2">
            <div class="col-8"><input type="email" class="form-control" placeholder="Enter your email"></div>
            <div class="col-4"><button class="btn btn-primary w-100" type="button">Subscribe</button></div>
          </form>
        </div>
      </div>
    </div>
  </section>
</div>
