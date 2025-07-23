<h1>Legal Documents</h1>
<?php echo validation_errors(); ?>
<?php echo form_open('admin/legal'); ?>
<?php echo generate_summernote_textarea('privacy_policy', 'Privacy Policy', $settings['privacy_policy']); ?>
<?php echo generate_summernote_textarea('terms_of_use', 'Terms of Use', $settings['terms_of_use']); ?>
<?php echo generate_summernote_textarea('cookie_policy', 'Cookie Policy', $settings['cookie_policy']); ?>
<button type="submit" class="btn btn-primary">Save Documents</button>
<?php echo form_close(); ?>
