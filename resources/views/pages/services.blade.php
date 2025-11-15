@extends('layouts.app')
@section('page_title', 'Our Services | Peoples Plus')
@section('content')

    <!-- Page Title -->
    <div class="page-title accent-background">
        <div class="container d-lg-flex justify-content-between align-items-center">
            <h1 class="mb-2 mb-lg-0">Our Professional Services</h1>
            <nav class="breadcrumbs">
                <ol>
                    <li><a href="/">Home</a></li>
                    <li class="current">Services</li>
                </ol>
            </nav>
        </div>
    </div><!-- End Page Title -->

    <!-- Services Section -->
    <section id="services" class="services section light-background">

        <div class="container">
            <div class="section-title" data-aos="fade-up">
                <h2>Comprehensive Management Solutions</h2>
                <p>We provide professional, relevant, and responsive solutions to help organizations achieve their goals through our specialized services.</p>
            </div>

            <div class="row gy-4">

                <!-- Management Consulting -->
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="service-item item-cyan position-relative">
                        <div class="icon">
                            <i class="bi bi-building"></i>
                        </div>
                        <a href="{{ route('service-details', 'management-consulting') }}" class="stretched-link">
                            <h3>Management Consulting</h3>
                        </a>
                        <p>Strategic and organizational planning, change management, and operational assistance for businesses.</p>
                        <ul class="service-features">
                            Organizational Development & Design
                            Strategic Planning
                            Project Management
                            Higher Education Management
                        </ul>
                    </div>
                </div><!-- End Service Item -->

                <!-- Human Resources -->
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="service-item item-orange position-relative">
                        <div class="icon">
                            <i class="bi bi-people"></i>
                        </div>
                        <a href="{{ route('service-details', 'human-resources') }}" class="stretched-link">
                            <h3>Human Resources</h3>
                        </a>
                        <p>Comprehensive HR solutions to optimize your workforce and organizational structure.</p>
                        <ul class="service-features">
                            Organizational Structures & Restructuring
                            Policy & Procedure Development
                            Manpower Planning & Recruitment
                            Performance Management
                            HR Audits & Training
                        </ul>
                    </div>
                </div><!-- End Service Item -->

                <!-- Accounting & Tax -->
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="service-item item-teal position-relative">
                        <div class="icon">
                            <i class="bi bi-calculator"></i>
                        </div>
                        <a href="{{ route('service-details', 'accounting-tax') }}" class="stretched-link">
                            <h3>Accounting & Tax Services</h3>
                        </a>
                        <p>Professional financial management and compliance services for businesses.</p>
                        <ul class="service-features">
                            Budget Preparation & Control
                            Bookkeeping & Accounts Examination
                            Business & Personal Tax Returns
                            Tax Advisory & Compliance
                            Payroll Administration
                        </ul>
                    </div>
                </div><!-- End Service Item -->

                <!-- Legal & Compliance -->
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
                    <div class="service-item item-red position-relative">
                        <div class="icon">
                            <i class="bi bi-file-earmark-text"></i>
                        </div>
                        <a href="{{ route('service-details', 'legal-compliance') }}" class="stretched-link">
                            <h3>Legal & Compliance</h3>
                        </a>
                        <p>Expert guidance on labor law and regulatory compliance matters.</p>
                        <ul class="service-features">
                            Labor Law Advisory
                            Employment Contracts & Manuals
                            Industrial Relations
                            Recognition Agreements
                            Dispute Resolution
                        </ul>
                    </div>
                </div><!-- End Service Item -->

                <!-- Higher Education -->
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
                    <div class="service-item item-indigo position-relative">
                        <div class="icon">
                            <i class="bi bi-mortarboard"></i>
                        </div>
                        <a href="{{ route('service-details', 'higher-education') }}" class="stretched-link">
                            <h3>Higher Education Management</h3>
                        </a>
                        <p>Specialized services for educational institutions and academic organizations.</p>
                        <ul class="service-features">
                             HR Matters for Institutions
                             Compliance & Risk Management
                             Financing & Resource Management
                             Program Development
                             Accreditation Support
                        </ul>
                    </div>
                </div><!-- End Service Item -->
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
                    <div class="service-item item-indigo position-relative">
                        <div class="icon">
                            <i class="bi bi-mortarboard"></i>
                        </div>
                        <a href="{{ route('service-details', 'higher-education') }}" class="stretched-link">
                            <h3>Immigration & Travel</h3>
                        </a>
                        <p>We offer immigration and travel advisory and assistance services to individuals and companies wishing to travel, work or invest in Zambia and the Southern African region.</p>
                        <ul class="service-features">

                        </ul>
                    </div>
                </div>
                <!-- ICT Solutions -->
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="600">
                    <div class="service-item item-pink position-relative">
                        <div class="icon">
                            <i class="bi bi-laptop"></i>
                        </div>
                        <a href="{{ route('service-details', 'ict-solutions') }}" class="stretched-link">
                            <h3>ICT Solutions</h3>
                        </a>
                        <p>Technology solutions to support your digital transformation needs.</p>

                           Information Systems Development
                            Digital Transformation Strategy
                            Data Protection Compliance
                            IT Infrastructure Advisory

                    </div>
                </div><!-- End Service Item -->

            </div>
        </div>

    </section><!-- /Services Section -->

    <!-- Features Section -->
    <section id="features" class="features section">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Our Approach</h2>
            <p>We deliver customized solutions through our network of experienced professionals across multiple disciplines.</p>
        </div><!-- End Section Title -->

        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="features-item">
                        <i class="bi bi-check-circle" style="color: #ffbb2c;"></i>
                        <h3><a href="" class="stretched-link">Professional Expertise</a></h3>
{{--                        <p>Team of certified professionals with diverse industry experience</p>--}}
                    </div>
                </div><!-- End Feature Item -->

                <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="features-item">
                        <i class="bi bi-lightbulb" style="color: #5578ff;"></i>
                        <h3><a href="" class="stretched-link">Innovative Solutions</a></h3>
{{--                        <p>Creative approaches tailored to your specific challenges</p>--}}
                    </div>
                </div><!-- End Feature Item -->

                <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="features-item">
                        <i class="bi bi-clock-history" style="color: #e80368;"></i>
                        <h3><a href="" class="stretched-link">Timely Delivery</a></h3>
{{--                        <p>Responsive service meeting your deadlines and requirements</p>--}}
                    </div>
                </div><!-- End Feature Item -->

                <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="400">
                    <div class="features-item">
                        <i class="bi bi-people" style="color: #e361ff;"></i>
                        <h3><a href="" class="stretched-link">Client-Centric</a></h3>
{{--                        <p>Solutions designed around your organizational needs</p>--}}
                    </div>
                </div><!-- End Feature Item -->

                <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="500">
                    <div class="features-item">
                        <i class="bi bi-shield-check" style="color: #47aeff;"></i>
                        <h3><a href="" class="stretched-link">Compliance Focus</a></h3>
{{--                        <p>Ensuring all solutions meet regulatory requirements</p>--}}
                    </div>
                </div><!-- End Feature Item -->

                <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="600">
                    <div class="features-item">
                        <i class="bi bi-cash-coin" style="color: #ffa76e;"></i>
                        <h3><a href="" class="stretched-link">Cost-Effective</a></h3>
{{--                        <p>Delivering value without compromising quality</p>--}}
                    </div>
                </div><!-- End Feature Item -->

                <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="700">
                    <div class="features-item">
                        <i class="bi bi-gear" style="color: #11dbcf;"></i>
                        <h3><a href="" class="stretched-link">Process Improvement</a></h3>
{{--                        <p>Streamlining operations for greater efficiency</p>--}}
                    </div>
                </div><!-- End Feature Item -->

                <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="800">
                    <div class="features-item">
                        <i class="bi bi-graph-up" style="color: #4233ff;"></i>
                        <h3><a href="" class="stretched-link">Performance Enhancement</a></h3>
{{--                        <p>Solutions that drive measurable business results</p>--}}
                    </div>
                </div><!-- End Feature Item -->

            </div>

        </div>

    </section><!-- /Features Section -->

    <!-- CTA Section -->
    <section id="cta" class="cta section dark-background">
        <div class="container" data-aos="fade-up">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <h3>Ready to Transform Your Organization?</h3>
                    <p>Contact us today to discuss how we can help you achieve your business goals with our professional management solutions.</p>
                    <a class="cta-btn" href="{{ route('contact-us') }}">Get In Touch</a>
                </div>
            </div>
        </div>
    </section><!-- /CTA Section -->

@endsection
