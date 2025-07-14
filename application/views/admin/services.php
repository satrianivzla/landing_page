<?php $this->load->view('templates/header'); ?>

<div class="row">
    <div class="col-md-3">
        <div class="list-group">
            <a href="<?php echo base_url('admin/slider'); ?>" class="list-group-item list-group-item-action">Slider</a>
            <a href="<?php echo base_url('admin/about'); ?>" class="list-group-item list-group-item-action">About Us</a>
            <a href="<?php echo base_url('admin/services'); ?>" class="list-group-item list-group-item-action active">Services</a>
            <a href="<?php echo base_url('admin/gallery'); ?>" class="list-group-item list-group-item-action">Gallery</a>
            <a href="<?php echo base_url('admin/contact'); ?>" class="list-group-item list-group-item-action">Contact</a>
            <a href="<?php echo base_url('admin/legal'); ?>" class="list-group-item list-group-item-action">Legal Pages</a>
        </div>
    </div>
    <div class="col-md-9">
        <h1>Manage Services</h1>
        <hr>
        <?php echo form_open('admin/update_services');?>
            <div class="form-group">
                <label for="service1_title">Service 1 Title</label>
                <input type="text" name="service1_title" id="service1_title" class="form-control" value="Sturdy Templates">
                <label for="service1_content">Service 1 Content</label>
                <input type="text" name="service1_content" id="service1_content" class="form-control" value="Our templates are updated regularly so they don't break.">
            </div>
            <hr>
            <div class="form-group">
                <label for="service2_title">Service 2 Title</label>
                <input type="text" name="service2_title" id="service2_title" class="form-control" value="Ready to Ship">
                <label for="service2_content">Service 2 Content</label>
                <input type="text" name="service2_content" id="service2_content" class="form-control" value="You can use this theme as is, or you can make changes!">
            </div>
            <hr>
            <div class="form-group">
                <label for="service3_title">Service 3 Title</label>
                <input type="text" name="service3_title" id="service3_title" class="form-control" value="Up to Date">
                <label for="service3_content">Service 3 Content</label>
                <input type="text" name="service3_content" id="service3_content" class="form-control" value="We update dependencies to keep things fresh.">
            </div>
            <hr>
            <div class="form-group">
                <label for="service4_title">Service 4 Title</label>
                <input type="text" name="service4_title" id="service4_title" class="form-control" value="Made with Love">
                <label for="service4_content">Service 4 Content</label>
                <input type="text" name="service4_content" id="service4_content" class="form-control" value="Is it really open source if it's not made with love?">
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
</div>

<?php $this->load->view('templates/footer'); ?>
