<template>
    <v-app>
        <!-- ======= Header ======= -->
        <header  id="header" class="fixed-top">
            <v-container>
                <v-row justify="center" no-gutters>
                    <v-col cols="12" xl=8>
                        <v-row class="align-items-center mt-0" no-gutters>
                            <v-col class="logo mr-auto" cols="6" md=2>
                                <h1 class="text-light"><a href="/"><span>BalikbayanBox</span></a></h1>
                                 <!-- Uncomment below if you prefer to use an image logo -->
                                <!-- <a href="index.html"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->
                            </v-col>
                            <v-col cols="12" md=10 class="d-none d-lg-block">
                                <nav class="nav-menu d-none d-lg-block">
                                    <ul>
                                        <li class="active"><a href="/">Home</a></li>
                                        <li><a href="#about">About Us</a></li>
                                        <li><a href="#services">Services</a></li>
                                        <li><a href="#contact">Contact Us</a></li>

                                        <li class="get-started"><a href="/signin">Sign-in</a></li>
                                    </ul>
                                </nav><!-- .nav-menu -->
                            </v-col>
                        </v-row>
                    </v-col>
                </v-row>
            </v-container>
        </header>


        <!-- ======= Hero Section ======= -->
        <section class="d-flex align-items-center" id="hero">
            <v-container>
                <v-row justify="center" class="align-items-center">
                    <v-col cols="12" xl="8" class="hero-text-image">
                        <v-row align="center">
                            <v-col cols="12" lg=5 class="pt-5 pt-lg-0 order-2 order-lg-1">
                                <h1 data-aos="fade-right">Bettter delivery<br> experience with <br>BalikbayanBox</h1>
                                <a data-aos="fade-right" data-aos-delay="100" href="#about" class="btn-get-started scrollto">Get Started</a>
                                <!-- <p class="mb-5" data-aos="fade-right" data-aos-delay="100">Order Delivery Food Online From Local Restaurants.</p> -->
                                <!-- <p data-aos="fade-right" data-aos-delay="200" data-aos-offset="-500"><a href="#" class="btn btn-outline-white">Get started</a></p> -->
                            </v-col>
                            <v-col cols="12" lg=7 class="order-1 order-lg-2 hero-img">
                                <img src="img/Hero.svg" alt="Image" class="img-fluid animated" data-aos="fade-right">
                            </v-col>
                        </v-row>
                    </v-col>
                </v-row>
            </v-container>
        </section><!-- End Hero -->

        <main id="main">

            <!-- ======= Home Section ======= -->
            <section id="about" class="about">
                <v-container>
                    <v-row justify="center">
                        <v-col cols="12" xl=8>
                            <v-row justify="space-between" align="center">
                                <v-col cols="12" sm=6 lg=7 data-aos="fade-up" data-aos-delay="">
                                    <div class="justify-content-center about-img">
                                       <img src="img/About.svg" class="img-fluid" alt="" data-aos="zoom-in">
                                    </div>
                                </v-col>
                                <v-col class="pt-5 pt-lg-0" cols="12" sm=6 lg=5 data-aos="fade-up" data-aos-delay="100">
                                    <h3 data-aos="fade-up">About BalikbayanBox</h3>
                                    <p data-aos="fade-up" data-aos-delay="100" class="title">
                                    The balikbayan box application system will be aiming in bridging and connecting the filipino around the globe. <br> <br>
                                    While brick and mortar business is past approaching becoming a thing of the past. The balikbayan box app is creating a one stop e-business balikbayan box. We are bringing forward innovative ideas that could make your sending experience better than yesteryear. <br> <br>
                                    We are transforming the traditional balikbayan box business to an information age, where in we can help track every movement of balikbayan boxes. Thus, connecting and bringing boxes closer to your loved ones back home.

                                    </p>
                                    <!-- <div class="row">
                                    <div class="col-md-6 text-center" data-aos="fade-up" data-aos-delay="100">
                                        <v-icon x-large color="primary">fa-tachometer-alt</v-icon>
                                        <h4>Fast</h4>
                                        <p>Consequuntur sunt aut quasi enim aliquam quae harum pariatur laboris nisi ut aliquip</p>
                                    </div>
                                    <div class="col-md-6 text-center" data-aos="fade-up" data-aos-delay="200">
                                        <v-icon x-large color="primary">fa-mobile</v-icon>
                                        <h4>Easy To Use</h4>
                                        <p>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt</p>
                                    </div>
                                    </div> -->
                                </v-col>
                            </v-row>
                        </v-col>
                    </v-row>
                </v-container>
            </section>

            <!-- ======= Services Section ======= -->
            <section id="services" class="services section-bg">
                <v-container>
                    <v-row justify="center">
                        <v-col cols="12" xl=8>
                            <div class="section-title" data-aos="fade-up">
                                <h2>Features</h2>
                                <p>Check out the great features we offer</p>
                            </div>

                            <div class="row">
                                <div class="col-md-6 col-lg-3 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="100">
                                    <div class="icon-box">
                                    <div class="icon"><i class="bx bxl-dribbble"></i></div>
                                    <h4 class="title">Digitalized</h4>
                                    <p class="description">By incorporating the traditional process of sending your packages, we offer you an all-digital process at the convenience of your phone.</p>
                                    </div>
                                </div>

                                <div class="col-md-6 col-lg-3 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="200">
                                    <div class="icon-box">
                                    <div class="icon"><i class="bx bx-file"></i></div>
                                    <h4 class="title">Hassle-free Tracking</h4>
                                    <p class="description">Tracking your package is now as easy as one tap away with accurate updates.</p>
                                    </div>
                                </div>

                                <div class="col-md-6 col-lg-3 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="300">
                                    <div class="icon-box">
                                    <div class="icon"><i class="bx bx-tachometer"></i></div>
                                    <h4 class="title">QR Code Feature</h4>
                                    <p class="description">A QR Code will be placed on your box. One scan is all it takes to check the details of your box.</p>
                                    </div>
                                </div>

                                <div class="col-md-6 col-lg-3 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="400">
                                    <div class="icon-box">
                                    <div class="icon"><i class="bx bx-world"></i></div>
                                    <h4 class="title">Reliable</h4>
                                    <p class="description">We make sure to deliver your package directly to the receiver's doorsteps and collecting their signature as proof of delivery.</p>
                                    </div>
                                </div>

                            </div>
                            <!-- <v-row class="mb-5 align-items-end">
                                <v-col data-aos="fade-up">
                                    <h2>Contact Form</h2>
                                    <p class="mb-0">We are always happy to hear from our clients and visitors, you may contact us anytime.</p>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col class="mb-5 mb-md-0" data-aos="fade-up">
                                    <v-form ref="form" lazy-validation>
                                        <v-row justify="center">
                                            <v-col cols="6"><v-text-field outlined label="Name"></v-text-field></v-col>
                                            <v-col cols="6"><v-text-field outlined label="Email"></v-text-field></v-col>
                                        </v-row>
                                        <v-row justify="center">
                                            <v-col cols="12"><v-text-field outlined label="Subject"></v-text-field></v-col>
                                        </v-row>
                                        <v-row justify="center">
                                            <v-col cols="12"><v-textarea outlined label="Message"></v-textarea></v-col>
                                        </v-row>
                                        <v-row justify="center">
                                            <v-btn color="primary" rounded large class="btn-primary d-block w-100">Sent Message</v-btn>
                                        </v-row>
                                    </v-form>
                                </v-col>
                                <v-col class="ml-auto order-2" data-aos="fade-up">
                                    <ul class="list-unstyled">
                                    <li class="mb-3">
                                        <strong class="d-block mb-1">Address</strong>
                                        <span>Fairland Properties 3/F Unit 12 Nuñez Extension, Zamboanga City</span>
                                    </li>
                                    <li class="mb-3">
                                        <strong class="d-block mb-1">Phone</strong>
                                        <span>+63 955 680 8880</span>
                                        <span>993-9790</span>
                                    </li>
                                    <li class="mb-3">
                                        <strong class="d-block mb-1">Telephone</strong>
                                        <span>993-9790</span>
                                    </li>
                                    <li class="mb-3">
                                        <strong class="d-block mb-1">Email</strong>
                                        <span>hungrychiefzam@gmail.com</span>
                                    </li>
                                    </ul>
                                </v-col>
                            </v-row> -->
                        </v-col>
                    </v-row>
                </v-container>
            </section><!-- End Services Section -->

            <!-- ======= Contact Us Section ======= -->
            <section id="contact" class="contact">
                <v-container>
                    <v-row justify="center">
                        <v-col cols="12" xl=8>
                            <div class="section-title" data-aos="fade-up">
                                <h2>Contact Us</h2>
                                <p>Contact us the get started</p>
                            </div>
                            <div class="row">

                                <div class="col-lg-5 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100">
                                    <div class="infos">
                                        <div class="address">
                                            <v-icon large >mdi-google-maps</v-icon>
                                            <h4>Location:</h4>
                                            <p>A108 Adam Street, New York, NY 535022</p>
                                        </div>

                                        <div class="email">
                                            <v-icon large >mdi-at</v-icon>
                                            <h4>Email:</h4>
                                            <p>info@example.com</p>
                                        </div>

                                        <div class="phone">
                                            <v-icon large >mdi-phone</v-icon>
                                            <h4>Call:</h4>
                                            <p>+1 5589 55488 55s</p>
                                        </div>

                                        <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d12097.433213460943!2d-74.0062269!3d40.7101282!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xb89d1fe6bc499443!2sDowntown+Conference+Center!5e0!3m2!1smk!2sbg!4v1539943755621" frameborder="0" style="border:0; width: 100%; height: 290px;" allowfullscreen></iframe>
                                    </div>

                                </div>

                                <div class="col-lg-7 mt-5 mt-lg-0 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="200">
                                    <form action="forms/contact.php" method="post" role="form" class="php-email-form">
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                        <label for="name">Your Name</label>
                                        <input type="text" name="name" class="form-control" id="name" data-rule="minlen:4" data-msg="Please enter at least 4 chars" />
                                        <div class="validate"></div>
                                        </div>
                                        <div class="form-group col-md-6">
                                        <label for="name">Your Email</label>
                                        <input type="email" class="form-control" name="email" id="email" data-rule="email" data-msg="Please enter a valid email" />
                                        <div class="validate"></div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Subject</label>
                                        <input type="text" class="form-control" name="subject" id="subject" data-rule="minlen:4" data-msg="Please enter at least 8 chars of subject" />
                                        <div class="validate"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Message</label>
                                        <textarea class="form-control" name="message" rows="10" data-rule="required" data-msg="Please write something for us"></textarea>
                                        <div class="validate"></div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="loading">Loading</div>
                                        <div class="error-message"></div>
                                        <div class="sent-message">Your message has been sent. Thank you!</div>
                                    </div>
                                    <div class="text-center"><button type="submit">Send Message</button></div>
                                    </form>
                                </div>

                            </div>
                        </v-col>
                    </v-row>
                </v-container>
            </section>
        </main><!-- End #main -->

        <!-- ======= Footer ======= -->
        <footer class="footer section-bg" role="contentinfo">
            <v-container>
                <v-row justify="center">
                    <v-col cols="12" xl=8>
                        <!-- <v-row>
                            <v-col cols="12" md=4 class="mb-4 mb-md-0">
                                <h3>About HungryChief</h3>
                                <p>Hungrychief is an online food ordering system or online restaurant aggregator that enables users to order food from various restaurants that are available on the Hungrychief website and mobile platform.  The system is web based and has mobile web integration it allows users to order their favorite foods from their favorite restaurant and then wait for a confirmation as for food get delivered to their address.</p>
                                <p class="social">
                                    <a href="https://www.facebook.com/hungrychief/" target="_blank"><span class="fab fa-facebook-f"></span></a>
                                </p>
                            </v-col>
                            <v-col cols="12" md=7 class="ml-auto">
                                <v-row class="site-section pt-0">
                                    <v-col cols="12" md=4 class="mb-4 mb-md-0">
                                        <h3>Menu</h3>
                                        <ul class="list-unstyled">
                                            <li><a href="#">Track My Order</a></li>
                                            <li><a href="#">How It Works</a></li>
                                            <li><a href="#">FAQ's</a></li>
                                            <li><a href="#">Term and Condition</a></li>
                                            <li><a href="#">Privacy Policy</a></li>
                                        </ul>
                                    </v-col>
                                    <v-col cols="12" md=4 class="mb-4 mb-md-0">
                                        <h3>Others</h3>
                                        <ul class="list-unstyled">
                                            <li><a href="#">Add your Restaurant</a></li>
                                            <li><a href="#">Business App</a></li>
                                            <li><a href="#">Restaurant Owner Guidlines</a></li>
                                            <li><a href="#">Promote and Advertise</a></li>
                                        </ul>
                                    </v-col>
                                    <v-col cols="12" md=4 class="mb-4 mb-md-0">
                                        <h3>Downloads</h3>
                                        <ul class="list-unstyled">
                                            <li><a href="#">Get from the App Store</a></li>
                                            <li><a href="https://play.google.com/store/apps/details?id=hungrychief.dreamers&fbclid=IwAR0ivFcAhizSP3IxLCvBT2Jl1nAZJkQhfMj7PjwiZq31wJjgeJXqulTL038">Get from the Play Store</a></li>
                                        </ul>
                                    </v-col>
                                </v-row>
                            </v-col>
                        </v-row> -->
                        <v-row justify="center" class="text-center">
                            <v-col cols="12" md=7>
                                <p class="copyright">&copy; Copyright BalikbayanBox. All Rights Reserved</p>
                                <p>Made with <v-icon class="far fa-heart fa-beat"></v-icon> by<a href="https://dreamers.ph" target="_blank"> Dreame.rs</a></p>
                            </v-col>
                        </v-row>
                    </v-col>
                </v-row>
            </v-container>
        </footer>

        <a href="#" class="back-to-top"><i class="fas fa-chevron-up"></i></a>
    </v-app>
</template>

<script>
    export default {
        data() {
            return {
                message: null,
            }
        },
        mounted() {
            // Echo.private('App.User.' + sessionStorage.getItem('user-id'))
            // .notification((notification) => {
            //     console.log(notification)

            //     Possible Notification Types
            //     + NewBoxCollectionRequestNotification
            //     + NewBoxRequestNotification
            //     + UpdatedBoxCollectionRequestNotification
            //     + UpdatedBoxNotification
            //     + UpdatedBoxRequestNotification
            // });
        },
        beforeRouteEnter (to, from, next) {
            if(sessionStorage.getItem('user-type')){
                if (sessionStorage.getItem('user-type') == "ADMINISTRATOR")
                    return next('/admin/boxes')
                // else if (sessionStorage.getItem('user-type') == 'GroceryStore')
                //     return next('/stock-classifications')
            }
            next();
        }
    }
</script>
