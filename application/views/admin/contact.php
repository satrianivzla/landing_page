<?php $this->load->view('templates/header'); ?>

<div class="row">
    <div class="col-md-3">
        <div class="list-group">
            <a href="<?php echo base_url('admin/slider'); ?>" class="list-group-item list-group-item-action">Slider</a>
            <a href="<?php echo base_url('admin/about'); ?>" class="list-group-item list-group-item-action">About Us</a>
            <a href="<?php echo base_url('admin/services'); ?>" class="list-group-item list-group-item-action">Services</a>
            <a href="<?php echo base_url('admin/gallery'); ?>" class="list-group-item list-group-item-action">Gallery</a>
            <a href="<?php echo base_url('admin/contact'); ?>" class="list-group-item list-group-item-action active">Contact</a>
            <a href="<?php echo base_url('admin/legal'); ?>" class="list-group-item list-group-item-action">Legal Pages</a>
            <a href="<?php echo base_url('admin/logo'); ?>" class="list-group-item list-group-item-action">Logo</a>
        </div>
    </div>
    <div class="col-md-9">
        <h1>Manage Contact</h1>
        <hr>
        <?php echo form_open('admin/update_contact');?>
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" name="phone" id="phone" class="form-control" value="123-456-6789">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control" value="feedback@startbootstrap.com">
            </div>
            <div class="form-group">
                <label for="map">Google Maps Iframe</label>
                <textarea name="map" id="map" class="form-control" rows="5"><iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3153.252953282967!2d144.9630579153165!3d-37.81410797975145!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6ad642af0f11fd81%3A0xf577d2f4c4a5a2a7!2sFederation+Square!5e0!3m2!1sen!2sau!4v1542861612419" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
</div>

<?php $this->load->view('templates/footer'); ?>
