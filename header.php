<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package etrigan
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'etrigan' ); ?></a>
	<div id="jumbosearch">
		<span class="fa fa-remove closeicon"></span>
		<div class="form">
			<?php get_search_form(); ?>
		</div>
	</div>	
	
	<div id="header-image">
		
		<img src="<?php header_image(); ?>">
		<div class="site-branding-container">
			<div class="site-branding container">
				<?php if ( get_theme_mod('etrigan_logo') != "" ) : ?>
				<div id="site-logo">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_url( get_theme_mod('etrigan_logo') ); ?>"></a>
				</div>
				<?php endif; ?>
				<div id="text-title-desc">
				<h1 class="site-title title-font"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
				</div>
			</div>
		</div>
		
	</div>
	
	
	
	<header id="masthead" class="site-header" role="banner">
	
	
		<div id="slickmenu"></div>
		<nav id="site-navigation" class="main-navigation" role="navigation">
			<div class="container">
				<?php 
				if (has_nav_menu(  'primary' ) && !get_theme_mod('etrigan_disable_nav_desc', true) ) :
					$walker = new Etrigan_Menu_With_Description; 
				elseif( !has_nav_menu(  'primary' ) ):
					$walker = '';
				else :
					$walker = new Etrigan_Menu_With_Icon;
				endif;
					wp_nav_menu( array( 'theme_location' => 'primary', 'walker' => $walker ) );  ?>
			</div>
		</nav><!-- #site-navigation -->
		
		
		<div class="container masthead-container">
		
			<div class="social-icons">
				<?php get_template_part('social', 'fa'); ?>	 
			</div>
		
			<?php if (class_exists('woocommerce')) : ?>
			<div id="top-cart">
				<div class="top-cart-icon">

	 
					<a class="cart-contents" href="<?php echo WC()->cart->get_cart_url(); ?>" title="<?php _e('View your shopping cart', 'etrigan'); ?>">
						<div class="count"><?php echo sprintf(_n('%d item', '%d items', WC()->cart->cart_contents_count, 'etrigan'), WC()->cart->cart_contents_count);?></div>
						<div class="total"> <?php echo WC()->cart->get_cart_total(); ?>
						</div>
					</a>
					
					<i class="fa fa-shopping-cart"></i>
					</div>
			</div>	
			<?php endif; ?>
			
			<div id="top-search">
				<?php get_template_part('searchform', 'top'); ?>
			</div>
			
		</div>	
		
		
		
	</header><!-- #masthead -->
	
	<div class="mega-container">
		<?php get_template_part('slider', 'swiper'); ?>
		<?php if (class_exists('woocommerce')) : ?>	
		<?php get_template_part('featured', 'products'); ?>
		<?php endif; ?>
		<?php get_template_part('coverflow', 'posts'); ?>
		<?php get_template_part('featured', 'posts'); ?>
	
		<div id="content" class="site-content container">