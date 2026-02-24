<div class="container py-5" data-aos="fade-up">
  <div class="row justify-content-center">
    <div class="col-md-7">
      <div class="card p-4" style="background: var(--card); border:1px solid var(--border)">
        <h3 class="mb-3">Register</h3>
        <form method="post">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">Full Name</label>
              <input type="text" class="form-control" name="name" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Email</label>
              <input type="email" class="form-control" name="email" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Password</label>
              <input type="password" class="form-control" name="password" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Account Type</label>
              <select class="form-select" name="role" id="roleSelect">
                <option value="customer">Customer</option>
                <option value="vendor">Vendor</option>
              </select>
            </div>
            <div id="vendorFields" class="row g-3 d-none">
              <div class="col-md-6">
                <label class="form-label">Shop Name</label>
                <input type="text" class="form-control" name="shop_name">
              </div>
              <div class="col-md-6">
                <label class="form-label">Shop Description</label>
                <input type="text" class="form-control" name="description">
              </div>
            </div>
          </div>
          <div class="mt-3 d-flex justify-content-end">
            <button class="btn btn-primary">Create Account</button>
          </div>
        </form>
        <div class="mt-3 small">Already have an account? <a href="<?php echo base_url('auth/login'); ?>">Login</a></div>
      </div>
    </div>
  </div>
</div>
<script>
  (function(){
    const sel = document.getElementById('roleSelect');
    const vf = document.getElementById('vendorFields');
    function toggle(){ vf.classList.toggle('d-none', sel.value!=='vendor'); }
    sel?.addEventListener('change', toggle); toggle();
  })();
</script>
