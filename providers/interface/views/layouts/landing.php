<?php
use yii\helpers\Html;
use yii\web\View;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use ui\bundles\DashboardAsset;

DashboardAsset::register($this);

$this->beginPage();
?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
  <meta charset="<?= Yii::$app->charset ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?= Html::csrfMetaTags() ?>
  <title><?= Html::encode($this->title) ?></title>
  <?php $this->head() ?>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
  <style>
    :root {
      --primary-color: #1a1a34;
      --primary-light: #2a2a4a;
      --primary-dark: #0a0a1a;
      --accent-color: #4a6bff;
      --text-light: #f8f9fa;
      --text-muted: #adb5bd;
    }
    
    body {
      margin: 0;
      font-family: 'Segoe UI', -apple-system, BlinkMacSystemFont, sans-serif;
      color: #333;
      line-height: 1.6;
    }
    
    /* Navigation */
    .navbar-landing {
      background-color: var(--primary-color);
      color: var(--text-light);
      padding: 1rem 0;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    .navbar-landing .container {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    
    .navbar-brand {
      color: var(--text-light);
      font-weight: 700;
      font-size: 1.5rem;
      text-decoration: none;
      display: flex;
      align-items: center;
    }
    
    .navbar-brand i {
      margin-right: 10px;
    }
    
    .nav-links {
      display: flex;
      gap: 1.5rem;
    }
    
    .nav-links a {
      color: var(--text-light);
      text-decoration: none;
      font-weight: 500;
      transition: all 0.3s ease;
      padding: 0.5rem 0;
      position: relative;
    }
    
    .nav-links a:hover {
      color: var(--accent-color);
    }
    
    .nav-links a:after {
      content: '';
      position: absolute;
      width: 0;
      height: 2px;
      background: var(--accent-color);
      bottom: 0;
      left: 0;
      transition: width 0.3s ease;
    }
    
    .nav-links a:hover:after {
      width: 100%;
    }
    
    .nav-actions {
      display: flex;
      gap: 1rem;
    }
    
    .btn-nav {
      padding: 0.5rem 1.25rem;
      border-radius: 6px;
      font-weight: 500;
      transition: all 0.3s ease;
    }
    
    .btn-nav-primary {
      background-color: var(--accent-color);
      color: white;
      border: 2px solid var(--accent-color);
    }
    
    .btn-nav-primary:hover {
      background-color: transparent;
      color: var(--accent-color);
    }
    
    .btn-nav-outline {
      border: 2px solid var(--text-light);
      color: var(--text-light);
      background: transparent;
    }
    
    .btn-nav-outline:hover {
      background-color: var(--text-light);
      color: var(--primary-color);
    }
    
    /* Mobile menu */
    .mobile-menu-btn {
      display: none;
      background: none;
      border: none;
      color: white;
      font-size: 1.5rem;
      cursor: pointer;
    }
    
    /* Footer */
    footer {
      background-color: var(--primary-color);
      color: var(--text-muted);
      padding: 3rem 0 1.5rem;
    }
    
    @media (max-width: 992px) {
      .nav-links, .nav-actions {
        display: none;
      }
      
      .mobile-menu-btn {
        display: block;
      }
    }
  </style>
</head>
<body>
<?php $this->beginBody() ?>

<nav class="navbar navbar-expand-lg navbar-landing text-white">
  <div class="container">
    <a href="<?= Yii::$app->homeUrl ?>" class="navbar-brand">
      <i class="bi bi-house-door"></i> RentalMS
    </a>
    
    <div class="nav-links">
      <a href="#features">Features</a>
      <a href="#how-it-works">How It Works</a>
      <a href="#testimonials">Testimonials</a>
 
    </div>
    
    <div class="nav-actions">
      <a href="<?= Url::to(['/dashboard/iam/login']) ?>" class="btn-nav btn-nav-primary">
        <i class="bi bi-box-arrow-in-right"></i> Login
      </a>
   
    </div>
    
    <button class="mobile-menu-btn">
      <i class="bi bi-list"></i>
    </button>
  </div>
</nav>

<main role="main">
  <?= $content ?>
</main>

<footer>
  <div class="container">
    <div class="row">
      <div class="col-lg-4 mb-4">
        <h5 class="text-white mb-3"><i class="bi bi-house-door"></i> RentalMS</h5>
        <p>Streamlining property management for landlords and tenants with powerful tools and excellent support.</p>
        <div class="social-links mt-3">
          <a href="#" class="text-muted me-2"><i class="bi bi-facebook fs-5"></i></a>
          <a href="#" class="text-muted me-2"><i class="bi bi-twitter fs-5"></i></a>
          <a href="#" class="text-muted me-2"><i class="bi bi-linkedin fs-5"></i></a>
          <a href="#" class="text-muted"><i class="bi bi-instagram fs-5"></i></a>
        </div>
      </div>
      <div class="col-lg-2 col-md-4 mb-4">
        <h6 class="text-white mb-3">Product</h6>
        <ul class="list-unstyled">
          <li class="mb-2"><a href="#features" class="text-muted">Features</a></li>
          <li class="mb-2"><a href="#pricing" class="text-muted">Pricing</a></li>
          <li class="mb-2"><a href="#" class="text-muted">API</a></li>
          <li><a href="#" class="text-muted">Updates</a></li>
        </ul>
      </div>
      <div class="col-lg-2 col-md-4 mb-4">
        <h6 class="text-white mb-3">Company</h6>
        <ul class="list-unstyled">
          <li class="mb-2"><a href="#" class="text-muted">About Us</a></li>
          <li class="mb-2"><a href="#" class="text-muted">Careers</a></li>
          <li class="mb-2"><a href="#" class="text-muted">Blog</a></li>
          <li><a href="#" class="text-muted">Contact</a></li>
        </ul>
      </div>
      <div class="col-lg-2 col-md-4 mb-4">
        <h6 class="text-white mb-3">Support</h6>
        <ul class="list-unstyled">
          <li class="mb-2"><a href="#" class="text-muted">Help Center</a></li>
          <li class="mb-2"><a href="#" class="text-muted">Community</a></li>
          <li class="mb-2"><a href="#" class="text-muted">Tutorials</a></li>
        </ul>
      </div>
      <div class="col-lg-2 col-md-4">
        <h6 class="text-white mb-3">Legal</h6>
        <ul class="list-unstyled">
          <li class="mb-2"><a href="#" class="text-muted">Privacy</a></li>
          <li class="mb-2"><a href="#" class="text-muted">Terms</a></li>
          <li><a href="#" class="text-muted">Security</a></li>
        </ul>
      </div>
    </div>
    <hr class="my-4 bg-secondary">
    <div class="row">
      <div class="col-md-6 mb-3 mb-md-0">
        <p class="mb-0">&copy; <?= date('Y') ?> Rental Management System. All rights reserved.</p>
      </div>
  
    </div>
  </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>