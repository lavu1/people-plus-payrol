@extends('layouts.app')
@section('page_title', 'Team | Peoples Plus')
@section('content')

    <!-- Page Title -->
    <div class="page-title accent-background">
        <div class="container d-lg-flex justify-content-between align-items-center">
            <h1 class="mb-2 mb-lg-0">Our Professional Team</h1>
            <nav class="breadcrumbs">
                <ol>
                    <li><a href="/">Home</a></li>
                    <li class="current">Team</li>
                </ol>
            </nav>
        </div>
    </div><!-- End Page Title -->

    <!-- Team Section -->
    <section id="team" class="team section">

        <div class="container">

            <div class="section-title" data-aos="fade-up">
                <h2>Our Core Team</h2>
                <p>Our team comes with a broad diversity of educational and professional backgrounds, with a shared passion for problem solving, delivering high standard results, and value creation.</p>
            </div>

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
                            <img src="assets/img/team/Chansa_Chishete.jpg" width="300" height=10" class="img-fluid" alt="Mrs. Chansa A. K. Chishete">
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

            <div class="section-title mt-5" data-aos="fade-up">
                <h2>Our Associate Consultants</h2>
                <p>We work with carefully selected professionals specialized in various fields with extensive practical experience.</p>
            </div>

            <div class="row gy-4">

                <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="300">
                    <div class="team-member">
                        <div class="member-img">
                            <img src="assets/img/team/team-3.jpg" class="img-fluid" alt="Mrs. Tamala N. Simwinga">
                            <div class="social">
                                <a href=""><i class="bi bi-linkedin"></i></a>
                                <a href=""><i class="bi bi-envelope"></i></a>
                            </div>
                        </div>
                        <div class="member-info">
                            <h4>MRS. TAMALA N. SIMMINGA</h4>
                            <span>ACMA, GCMA, FZICA</span>
                            <p>Financial expert with 20+ years in public finance and higher education institution management.</p>
                        </div>
                    </div>
                </div><!-- End Team Member -->

                <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="400">
                    <div class="team-member">
                        <div class="member-img">
                            <img src="assets/img/team/team-4.jpg" class="img-fluid" alt="Mr. Passmore Hamukoma">
                            <div class="social">
                                <a href=""><i class="bi bi-linkedin"></i></a>
                                <a href=""><i class="bi bi-envelope"></i></a>
                            </div>
                        </div>
                        <div class="member-info">
                            <h4>MR. PASSMORE HAMUKOMA</h4>
                            <span>MSc, BA-Ed, FZIHRM</span>
                            <p>Mining industry executive with 40+ years experience in organizational development and change management.</p>
                        </div>
                    </div>
                </div><!-- End Team Member -->

                <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="500">
                    <div class="team-member">
                        <div class="member-img">
                            <img src="assets/img/team/team-2.jpg" class="img-fluid" alt="Eng. John Silungwe">
                            <div class="social">
                                <a href=""><i class="bi bi-linkedin"></i></a>
                                <a href=""><i class="bi bi-envelope"></i></a>
                            </div>
                        </div>
                        <div class="member-info">
                            <h4>ENG. JOHN SILUNGWE</h4>
                            <span>MBA, BEng, CDPO</span>
                            <p>ICT expert with 25+ years experience, specializing in digital transformation and senior management.</p>
                        </div>
                    </div>
                </div><!-- End Team Member -->

                <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="600">
                    <div class="team-member">
                        <div class="member-img">
                            <img src="assets/img/team/Eng_Chrispin_Chomba.jpg" class="img-fluid" alt="Eng. Chrispin Chomba">
                            <div class="social">
                                <a href=""><i class="bi bi-linkedin"></i></a>
                                <a href=""><i class="bi bi-envelope"></i></a>
                            </div>
                        </div>
                        <div class="member-info">
                            <h4>ENG. CHRISPIN CHOMBA</h4>
                            <span>MSc, BEng, Member (EIZ)</span>
                            <p>Project management and HSE specialist with 11+ years experience in public and private sectors.</p>
                        </div>
                    </div>
                </div><!-- End Team Member -->

            </div>

        </div>

    </section><!-- /Team Section -->
@endsection
