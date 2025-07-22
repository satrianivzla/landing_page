<?php $this->load->view('templates/header'); ?>

<div class="row">
    <div class="col-md-12">
        <h1>Installation - Step 4: Complete</h1>
        <hr>
        <p class="text-success">Installation is complete!</p>
        <div class="alert alert-danger" role="alert">
            <strong>Security Warning!</strong> Please delete the install controller file now! (application/controllers/install.php)
        </div>
        <a href="<?php echo base_url(); ?>" class="btn btn-primary">Go to Home Page</a>
        <a href="<?php echo base_url('admin'); ?>" class="btn btn-secondary">Go to Admin Panel</a>
    </div>
</div>

<?php $this->load->view('templates/footer'); ?>
