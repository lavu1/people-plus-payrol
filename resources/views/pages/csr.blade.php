@extends('layouts.app')
@section('page_title', 'Our CSR | Peoples Plus')
@section('content')

    <!-- Page Title -->
    <div class="page-title accent-background">
        <div class="container d-lg-flex justify-content-between align-items-center">
            <h1 class="mb-2 mb-lg-0">Corporate Social Responsibility</h1>
            <nav class="breadcrumbs">
                <ol>
                    <li><a href="/">Home</a></li>
                    <li class="current"> CSR</li>
                </ol>
            </nav>
        </div>
    </div><!-- End Page Title -->

    <!-- Services Section -->
    <section id="services" class="services section light-background">
        <div class="container">
            <div class="section-title" data-aos="fade-up">
                <h2>Corporate Social Responsibility</h2>
                <p>At Peoples Plus, we believe in giving back to the community and supporting causes that create lasting
                    positive impact. Our commitment extends beyond business excellence to meaningful social
                    contribution.</p>
            </div>

            <div class="row gy-4">

                <!-- Management Consulting -->
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="service-item item-cyan position-relative">
                        <div class="icon">
                            <i class="bi bi-journal-bookmark"></i>
                        </div>
                        <h3>Gospel Literature Outreach</h3>
                        <p>Supporting leadership training programs that equip individuals with spiritual guidance and
                            educational resources for community transformation.</p>
                        <ul class="csr-features">
                            Leaders Training Programmes
                            Educational Material Distribution
                            Spiritual Development Initiatives
                            Community Outreach Support
                        </ul>
                    </div>
                </div><!-- End Service Item -->

                <!-- Human Resources -->
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="service-item item-orange position-relative">
                        <div class="icon">
                            <i class="bi bi-mortarboard"></i>
                        </div>
                        <h3>Central African Baptist University</h3>
                        <p>Providing student scholarships to empower the next generation of African leaders through quality higher education and professional development.</p>
                        <ul class="csr-features">
                            Student Scholarships
                            Educational Funding
                            Leadership Development
                            Academic Excellence Support
                        </ul>
                    </div>
                </div><!-- End Service Item -->

                <!-- Accounting & Tax -->
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="service-item item-teal position-relative">
                        <div class="icon">
                            <i class="bi bi-heart"></i>
                        </div>
                        <h3>Renewed Hope Children's Village</h3>
                        <p>Supporting orphaned and vulnerable children with shelter, education, healthcare, and loving care to help them build brighter futures.</p>
                        <ul class="csr-features">
                            Orphanage Support
                            Childcare & Education
                            Healthcare Provision
                            Family Reintegration Programs
                        </ul>
                    </div>
                </div><!-- End Service Item -->

            </div>
        </div>

    </section>

@endsection
