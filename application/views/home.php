<?php $this->load->view('templates/header', array('logo' => $logo, 'favicon' => $favicon)); ?>

<div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
  </div>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="https://via.placeholder.com/800x400.png?text=First+slide" class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item">
      <img src="https://via.placeholder.com/800x400.png?text=Second+slide" class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item">
      <img src="https://via.placeholder.com/800x400.png?text=Third+slide" class="d-block w-100" alt="...">
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>

<section id="about" class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h2 class="section-heading">About Us</h2>
                <hr class="my-4">
                <p class="mb-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p>
            </div>
        </div>
    </div>
</section>

<section id="services" class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Our Services</h2>
                <hr class="my-4">
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6 text-center">
                <div class="service-box mt-5 mx-auto">
                    <i class="fas fa-4x fa-gem text-primary mb-3 sr-icon-1"></i>
                    <h3 class="mb-3">Sturdy Templates</h3>
                    <p class="text-muted mb-0">Our templates are updated regularly so they don't break.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 text-center">
                <div class="service-box mt-5 mx-auto">
                    <i class="fas fa-4x fa-paper-plane text-primary mb-3 sr-icon-2"></i>
                    <h3 class="mb-3">Ready to Ship</h3>
                    <p class="text-muted mb-0">You can use this theme as is, or you can make changes!</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 text-center">
                <div class="service-box mt-5 mx-auto">
                    <i class="fas fa-4x fa-code text-primary mb-3 sr-icon-3"></i>
                    <h3 class="mb-3">Up to Date</h3>
                    <p class="text-muted mb-0">We update dependencies to keep things fresh.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 text-center">
                <div class="service-box mt-5 mx-auto">
                    <i class="fas fa-4x fa-heart text-primary mb-3 sr-icon-4"></i>
                    <h3 class="mb-3">Made with Love</h3>
                    <p class="text-muted mb-0">Is it really open source if it's not made with love?</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="gallery" class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Gallery</h2>
                <hr class="my-4">
                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                    <label class="btn btn-secondary active">
                        <input type="radio" name="options" id="option1" autocomplete="off" checked> All
                    </label>
                    <label class="btn btn-secondary">
                        <input type="radio" name="options" id="option2" autocomplete="off"> Category 1
                    </label>
                    <label class="btn btn-secondary">
                        <input type="radio" name="options" id="option3" autocomplete="off"> Category 2
                    </label>
                </div>
            </div>
        </div>
        <div class="row no-gutters mt-4">
            <div class="col-lg-4 col-sm-6">
                <a class="portfolio-box" href="https://via.placeholder.com/800x600.png?text=Image+1">
                    <img class="img-fluid" src="https://via.placeholder.com/400x300.png?text=Image+1" alt="">
                    <div class="portfolio-box-caption">
                        <div class="portfolio-box-caption-content">
                            <div class="project-category text-faded">
                                Category
                            </div>
                            <div class="project-name">
                                Project Name
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-sm-6">
                <a class="portfolio-box" href="https://via.placeholder.com/800x600.png?text=Image+2">
                    <img class="img-fluid" src="https://via.placeholder.com/400x300.png?text=Image+2" alt="">
                    <div class="portfolio-box-caption">
                        <div class="portfolio-box-caption-content">
                            <div class="project-category text-faded">
                                Category
                            </div>
                            <div class="project-name">
                                Project Name
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-sm-6">
                <a class="portfolio-box" href="https://via.placeholder.com/800x600.png?text=Image+3">
                    <img class="img-fluid" src="https://via.placeholder.com/400x300.png?text=Image+3" alt="">
                    <div class="portfolio-box-caption">
                        <div class="portfolio-box-caption-content">
                            <div class="project-category text-faded">
                                Category
                            </div>
                            <div class="project-name">
                                Project Name
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>

