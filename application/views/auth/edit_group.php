<?php $this->load->view('templates/header'); ?>

<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <h1><?php echo lang('edit_group_heading');?></h1>
        <p><?php echo lang('edit_group_subheading');?></p>

        <div id="infoMessage"><?php echo $message;?></div>

        <?php echo form_open(current_url());?>

              <div class="form-group">
                    <?php echo lang('edit_group_name_label', 'group_name');?> <br />
                    <?php echo form_input($group_name);?>
              </div>

              <div class="form-group">
                    <?php echo lang('edit_group_desc_label', 'description');?> <br />
                    <?php echo form_input($group_description);?>
              </div>

              <p><?php echo form_submit('submit', lang('edit_group_submit_btn'), array('class' => 'btn btn-primary'));?></p>

        <?php echo form_close();?>
    </div>
</div>

<?php $this->load->view('templates/footer'); ?>
