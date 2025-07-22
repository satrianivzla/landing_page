<h1>About Us</h1>
<?php echo validation_errors(); ?>
<?php echo form_open('admin/about'); ?>
<div class="mb-3">
    <label for="about_us_content" class="form-label">About Us Content</label>
    <textarea name="about_us_content" id="about_us_content" class="form-control summernote"><?php echo $settings['about_us_content']; ?></textarea>
</div>
<button type="submit" class="btn btn-primary">Save Content</button>
<?php echo form_close(); ?>
