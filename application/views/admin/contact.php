<h1>Contact</h1>
<?php echo validation_errors(); ?>
<?php echo form_open('admin/contact'); ?>
<?php echo generate_summernote_textarea('contact_content', 'Contact Content', $settings['contact_content']); ?>
<button type="submit" class="btn btn-primary">Save Content</button>
<?php echo form_close(); ?>
