<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link rel="icon" href="<?php echo base_url($favicon); ?>" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css'); ?>">
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
			      <?php
				    $installer_logo ="logo.png";
					if (@getimagesize(base_url($logo))) {
						echo '<img src="'. base_url($logo).'" alt="Logo" title="Logo" width="150">';
					} else {
			            echo '<img src="'. base_url('uploads/'. $installer_logo).'" alt="Logo" title="Logo" width="150">';
					}
				  ?>
            </a>
        </div>
    </nav>
    <div class="container">
