<div class="container py-5" data-aos="fade-up">
  <div class="row justify-content-center">
    <div class="col-md-5">
      <div class="card p-4" style="background: var(--card); border:1px solid var(--border)">
        <h3 class="mb-3">Login</h3>
        <form method="post">
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" name="email" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" class="form-control" name="password" required>
          </div>
          <div class="d-flex justify-content-between align-items-center">
            <a href="<?php echo base_url('auth/forgot'); ?>" class="small">Forgot password?</a>
            <button class="btn btn-primary">Login</button>
          </div>
        </form>
        <div class="mt-3 small">Don't have an account? <a href="<?php echo base_url('auth/register'); ?>">Register</a></div>
      </div>
    </div>
  </div>
</div>
