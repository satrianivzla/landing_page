<?php $this->load->view('templates/header'); ?>

<div class="row">
    <div class="col-md-3">
        <div class="list-group">
            <a href="<?php echo base_url('admin/slider'); ?>" class="list-group-item list-group-item-action">Slider</a>
            <a href="<?php echo base_url('admin/about'); ?>" class="list-group-item list-group-item-action">About Us</a>
            <a href="<?php echo base_url('admin/services'); ?>" class="list-group-item list-group-item-action">Services</a>
            <a href="<?php echo base_url('admin/gallery'); ?>" class="list-group-item list-group-item-action">Gallery</a>
            <a href="<?php echo base_url('admin/contact'); ?>" class="list-group-item list-group-item-action">Contact</a>
            <a href="<?php echo base_url('admin/legal'); ?>" class="list-group-item list-group-item-action active">Legal Pages</a>
            <a href="<?php echo base_url('admin/logo'); ?>" class="list-group-item list-group-item-action">Logo</a>
            <a href="<?php echo base_url('admin/favicon'); ?>" class="list-group-item list-group-item-action">Favicon</a>
        </div>
    </div>
    <div class="col-md-9">
        <h1>Manage Legal Pages</h1>
        <hr>
        <?php echo form_open('admin/update_legal');?>
            <div class="form-group">
                <label for="privacy">Privacy Policy</label>
                <textarea name="privacy" id="privacy" class="form-control" rows="10"></textarea>
            </div>
            <hr>
            <div class="form-group">
                <label for="cookies">Cookies Policy</label>
                <textarea name="cookies" id="cookies" class="form-control" rows="10"></textarea>
            </div>
            <hr>
            <div class="form-group">
                <label for="terms">Terms of Use</label>
                <textarea name="terms" id="terms" class="form-control" rows="10"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
</div>

<?php $this->load->view('templates/footer'); ?>
