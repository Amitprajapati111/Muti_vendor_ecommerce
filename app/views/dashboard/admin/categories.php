<div class="container py-4">
  <div class="d-flex align-items-center justify-content-between mb-3">
    <h3>Manage Categories</h3>
    <a class="btn btn-outline-secondary" href="<?php echo base_url('admin/dashboard'); ?>">Back to Dashboard</a>
  </div>

  <div class="row g-4">
    <div class="col-md-5">
      <div class="p-3 rounded-4" style="background: var(--card); border:1px solid var(--border)" data-aos="fade-right">
        <h5 class="mb-3">Add Category</h5>
        <form method="post" action="<?php echo base_url('admin/addCategory'); ?>">
          <div class="mb-3">
            <label class="form-label">Category Name</label>
            <input class="form-control" type="text" name="name" placeholder="e.g., Electronics" required>
          </div>
          <button class="btn btn-primary">Add</button>
        </form>
      </div>
    </div>
    <div class="col-md-7">
      <div class="p-3 rounded-4" style="background: var(--card); border:1px solid var(--border)" data-aos="fade-left">
        <h5 class="mb-3">All Categories</h5>
        <div class="table-responsive">
          <table class="table align-middle">
            <thead><tr><th>#</th><th>Name</th><th>Action</th></tr></thead>
            <tbody>
              <?php $i=1; foreach (($categories ?? []) as $c): ?>
              <tr>
                <td><?php echo $i++; ?></td>
                <td><?php echo e($c['name']); ?></td>
                <td>
                  <a class="btn btn-sm btn-outline-danger" href="<?php echo base_url('admin/deleteCategory/'.$c['id']); ?>" onclick="return confirm('Delete this category?');">Delete</a>
                </td>
              </tr>
              <?php endforeach; ?>
              <?php if (empty($categories)): ?>
                <tr><td colspan="3" class="text-center text-muted">No categories yet.</td></tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
