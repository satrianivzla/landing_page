<h1>About Us</h1>
<?php echo validation_errors(); ?>
<?php echo form_open('admin/about'); ?>
<?php echo generate_summernote_textarea('about_us_content', 'About Us Content', $settings['about_us_content']); ?>
<button type="submit" class="btn btn-primary">Save Content</button>
<?php echo form_close(); ?>
