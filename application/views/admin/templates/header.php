<!DOCTYPE html>
<html>
<head>
    <title><?php echo $title; ?> - <?php echo $settings['site_title']; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs5.min.css" />
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?php echo site_url('admin'); ?>"><?php echo $settings['site_title']; ?> Admin</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo site_url('admin'); ?>">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo site_url('admin/settings'); ?>">Settings</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo site_url('admin/about'); ?>">About Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo site_url('admin/services'); ?>">Services</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo site_url('admin/gallery'); ?>">Gallery</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo site_url('admin/contact'); ?>">Contact</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo site_url('admin/legal'); ?>">Legal</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo site_url('auth/logout'); ?>">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="container">
