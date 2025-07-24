<h1>Edit Gallery Category</h1>
<?php echo validation_errors(); ?>
<?php echo form_open('admin/edit_gallery_category/' . $category['id']); ?>
<div class="mb-3">
    <label for="name" class="form-label">Name</label>
    <input type="text" name="name" id="name" class="form-control" value="<?php echo $category['name']; ?>">
</div>
<button type="submit" class="btn btn-primary">Update Category</button>
<?php echo form_close(); ?>
