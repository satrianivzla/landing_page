<h1>Gallery</h1>
<a href="<?php echo site_url('admin/add_gallery_image'); ?>" class="btn btn-primary mb-3">Add Image</a>
<table id="galleryTable" class="table table-striped" style="width:100%">
    <thead>
        <tr>
            <th>Title</th>
            <th>Category</th>
            <th>Image</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($gallery as $image): ?>
            <tr>
                <td><?php echo $image['title']; ?></td>
                <td><?php echo $image['category_id']; ?></td>
                <td><img src="<?php echo base_url('uploads/gallery/' . $image['image']); ?>" width="100"></td>
                <td>
                    <a href="<?php echo site_url('admin/edit_gallery_image/' . $image['id']); ?>" class="btn btn-sm btn-info">Edit</a>
                    <a href="<?php echo site_url('admin/delete_gallery_image/' . $image['id']); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this image?')">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
