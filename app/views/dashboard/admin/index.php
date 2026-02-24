<div class="container py-4">
  <h3 class="mb-4">Admin Dashboard</h3>
  <div class="row g-3" data-aos="fade-up">
    <div class="col-6 col-md-3"><div class="p-3 rounded-4 border" style="border-color: var(--border)!important; background: var(--card)"><div class="text-muted">Users</div><div class="fs-3 fw-bold"><?php echo (int)($stats['users'] ?? 0); ?></div></div></div>
    <div class="col-6 col-md-3"><div class="p-3 rounded-4 border" style="border-color: var(--border)!important; background: var(--card)"><div class="text-muted">Vendors</div><div class="fs-3 fw-bold"><?php echo (int)($stats['vendors'] ?? 0); ?></div></div></div>
    <div class="col-6 col-md-3"><div class="p-3 rounded-4 border" style="border-color: var(--border)!important; background: var(--card)"><div class="text-muted">Products</div><div class="fs-3 fw-bold"><?php echo (int)($stats['products'] ?? 0); ?></div></div></div>
    <div class="col-6 col-md-3"><div class="p-3 rounded-4 border" style="border-color: var(--border)!important; background: var(--card)"><div class="text-muted">Orders</div><div class="fs-3 fw-bold"><?php echo (int)($stats['orders'] ?? 0); ?></div></div></div>
  </div>

  <div class="row mt-4 g-4">
    <div class="col-md-8" data-aos="fade-up" data-aos-delay="100">
      <div class="p-3 rounded-4 border" style="border-color: var(--border)!important; background: var(--card)">
        <h5 class="mb-3">Sales Overview (demo)</h5>
        <canvas id="salesChart" height="120"></canvas>
      </div>
    </div>
    <div class="col-md-4" data-aos="fade-up" data-aos-delay="150">
      <div class="p-3 rounded-4 border" style="border-color: var(--border)!important; background: var(--card)">
        <h5 class="mb-3">Quick Links</h5>
        <ul class="list-unstyled mb-0">
          <li><a href="<?php echo base_url('admin/vendors'); ?>" class="text-decoration-none">Pending Vendors</a></li>
          <li><a href="<?php echo base_url('admin/categories'); ?>" class="text-decoration-none">Manage Categories</a></li>
        </ul>
      </div>
    </div>
  </div>
</div>
<script>
  (function(){
    const ctx = document.getElementById('salesChart');
    if (!ctx || !window.Chart) return;
    const labels = ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'];
    const data = labels.map((_,i)=>Math.round(50 + Math.random()*150));
    new Chart(ctx, { type: 'line', data: { labels, datasets: [{ label: 'Orders', data, borderColor: '#0d6efd', backgroundColor: 'rgba(13,110,253,.15)', tension:.3, fill:true }]}, options: { plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } } });
  })();
</script>
