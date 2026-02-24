<div class="container py-5" data-aos="fade-up">
  <div class="row justify-content-center">
    <div class="col-md-5">
      <div class="card p-4" style="background: var(--card); border:1px solid var(--border)">
        <h3 class="mb-3">Forgot Password</h3>
        <form method="post">
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" name="email" required>
          </div>
          <button class="btn btn-primary">Send reset link</button>
        </form>
        <div class="mt-3 small"><a href="<?php echo base_url('auth/login'); ?>">Back to login</a></div>
      </div>
    </div>
  </div>
</div>
