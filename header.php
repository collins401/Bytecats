<!DOCTYPE>
<html  <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<title><?php wp_title(''); ?><?php if(wp_title('', false)) { echo ' :'; } ?> <?php bloginfo('name'); ?></title>
<link href="<?php echo get_template_directory_uri(); ?>/img/icons/favicon.ico" rel="shortcut icon">
<link href="<?php echo get_template_directory_uri(); ?>/img/icons/touch.png" rel="apple-touch-icon-precomposed">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<meta name="description" content="<?php bloginfo('description'); ?>">
<?php wp_head(); ?>
</head>
<body>

    <header class="header" role="banner">
        <div class="container">
            <!-- logo -->
            <div class="grid-1-4 logo">
                <a href="<?php echo home_url(); ?>">
                    <!-- svg logo - toddmotto.com/mastering-svg-use-for-a-retina-web-fallbacks-with-png-script -->
                    <img src="<?php echo get_template_directory_uri(); ?>/img/logo.png" alt="Logo" class="logo-img">
                </a>
            </div>
            <!-- /logo -->

            <!-- nav -->
            <nav class="grid-3-3 nav" role="navigation">
                <?php wp_nav_menu();?>
            </nav>
            <!-- /nav -->
        </div>
    </header>
    <!-- /header -->
    <!-- wrapper -->
    <div class="container">
        <div class="row">