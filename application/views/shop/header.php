<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title><?=$product['name'];?> / Herbal House</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="<?=$product['name']?>, <?=$product['category']?> /  Herbal House - Business Helping Program" />
		<meta name="theme-color" content="#0acf67" />

        <!-- Open Graph data -->
        <meta property="fb:app_id" content="" />
        <meta property="og:type" content="article" />
        <meta property="og:title" content="<?=$product['name']?> / Herbal House" />
        <meta property="og:description" content="<?=$product['name']?>, <?=$product['category']?> /  Herbal House - Business Helping Program" />
        <meta property="og:url" content="<?=$product['product_url']?>" />
        <meta property="og:site_name" content="Herbal House" />
        <meta property="og:image" content="<?= $product['image_url']; ?>" />
        <meta property="og:image:width" content="800" />
        <meta property="og:image:height" content="800" />
        <meta property="og:image:alt" content="<?=$product['name']?>, <?=$product['category']?> /  Herbal House - Business Helping Program" />

        <!-- Twitter Card data -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:site" content="@herbalhouse>">
        <meta name="twitter:creator" content="@herbalhouse">
        <meta name="twitter:title" content="<?=$product['name'];?> / Herbal House>">
        <meta name="twitter:description" content="<?=$product['name']?>, <?=$product['category']?> /  Herbal House - Business Helping Program">
        <meta name="twitter:image" content="<?= $product['image_url']?>">


        <!-- App favicon -->
        <link rel="shortcut icon" href="<?=base_url()?>assets/images/favicon.png">

        <!-- App css -->
        <link href="<?=base_url()?>assets/css/product.css" rel="stylesheet" type="text/css" />
        <link href="<?=base_url()?>assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="<?=base_url()?>assets/css/app-dark.min.css" rel="stylesheet" type="text/css" id="dark-style" />
        <link href="<?=base_url()?>assets/css/app.min.css" rel="stylesheet" type="text/css" id="light-style" />
        <link href="<?=base_url()?>assets/css/default.css" rel="stylesheet" type="text/css" />

    </head>
    <body class="loading" >