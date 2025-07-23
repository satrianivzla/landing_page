<h1>Services</h1>
<?php echo validation_errors(); ?>
<?php echo form_open('admin/services'); ?>
<?php echo generate_summernote_textarea('services_content', 'Services Content', $settings['services_content']); ?>
<button type="submit" class="btn btn-primary">Save Content</button>
<?php echo form_close(); ?>
