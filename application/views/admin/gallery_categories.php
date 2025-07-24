<h1>Gallery Categories</h1>
<a href="<?php echo site_url('admin/add_gallery_category'); ?>" class="btn btn-primary mb-3">Add Category</a>
<table class="table">
    <thead>
        <tr>
            <th>Name</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($categories as $category): ?>
            <tr>
                <td><?php echo $category['name']; ?></td>
                <td>
                    <a href="<?php echo site_url('admin/edit_gallery_category/' . $category['id']); ?>" class="btn btn-sm btn-info">Edit</a>
                    <a href="<?php echo site_url('admin/delete_gallery_category/' . $category['id']); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this category?')">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
