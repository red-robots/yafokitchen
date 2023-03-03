<?php
/**
 * The header for theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package ACStarter
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<link href="https://fonts.googleapis.com/css?family=Montserrat:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i|Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">
<script defer src="<?php bloginfo( 'template_url' ); ?>/assets/svg-with-js/js/fontawesome-all.js"></script>
<!-- Global site tag (gtag.js) - Google Analytics -->
<!-- <script async src="https://www.googletagmanager.com/gtag/js?id=UA-131407606-2"></script> -->
<!-- <script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-131407606-2');
</script> -->
<?php wp_head(); ?>
<?php if( $customScripts = get_field("header_custom_scripts","option") ) { echo $customScripts; } ?>
</head>

<body <?php body_class(); ?>>

<!-- Gift Card popup -->
<?php 
$active = get_field('turn_on_popup', 'option');
$offer = get_field('offer', 'option');
$btnText = get_field('button_text', 'option');
$btnLink = get_field('button_link', 'option');
// echo '<pre>';
// print_r($active);
// echo '</pre>';

if( $active[0] == 'turnon' && is_front_page() ) { ?>
	<div style="display: none;">
		<div class='ajax popup' >
			<a href="<?php echo $btnLink; ?>" target="_blank">
				<?php echo $offer; ?>
			</a>
		<br>
			<div class="view-btn">
				<a href="<?php echo $btnLink; ?>" target="_blank"><?php echo $btnText; ?></a>
			</div>
		</div>
	</div>
<?php } ?>

	
<div id="page" class="site clear">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'acstarter' ); ?></a>

	<header id="masthead" class="site-header" role="banner">
		<div class="orderBtn">
			<?php if( $order_link = get_field('order_link','option') ) { ?>
			<!-- <a href="<?php echo $order_link ?>"> -->
				<span class="txt">Order &amp; Delivery</span>
				<i class="yafo-chickpea y1"></i>
				<i class="yafo-chickpea y2"></i>
				<i class="yafo-chickpea y3"></i>
				<span class="arrow-right"><i class="fas fa-chevron-right"></i></span>
			<!-- </a> -->
			<?php } ?>
			<?php $order_options = get_field('order_options','option'); ?>
			<?php if ($order_options) { 

				
				?>
			<div class="topmenu">
			<div class="order-options">
				<?php foreach ($order_options as $o) { 
					$o_link = $o['link'];
					$o_logo = $o['logo'];  
					$o_text = $o['text']; ?>
					<?php //if ($o_link && $o_logo) { ?>
						<div class="orderlink">
							<a href="<?php echo $o_link ?>" target="_blank">
								<?php if ($o_logo) { ?>
									<img src="<?php echo $o_logo['url'] ?>" alt="$o_logo['title']">
								<?php } ?>
								<?php if ($o_text) { ?>
								<span class="text"><?php echo $o_text ?></span>	
								<?php } ?>
							</a>
						</div>
					<?php //} ?>	
				<?php } ?>
				<!-- <div class="closediv clear"><a href="#" id="close-order">Close</a></div> -->
			</div>
			</div>
			<?php } ?>
		</div>
		<div class="wrapper">
			<?php 
			// echo '<pre>';
				// print_r($order_options);
				// echo '</pre>'; ?>
			<?php if( get_custom_logo() ) { ?>
	            <div class="logo">
	            	<?php the_custom_logo(); ?>
	            </div>
	        <?php } else { ?>
	            <div class="logo">
		            <a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a>
	            </div>
	        <?php } ?>
			<nav id="site-navigation" class="main-navigation" role="navigation">
				<button id="toggleMenu" class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><span class="sr-only"><?php esc_html_e( 'MENU', 'acstarter' ); ?></span><span class="bar"></span></button>
				<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu', 'container_class'=>'nav-wrapper' ) ); ?>
			</nav><!-- #site-navigation -->
		</div><!-- wrapper -->
	</header><!-- #masthead -->

	<?php get_template_part('template-parts/banner'); ?>

	<div id="content" class="site-content wrapper">
