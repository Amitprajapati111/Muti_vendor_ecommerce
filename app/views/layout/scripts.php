<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<?php $SIMPLE = (defined('SIMPLE_MODE') && SIMPLE_MODE); ?>
<?php if (!$SIMPLE): ?>
  <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<?php endif; ?>
<script>
  window.APP_BASE = '<?php echo rtrim(base_url(''), '/'); ?>/';
</script>
<script src="<?php echo asset('js/app.js'); ?>"></script>
</body>
</html>
