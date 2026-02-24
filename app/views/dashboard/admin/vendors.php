<div class="container py-4">
  <div class="d-flex align-items-center justify-content-between mb-3">
    <h3>Pending Vendors</h3>
  </div>
  <div class="table-responsive" data-aos="fade-up">
    <table class="table align-middle">
      <thead><tr><th>#</th><th>Shop</th><th>Owner</th><th>Email</th><th>Status</th><th>Actions</th></tr></thead>
      <tbody>
        <?php $i=1; foreach (($vendors ?? []) as $v): ?>
        <tr>
          <td><?php echo $i++; ?></td>
          <td><?php echo e($v['shop_name']); ?></td>
          <td><?php echo e($v['name']); ?></td>
          <td><?php echo e($v['email']); ?></td>
          <td><span class="badge text-bg-warning">Pending</span></td>
          <td>
            <a class="btn btn-sm btn-success" href="<?php echo base_url('admin/approveVendor/'.$v['id']); ?>">Approve</a>
            <a class="btn btn-sm btn-outline-danger" href="<?php echo base_url('admin/rejectVendor/'.$v['id']); ?>">Reject</a>
          </td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($vendors)): ?>
          <tr><td colspan="6" class="text-center text-muted">No pending vendors.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
