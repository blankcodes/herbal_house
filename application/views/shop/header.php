<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title><?=$product['name'];?> - Herbal House Philippines</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="<?=$product['name']?>, <?=$product['category']?> /  Herbal House Philippines - Your Partner in Good Health" />
		<meta name="theme-color" content="#0acf67" />

        <!-- Open Graph data -->
        <meta property="fb:app_id" content="" />
        <meta property="og:type" content="article" />
        <meta property="og:title" content="<?=$product['name']?> - Herbal House Philippines" />
        <meta property="og:description" content="<?=$product['name']?>, <?=$product['category']?> - Your Partner in Good Health" />
        <meta property="og:url" content="<?=$product['product_url']?>" />
        <meta property="og:site_name" content="Herbal House PH" />
        <meta property="og:image" content="<?= $product['image_url']; ?>" />
        <meta property="og:image:width" content="800" />
        <meta property="og:image:height" content="800" />
        <meta property="og:image:alt" content="<?=$product['name']?>, <?=$product['category']?> /  Herbal House Philippines - Your Partner in Good Health" />

        <!-- Twitter Card data -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:site" content="@herbalhouse">
        <meta name="twitter:creator" content="@herbalhouse">
        <meta name="twitter:title" content="<?=$product['name'];?> - Herbal House Philippines">
        <meta name="twitter:description" content="<?=$product['name']?>, <?=$product['category']?>. Your Partner in Good Health">
        <meta name="twitter:image" content="<?= $product['image_url']?>">

        <link rel="canonical" href="<?= $product['product_url']; ?>">
        <!-- App favicon -->
        <link rel="shortcut icon" href="<?=base_url()?>assets/images/favicon.png">

        <!-- App css -->
        <link href="<?=base_url()?>assets/css/product.css" rel="stylesheet" type="text/css" />
        <link href="<?=base_url()?>assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="<?=base_url()?>assets/css/app-dark.min.css" rel="stylesheet" type="text/css" id="dark-style" />
        <link href="<?=base_url()?>assets/css/app.min.css" rel="stylesheet" type="text/css" id="light-style" />
        <link href="<?=base_url()?>assets/css/default.css" rel="stylesheet" type="text/css" />
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
                "@id":"<?=base_url('#products')?>",
                "name":"Product"
              }
            },
            {
              "@type":"ListItem",
              "position":4,
              "item":{
                "@id":"<?=$product['product_url'];?>",
                "name":"<?=$product['name'];?>"
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
    <?php  
    $desc = strip_tags($product['description']);
    $desc = substr($desc, 0, 80).'...';
     ?>
    <script type='application/ld+json'>
    {
      "@context": "https://schema.org/",
      "@type": "Product",
      "name": "<?=$product['name']?>",
      "image": "<?= $product['image_url']; ?>",
      "description": "<?=$desc;?>",
      "sku": "<?= $product['sku']; ?>",
      "mpn": "MPN-<?= $product['sku']; ?>",
      "brand": {
        "@type": "Brand",
        "name": "Herbal House"
      },
      "review": {
        "@type": "Review",
        "reviewRating": {
          "@type": "Rating",
          "ratingValue": "5",
          "bestRating": "5"
        },
        "author": {
          "@type": "Person",
          "name": "Grace M."
        }
      },
      "aggregateRating": {
        "@type": "AggregateRating",
        "ratingValue": "5",
        "reviewCount": "3"
      },
      "offers": {
        "@type": "Offer",
        "url": "<?=$product['product_url']?>",
        "priceCurrency": "PHP",
        "price": "<?=$product['price']?>",
        "priceValidUntil": "2021-12-31",
        "itemCondition": "https://schema.org/UsedCondition",
        "availability": "https://schema.org/InStock",
        "seller": {
          "@type": "Organization",
          "name": "Herbal House Philippines"
        }
      }
    }
</script>