<div class="container py-4">
  <div class="d-flex align-items-center justify-content-between mb-3">
    <h3>My Products</h3>
    <button class="btn btn-primary" data-bs-toggle="collapse" data-bs-target="#addForm">Add Product</button>
  </div>
  <div id="addForm" class="collapse">
    <div class="p-3 rounded-4 mb-4" style="background: var(--card); border:1px solid var(--border)">
      <form method="post" action="<?php echo base_url('vendor/addProduct'); ?>">
        <div class="row g-3">
          <div class="col-md-6"><input class="form-control" name="name" placeholder="Product Name" required></div>
          <div class="col-md-3"><input class="form-control" name="price" placeholder="Price" type="number" step="0.01" required></div>
          <div class="col-md-3"><input class="form-control" name="stock" placeholder="Stock" type="number" required></div>
          <div class="col-md-6">
            <select class="form-select" name="category_id" required>
              <option value="">Category</option>
              <?php foreach (($categories ?? []) as $c): ?>
                <option value="<?php echo (int)$c['id']; ?>"><?php echo e($c['name']); ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-md-6"><input class="form-control" name="brand" placeholder="Brand (optional)"></div>
          <div class="col-12"><textarea class="form-control" name="description" rows="3" placeholder="Description"></textarea></div>
          <div class="col-12">
            <label class="form-label">Image URLs (one per line)</label>
            <textarea class="form-control" name="images" rows="3" placeholder="https://...\nhttps://..."></textarea>
          </div>
        </div>
        <div class="mt-3 d-flex justify-content-end">
          <button class="btn btn-primary">Save Product</button>
        </div>
      </form>
    </div>
  </div>

  <div class="table-responsive" data-aos="fade-up">
    <table class="table align-middle">
      <thead>
        <tr>
          <th>#</th>
          <th>Name</th>
          <th>Price</th>
          <th>Stock</th>
          <th>Category</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php $i=1; foreach (($items ?? []) as $p): ?>
        <tr>
          <td><?php echo $i++; ?></td>
          <td><?php echo e($p['name']); ?></td>
          <td>₹<?php echo number_format((float)$p['price'], 2); ?></td>
          <td><?php echo (int)$p['stock']; ?></td>
          <td><?php echo (int)$p['category_id']; ?></td>
          <td>
            <div class="btn-group btn-group-sm">
              <a class="btn btn-outline-danger" href="<?php echo base_url('vendor/deleteProduct/'.$p['id']); ?>" onclick="return confirm('Delete this product?');">Delete</a>
            </div>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
