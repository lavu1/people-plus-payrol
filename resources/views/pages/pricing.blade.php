@extends('layouts.app')
@section('page_title', 'Contact Us | Peoples Plus')
@section('content')


    <!-- Page Title -->
    <div class="page-title accent-background">
        <div class="container d-lg-flex justify-content-between align-items-center">
            <h1 class="mb-2 mb-lg-0">Pricing</h1>
            <nav class="breadcrumbs">
                <ol>
                    <li><a href="/">Home</a></li>
                    <li class="current">Pricing</li>
                </ol>
            </nav>
        </div>
    </div><!-- End Page Title -->

    <!-- Pricing Section -->
    <section id="pricing" class="pricing section">

        <div class="container">

            <div class="row gy-4">

                <div class="col-lg-4" data-aos="zoom-in" data-aos-delay="100">
                    <div class="pricing-item">
                        <h3>Payroll Plan</h3>
                        <p class="description">At People's plus, we believe in accessible, powerful HR tools for everyone. That’s why our payroll App presently comes at no cost—because great workforce management shouldn’t be limited by budget.</p>
                        <h4><sup>ZMW</sup>0<span> / month</span></h4>
                        <a href="/admin/login" class="cta-btn">Free</a>
                        <p class="text-center small">No credit card required</p>
                        <ul>
                            <li><i class="bi bi-check"></i> <span>Unlimited Employee Profiles</span></li>
                            <li><i class="bi bi-check"></i> <span>Payroll Processing</span></li>
                            <li><i class="bi bi-check"></i> <span>Attendance & Leave Tracking</span></li>
                            <li><i class="bi bi-check"></i> <span>Employee Self-Service Portal</span></li>
                            <li><i class="bi bi-check"></i> <span>Basic Reporting</span></li>
                            <li><i class="bi bi-check"></i> <span>Mobile App Access</span></li>
                            <li><i class="bi bi-check"></i> <span>Advanced Reporting</span></li>
{{--                            <li class="na"><i class="bi bi-x"></i> <span>Advanced Reporting</span></li>--}}
                        </ul>
                    </div>
                </div><!-- End Pricing Item -->
                <div class="col-lg-4" data-aos="zoom-in" data-aos-delay="100">
                    <div class="pricing-item">
                        <h3>Other Services</h3>

                        <p class="description">At People's Plus, we believe in accessible, powerful HR tools
                            and management solutions for everyone. That’s why our services come
                            at competitive and affordable prices. For affordable solutions
                            tailored to your business needs, request a quote today and
                            discover how we can help you do more for less.</p>
                        <h4><sup>ZMW</sup>0<span> / month</span></h4>
                        <a href="mailto:ppmsolutions24@gmail.com" class="cta-btn">Request a Quote at ppmsolutions24@gmail.com </a>
                        <p class="text-center small">No credit card required</p>
                        <ul>
{{--                            <li><i class="bi bi-check"></i> <span>Unlimited Employee Profiles</span></li>--}}
{{--                            <li><i class="bi bi-check"></i> <span>Advanced Reporting</span></li>--}}
                            {{--                            <li class="na"><i class="bi bi-x"></i> <span>Advanced Reporting</span></li>--}}
                        </ul>
                    </div>
                </div>
            </div>

        </div>

    </section><!-- /Pricing Section -->

@endsection
