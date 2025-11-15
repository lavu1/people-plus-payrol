@extends('layouts.app')
@section('page_title', 'About Us | Peoples Plus')
@section('content')
    <!-- Page Title -->
    <div class="page-title accent-background">
        <div class="container d-lg-flex justify-content-between align-items-center">
            <h1 class="mb-2 mb-lg-0">About</h1>
            <nav class="breadcrumbs">
                <ol>
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li class="current">About</li>
                </ol>
            </nav>
        </div>
    </div><!-- End Page Title -->

    <!-- About Section -->
    <section id="about" class="about section">
        <div class="container">
            <div class="row position-relative">
                <div class="col-lg-7 about-img" data-aos="zoom-out" data-aos-delay="200">
                    <img src="assets/img/about.jpg">
                </div>
                <div class="col-lg-7" data-aos="fade-up" data-aos-delay="100">
                    <h2 class="inner-title">Who We Are</h2>
                    <div class="our-story">
                        <h4>Since 2024</h4>
                        <h3>Our Story</h3>
                        <p style="text-align: justify !important;">Founded in 2024, People-Plus Management Solutions is a management
                            consultancy firm dedicated to the provision of professional, relevant,
                            responsive and creative solutions to help organisations and individuals to
                            achieve their goals. based in Kitwe, People-Plus has a team of dedicated
                            professionals, supported by a network of associate Consultants based on
                            the Copperbelt and Lusaka Provinces of Zambia, and also in South Africa.
                            We are passionate about providing relevant management Solutions, with a
                            special focus on immigration and Travel advisory services.</p>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- /About Section -->

    <!-- Rest of the file remains exactly the same -->

    <!-- Team Section -->
    <section id="team" class="team section light-background">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Our Team</h2>
            <p>We are a dedicated team of HR tech experts, software developers, and payroll specialists committed to
                transforming workforce management. With years of experience in HR automation, cloud-based payroll
                systems, and compliance solutions, we’ve built a platform that simplifies complex processes while
                ensuring accuracy, security, and scalability.</p>
        </div><!-- End Section Title -->

        <div class="container">

            <div class="row gy-4">

                <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100">
                    <div class="team-member">
                        <div class="member-img">
                            <img src="assets/img/team/Thewa_web_photo.jpg" class="img-fluid" alt="Mr. J. Thewa Chishete">
                            <div class="social">
                                <a href=""><i class="bi bi-linkedin"></i></a>
                                <a href=""><i class="bi bi-envelope"></i></a>
                            </div>
                        </div>
                        <div class="member-info">
                            <h4>MR. J. THEWA CHISHETE</h4>
                            <span>MA, BA (HRM), MZIHRM, AIoDZ</span>
                            <p>HR practitioner with over 18 years' experience specializing in organizational restructuring, policy drafting, manpower planning, and higher education administration.</p>
                        </div>
                    </div>
                </div><!-- End Team Member -->

                <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="200">
                    <div class="team-member">
                        <div class="member-img">
                            <img src="assets/img/team/Chansa_Chishete.jpg" class="img-fluid" alt="Mrs. Chansa A. K. Chishete">
                            <div class="social">
                                <a href=""><i class="bi bi-linkedin"></i></a>
                                <a href=""><i class="bi bi-envelope"></i></a>
                            </div>
                        </div>
                        <div class="member-info">
                            <h4>MRS. CHANSA A. K. CHISHETE</h4>
                            <span>BAcc; ZICA Cert. (Tax); ZiCATech</span>
                            <p>Accounting professional with 6+ years experience in financial systems development, payroll administration, budget preparation, and taxation.</p>
                        </div>
                    </div>
                </div><!-- End Team Member -->

            </div>

        </div>

    </section><!-- /Team Section -->

    <!-- Skills Section -->
    <section id="skills" class="skills section">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2 class="mt-4">Our Vision</h2>
            <p>The market leader in HR, Tax, Education, ICT and Personal Financial Management Solutions in
                the Southern African region.</p>

            <h2 class="mt-4">Our Mission</h2>
            <p>To provide management solutions that help to improve our clients' operational efficiency,
                competitiveness, profitability, compliance and peace of mind.</p>

            <h2 class="mt-4">Core Values</h2>
            <ul style="list-style-type: none; padding-left: 0; margin: 0;">
                <li><strong>Fortitude:</strong> There is a solution to every management challenge. We'll help you find yours.</li>
                <li><strong>Adaptability:</strong> Making necessary changes without compromising quality and our values</li>
                <li><strong>Innovation:</strong> Improve operations, meet customer needs, and drive business growth</li>
                <li><strong>Team-Work:</strong> Valuing people and their input is an integral component of success</li>
                <li><strong>Honesty:</strong> Sincere, truthful and fair transactions and engagements</li>
            </ul>

