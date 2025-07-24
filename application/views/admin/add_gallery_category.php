<h1>Add Gallery Category</h1>
<?php echo validation_errors(); ?>
<?php echo form_open('admin/add_gallery_category'); ?>
<div class="mb-3">
    <label for="name" class="form-label">Name</label>
    <input type="text" name="name" id="name" class="form-control">
</div>
<button type="submit" class="btn btn-primary">Add Category</button>
<?php echo form_close(); ?>
