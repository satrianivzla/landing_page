<?php $this->load->view('templates/header'); ?>

<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <h1><?php echo lang('login_heading');?></h1>
        <p><?php echo lang('login_subheading');?></p>

        <div id="infoMessage"><?php echo $message;?></div>

        <?php echo form_open("auth/login");?>

          <div class="form-group">
            <?php echo lang('login_identity_label', 'identity');?>
            <?php echo form_input($identity);?>
          </div>

          <div class="form-group">
            <?php echo lang('login_password_label', 'password');?>
            <?php echo form_input($password);?>
          </div>

          <div class="form-group">
            <?php echo lang('login_remember_label', 'remember');?>
            <?php echo form_checkbox('remember', '1', FALSE, 'id="remember"');?>
          </div>


          <p><?php echo form_submit('submit', lang('login_submit_btn'), array('class' => 'btn btn-primary'));?></p>

        <?php echo form_close();?>

        <p><a href="forgot_password"><?php echo lang('login_forgot_password');?></a></p>
    </div>
</div>

<?php $this->load->view('templates/footer'); ?>
