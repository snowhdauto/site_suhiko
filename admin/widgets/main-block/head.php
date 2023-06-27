<meta charset="UTF-8">
<title><?php if($title != '') { echo $title.' | '; } ?><?php echo $SITENAME; ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<meta name="description" content="<?php echo $description; ?>"/>
<meta name="keywords" content="<?php echo $keywords; ?>"/>

<link rel="apple-touch-icon" sizes="180x180" href="/assets/img/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="/assets/img/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/assets/img/favicon-16x16.png">
<link rel="manifest" href="/assets/img/site.webmanifest">
<link rel="mask-icon" href="/assets/img/safari-pinned-tab.svg" color="#f36638">
<link rel="shortcut icon" href="/assets/img/favicon.ico">
<meta name="apple-mobile-web-app-title" content="SushiKO">
<meta name="application-name" content="SushiKO">
<meta name="msapplication-TileColor" content="#da532c">
<meta name="msapplication-config" content="/assets/img/browserconfig.xml">
<meta name="theme-color" content="#f36638">

<link rel="stylesheet" href="/assets/fonts/stylesheet.css">
<link rel="stylesheet" href="/assets/libs/fontawesome/css/fontawesome.min.css">
<link rel="stylesheet" href="/admin/assets/libs/medium-editor/css/medium-editor.css">
<link rel="stylesheet" href="/admin/assets/libs/medium-editor/css/themes/default.css">
<link rel="stylesheet" href="/admin/assets/libs/dolphron-elements/css/dolphron-elements.css">
<link rel="stylesheet" href="/admin/assets/css/main.css">

<?php
$scheme = isset($_SERVER['HTTP_SCHEME']) ? $_SERVER['HTTP_SCHEME'] : ( 
	( (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || 443 == $_SERVER['SERVER_PORT'] ) ? 'https://' : 'http://'
);
$siteurl = $scheme . $_SERVER["SERVER_NAME"];
?>

<!-- START - Open Graph and Twitter Card Tags 2.3.3 -->
<!-- Facebook Open Graph -->
<meta property="og:locale" content="<?php echo $LOCALE; ?>"/>
<meta property="og:site_name" content="<?php echo $SITENAME; ?>"/>
<meta property="og:title" content="<?php echo $title; ?>"/>
<meta property="og:url" content="<?php echo $siteurl . $curent_url; ?>"/>
<meta property="og:type" content="<?php echo $page_type; ?>"/> <!-- website / article -->
<meta property="og:description" content="<?php echo $description; ?>"/>
<meta property="og:image" content="<?php echo $image; ?>"/>
<meta property="og:image:url" content="<?php echo $image; ?>"/>
<meta property="og:image:secure_url" content="<?php echo $image; ?>"/>
<meta property="article:published_time" content="<?php echo $published; ?>"/><!-- format 2020-05-29T10:45:44+03:00 -->
<meta property="article:modified_time" content="<?php echo $published; ?>" /><!-- format 2020-05-29T10:45:44+03:00 -->
<meta property="og:updated_time" content="<?php echo $published; ?>" /><!-- format 2020-05-29T10:45:44+03:00 -->
<!-- Google+ / Schema.org -->
<meta itemprop="name" content="<?php echo $title; ?>"/>
<meta itemprop="headline" content="<?php echo $title; ?>"/>
<meta itemprop="description" content="<?php echo $description; ?>"/>
<meta itemprop="image" content="<?php echo $image; ?>"/>
<meta itemprop="datePublished" content="<?php echo $published; ?>"/><!-- format 2020-05-29 -->
<meta itemprop="dateModified" content="<?php echo $published; ?>" /><!-- format 2020-05-29T10:45:44+03:00 -->
<meta itemprop="author" content="hello@dolphron.com"/>
<!--<meta itemprop="publisher" content="<?php echo $SITENAME; ?>"/>--> <!-- To solve: The attribute publisher.itemtype has an invalid value -->
<!-- Twitter Cards -->
<meta name="twitter:title" content="<?php echo $title; ?>"/>
<meta name="twitter:url" content="<?php echo $siteurl . $curent_url; ?>"/>
<meta name="twitter:description" content="<?php echo $description; ?>"/>
<meta name="twitter:image" content="<?php echo $image; ?>"/>
<meta name="twitter:card" content="summary_large_image"/>