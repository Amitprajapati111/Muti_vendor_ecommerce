<?php /** @var string $title */ ?>
<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Multi-vendor eCommerce platform with modern UI and smooth animations.">
  <meta name="keywords" content="ecommerce, multi-vendor, shop, buy, sell">
  <meta name="author" content="<?php echo e(APP_NAME); ?>">
  <?php
    $meta_title = $title ?? APP_NAME;
    $meta_description = $meta_description ?? 'Multi-vendor eCommerce platform with modern UI and smooth animations.';
    $meta_url = current_url();
    $meta_image = $meta_image ?? 'https://picsum.photos/seed/multivendor-eshop/1200/630';
    $SIMPLE = (defined('SIMPLE_MODE') && SIMPLE_MODE);
  ?>
  <title><?php echo e($meta_title); ?></title>
  <link rel="canonical" href="<?php echo e($meta_url); ?>">
  <meta property="og:title" content="<?php echo e($meta_title); ?>" />
  <meta property="og:description" content="<?php echo e($meta_description); ?>" />
  <meta property="og:url" content="<?php echo e($meta_url); ?>" />
  <meta property="og:image" content="<?php echo e($meta_image); ?>" />
  <meta property="og:type" content="website" />
  <meta name="twitter:card" content="summary_large_image" />
  <meta name="twitter:title" content="<?php echo e($meta_title); ?>" />
  <meta name="twitter:description" content="<?php echo e($meta_description); ?>" />
  <meta name="twitter:image" content="<?php echo e($meta_image); ?>" />
  <meta name="theme-color" content="#0d6efd" />
  <?php if (!$SIMPLE): ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <?php endif; ?>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
  <?php if (!$SIMPLE): ?>
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet" />
  <?php endif; ?>
  <link rel="stylesheet" href="<?php echo asset('css/styles.css'); ?>">
  <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='0.9em' font-size='90'>🛍️</text></svg>">
  <?php if (!$SIMPLE): ?>
    <noscript>
      <style>#loader{display:none!important}#app{opacity:1!important}</style>
    </noscript>
    <script>
      // Inline fail-safe: hide loader even if external scripts hang or block
      document.addEventListener('DOMContentLoaded', function(){
        setTimeout(function(){
          var l=document.getElementById('loader'); if(l) l.style.display='none';
          var a=document.getElementById('app'); if(a) a.classList.remove('opacity-0');
        }, 250);
      });
    </script>
  <?php endif; ?>
</head>
<body>
<?php if (!$SIMPLE): ?>
  <div id="loader" class="loader-overlay d-flex align-items-center justify-content-center">
    <div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>
  </div>
<?php endif; ?>
<div id="app" <?php echo $SIMPLE ? '' : 'class="opacity-0"'; ?>>
