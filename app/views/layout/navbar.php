<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
  <div class="container">
    <a class="navbar-brand fw-bold text-primary" href="<?php echo base_url('home'); ?>"><?php echo e(APP_NAME); ?></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <form class="d-flex ms-auto me-3 w-50 position-relative" role="search" onsubmit="return false;">
        <input id="globalSearch" class="form-control" type="search" placeholder="Search products..." aria-label="Search">
        <div id="searchResults" class="list-group position-absolute w-100 shadow-sm d-none" style="top: 100%; z-index: 1050;"></div>
      </form>
      <ul class="navbar-nav mb-2 mb-lg-0 align-items-lg-center">
        <li class="nav-item"><a class="nav-link" href="<?php echo base_url('product'); ?>">Products</a></li>
        <li class="nav-item"><a class="nav-link" href="<?php echo base_url('cart'); ?>"><i class="fa-solid fa-cart-shopping"></i> Cart</a></li>
        <?php if ($u = current_user()): ?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="fa-solid fa-user"></i> <?php echo e($u['name']); ?>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <?php if (($u['role'] ?? '') === 'vendor'): ?>
                <li><a class="dropdown-item" href="<?php echo base_url('vendor/products'); ?>">Vendor Dashboard</a></li>
              <?php elseif (($u['role'] ?? '') === 'admin'): ?>
                <li><a class="dropdown-item" href="<?php echo base_url('admin/dashboard'); ?>">Admin Dashboard</a></li>
              <?php endif; ?>
              <li><a class="dropdown-item" href="<?php echo base_url('account/profile'); ?>">Profile</a></li>
              <?php if (($u['role'] ?? '') === 'customer'): ?>
                <li><a class="dropdown-item" href="<?php echo base_url('account/orders'); ?>">My Orders</a></li>
                <li><a class="dropdown-item" href="<?php echo base_url('wishlist'); ?>">My Wishlist</a></li>
              <?php endif; ?>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="<?php echo base_url('auth/logout'); ?>">Logout</a></li>
            </ul>
          </li>
        <?php else: ?>
          <li class="nav-item"><a class="nav-link" href="<?php echo base_url('auth/login'); ?>">Login</a></li>
          <li class="nav-item"><a class="nav-link" href="<?php echo base_url('auth/register'); ?>">Register</a></li>
        <?php endif; ?>
        <li class="nav-item ms-lg-3">
          <button id="darkToggle" class="btn btn-sm btn-outline-secondary" title="Toggle dark mode"><i class="fa-regular fa-moon"></i></button>
        </li>
      </ul>
    </div>
  </div>
</nav>

<?php if ($msg = flash('success')): ?>
  <div class="container mt-3"><div class="alert alert-success alert-dismissible fade show" role="alert">
    <?php echo e($msg); ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div></div>
<?php endif; ?>
<?php if ($msg = flash('error')): ?>
  <div class="container mt-3"><div class="alert alert-danger alert-dismissible fade show" role="alert">
    <?php echo e($msg); ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div></div>
<?php endif; ?>
