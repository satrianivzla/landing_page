<?php $this->load->view('templates/header'); ?>

<div class="row">
    <div class="col-md-3">
        <div class="list-group">
            <a href="<?php echo base_url('admin/slider'); ?>" class="list-group-item list-group-item-action">Slider</a>
            <a href="<?php echo base_url('admin/about'); ?>" class="list-group-item list-group-item-action">About Us</a>
            <a href="<?php echo base_url('admin/services'); ?>" class="list-group-item list-group-item-action">Services</a>
            <a href="<?php echo base_url('admin/gallery'); ?>" class="list-group-item list-group-item-action active">Gallery</a>
            <a href="<?php echo base_url('admin/contact'); ?>" class="list-group-item list-group-item-action">Contact</a>
            <a href="<?php echo base_url('admin/legal'); ?>" class="list-group-item list-group-item-action">Legal Pages</a>
            <a href="<?php echo base_url('admin/logo'); ?>" class="list-group-item list-group-item-action">Logo</a>
            <a href="<?php echo base_url('admin/favicon'); ?>" class="list-group-item list-group-item-action">Favicon</a>
        </div>
    </div>
    <div class="col-md-9">
        <h1>Manage Gallery</h1>
        <hr>
        <h3>Upload New Image</h3>
        <?php echo form_open_multipart('admin/upload_gallery_image');?>
            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" name="image" id="image" class="form-control">
            </div>
            <div class="form-group">
                <label for="category">Category</label>
                <input type="text" name="category" id="category" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Upload</button>
        </form>
        <hr>
        <h3>Existing Images</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Category</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><img src="https://via.placeholder.com/150x150.png?text=Image+1" class="img-thumbnail"></td>
                    <td>Category 1</td>
                    <td><a href="#" class="btn btn-danger">Delete</a></td>
                </tr>
                <tr>
                    <td><img src="https://via.placeholder.com/150x150.png?text=Image+2" class="img-thumbnail"></td>
                    <td>Category 2</td>
                    <td><a href="#" class="btn btn-danger">Delete</a></td>
                </tr>
                <tr>
                    <td><img src="https://via.placeholder.com/150x150.png?text=Image+3" class="img-thumbnail"></td>
                    <td>Category 1</td>
                    <td><a href="#" class="btn btn-danger">Delete</a></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<?php $this->load->view('templates/footer'); ?>