<section id="contact" class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h2 class="section-heading">Contact Us</h2>
                <hr class="my-4">
                <p class="mb-5">Ready to start your next project with us? That's great! Give us a call or send us an email and we will get back to you as soon as possible!</p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 ml-auto text-center">
                <i class="fas fa-phone fa-3x mb-3 sr-contact-1"></i>
                <p>123-456-6789</p>
            </div>
            <div class="col-lg-4 mr-auto text-center">
                <i class="fas fa-envelope fa-3x mb-3 sr-contact-2"></i>
                <p>
                    <a href="mailto:your-email@your-domain.com">feedback@startbootstrap.com</a>
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <form id="contactForm" name="sentMessage" novalidate="novalidate">
                    <div class="control-group">
                        <div class="form-group floating-label-form-group controls mb-0 pb-2">
                            <label>Name</label>
                            <input class="form-control" id="name" type="text" placeholder="Name" required="required" data-validation-required-message="Please enter your name.">
                            <p class="help-block text-danger"></p>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="form-group floating-label-form-group controls mb-0 pb-2">
                            <label>Email Address</label>
                            <input class="form-control" id="email" type="email" placeholder="Email Address" required="required" data-validation-required-message="Please enter your email address.">
                            <p class="help-block text-danger"></p>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="form-group floating-label-form-group controls mb-0 pb-2">
                            <label>Phone Number</label>
                            <input class="form-control" id="phone" type="tel" placeholder="Phone Number" required="required" data-validation-required-message="Please enter your phone number.">
                            <p class="help-block text-danger"></p>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="form-group floating-label-form-group controls mb-0 pb-2">
                            <label>Message</label>
                            <textarea class="form-control" id="message" rows="5" placeholder="Message" required="required" data-validation-required-message="Please enter a message."></textarea>
                            <p class="help-block text-danger"></p>
                        </div>
                    </div>
                    <br>
                    <div id="success"></div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-xl" id="sendMessageButton">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<div class="map-responsive">
<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3153.252953282967!2d144.9630579153165!3d-37.81410797975145!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6ad642af0f11fd81%3A0xf577d2f4c4a5a2a7!2sFederation+Square!5e0!3m2!1sen!2sau!4v1542861612419" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
</div>

<a href="https://wa.me/1234567890" class="float" target="_blank">
<i class="fa fa-whatsapp my-float"></i>
</a>
<style>
.float{
	position:fixed;
	width:60px;
	height:60px;
	bottom:40px;
	right:40px;
	background-color:#25d366;
	color:#FFF;
	border-radius:50px;
	text-align:center;
	font-size:30px;
	box-shadow: 2px 2px 3px #999;
}

.my-float{
	margin-top:16px;
}
</style>
<footer class="bg-light py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h5 class="text-uppercase">Footer Content</h5>
                <p>
                    Here you can use rows and columns to organize your footer content.
                </p>
            </div>
            <div class="col-md-2">
                <h5 class="text-uppercase">Links</h5>
                <ul class="list-unstyled">
                    <li>
                        <a href="#!">Link 1</a>
                    </li>
                    <li>
                        <a href="#!">Link 2</a>
                    </li>
                </ul>
            </div>
            <div class="col-md-2">
                <h5 class="text-uppercase">Links</h5>
                <ul class="list-unstyled">
                    <li>
                        <a href="#!">Link 3</a>
                    </li>
                    <li>
                        <a href="#!">Link 4</a>
                    </li>
                </ul>
            </div>
            <div class="col-md-4">
                <h5 class="text-uppercase">Follow Us</h5>
                <a type="button" class="btn-floating btn-lg btn-fb">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a type="button" class="btn-floating btn-lg btn-tw">
                    <i class="fab fa-twitter"></i>
                </a>
                <a type="button" class="btn-floating btn-lg btn-gplus">
                    <i class="fab fa-google-plus-g"></i>
                </a>
            </div>
        </div>
        <div class="footer-copyright text-center py-3">© 2020 Copyright:
            <a href="https://mdbootstrap.com/education/bootstrap/"> MDBootstrap.com</a>
        </div>
    </div>
</footer>

<?php $this->load->view('templates/footer'); ?>
