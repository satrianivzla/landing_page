<h1>Settings</h1>
<?php echo validation_errors(); ?>
<?php if (isset($error)) echo '<div class="alert alert-danger">' . $error . '</div>'; ?>
<?php echo form_open_multipart('admin/settings'); ?>
<div class="mb-3">
    <label for="site_title" class="form-label">Site Title</label>
    <input type="text" name="site_title" id="site_title" class="form-control" value="<?php echo $settings['site_title']; ?>">
</div>
<div class="mb-3">
    <label for="meta_description" class="form-label">Meta Description</label>
    <textarea name="meta_description" id="meta_description" class="form-control"><?php echo $settings['meta_description']; ?></textarea>
</div>
<div class="mb-3">
    <label for="meta_keywords" class="form-label">Meta Keywords</label>
    <textarea name="meta_keywords" id="meta_keywords" class="form-control"><?php echo $settings['meta_keywords']; ?></textarea>
</div>
<div class="mb-3">
    <label for="countdown_date" class="form-label">Countdown Date</label>
    <input type="text" name="countdown_date" id="countdown_date" class="form-control" value="<?php echo $settings['countdown_date']; ?>">
</div>
<div class="mb-3">
    <label for="logo" class="form-label">Logo</label>
    <input type="file" name="logo" id="logo" class="form-control">
    <?php if ($settings['logo']): ?>
        <img src="<?php echo base_url('uploads/' . $settings['logo']); ?>" alt="Logo" width="100">
    <?php endif; ?>
</div>
<div class="mb-3">
    <label for="favicon" class="form-label">Favicon</label>
    <input type="file" name="favicon" id="favicon" class="form-control">
    <?php if ($settings['favicon']): ?>
        <img src="<?php echo base_url('uploads/' . $settings['favicon']); ?>" alt="Favicon" width="32">
    <?php endif; ?>
</div>
<div class="mb-3 form-check">
    <input type="checkbox" name="show_about" id="show_about" class="form-check-input" value="1" <?php echo $settings['show_about'] ? 'checked' : ''; ?>>
    <label for="show_about" class="form-check-label">Show About Us Section</label>
</div>
<div class="mb-3 form-check">
    <input type="checkbox" name="show_services" id="show_services" class="form-check-input" value="1" <?php echo $settings['show_services'] ? 'checked' : ''; ?>>
    <label for="show_services" class="form-check-label">Show Services Section</label>
</div>
<div class="mb-3 form-check">
    <input type="checkbox" name="show_gallery" id="show_gallery" class="form-check-input" value="1" <?php echo $settings['show_gallery'] ? 'checked' : ''; ?>>
    <label for="show_gallery" class="form-check-label">Show Gallery Section</label>
</div>
<div class="mb-3 form-check">
    <input type="checkbox" name="show_contact" id="show_contact" class="form-check-input" value="1" <?php echo $settings['show_contact'] ? 'checked' : ''; ?>>
    <label for="show_contact" class="form-check-label">Show Contact Section</label>
</div>
<button type="submit" class="btn btn-primary">Save Settings</button>
<?php echo form_close(); ?>
