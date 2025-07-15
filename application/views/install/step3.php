<?php $this->load->view('templates/header'); ?>

<div class="row">
    <div class="col-md-12">
        <h1>Installation - Step 3: Site Information</h1>
        <hr>
        <p class="text-success">Database has been set up successfully!</p>
        <?php echo form_open_multipart('install/step4'); ?>
            <div class="form-group">
                <label for="site_title">Site Title</label>
                <input type="text" name="site_title" id="site_title" class="form-control" value="Coming Soon">
            </div>
            <div class="form-group">
                <label for="logo">Logo</label>
                <input type="file" name="logo" id="logo" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Next</button>
        </form>
    </div>
</div>

<?php $this->load->view('templates/footer'); ?>
