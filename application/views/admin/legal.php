<h1>Legal Documents</h1>
<?php echo validation_errors(); ?>
<?php echo form_open('admin/legal'); ?>
<div class="mb-3">
    <label for="privacy_policy" class="form-label">Privacy Policy</label>
    <textarea name="privacy_policy" id="privacy_policy" class="form-control summernote"><?php echo $settings['privacy_policy']; ?></textarea>
</div>
<div class="mb-3">
    <label for="terms_of_use" class="form-label">Terms of Use</label>
    <textarea name="terms_of_use" id="terms_of_use" class="form-control summernote"><?php echo $settings['terms_of_use']; ?></textarea>
</div>
<div class="mb-3">
    <label for="cookie_policy" class="form-label">Cookie Policy</label>
    <textarea name="cookie_policy" id="cookie_policy" class="form-control summernote"><?php echo $settings['cookie_policy']; ?></textarea>
</div>
<button type="submit" class="btn btn-primary">Save Documents</button>
<?php echo form_close(); ?>
