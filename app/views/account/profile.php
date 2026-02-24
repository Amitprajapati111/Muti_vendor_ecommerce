<div class="container py-4">
  <h3 class="mb-3">My Profile</h3>
  <div class="row">
    <div class="col-md-6">
      <div class="p-3 rounded-4" style="background: var(--card); border:1px solid var(--border)" data-aos="fade-up">
        <form method="post">
          <div class="mb-3">
            <label class="form-label">Full Name</label>
            <input class="form-control" type="text" name="name" value="<?php echo e($user['name']); ?>" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input class="form-control" type="email" value="<?php echo e($user['email']); ?>" disabled>
          </div>
          <button class="btn btn-primary">Save Changes</button>
        </form>
      </div>
    </div>
  </div>
</div>
