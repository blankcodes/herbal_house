<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title><?=$title?> / Herbal House</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="" name="description" />
        <meta name="theme-color" content="#0acf67" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="<?=base_url()?>assets/images/favicon.png">

        <!-- App css -->
        <link href="<?=base_url()?>assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="<?=base_url()?>assets/css/app-dark.min.css" rel="stylesheet" type="text/css" id="dark-style" />
        <link href="<?=base_url()?>assets/css/app.min.css" rel="stylesheet" type="text/css" id="light-style" />
        <script src="<?=base_url()?>assets/js/sweetalert2.all.min.js"></script>
        <link href="<?=base_url()?>assets/css/default.css" rel="stylesheet" type="text/css" />
        <?php if ($page == 'member_binary_list' || $page == 'member_binary_list_uc' || $page == 'member_binary_list_direct'){ echo'<link href="'.base_url().'assets/css/binary.css" rel="stylesheet" type="text/css" />'; }?>
        <?php if ($page == 'member_products'){ ?>
        <link href="<?=base_url()?>assets/css/product.css" rel="stylesheet" type="text/css" />
        <?php } ?>
    </head>

    <body class="loading" data-layout-config='{"leftSideBarTheme":"dark","layoutBoxed":false, "leftSidebarCondensed":false, "leftSidebarScrollable":false,"darkMode":false}'>
        <!-- Begin page -->