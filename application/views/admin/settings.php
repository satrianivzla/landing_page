<h1>Settings</h1>
<?php echo validation_errors(); ?>
<?php echo form_open('admin/settings'); ?>
<div class="mb-3">
    <label for="site_title" class="form-label">Site Title</label>
    <input type="text" name="site_title" id="site_title" class="form-control" value="<?php echo $settings['site_title']; ?>">
</div>
<div class="mb-3">
    <label for="countdown_date" class="form-label">Countdown Date</label>
    <input type="text" name="countdown_date" id="countdown_date" class="form-control" value="<?php echo $settings['countdown_date']; ?>">
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
