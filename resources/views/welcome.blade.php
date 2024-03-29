<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/iconsfont.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/light-style.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/aos.css')}}">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <link rel="stylesheet" href="{{asset('assets/css/welcomestyle.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/responsive.css')}}">
    <title>Narola care</title>
    <link rel="icon" href="{{ asset('assets/favicon.png') }}">
</head>

<body class="welcome-page">
    <!-- Back to top button -->
    <a id="button" class="topup_btn">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
            <path d="M201.4 105.4c12.5-12.5 32.8-12.5 45.3 0l192 192c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L224 173.3 54.6 342.6c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3l192-192z"/>
        </svg>
    </a>
    <div class="master-wrapper">
        <header>
            <nav class="navbar navbar-expand-lg">
                <div class="container-fluid">
                    <a data-aos="zoom-in" class="navbar-brand" href="{{ url('/') }}">
                        <span class="svg-icon">
                            <svg width="30" height="30" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 1024 1024"
                                style="enable-background:new 0 0 1024 1024;" xml:space="preserve">
                                <style type="text/css">
                                    .st0 {
                                        fill: #0084FF;
                                    }

                                    .st1 {
                                        fill: url(#SVGID_1_);
                                    }
                                </style>
                                <g>
                                    <path class="st0" d="M195.6,50.9c361.8-131.6,804,95,804,493.4c0,255.8-208.3,467.8-467.8,467.8C276,1012,64.1,803.7,64.1,544.2
                                c0-222.9,160.8-409.3,369.1-456.8C414.9,80.1,305.3,47.2,195.6,50.9z M535.5,314c-127.9,0-233.9,106-233.9,233.9
                                s106,233.9,233.9,233.9s233.9-106,233.9-233.9C769.4,416.3,663.4,314,535.5,314z" />

                                    <linearGradient id="SVGID_1_" gradientUnits="userSpaceOnUse" x1="197.2523"
                                        y1="686.1813" x2="819.3561" y2="326.998"
                                        gradientTransform="matrix(1 0 0 -1 0 1026)">
                                        <stop offset="0" style="stop-color:#2194FF" />
                                        <stop offset="1" style="stop-color:#CBEDFF" />
                                    </linearGradient>
                                    <path class="st1" d="M195.6,50.9c358.1-135.2,804,95,804,493.4c0,255.8-208.3,467.8-467.8,467.8C276,1012,64.1,803.7,64.1,544.2
                            c40.2,131.6,135.2,222.9,248.5,263.1c164.4,58.5,314.3-3.7,409.3-116.9c54.8-65.8,84-138.9,91.3-212c7.3-69.4-7.3-138.9-36.5-201
                            C681.7,72.8,411.2,10.7,195.6,50.9z" />
                                </g>
                            </svg>
                        </span>
                        <span class="svg-text text-blue ms-2">
                            Narola Care
                        </span>
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#headerMenu"
                        aria-controls="headerMenu" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon">
                            <svg width="25" height="25" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 400 325"
                                style="enable-background:new 0 0 400 325;" xml:space="preserve">
                                <style type="text/css">
                                    .st0 {
                                        fill: #2194FE;
                                    }
                                </style>
                                <g>
                                    <path class="st0"
                                        d="M203.1,67c-56.3,0-112.6,0-168.9,0C22,67,13.9,59.3,11.5,45.7c-2.8-15.3,6.5-30.8,19-31.8c1-0.1,2-0.1,3-0.1
        c112.9,0,225.9,0,338.8,0c11.6,0,19.5,7.5,22,20.6c3.1,15.6-6.1,31.4-18.9,32.4c-3,0.2-6,0.1-9,0.1C312,67,257.5,67,203.1,67z" />
                                    <path class="st0" d="M203,262.1c56.3,0,112.6,0,168.9,0c12,0,19.9,7,22.5,19.5c3,14.7-6.2,29.5-19,30.5c-1.5,0.1-3,0.1-4.5,0.1
        c-111.9,0-223.9,0-335.8,0c-12.9,0-20.8-6.7-23.5-19.5c-3-14.7,6.2-29.7,19-30.5c6.8-0.4,13.7-0.2,20.5-0.2
        C101.7,262.1,152.3,262.1,203,262.1z" />
                                    <path class="st0" d="M271.3,191c-35.1,0-70.3,0.1-105.4-0.1c-15.2-0.1-25.2-17.8-21.1-36.7c2.5-11.5,10.2-19.5,19.2-20.1
        c1.2-0.1,2.3-0.1,3.5-0.1c69.6,0,139.2,0.1,208.9-0.1c8.5,0,15.4,3.4,20.1,13.1c4.4,9.1,4.8,19,0.9,28.6c-3.8,9.6-9.9,15-18.1,15.1
        c-17,0.2-34,0.1-51,0.1C309.3,191,290.3,191,271.3,191z" />
                                </g>
                            </svg>

                        </span>
                    </button>
                    <div data-aos="zoom-in-right" class="collapse navbar-collapse" id="headerMenu">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" href="#about-us-section">About Us</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#generic_price_table">Pricing</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#contact-us">Contact</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#testimonial-section">Testimonial</a>
                            </li>
                        </ul>
                    </div>
                    <div class="">
                        <ul class="navbar-nav">
                        @auth
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">Dashboard</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">Login</a>
                            </li>
                        @endauth
                        </ul>
                    </div>
                </div>
            </nav>
        </header>

        <section class="banner-section">
            <div class="container-fluid">
                <div class="row align-items-center flex-lg-row flex-column-reverse">
                    <div class="col-lg-6 banner-left">
                        <div class="bs-left" data-aos="fade-right" data-aos-offset="300" data-aos-easing="ease-in-sine">
                            <h1>Many <span>TouchPoints</span>,<br>
                                one <span>platform</span></h1>
                            <h4>
                                Inform. Engage. Improve the patient experience and knowledge. We help you achieve your
                                patient goals to be better and a step ahead.
                            </h4>
                        </div>
                    </div>
                    <div class="col-lg-6 banner-right">
                        <img src="{{asset('assets/img/banner.png')}}" alt="banner" data-aos="fade-left" data-aos-offset="600"
                            data-aos-duration="600">
                    </div>
                </div>
            </div>
        </section>

        <section class="tab-section" id="about-us-section">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-7 col-lg-12">
                        <div class="tab-content" data-aos="zoom-in" data-aos-offset="600" data-aos-duration="600"
                            id="homeTab">
                            <div class="tab-pane fade show active" id="medicalAdhere" role="tabpanel"
                                aria-labelledby="medicalAdhere-tab">
                                <div class="box-inner-top">
                                    <h3>Medical Adherence</h3>
                                    <p>Getting a medical help when needed is important; following the advice given is
                                        equally important. To manage chronic condition, medical adherence has a higher
                                        input to improve or worsen the disease. There is 12% of mortality rate for
                                        non-adherent patients and 50%...</p>
                                </div>
                                <div class="box-inner-bottom">
                                    <img src="{{asset('assets/img/adherence.png')}}" alt="adherence">
                                </div>
                            </div>
                            <div class="tab-pane fade" id="improveEngagment" role="tabpanel"
                                aria-labelledby="improveEngagment-tab">
                                <div class="box-inner-top">
                                    <h3>Improve Engagement</h3>
                                    <p>Patient engagement is increasingly recognized as an integral part of health care
                                        and a critical component of safe people-centred services. People using health
                                        services are increasingly asking for more responsive, open and transparent
                                        health care systems. Engaged patients...</p>
                                </div>
                                <div class="box-inner-bottom">
                                    <img src="{{asset('assets/img/MH_IMPROVE-engagement.png')}}" alt="adherence">
                                </div>
                            </div>
                            <div class="tab-pane fade" id="appointment" role="tabpanel"
                                aria-labelledby="appointment-tab">
                                <div class="box-inner-top">
                                    <h3>Appointment</h3>
                                    <p>Patient engagement is increasingly recognized as an integral part of health care
                                        and a critical component of safe people-centred services. People using health
                                        services are increasingly asking for more responsive, open and transparent
                                        health care systems. Engaged patients...</p>
                                </div>
                                <div class="box-inner-bottom">
                                    <img src="{{asset('assets/img/MH_IMPROVE-engagement.png')}}" alt="adherence">
                                </div>
                            </div>
                            <div class="tab-pane fade" id="heathAnal" role="tabpanel" aria-labelledby="heathAnal-tab">
                                <div class="box-inner-top">
                                    <h3>Health Analytics</h3>
                                    <p>Patient engagement is increasingly recognized as an integral part of health care
                                        and a critical component of safe people-centred services. People using health
                                        services are increasingly asking for more responsive, open and transparent
                                        health care systems. Engaged patients...</p>
                                </div>
                                <div class="box-inner-bottom">
                                    <img src="{{asset('assets/img/MH_IMPROVE-engagement.png')}}" alt="adherence">
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pdr" role="tabpanel" aria-labelledby="pdr-tab">
                                <div class="box-inner-top">
                                    <h3>Camp Management</h3>
                                    <p>Patient engagement is increasingly recognized as an integral part of health care
                                        and a critical component of safe people-centred services. People using health
                                        services are increasingly asking for more responsive, open and transparent
                                        health care systems. Engaged patients...</p>
                                </div>
                                <div class="box-inner-bottom">
                                    <img src="{{asset('assets/img/MH_IMPROVE-engagement.png')}}" alt="adherence">
                                </div>
                            </div>
                            <div class="tab-pane fade" id="hcm" role="tabpanel" aria-labelledby="hcm-tab">
                                <div class="box-inner-top">
                                    <h3>Relationship</h3>
                                    <p>Patient engagement is increasingly recognized as an integral part of health care
                                        and a critical component of safe people-centred services. People using health
                                        services are increasingly asking for more responsive, open and transparent
                                        health care systems. Engaged patients...</p>
                                </div>
                                <div class="box-inner-bottom">
                                    <img src="{{asset('assets/img/MH_IMPROVE-engagement.png')}}" alt="adherence">
                                </div>
                            </div>
                            <div class="tab-pane fade" id="rmp" role="tabpanel" aria-labelledby="rmp-tab">
                                <div class="box-inner-top">
                                    <h3>Relationship</h3>
                                    <p>Patient engagement is increasingly recognized as an integral part of health care
                                        and a critical component of safe people-centred services. People using health
                                        services are increasingly asking for more responsive, open and transparent
                                        health care systems. Engaged patients...</p>
                                </div>
                                <div class="box-inner-bottom">
                                    <img src="{{asset('assets/img/MH_IMPROVE-engagement.png')}}" alt="adherence">
                                </div>
                            </div>
                            <div class="tab-pane fade" id="ease-bill" role="tabpanel" aria-labelledby="ease-bill-tab">
                                <div class="box-inner-top">
                                    <h3>Easy Billing</h3>
                                    <p>Patient engagement is increasingly recognized as an integral part of health care
                                        and a critical component of safe people-centred services. People using health
                                        services are increasingly asking for more responsive, open and transparent
                                        health care systems. Engaged patients...</p>
                                </div>
                                <div class="box-inner-bottom">
                                    <img src="{{asset('assets/img/MH_IMPROVE-engagement.png')}}" alt="adherence">
                                </div>
                            </div>
                            <div class="tab-pane fade" id="why" role="tabpanel" aria-labelledby="why-tab">
                                <div class="box-inner-top">
                                    <h3>Why Narola Care</h3>
                                    <p>Patient engagement is increasingly recognized as an integral part of health care
                                        and a critical component of safe people-centred services. People using health
                                        services are increasingly asking for more responsive, open and transparent
                                        health care systems. Engaged patients...</p>
                                </div>
                                <div class="box-inner-bottom">
                                    <img src="{{asset('assets/img/MH_IMPROVE-engagement.png')}}" alt="adherence">
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-xl-5 col-lg-12">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item one" role="presentation" data-aos="zoom-in" data-aos-offset="300"
                                data-aos-duration="300">
                                <a href="#medicalAdhere" class="nav-link active" id="medicalAdhere-tab"
                                    data-bs-toggle="tab" data-bs-target="#medicalAdhere" type="button" role="tab"
                                    aria-controls="medicalAdhere" aria-selected="true">
                                    <span>
                                        Medical Adhere
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item two" role="presentation" data-aos="zoom-in" data-aos-offset="400"
                                data-aos-duration="400">
                                <a href="#improveEngagment" class="nav-link" id="improveEngagment-tab"
                                    data-bs-toggle="tab" data-bs-target="#improveEngagment" type="button" role="tab"
                                    aria-controls="improveEngagment" aria-selected="false"><span>Improve
                                    Engagement</span></a>
                            </li>
                            <li class="nav-item three" role="presentation" data-aos="zoom-in" data-aos-offset="400"
                                data-aos-duration="500">
                                <a href="#appointment" class="nav-link" id="appointment-tab" data-bs-toggle="tab"
                                    data-bs-target="#appointment" type="button" role="tab" aria-controls="appointment"
                                    aria-selected="false"><span>Appointment</span></a>
                            </li>
                            <li class="nav-item four" role="presentation" data-aos="zoom-in" data-aos-offset="400"
                                data-aos-duration="600">
                                <a href="#heathAnal" class="nav-link" id="heathAnal-tab" data-bs-toggle="tab"
                                    data-bs-target="#heathAnal" type="button" role="tab" aria-controls="heathAnal"
                                    aria-selected="false"><span>Health
                                    Analytics</span></a>
                            </li>
                            <li class="nav-item five" role="presentation" data-aos="zoom-in" data-aos-offset="400"
                                data-aos-duration="700">
                                <a href="#pdr" class="nav-link" id="pdr-tab" data-bs-toggle="tab" data-bs-target="#pdr"
                                    type="button" role="tab" aria-controls="pdr" aria-selected="false"><span>Camp
                                    Management</span></a>
                            </li>
                            <li class="nav-item six" role="presentation" data-aos="zoom-in" data-aos-offset="400"
                                data-aos-duration="800">
                                <a href="#hcm" class="nav-link" id="hcm-tab" data-bs-toggle="tab" data-bs-target="#hcm"
                                    type="button" role="tab" aria-controls="hcm" aria-selected="false"><span>Relationship</span></a>
                            </li>
                            <li class="nav-item seven" role="presentation" data-aos="zoom-in" data-aos-offset="400"
                                data-aos-duration="900">
                                <a href="#rmp" class="nav-link" id="rmp-tab" data-bs-toggle="tab" data-bs-target="#rmp"
                                    type="button" role="tab" aria-controls="rmp" aria-selected="false">
                                    <span>Reminder's</span>
                                </a>
                            </li>
                            <li class="nav-item eight" role="presentation" data-aos="zoom-in" data-aos-offset="400"
                                data-aos-duration="1000">
                                <a href="#ease-bill" class="nav-link" id="ease-bill-tab" data-bs-toggle="tab"
                                    data-bs-target="#ease-bill" type="button" role="tab" aria-controls="ease-bill"
                                    aria-selected="false">
                                    <span>
                                    Easy
                                    Billing</span>
                                </a>
                            </li>
                            <li class="nav-item nine" role="presentation" data-aos="zoom-in" data-aos-offset="400"
                                data-aos-duration="1000">
                                <a href="#why" class="nav-link" id="why-tab" data-bs-toggle="tab" data-bs-target="#why"
                                    type="button" role="tab" aria-controls="why" aria-selected="false">
                                   <span> Why Narola Care</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
        </section>

        <div id="generic_price_table">   
            <section>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <!--PRICE HEADING START-->
                            <div class="price-heading clearfix">
                                <h1 class="text-center mb-5">Pricing Table</h1>
                            </div>
                            <!--//PRICE HEADING END-->
                        </div>
                    </div>
                </div>
                <div class="container-fluid">
                    
                    <!--BLOCK ROW START-->
                    <div class="row">
                        <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12">
                        
                            <!--PRICE CONTENT START-->
                            <div class="generic_content clearfix">
                                
                                <!--HEAD PRICE DETAIL START-->
                                <div class="generic_head_price clearfix">
                                
                                    <!--HEAD CONTENT START-->
                                    <div class="generic_head_content clearfix">
                                    
                                        <!--HEAD START-->
                                        <div class="head_bg"></div>
                                        <div class="head">
                                            <span>Basic</span>
                                        </div>
                                        <!--//HEAD END-->
                                        
                                    </div>
                                    <!--//HEAD CONTENT END-->
                                    
                                    <!--PRICE START-->
                                    <div class="generic_price_tag clearfix">    
                                        <span class="price">
                                            <span class="sign">$</span>
                                            <span class="currency">99</span>
                                            <span class="cent">.99</span>
                                            <span class="month">/MON</span>
                                        </span>
                                    </div>
                                    <!--//PRICE END-->
                                    
                                </div>                            
                                <!--//HEAD PRICE DETAIL END-->
                                
                                <!--FEATURE LIST START-->
                                <div class="generic_feature_list">
                                    <ul>
                                        <li><span>2GB</span> Bandwidth</li>
                                        <li><span>150GB</span> Storage</li>
                                        <li><span>12</span> Accounts</li>
                                        <li><span>7</span> Host Domain</li>
                                        <li><span>24/7</span> Support</li>
                                    </ul>
                                </div>
                                <!--//FEATURE LIST END-->
                                
                                <!--BUTTON START-->
                                <div class="generic_price_btn clearfix">
                                    <a class="" href="">Sign up</a>
                                </div>
                                <!--//BUTTON END-->
                                
                            </div>
                            <!--//PRICE CONTENT END-->
                                
                        </div>
                        
                        <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12">
                        
                            <!--PRICE CONTENT START-->
                            <div class="generic_content active clearfix">
                                
                                <!--HEAD PRICE DETAIL START-->
                                <div class="generic_head_price clearfix">
                                
                                    <!--HEAD CONTENT START-->
                                    <div class="generic_head_content clearfix">
                                    
                                        <!--HEAD START-->
                                        <div class="head_bg"></div>
                                        <div class="head">
                                            <span>Standard</span>
                                        </div>
                                        <!--//HEAD END-->
                                        
                                    </div>
                                    <!--//HEAD CONTENT END-->
                                    
                                    <!--PRICE START-->
                                    <div class="generic_price_tag clearfix">    
                                        <span class="price">
                                            <span class="sign">$</span>
                                            <span class="currency">199</span>
                                            <span class="cent">.99</span>
                                            <span class="month">/MON</span>
                                        </span>
                                    </div>
                                    <!--//PRICE END-->
                                    
                                </div>                            
                                <!--//HEAD PRICE DETAIL END-->
                                
                                <!--FEATURE LIST START-->
                                <div class="generic_feature_list">
                                    <ul>
                                        <li><span>2GB</span> Bandwidth</li>
                                        <li><span>150GB</span> Storage</li>
                                        <li><span>12</span> Accounts</li>
                                        <li><span>7</span> Host Domain</li>
                                        <li><span>24/7</span> Support</li>
                                    </ul>
                                </div>
                                <!--//FEATURE LIST END-->
                                
                                <!--BUTTON START-->
                                <div class="generic_price_btn clearfix">
                                    <a class="" href="">Sign up</a>
                                </div>
                                <!--//BUTTON END-->
                                
                            </div>
                            <!--//PRICE CONTENT END-->
                                
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12">
                        
                            <!--PRICE CONTENT START-->
                            <div class="generic_content clearfix">
                                
                                <!--HEAD PRICE DETAIL START-->
                                <div class="generic_head_price clearfix">
                                
                                    <!--HEAD CONTENT START-->
                                    <div class="generic_head_content clearfix">
                                    
                                        <!--HEAD START-->
                                        <div class="head_bg"></div>
                                        <div class="head">
                                            <span>Unlimited</span>
                                        </div>
                                        <!--//HEAD END-->
                                        
                                    </div>
                                    <!--//HEAD CONTENT END-->
                                    
                                    <!--PRICE START-->
                                    <div class="generic_price_tag clearfix">    
                                        <span class="price">
                                            <span class="sign">$</span>
                                            <span class="currency">299</span>
                                            <span class="cent">.99</span>
                                            <span class="month">/MON</span>
                                        </span>
                                    </div>
                                    <!--//PRICE END-->
                                    
                                </div>                            
                                <!--//HEAD PRICE DETAIL END-->
                                
                                <!--FEATURE LIST START-->
                                <div class="generic_feature_list">
                                    <ul>
                                        <li><span>2GB</span> Bandwidth</li>
                                        <li><span>150GB</span> Storage</li>
                                        <li><span>12</span> Accounts</li>
                                        <li><span>7</span> Host Domain</li>
                                        <li><span>24/7</span> Support</li>
                                    </ul>
                                </div>
                                <!--//FEATURE LIST END-->
                                
                                <!--BUTTON START-->
                                <div class="generic_price_btn clearfix">
                                    <a class="" href="">Sign up</a>
                                </div>
                                <!--//BUTTON END-->
                                
                            </div>
                            <!--//PRICE CONTENT END-->
                                
                        </div>
                    </div>  
                    <!--//BLOCK ROW END-->
                    
                </div>
            </section>    
        </div>

        <div class="testimonaol-section testimonial text-center" id="testimonial-section">
            <div class="container-lg">
                <div class="heading white-heading" data-aos="fade-up">
                    Testimonial
                </div>
                <div id="testimonial4"
                    class="carousel slide testimonial4_indicators testimonial4_control_button thumb_scroll_x swipe_x"
                    data-bs-ride="carousel" data-bs-touch="true" data-bs-interval="5000" data-bs-duration="2000">

                    <div class="carousel-inner" role="listbox">
                        <div class="carousel-item active">
                            <div class="testimonial4_slide">
                                <img src="https://i.ibb.co/8x9xK4H/team.jpg" class="img-circle img-responsive"
                                    data-aos="flip-left" data-aos-duration="400" />
                                <p data-aos="zoom-in" data-aos-duration="900">Lorem Ipsum is simply dummy text of the
                                    printing and typesetting
                                    industry. Lorem
                                    Ipsum has been the industry's standard dummy text ever since the 1500s, when an
                                    unknown printer took a galley of type and scrambled it to make a type specimen book.
                                </p>
                                <h4 data-aos="zoom-in-down" data-aos-duration="900">Client 1</h4>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="testimonial4_slide">
                                <img src="https://i.ibb.co/8x9xK4H/team.jpg" class="img-circle img-responsive"
                                    data-aos="flip-left" data-aos-duration="400" />
                                <p data-aos="zoom-in" data-aos-duration="900">Lorem Ipsum is simply dummy text of the
                                    printing and typesetting
                                    industry. Lorem
                                    Ipsum has been the industry's standard dummy text ever since the 1500s, when an
                                    unknown printer took a galley of type and scrambled it to make a type specimen book.
                                </p>
                                <h4 data-aos="zoom-in-down" data-aos-duration="900">Client 2</h4>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="testimonial4_slide">
                                <img src="https://i.ibb.co/8x9xK4H/team.jpg" class="img-circle img-responsive"
                                    data-aos="flip-left" data-aos-duration="400" data-aos-duration="690" />
                                <p data-aos="zoom-in">Lorem Ipsum is simply dummy text of the printing and typesetting
                                    industry. Lorem
                                    Ipsum has been the industry's standard dummy text ever since the 1500s, when an
                                    unknown printer took a galley of type and scrambled it to make a type specimen book.
                                </p>
                                <h4 data-aos="zoom-in-down" data-aos-duration="900">Client 3</h4>
                            </div>
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#testimonial4" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </a>
                    <a class="carousel-control-next" href="#testimonial4" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </a>
                </div>
            </div>
        </div>

        <section class="news-letter-section" id="contact-us">
            <div class="conatiner-lg">
                <div class="news-letter-block" data-aos="zoom-in-up" data-aos-duration="300">
                    <div class="nwl-title" data-aos="zoom-in-up" data-aos-duration="500">Subscribe to get the latest
                        news</div>
                    <div class="nwl-input" data-aos="zoom-in-up" data-aos-duration="800">
                        <input type="text" placeholder="Enter Email" class="form-control">
                        <button class="btn">Subscribe</button>
                    </div>
                </div>
            </div>
        </section>
        <footer class="footer">
            <div class="footer-block">
                <div class="container-lg">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="foot-logo">
                                <a class="navbar-brand" data-aos="zoom-in-right" data-aos-duration="500"
                                    href="{{ url('/') }}">
                                    <span class="svg-icon">
                                        <svg width="30" height="30" version="1.1" id="Layer_1"
                                            xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                            viewBox="0 0 1024 1024" style="enable-background:new 0 0 1024 1024;"
                                            xml:space="preserve">
                                            <style type="text/css">
                                                .st0 {
                                                    fill: #0084FF;
                                                }

                                                .st1 {
                                                    fill: url(#SVGID_1_);
                                                }
                                            </style>
                                            <g>
                                                <path class="st0"
                                                    d="M195.6,50.9c361.8-131.6,804,95,804,493.4c0,255.8-208.3,467.8-467.8,467.8C276,1012,64.1,803.7,64.1,544.2
                                            c0-222.9,160.8-409.3,369.1-456.8C414.9,80.1,305.3,47.2,195.6,50.9z M535.5,314c-127.9,0-233.9,106-233.9,233.9
                                            s106,233.9,233.9,233.9s233.9-106,233.9-233.9C769.4,416.3,663.4,314,535.5,314z" />

                                                <linearGradient id="SVGID_1_" gradientUnits="userSpaceOnUse"
                                                    x1="197.2523" y1="686.1813" x2="819.3561" y2="326.998"
                                                    gradientTransform="matrix(1 0 0 -1 0 1026)">
                                                    <stop offset="0" style="stop-color:#2194FF" />
                                                    <stop offset="1" style="stop-color:#CBEDFF" />
                                                </linearGradient>
                                                <path class="st1" d="M195.6,50.9c358.1-135.2,804,95,804,493.4c0,255.8-208.3,467.8-467.8,467.8C276,1012,64.1,803.7,64.1,544.2
                                        c40.2,131.6,135.2,222.9,248.5,263.1c164.4,58.5,314.3-3.7,409.3-116.9c54.8-65.8,84-138.9,91.3-212c7.3-69.4-7.3-138.9-36.5-201
                                        C681.7,72.8,411.2,10.7,195.6,50.9z" />
                                            </g>
                                        </svg>
                                    </span>
                                    <span class="svg-text text-blue ms-2">
                                        Narola Care
                                    </span>
                                </a>
                            </div>
                            <div class="foot-text" data-aos="zoom-in-right" data-aos-duration="700">
                                <h3>
                                    Bringing loving care <br>
                                    to health managements
                                </h3>
                                <a href="{{ route('login') }}" class="btn">Login / Signup</a>
                            </div>
                        </div>
                        <div class="col-md-8 footer-sec">
                            <div class="row justify-content-end">
                                <div class="col-md-3">
                                    <div class="footer-content" data-aos="zoom-in-left" data-aos-duration="500">
                                        <div class="footer-title">
                                            <strong>Company</strong>
                                        </div>
                                        <ul class="list-unstyled">
                                            <li>
                                                <a class="about-us-section" href="#about-us-section">
                                                    About Us
                                                </a>
                                            </li>
                                            <li>
                                                <a>
                                                    Benefits
                                                </a>
                                            </li>
                                            <li>
                                                <a class="contact-us" href="#contact-us">
                                                    Contact
                                                </a>
                                            </li>
                                            <li>
                                                <a class="testimonial-section" href="#testimonial-section">
                                                    Testimonial
                                                </a>
                                            </li>
                                            <li>
                                                <a>
                                                    Privacy Policy
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="footer-content" data-aos="zoom-in-left" data-aos-duration="700">
                                        <div class="footer-title">
                                            <strong>Learn more</strong>
                                        </div>
                                        <ul class="list-unstyled">
                                            <li>
                                                <a>
                                                    Support
                                                </a>
                                            </li>
                                            <li>
                                                <a>
                                                    FAQs
                                                </a>
                                            </li>
                                            <li>
                                                <a>
                                                    Terms and Conditions
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</body>

<script src="{{asset('assets/js/jquery.min.js')}}"></script>
<script src="{{asset('assets/js/aos.js')}}"></script>
<script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<script src="{{asset('assets/js/welcomescript.js')}}"></script>

<script type="text/javascript">
    var btn = $("#button");

    $(window).scroll(function () {
      if ($(window).scrollTop() > 75) {
        btn.addClass("show");
      } else {
        btn.removeClass("show");
      }
    });

    btn.on("click", function (e) {
      e.preventDefault();
      $("html, body").animate({ scrollTop: 0 }, "300");
    });

</script>

</html>