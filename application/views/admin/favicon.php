<?php $this->load->view('templates/header'); ?>

<div class="row">
    <div class="col-md-3">
        <div class="list-group">
            <a href="<?php echo base_url('admin/slider'); ?>" class="list-group-item list-group-item-action">Slider</a>
            <a href="<?php echo base_url('admin/about'); ?>" class="list-group-item list-group-item-action">About Us</a>
            <a href="<?php echo base_url('admin/services'); ?>" class="list-group-item list-group-item-action">Services</a>
            <a href="<?php echo base_url('admin/gallery'); ?>" class="list-group-item list-group-item-action">Gallery</a>
            <a href="<?php echo base_url('admin/contact'); ?>" class="list-group-item list-group-item-action">Contact</a>
            <a href="<?php echo base_url('admin/legal'); ?>" class="list-group-item list-group-item-action">Legal Pages</a>
            <a href="<?php echo base_url('admin/logo'); ?>" class="list-group-item list-group-item-action">Logo</a>
            <a href="<?php echo base_url('admin/favicon'); ?>" class="list-group-item list-group-item-action active">Favicon</a>
        </div>
    </div>
    <div class="col-md-9">
        <h1>Manage Favicon</h1>
        <hr>
        <h3>Upload New Favicon</h3>
        <?php echo form_open_multipart('admin/upload_favicon');?>
            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" name="image" id="image" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Upload</button>
        </form>
        <hr>
        <h3>Current Favicon</h3>
        <img src="https://via.placeholder.com/32x32.png?text=Favicon" class="img-thumbnail">
    </div>
</div>

<?php $this->load->view('templates/footer'); ?>
