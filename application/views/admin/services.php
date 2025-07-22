<h1>Services</h1>
<?php echo validation_errors(); ?>
<?php echo form_open('admin/services'); ?>
<div class="mb-3">
    <label for="services_content" class="form-label">Services Content</label>
    <textarea name="services_content" id="services_content" class="form-control summernote"><?php echo $settings['services_content']; ?></textarea>
</div>
<button type="submit" class="btn btn-primary">Save Content</button>
<?php echo form_close(); ?>
