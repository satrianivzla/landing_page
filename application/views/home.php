<?php
$countdown = date("Y/m/d", strtotime($countdown_date));
?>
<main class="main">

    <!-- Hero Section -->
    <section id="hero" class="hero section transparent-background">

      <div class="container text-center" data-aos="fade-up" data-aos-delay="100">
        <div class="row justify-content-center">
          <div class="col-lg-8">
            <h2><?php echo $settings['site_title']; ?></h2>
            <p>We are still working on our website. Stay tuned for updates!</p>
          </div>
          <div class="countdown d-flex justify-content-center" data-count="<?php echo $countdown; ?>">
            <div>
              <h3 class="count-days">0</h3>
              <h4>Days</h4>
            </div>
            <div>
              <h3 class="count-hours">0</h3>
              <h4>Hours</h4>
            </div>
            <div>
              <h3 class="count-minutes">0</h3>
              <h4>Minutes</h4>
            </div>
            <div>
              <h3 class="count-seconds">0</h3>
              <h4>Seconds</h4>
            </div>
          </div>

          <div class="col-lg-5 hero-newsletter">
            <p>Subscribe now to get the latest updates!</p>
            <form action="forms/newsletter.php" method="post" class="php-email-form">
              <div class="newsletter-form"><input type="email" name="email"><input type="submit" value="Subscribe"></div>
              <div class="loading">Loading</div>
              <div class="error-message"></div>
              <div class="sent-message">Your subscription request has been sent. Thank you!</div>
            </form>
          </div>

          <div class="social-links">
            <?php if (!empty($settings['account_whatsapp'])) { ?><a href="<?php echo $settings['account_whatsapp']; ?>" title="WhatsApp" target="_blank"><i class="bi bi-whatsapp"></i></a><?php } ?>
            <?php if (!empty($settings['account_instagram'])) { ?><a href="<?php echo $settings['account_instagram']; ?>" title="Instagram" target="_blank"><i class="bi bi-instagram"></i></a><?php } ?>
            <?php if (!empty($settings['account_tiktok'])) { ?><a href="<?php echo $settings['account_tiktok']; ?>" title="TikTok" target="_blank"><i class="bi bi-tiktok"></i></a><?php } ?>
            <?php if (!empty($settings['account_facebook'])) { ?><a href="<?php echo $settings['account_facebook']; ?>" title="Facebook" target="_blank"><i class="bi bi-facebook"></i></a><?php } ?>
            <?php if (!empty($settings['account_twitter'])) { ?><a href="<?php echo $settings['account_twitter']; ?>" title="Twitter" target="_blank"><i class="bi bi-twitter-x"></i></a><?php } ?>
            <?php if (!empty($settings['account_linkedin'])) { ?><a href="<?php echo $settings['account_linkedin']; ?>" title="Linkedin" target="_blank"><i class="bi bi-linkedin"></i></a><?php } ?>
          </div>

        </div>
      </div>

    </section><!-- /Hero Section -->

    <?php if ($settings['show_about']): ?>
    <!-- About Section -->
    <section id="about" class="about section">

      <div class="container">

        <div class="row gy-4">

          <div class="col-lg-6 content" data-aos="fade-up" data-aos-delay="100">
            <p class="who-we-are">Who We Are</p>
            <h3>Unleashing Potential with Creative Strategy</h3>
            <?php echo $settings['about_us_content']; ?>
          </div>

          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
            <div class="row gy-4">
              <div class="col-md-6">
                <div class="icon-box">
                  <i class="bi bi-briefcase"></i>
                  <h3>Corporis</h3>
                  <p>Ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                  <a href="#" class="read-more"><span>Read More</span> <i class="bi bi-arrow-right"></i></a>
                </div>
              </div>
              <div class="col-md-6">
                <div class="icon-box">
                  <i class="bi bi-gem"></i>
                  <h3>Laborum</h3>
                  <p>Ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                  <a href="#" class="read-more"><span>Read More</span> <i class="bi bi-arrow-right"></i></a>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </section><!-- /About Section -->
    <?php endif; ?>

    <?php if ($settings['show_services']): ?>
    <!-- Services Section -->
    <section id="services" class="services section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Services</h2>
        <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p>
      </div><!-- End Section Title -->

      <div class="container">
        <?php echo $settings['services_content']; ?>
      </div>

    </section><!-- /Services Section -->
    <?php endif; ?>

    <?php if ($settings['show_gallery']): ?>
    <!-- Portfolio Section -->
    <section id="portfolio" class="portfolio section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Portfolio</h2>
        <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p>
      </div><!-- End Section Title -->

      <div class="container">

        <div class="isotope-layout" data-default-filter="*" data-layout="masonry" data-sort="original-order">

          <ul class="portfolio-filters isotope-filters" data-aos="fade-up" data-aos-delay="100">
            <li data-filter="*" class="filter-active">All</li>
            <?php
            $filters = [];
            foreach ($gallery as $image) {
                $filters[] = $image['filter'];
            }
            $filters = array_unique($filters);
            foreach ($filters as $filter) {
                echo '<li data-filter=".filter-' . $filter . '">' . ucfirst($filter) . '</li>';
            }
            ?>
          </ul><!-- End Portfolio Filters -->

          <div class="row gy-4 isotope-container" data-aos="fade-up" data-aos-delay="200">
            <?php foreach ($gallery as $image): ?>
            <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-<?php echo $image['filter']; ?>">
              <div class="portfolio-content h-100">
                <img src="<?php echo base_url('uploads/gallery/' . $image['image']); ?>" class="img-fluid" alt="">
                <div class="portfolio-info">
                  <h4><?php echo $image['title']; ?></h4>
                  <p>Lorem ipsum, dolor sit amet consectetur</p>
                  <a href="<?php echo base_url('uploads/gallery/' . $image['image']); ?>" title="<?php echo $image['title']; ?>" data-gallery="portfolio-gallery-<?php echo $image['filter']; ?>" class="glightbox preview-link"><i class="bi bi-zoom-in"></i></a>
                  <a href="portfolio-details.html" title="More Details" class="details-link"><i class="bi bi-link-45deg"></i></a>
                </div>
              </div>
            </div><!-- End Portfolio Item -->
            <?php endforeach; ?>
          </div><!-- End Portfolio Container -->

        </div>

      </div>

    </section><!-- /Portfolio Section -->
    <?php endif; ?>

    <?php if ($settings['show_contact']): ?>
    <!-- Contact Section -->
    <section id="contact" class="contact section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Contact</h2>
        <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p>
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-4">

          <div class="col-lg-5">

            <div class="info-wrap">
              <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="200">
                <i class="bi bi-geo-alt flex-shrink-0"></i>
                <div>
                  <h3>Address</h3>
                  <p><?php echo $settings['contact_address']; ?></p>
                </div>
              </div><!-- End Info Item -->

              <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="300">
                <i class="bi bi-telephone flex-shrink-0"></i>
                <div>
                  <h3>Call Us</h3>
                  <p><?php echo $settings['contact_phone']; ?></p>
                </div>
              </div><!-- End Info Item -->

              <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="400">
                <i class="bi bi-envelope flex-shrink-0"></i>
                <div>
                  <h3>Email Us</h3>
                  <p><?php echo $settings['contact_email']; ?></p>
                </div>
              </div><!-- End Info Item -->

              <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="500">
                <i class="bi bi-clock flex-shrink-0"></i>
                <div>
                  <h3>Opening Hours</h3>
                  <p><?php echo $settings['opening_days']; ?>: <?php echo $settings['opening_hours']; ?></p>
                </div>
              </div><!-- End Info Item -->

              <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d48389.78314118045!2d-74.006138!3d40.710059!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c25a22a3bda30d%3A0xb89d1fe6bc499443!2sDowntown%20Conference%20Center!5e0!3m2!1sen!2sus!4v1676961268712!5m2!1sen!2sus" frameborder="0" style="border:0; width: 100%; height: 270px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
          </div>

          <div class="col-lg-7">
            <form action="forms/contact.php" method="post" class="php-email-form" data-aos="fade-up" data-aos-delay="200">
              <div class="row gy-4">

                <div class="col-md-6">
                  <label for="name-field" class="pb-2">Your Name</label>
                  <input type="text" name="name" id="name-field" class="form-control" required="">
                </div>

                <div class="col-md-6">
                  <label for="email-field" class="pb-2">Your Email</label>
                  <input type="email" class="form-control" name="email" id="email-field" required="">
                </div>

                <div class="col-md-12">
                  <label for="subject-field" class="pb-2">Subject</label>
                  <input type="text" class="form-control" name="subject" id="subject-field" required="">
                </div>

                <div class="col-md-12">
                  <label for="message-field" class="pb-2">Message</label>
                  <textarea class="form-control" name="message" rows="10" id="message-field" required=""></textarea>
                </div>

                <div class="col-md-12 text-center">
                  <div class="loading">Loading</div>
                  <div class="error-message"></div>
                  <div class="sent-message">Your message has been sent. Thank you!</div>

                  <button type="submit">Send Message</button>
                </div>

              </div>
            </form>
          </div><!-- End Contact Form -->

        </div>

      </div>

    </section><!-- /Contact Section -->
    <?php endif; ?>

</main>
