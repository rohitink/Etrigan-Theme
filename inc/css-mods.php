<?php
/* 
**   Custom Modifcations in CSS depending on user settings.
*/

function etrigan_custom_css_mods() {
	
	$custom_css = "";
	
	//If Menu Description is Disabled.
	if ( !has_nav_menu('primary') || get_theme_mod('etrigan_disable_nav_desc', true) ) :
		$custom_css .= "#site-navigation ul li a { padding: 30px 15px; }";
	endif;
	
	
	//Exception: IMage transform origin should be left on Left Alignment, i.e. Default
	if ( !get_theme_mod('etrigan_center_logo') ) :
		$custom_css .= "#masthead #site-logo img { transform-origin: left; }";
	endif;	
	
	if ( get_theme_mod('etrigan_title_font') ) :
		$custom_css .= ".title-font, h1, h2, .section-title, .woocommerce ul.products li.product h3 { font-family: ".esc_html( get_theme_mod('etrigan_title_font','Droid Serif') )."; }";
	endif;
	
	if ( get_theme_mod('etrigan_body_font') ) :
		$custom_css .= "body, h2.site-description { font-family: ".esc_html( get_theme_mod('etrigan_body_font','Ubuntu') )."; }";
	endif;
	
	if ( get_theme_mod('etrigan_site_titlecolor') ) :
		$custom_css .= "#header-image h1.site-title a { color: ".esc_html( get_theme_mod('etrigan_site_titlecolor', '#FFFFFF') )."; }";
	endif;
	
	
	if ( get_theme_mod('etrigan_header_desccolor','#FFFFFF') ) :
		$custom_css .= ".site-description { color: ".esc_html( get_theme_mod('etrigan_header_desccolor','#FFFFFF') )."; }";
	endif;
	//Check Jetpack is active
	if ( class_exists( 'Jetpack' ) && Jetpack::is_module_active( 'infinite-scroll' ) )
		$custom_css .= '.pagination { display: none; }';


	if ( get_theme_mod('etrigan_custom_css') ) :
		$custom_css .=  strip_tags( get_theme_mod('etrigan_custom_css') );
	endif;
	
	
	if ( get_theme_mod('etrigan_hide_title_tagline') ) :
		$custom_css .= "#header-image .site-branding #text-title-desc { display: none; }";
	endif;
	
	if ( get_theme_mod('etrigan_logo_resize') ) :
		$val = esc_html( get_theme_mod('etrigan_logo_resize') )/100;
		$custom_css .= "#masthead #site-logo img { transform: scale(".$val."); -webkit-transform: scale(".$val."); -moz-transform: scale(".$val."); -ms-transform: scale(".$val."); }";
		endif;

	wp_add_inline_style( 'etrigan-main-theme-style', $custom_css );
	
}

add_action('wp_enqueue_scripts', 'etrigan_custom_css_mods');