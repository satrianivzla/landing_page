<?php $this->load->view('templates/header'); ?>

<div class="row">
    <div class="col-md-12">
        <h1>Installation - Step 1: Server Requirements</h1>
        <hr>
        <p>PHP Version: <?php echo phpversion(); ?></p>
        <?php if (phpversion() >= '5.6'): ?>
            <p class="text-success">OK</p>
        <?php else: ?>
            <p class="text-danger">Failed</p>
        <?php endif; ?>

        <p>MySQLi Extension: <?php echo extension_loaded('mysqli') ? 'Loaded' : 'Not Loaded'; ?></p>
        <?php if (extension_loaded('mysqli')): ?>
            <p class="text-success">OK</p>
        <?php else: ?>
            <p class="text-danger">Failed</p>
        <?php endif; ?>

        <a href="<?php echo base_url('install/step2'); ?>" class="btn btn-primary">Next</a>
    </div>
</div>

<?php $this->load->view('templates/footer'); ?>
