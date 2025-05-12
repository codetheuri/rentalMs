<?php
use yii\helpers\Html;
use yii\helpers\Url;
use ui\bundles\DashboardAsset;
DashboardAsset::register($this);
?>

<div class="landing-page">
    <!-- Hero Section -->
    <section class="hero-section" style="background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%); color: var(--text-light);">
        <div class="container py-5">
            <div class="row align-items-center py-5">
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <h1 class="display-4 fw-bold mb-4">Streamline Your Rental Properties</h1>
                    <p class="lead mb-4">The complete solution for landlords and property managers to automate operations, reduce vacancies, and maximize profits.</p>
                    
                    <div class="d-flex flex-wrap gap-3 mb-4">
                        <a class="btn btn-primary btn-lg px-4" href="<?=Url::to(['/dashboard/iam/login'])?>">
                            Get Started <i class="bi bi-arrow-right ms-2"></i>
                        </a>
                        <a href="#features" class="btn btn-outline-light btn-lg px-4">
                            Explore Features <i class="bi bi-grid ms-2"></i>
                        </a>
                    </div>
                    
                    <div class="d-flex flex-wrap gap-4" style="color: var(--text-muted);">
                        <div><i class="bi bi-check-circle-fill text-success me-2"></i> No credit card required</div>
                        <div><i class="bi bi-people-fill text-info me-2"></i> Trusted by 500+ landlords</div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <img src="https://images.unsplash.com/photo-1560518883-ce09059eeffa?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80" 
                         alt="Modern apartment building" 
                         class="img-fluid rounded shadow-lg">
                </div>
            </div>
        </div>
    </section>



    <!-- Features Section -->
    <section id="features" class="py-5">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h2 class="fw-bold mb-3">Powerful Features for Property Management</h2>
                <p class="text-muted lead">Everything you need to manage your rental properties efficiently</p>
            </div>
            
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="feature-icon" style="background-color: rgba(26, 26, 52, 0.1); color: var(--primary-color);">
                                <i class="bi bi-shield-lock fs-2"></i>
                            </div>
                            <h3 class="h4">Secure Access</h3>
                            <p class="text-muted">Role-based access control ensures Admins, Landlords, and Tenants only see what they need with enterprise-grade security.</p>
                            <ul class="text-muted">
                                <li>Multi-factor authentication</li>
                                <li>Permission management</li>
                                <li>Activity logging</li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="feature-icon" style="background-color: rgba(26, 26, 52, 0.1); color: var(--primary-color);">
                                <i class="bi bi-building fs-2"></i>
                            </div>
                            <h3 class="h4">Property Management</h3>
                            <p class="text-muted">Complete control over your properties with detailed records, photos, and documentation.</p>
                            <ul class="text-muted">
                                <li>Unlimited properties & units</li>
                                <li>Custom property fields</li>
                                <li>Document storage</li>
                                <li>Tenant assignment</li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="feature-icon" style="background-color: rgba(26, 26, 52, 0.1); color: var(--primary-color);">
                                <i class="bi bi-tools fs-2"></i>
                            </div>
                            <h3 class="h4">Maintenance Tracking</h3>
                            <p class="text-muted">Streamline maintenance requests with automated workflows and tracking.</p>
                            <ul class="text-muted">
                                <li>Tenant request portal</li>
                                <li>Priority management</li>
                                <li>Vendor coordination</li>
                                <li>Real-time updates</li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <!-- Additional feature cards -->
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="feature-icon" style="background-color: rgba(26, 26, 52, 0.1); color: var(--primary-color);">
                                <i class="bi bi-cash-coin fs-2"></i>
                            </div>
                            <h3 class="h4">Rent Collection</h3>
                            <p class="text-muted">Automated rent collection with multiple payment options and tracking.</p>
                            <ul class="text-muted">
                                <li>Online payments</li>
                                <li>Automatic reminders</li>
                                <li>Receipt generation</li>
                                <li>Late fee calculation</li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="feature-icon" style="background-color: rgba(26, 26, 52, 0.1); color: var(--primary-color);">
                                <i class="bi bi-file-earmark-text fs-2"></i>
                            </div>
                            <h3 class="h4">Lease Management</h3>
                            <p class="text-muted">Create, sign, and manage leases digitally with customizable templates.</p>
                            <ul class="text-muted">
                                <li>E-signature support</li>
                                <li>Auto-renewal options</li>
                                <li>Lease term tracking</li>
                                <li>Custom clauses</li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="feature-icon" style="background-color: rgba(26, 26, 52, 0.1); color: var(--primary-color);">
                                <i class="bi bi-graph-up fs-2"></i>
                            </div>
                            <h3 class="h4">Reporting & Analytics</h3>
                            <p class="text-muted">Comprehensive reports to analyze your property performance.</p>
                            <ul class="text-muted">
                                <li>Financial reports</li>
                                <li>Vacancy analysis</li>
                                <li>Maintenance costs</li>
                                <li>Custom report builder</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section id="how-it-works" class="py-5 bg-light">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h2 class="fw-bold mb-3">How It Works</h2>
                <p class="text-muted lead">Get started in just a few simple steps</p>
            </div>
            
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="text-center px-3">
                        <div class="step-number rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                             style="background-color: var(--primary-color); color: white; width: 50px; height: 50px; font-size: 1.5rem; font-weight: bold;">1</div>
                        <h3 class="h4">Sign Up</h3>
                        <p class="text-muted">Create your account in minutes. No long-term contracts or setup fees.</p>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="text-center px-3">
                        <div class="step-number rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                             style="background-color: var(--primary-color); color: white; width: 50px; height: 50px; font-size: 1.5rem; font-weight: bold;">2</div>
                        <h3 class="h4">Add Properties</h3>
                        <p class="text-muted">Enter your property details, upload photos, and set up units.</p>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="text-center px-3">
                        <div class="step-number rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                             style="background-color: var(--primary-color); color: white; width: 50px; height: 50px; font-size: 1.5rem; font-weight: bold;">3</div>
                        <h3 class="h4">Invite Tenants</h3>
                        <p class="text-muted">Onboard tenants with secure portals for communication and payments.</p>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-5">
                <a href="<?=Url::to(['/dashboard/iam/login'])?>" class="btn btn-primary btn-lg px-4" style="background-color: var(--primary-color); border-color: var(--primary-dark);">
                    Start Managing Properties Now <i class="bi bi-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="testimonials" class="py-5">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h2 class="fw-bold mb-3">What Our Customers Say</h2>
                <p class="text-muted lead">Trusted by property managers and landlords nationwide</p>
            </div>
            
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="mb-3 text-warning">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                            </div>
                            <p class="mb-4">"This system cut our administrative work by 70%. The maintenance tracking alone is worth the price!"</p>
                            <div class="d-flex align-items-center">
                                <img src="https://randomuser.me/api/portraits/women/45.jpg" alt="User" class="rounded-circle me-3" width="50">
                                <div>
                                    <h6 class="mb-0">Sarah Johnson</h6>
                                    <small class="text-muted">Property Manager, Nairobi</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="mb-3 text-warning">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                            </div>
                            <p class="mb-4">"As a landlord with multiple properties, this system has been a game-changer for organization and tenant communication."</p>
                            <div class="d-flex align-items-center">
                                <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="User" class="rounded-circle me-3" width="50">
                                <div>
                                    <h6 class="mb-0">Michael Omondi</h6>
                                    <small class="text-muted">Landlord, Mombasa</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="mb-3 text-warning">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-half"></i>
                            </div>
                            <p class="mb-4">"The tenant portal makes rent payments so easy. I've had zero late payments since switching to this system."</p>
                            <div class="d-flex align-items-center">
                                <img src="https://randomuser.me/api/portraits/women/68.jpg" alt="User" class="rounded-circle me-3" width="50">
                                <div>
                                    <h6 class="mb-0">Grace Wambui</h6>
                                    <small class="text-muted">Property Owner, Kisumu</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-5" style="background-color: var(--primary-color); color: white;">
        <div class="container py-5">
            <div class="row align-items-center">
                <div class="col-lg-8 mb-4 mb-lg-0">
                    <h2 class="fw-bold mb-3">Ready to Transform Your Property Management?</h2>
                    <p class="lead mb-0">Join thousands of landlords and property managers who trust our system.</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a href="<?=Url::to(['/dashboard/iam/login'])?>" class="btn btn-light btn-lg px-4">
                        Get Started Today <i class="bi bi-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
    .feature-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    
    .grayscale {
        filter: grayscale(100%);
        opacity: 0.7;
        transition: all 0.3s ease;
    }
    
    .grayscale:hover {
        filter: grayscale(0);
        opacity: 1;
    }
    
    .hero-section {
        padding: 5rem 0;
    }
    
    .btn-primary {
        background-color: var(--primary-color);
        border-color: var(--primary-dark);
    }
    
    .btn-primary:hover {
        background-color: var(--primary-dark);
        border-color: var(--primary-dark);
    }
    
    .btn-outline-light:hover {
        color: var(--primary-color);
    }
</style>