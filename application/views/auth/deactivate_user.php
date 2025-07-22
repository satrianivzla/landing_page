<?php $this->load->view('templates/header'); ?>

<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <h1><?php echo lang('deactivate_heading');?></h1>
        <p><?php echo sprintf(lang('deactivate_subheading'), $user->username);?></p>

        <?php echo form_open("auth/deactivate/".$user->id);?>

          <div class="form-group">
            <?php echo lang('deactivate_confirm_y_label', 'confirm');?>
            <input type="radio" name="confirm" value="yes" checked="checked" />
            <?php echo lang('deactivate_confirm_n_label', 'confirm');?>
            <input type="radio" name="confirm" value="no" />
          </div>

          <?php echo form_hidden($csrf); ?>
          <?php echo form_hidden(array('id'=>$user->id)); ?>

          <p><?php echo form_submit('submit', lang('deactivate_submit_btn'), array('class' => 'btn btn-primary'));?></p>

        <?php echo form_close();?>
    </div>
</div>

<?php $this->load->view('templates/footer'); ?>