{{--            <h2>Our Skills</h2>--}}
{{--            <p>Choose us </p>--}}
        </div><!-- End Section Title -->

{{--        <div class="container" data-aos="fade-up" data-aos-delay="100">--}}

{{--            <div class="row skills-content skills-animation">--}}

{{--                <div class="col-lg-6">--}}

{{--                    <div class="progress">--}}
{{--                        <span class="skill"><span>HR Process Automation</span> <i class="val">100%</i></span>--}}
{{--                        <div class="progress-bar-wrap">--}}
{{--                            <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0"--}}
{{--                                 aria-valuemax="100"></div>--}}
{{--                        </div>--}}
{{--                    </div><!-- End Skills Item -->--}}

{{--                    <div class="progress">--}}
{{--                        <span class="skill"><span>Payroll & Tax Compliance</span> <i class="val">90%</i></span>--}}
{{--                        <div class="progress-bar-wrap">--}}
{{--                            <div class="progress-bar" role="progressbar" aria-valuenow="90" aria-valuemin="0"--}}
{{--                                 aria-valuemax="100"></div>--}}
{{--                        </div>--}}
{{--                    </div><!-- End Skills Item -->--}}

{{--                    <div class="progress">--}}
{{--                        <span class="skill"><span>Cloud-Based SaaS Solutions</span> <i class="val">75%</i></span>--}}
{{--                        <div class="progress-bar-wrap">--}}
{{--                            <div class="progress-bar" role="progressbar" aria-valuenow="75" aria-valuemin="0"--}}
{{--                                 aria-valuemax="100"></div>--}}
{{--                        </div>--}}
{{--                    </div><!-- End Skills Item -->--}}

{{--                </div>--}}

{{--                <div class="col-lg-6">--}}

{{--                    <div class="progress">--}}
{{--                        <span class="skill"><span>Data Security & Encryption</span> <i class="val">80%</i></span>--}}
{{--                        <div class="progress-bar-wrap">--}}
{{--                            <div class="progress-bar" role="progressbar" aria-valuenow="80" aria-valuemin="0"--}}
{{--                                 aria-valuemax="100"></div>--}}
{{--                        </div>--}}
{{--                    </div><!-- End Skills Item -->--}}

{{--                    <div class="progress">--}}
{{--                        <span class="skill"><span>Integration Capabilities</span> <i class="val">90%</i></span>--}}
{{--                        <div class="progress-bar-wrap">--}}
{{--                            <div class="progress-bar" role="progressbar" aria-valuenow="90" aria-valuemin="0"--}}
{{--                                 aria-valuemax="100"></div>--}}
{{--                        </div>--}}
{{--                    </div><!-- End Skills Item -->--}}

{{--                    <div class="progress">--}}
{{--                        <span class="skill"><span>User-Centric Design</span> <i class="val">55%</i></span>--}}
{{--                        <div class="progress-bar-wrap">--}}
{{--                            <div class="progress-bar" role="progressbar" aria-valuenow="55" aria-valuemin="0"--}}
{{--                                 aria-valuemax="100"></div>--}}
{{--                        </div>--}}
{{--                    </div><!-- End Skills Item -->--}}

{{--                </div>--}}

{{--            </div>--}}

{{--        </div>--}}

    </section><!-- /Skills Section -->

    <!-- Clients Section -->
    <section id="clients" class="clients section">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Clients</h2>
            <p>Trusted by forward-thinking companies, our HR and payroll system delivers reliability and innovation.</p>
        </div><!-- End Section Title -->

        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="row g-0 clients-wrap">
                <div class="col-xl-3 col-md-3  client-logo">
                    <img src="assets/img/blog/zihrm.png" class="img-fluid" alt="Zambia Institute of Human Resource Management">
                </div>
                <div class="col-xl-3 col-md-3  client-logo">
                    <img src="assets/img/blog/ndcc.png" class="img-fluid" alt="Ndola and District Chamber of Commerce and Industry">
                </div>
                <div class="col-xl-3 col-md-3  client-logo">
                    <img src="assets/img/blog/wcfcb.png" class="img-fluid" alt=" Workers Compensation Fund Control Board">
                </div>
                <div class="col-xl-3 col-md-3  client-logo">
                    <img src="assets/img/blog/napsa.png" class="img-fluid" alt="National Pension Scheme Authority - NAPSA">
                </div>
            </div>

        </div>

    </section><!-- /Clients Section -->
@endsection
