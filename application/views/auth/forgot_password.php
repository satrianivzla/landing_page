<?php $this->load->view('templates/header'); ?>

<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <h1><?php echo lang('forgot_password_heading');?></h1>
        <p><?php echo sprintf(lang('forgot_password_subheading'), $identity_label);?></p>

        <div id="infoMessage"><?php echo $message;?></div>

        <?php echo form_open("auth/forgot_password");?>

              <div class="form-group">
                <label for="identity"><?php echo (($type=='email') ? sprintf(lang('forgot_password_email_label'), $identity_label) : sprintf(lang('forgot_password_identity_label'), $identity_label));?></label> <br />
                <?php echo form_input($identity);?>
              </div>

              <p><?php echo form_submit('submit', lang('forgot_password_submit_btn'), array('class' => 'btn btn-primary'));?></p>

        <?php echo form_close();?>
    </div>
</div>

<?php $this->load->view('templates/footer'); ?>
