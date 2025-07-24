<h1>Add Gallery Image</h1>
<?php echo validation_errors(); ?>
<?php if (isset($error)) echo '<div class="alert alert-danger">' . $error . '</div>'; ?>
<?php echo form_open_multipart('admin/add_gallery_image'); ?>
<div class="mb-3">
    <label for="title" class="form-label">Title</label>
    <input type="text" name="title" id="title" class="form-control">
</div>
<div class="mb-3">
    <label for="category_id" class="form-label">Category</label>
    <select name="category_id" id="category_id" class="form-control">
        <?php foreach ($categories as $category): ?>
            <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
        <?php endforeach; ?>
    </select>
</div>
<div class="mb-3">
    <label for="image" class="form-label">Image</label>
    <input type="file" name="image" id="image" class="form-control">
</div>
<button type="submit" class="btn btn-primary">Add Image</button>
<?php echo form_close(); ?>
