<?php $this->load->view('templates/header'); ?>

<div class="row">
    <div class="col-md-12">
        <h1>Installation - Step 2: Database Credentials</h1>
        <hr>
        <?php echo form_open('install/step3'); ?>
            <div class="form-group">
                <label for="hostname">Hostname</label>
                <input type="text" name="hostname" id="hostname" class="form-control" value="localhost">
            </div>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" class="form-control" value="root">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control">
            </div>
            <div class="form-group">
                <label for="database">Database</label>
                <input type="text" name="database" id="database" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Next</button>
        </form>
    </div>
</div>

<?php $this->load->view('templates/footer'); ?>
