<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $title; ?></title>
    <meta name="description" content="<?php echo $settings['meta_description']; ?>">
    <meta name="keywords" content="<?php echo $settings['meta_keywords']; ?>">
    <?php if ($settings['favicon']): ?>
        <link rel="apple-touch-icon" sizes="180x180" href="<?php echo base_url('uploads/' . $settings['favicon']); ?>/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="<?php echo base_url('uploads/' . $settings['favicon']); ?>/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url('uploads/' . $settings['favicon']); ?>/favicon-16x16.png">
        <link rel="manifest" href="<?php echo base_url('uploads/' . $settings['favicon']); ?>/site.webmanifest">
    <?php endif; ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css'); ?>">
</head>
<body>
