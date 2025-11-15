@extends('layouts.app')
@section('page_title', 'Getting Started | Peoples Plus')
@section('content')

    <!-- Page Title -->
    <div class="page-title accent-background">
        <div class="container d-lg-flex justify-content-between align-items-center">
            <h1 class="mb-2 mb-lg-0">Getting Started with Payroll System</h1>
            <nav class="breadcrumbs">
                <ol>
                    <li><a href="/">Home</a></li>
                    <li class="current">Getting Started</li>
                </ol>
            </nav>
        </div>
    </div><!-- End Page Title -->

    <!-- Getting Started Section -->
    <section id="getting-started" class="services section light-background">
        <div class="container">
            <div class="section-title" data-aos="fade-up">
                <h2>How to Register & Access the Payroll System</h2>
                <p>Follow these simple steps to create your company account and start managing payroll efficiently.</p>
            </div>

            <div class="row gy-5">

                <!-- Step 1: Visit Registration Page -->
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="service-item item-cyan position-relative text-center">
                        <div class="icon mb-3">
                            <i class="bi bi-globe fs-1"></i>
                        </div>
                        <h3>Step 1: Visit Registration Page</h3>
                        <p>Go to the official payroll registration portal to begin creating your company account.</p>
                        <a href="https://payroll.peoplesplus.com/register" class="btn btn-outline-primary mt-3" target="_blank">
                            <i class="bi bi-box-arrow-up-right"></i> Open Registration
                        </a>
                    </div>
                </div>

                <!-- Step 2: Fill Company Details -->
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="service-item item-orange position-relative text-center">
                        <div class="icon mb-3">
                            <i class="bi bi-building fs-1"></i>
                        </div>
                        <h3>Step 2: Enter Company Information</h3>
                        <p>Provide your business name, tax ID (TPIN), contact email, and phone number.</p>
                        <ul class="list-unstyled mt-3 text-start px-4">
                            <li><i class="bi bi-check-circle text-success"></i> Company Name</li>
                            <li><i class="bi bi-check-circle text-success"></i> TPIN / PACRA Number</li>
                            <li><i class="bi bi-check-circle text-success"></i> Admin Email & Phone</li>
                            <li><i class="bi bi-check-circle text-success"></i> Physical Address</li>
                        </ul>
                    </div>
                </div>

                <!-- Step 3: Set Up Admin Account -->
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="service-item item-teal position-relative text-center">
                        <div class="icon mb-3">
                            <i class="bi bi-person-lock fs-1"></i>
                        </div>
                        <h3>Step 3: Create Admin Account</h3>
                        <p>Set a secure password and verify your email address to activate your account.</p>
                        <ul class="list-unstyled mt-3 text-start px-4">
                            <li><i class="bi bi-shield-lock text-success"></i> Minimum 8 characters</li>
                            <li><i class="bi bi-shield-lock text-success"></i> Include number & symbol</li>
                            <li><i class="bi bi-envelope-check text-success"></i> Verify via email link</li>
                        </ul>
                    </div>
                </div>

                <!-- Step 4: Add Employees -->
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
                    <div class="service-item item-indigo position-relative text-center">
                        <div class="icon mb-3">
                            <i class="bi bi-people fs-1"></i>
                        </div>
                        <h3>Step 4: Add Your Employees</h3>
                        <p>Upload employee details manually or import via CSV for faster setup.</p>
                        <small class="text-muted d-block mt-3">
                            <i class="bi bi-file-earmark-spreadsheet"></i> Supports NAPSA numbers, NHIMA, bank details
                        </small>
                    </div>
                </div>

                <!-- Step 5: Configure Payroll Settings -->
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
                    <div class="service-item item-pink position-relative text-center">
                        <div class="icon mb-3">
                            <i class="bi bi-gear-wide-connected fs-1"></i>
                        </div>
                        <h3>Step 5: Configure Payroll Rules</h3>
                        <p>Set pay frequency, allowances, deductions, and statutory compliance settings.</p>
                        <small class="text-muted d-block mt-3">
                            <i class="bi bi-check2-all"></i> Auto-calculates PAYE, NAPSA, NHIMA
                        </small>
                    </div>
                </div>

                <!-- Step 6: Start Processing Payroll -->
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="600">
                    <div class="service-item item-red position-relative text-center">
                        <div class="icon mb-3">
                            <i class="bi bi-currency-exchange fs-1"></i>
                        </div>
                        <h3>Step 6: Run Your First Payroll</h3>
                        <p>Generate payslips, export reports, and send payments — all in a few clicks!</p>
                        <a href="/admin/login" class="btn btn-success mt-3">
                            <i class="bi bi-box-arrow-in-right"></i> Login to Dashboard
                        </a>
                    </div>
                </div>

            </div>

            <!-- Final Call to Action -->
            <div class="text-center mt-5" data-aos="fade-up" data-aos-delay="700">
                <div class="alert alert-info d-inline-block p-4 rounded shadow-sm">
                    <h4><i class="bi bi-shield-check text-primary"></i> Ready to Begin?</h4>
                    <p class="mb-3">Your payroll system is secure, compliant, and easy to use.</p>
                    <a href="/admin/login" class="btn btn-lg btn-primary">
                        <i class="bi bi-box-arrow-in-right"></i> Login to Payroll System
                    </a>
                    <br>
                    <small class="text-muted">
                        The App is cloud based, and hosted in the USA
                    </small>
                    <br><br>
                    <small class="text-muted">
                        Need help? Email us at <a href="mailto:ppmsolutions24@gmail.com">ppmsolutions24@gmail.com</a>
                    </small>
                </div>
            </div>

        </div>
    </section>

@endsection
