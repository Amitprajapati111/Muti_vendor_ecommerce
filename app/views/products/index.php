<div class="container py-4">
  <div class="row g-4">
    <aside class="col-md-3" data-aos="fade-right">
      <div class="p-3 rounded-4" style="background: var(--card); border:1px solid var(--border)">
        <h5>Filters</h5>
        <form method="get">
          <div class="mb-3">
            <label class="form-label">Search</label>
            <input class="form-control" type="text" name="q" value="<?php echo e($filters['q'] ?? ''); ?>">
          </div>
          <div class="mb-3">
            <label class="form-label">Category</label>
            <select class="form-select" name="category_id">
              <option value="">All</option>
              <?php foreach ($categories as $c): ?>
                <option value="<?php echo (int)$c['id']; ?>" <?php echo ((int)($filters['category_id'] ?? 0) === (int)$c['id'])?'selected':''; ?>><?php echo e($c['name']); ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Price range (₹)</label>
            <div class="row g-2">
              <div class="col"><input class="form-control" type="number" placeholder="Min" name="min" value="<?php echo e($filters['min'] ?? ''); ?>"></div>
              <div class="col"><input class="form-control" type="number" placeholder="Max" name="max" value="<?php echo e($filters['max'] ?? ''); ?>"></div>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label">Brand</label>
            <input class="form-control" type="text" name="brand" value="<?php echo e($filters['brand'] ?? ''); ?>">
          </div>
          <div class="mb-3">
            <label class="form-label">Vendor</label>
            <select class="form-select" name="vendor_id">
              <option value="">All Vendors</option>
              <?php foreach (($vendors ?? []) as $v): ?>
                <option value="<?php echo (int)$v['id']; ?>" <?php echo ((int)($filters['vendor_id'] ?? 0) === (int)$v['id'])?'selected':''; ?>><?php echo e($v['shop_name']); ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Minimum rating</label>
            <select class="form-select" name="min_rating">
              <?php $mr = (float)($filters['min_rating'] ?? 0); ?>
              <option value="" <?php echo $mr? '':'selected'; ?>>Any</option>
              <option value="4" <?php echo ($mr>=4)?'selected':''; ?>>4+ stars</option>
              <option value="3" <?php echo ($mr>=3 && $mr<4)?'selected':''; ?>>3+ stars</option>
              <option value="2" <?php echo ($mr>=2 && $mr<3)?'selected':''; ?>>2+ stars</option>
              <option value="1" <?php echo ($mr>=1 && $mr<2)?'selected':''; ?>>1+ star</option>
            </select>
          </div>
          <button class="btn btn-primary w-100">Apply</button>
        </form>
      </div>
    </aside>
    <main class="col-md-9">
      <div class="row g-3 g-md-4" data-aos="fade-up">
        <?php foreach (($products ?? []) as $p): ?>
        <div class="col-6 col-lg-4">
          <div class="product-card">
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
              <?php $avg = isset($p['avg_rating']) ? (float)$p['avg_rating'] : 0; $rc = (int)($p['rating_count'] ?? 0); ?>
              <div class="mt-1 small d-flex align-items-center gap-1">
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
          </div>
        </div>
        <?php endforeach; ?>
      </div>

      <?php if (($pagination['pages'] ?? 1) > 1): ?>
      <nav class="mt-4">
        <ul class="pagination justify-content-center">
          <?php for ($i=1; $i<=($pagination['pages'] ?? 1); $i++): ?>
            <li class="page-item <?php echo ($i==($pagination['page'] ?? 1))?'active':''; ?>">
              <a class="page-link" href="<?php echo base_url('product/index/'.$i.'?'.http_build_query($filters)); ?>"><?php echo $i; ?></a>
            </li>
          <?php endfor; ?>
        </ul>
      </nav>
      <?php endif; ?>
    </main>
  </div>
</div>
