<?php $this->load->view('templates/header'); ?>

<div class="row">
    <div class="col-md-3">
        <div class="list-group">
            <a href="<?php echo base_url('admin/slider'); ?>" class="list-group-item list-group-item-action">Slider</a>
            <a href="<?php echo base_url('admin/about'); ?>" class="list-group-item list-group-item-action active">About Us</a>
            <a href="<?php echo base_url('admin/services'); ?>" class="list-group-item list-group-item-action">Services</a>
            <a href="<?php echo base_url('admin/gallery'); ?>" class="list-group-item list-group-item-action">Gallery</a>
            <a href="<?php echo base_url('admin/contact'); ?>" class="list-group-item list-group-item-action">Contact</a>
            <a href="<?php echo base_url('admin/legal'); ?>" class="list-group-item list-group-item-action">Legal Pages</a>
            <a href="<?php echo base_url('admin/logo'); ?>" class="list-group-item list-group-item-action">Logo</a>
        </div>
    </div>
    <div class="col-md-9">
        <h1>Manage About Us</h1>
        <hr>
        <?php echo form_open('admin/update_about');?>
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" id="title" class="form-control" value="About Us">
            </div>
            <div class="form-group">
                <label for="content">Content</label>
                <textarea name="content" id="content" class="form-control" rows="5">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
</div>

<?php $this->load->view('templates/footer'); ?>
