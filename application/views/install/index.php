<?php $this->load->view('templates/header'); ?>

<div class="row">
    <div class="col-md-12">
        <h1>Installation - Step 1: Server Requirements</h1>
        <hr>
        <p>PHP Version: <?php echo phpversion(); ?></p>
        <?php if ($requirements['php_version']): ?>
            <p class="text-success">OK</p>
        <?php else: ?>
            <p class="text-danger">Failed</p>
        <?php endif; ?>

        <p>MySQLi Extension: <?php echo $requirements['mysqli_extension'] ? 'Loaded' : 'Not Loaded'; ?></p>
        <?php if ($requirements['mysqli_extension']): ?>
            <p class="text-success">OK</p>
        <?php else: ?>
            <p class="text-danger">Failed</p>
        <?php endif; ?>

        <?php if ($message): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $message; ?>
            </div>
        <?php else: ?>
            <a href="<?php echo base_url('install/step2'); ?>" class="btn btn-primary">Next</a>
        <?php endif; ?>
    </div>
</div>

<?php $this->load->view('templates/footer'); ?>
