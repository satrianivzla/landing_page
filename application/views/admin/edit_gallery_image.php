<h1>Edit Gallery Image</h1>
<?php echo validation_errors(); ?>
<?php if (isset($error)) echo '<div class="alert alert-danger">' . $error . '</div>'; ?>
<?php echo form_open_multipart('admin/edit_gallery_image/' . $image['id']); ?>
<div class="mb-3">
    <label for="title" class="form-label">Title</label>
    <input type="text" name="title" id="title" class="form-control" value="<?php echo $image['title']; ?>">
</div>
<div class="mb-3">
    <label for="filter" class="form-label">Filter</label>
    <input type="text" name="filter" id="filter" class="form-control" value="<?php echo $image['filter']; ?>">
</div>
<div class="mb-3">
    <label for="image" class="form-label">Image</label>
    <input type="file" name="image" id="image" class="form-control">
    <img src="<?php echo base_url('uploads/gallery/' . $image['image']); ?>" width="100">
</div>
<button type="submit" class="btn btn-primary">Update Image</button>
<?php echo form_close(); ?>
