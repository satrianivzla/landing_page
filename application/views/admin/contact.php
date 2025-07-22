<h1>Contact</h1>
<?php echo validation_errors(); ?>
<?php echo form_open('admin/contact'); ?>
<div class="mb-3">
    <label for="contact_content" class="form-label">Contact Content</label>
    <textarea name="contact_content" id="contact_content" class="form-control summernote"><?php echo $settings['contact_content']; ?></textarea>
</div>
<button type="submit" class="btn btn-primary">Save Content</button>
<?php echo form_close(); ?>
