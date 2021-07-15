<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title><?=$category['name'];?> - Herbal House Philippines</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="<?=$category['name']?> /  Herbal House Philippines - Your Partner in Good Health" />
		<meta name="theme-color" content="#0acf67" />

        <!-- Open Graph data -->
        <meta property="fb:app_id" content="" />
        <meta property="og:type" content="article" />
        <meta property="og:title" content="<?=$category['name']?> - Herbal House Philippines" />
        <meta property="og:description" content="<?=$category['name']?> - Your Partner in Good Health" />
        <meta property="og:url" content="<?=base_url('product/category/'.$category['category_url'])?>" />
        <meta property="og:site_name" content="Herbal House Philippines" />
        <meta property="og:image" content="<?= $category['image']; ?>" />
        <meta property="og:image:width" content="800" />
        <meta property="og:image:height" content="800" />
        <meta property="og:image:alt" content="<?=$category['name']?> /  Herbal House Philippines - Your Partner in Good Health" />

        <!-- Twitter Card data -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:site" content="@herbalhouse">
        <meta name="twitter:creator" content="@herbalhouse">
        <meta name="twitter:title" content="<?=$category['name'];?> - Herbal House Philippines">
        <meta name="twitter:description" content="<?=$category['name']?>, Your Partner in Good Health">
        <meta name="twitter:image" content="<?= $category['image']?>">

        <link rel="canonical" href="<?=base_url('product/category/'.$category['category_url'])?>">
        <!-- App favicon -->
        <link rel="shortcut icon" href="<?=base_url()?>assets/images/favicon.png">

        <!-- App css -->
        <link href="<?=base_url();?>assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="<?=base_url();?>assets/css/app.min.css" rel="stylesheet" type="text/css" id="light-style" />
        <link href="<?=base_url();?>assets/css/app-dark.min.css" rel="stylesheet" type="text/css" id="dark-style" />  
        <link href="<?=base_url();?>assets/css/default.css" rel="stylesheet" type="text/css" />
        <link href="<?=base_url();?>assets/css/product.css" rel="stylesheet" type="text/css" />
        <?= $analyticSrc; ?>
        
        <?= $analyticData; ?>
    </head>
    <body class="loading" >

    <script type="application/ld+json">
    {
        "@context":"https://schema.org",
        "@type":"BreadcrumbList",
        "itemListElement":[{
          "@type":"ListItem",
          "position":1,
          "item":
            {
              "@id":"<?=base_url()?>",
              "name":"Herbal House Philippines"
            }
          },
            {
              "@type":"ListItem",
              "position":2,
              "item":{
                "@id":"<?=base_url('#shop_now')?>",
                "name":"Shop"
              }
            },
            {
              "@type":"ListItem",
              "position":3,
              "item":{
                "@id":"<?=base_url('#category')?>",
                "name":"Category"
              }
            },
            {
              "@type":"ListItem",
              "position":4,
              "item":{
                "@id":"<?=base_url('product/category/').$category['category_url']?>",
                "name":"<?=$category['name'];?>"
              }
            }
          ]
        }
    </script>
    <script type="application/ld+json">
    {
        "@context":"https:\/\/schema.org",
        "@type":"Organization",
        "name":"Herbal House Philippines",
        "url":"https:\/\/herbalhouseph.com\/",
        "sameAs":["https:\/\/www.facebook.com\/herbalhouseofficial"],
        "@id":"#organization",
        "logo":"<?=base_url()?>assets/images/favicon.png"
    }
    </script>
