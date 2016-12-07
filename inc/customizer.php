<?php
/**
 * etrigan Theme Customizer
 *
 * @package etrigan
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function etrigan_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';		
	
	//Logo Settings
	$wp_customize->add_section( 'title_tagline' , array(
	    'title'      => __( 'Title, Tagline & Logo', 'etrigan' ),
	    'priority'   => 30,
	) );
	
	$wp_customize->add_setting( 'etrigan_logo' , array(
	    'default'     => '',
	    'sanitize_callback' => 'esc_url_raw',
	) );
	
	$wp_customize->add_control(
	    new WP_Customize_Image_Control(
	        $wp_customize,
	        'etrigan_logo',
	        array(
	            'label' => __('Upload Logo','etrigan'),
	            'section' => 'title_tagline',
	            'settings' => 'etrigan_logo',
	            'priority' => 5,
	        )
		)
	);
	
	$wp_customize->add_setting( 'etrigan_logo_resize' , array(
	    'default'     => 100,
	    'sanitize_callback' => 'etrigan_sanitize_positive_number',
	) );
	$wp_customize->add_control(
	        'etrigan_logo_resize',
	        array(
	            'label' => __('Resize & Adjust Logo','etrigan'),
	            'section' => 'title_tagline',
	            'settings' => 'etrigan_logo_resize',
	            'priority' => 6,
	            'type' => 'range',
	            'active_callback' => 'etrigan_logo_enabled',
	            'input_attrs' => array(
			        'min'   => 30,
			        'max'   => 200,
			        'step'  => 5,
			    ),
	        )
	);
	
	function etrigan_logo_enabled($control) {
		$option = $control->manager->get_setting('etrigan_logo');
		return $option->value() == true;
	}
	
	
	
	//Replace Header Text Color with, separate colors for Title and Description
	//Override etrigan_site_titlecolor
	$wp_customize->remove_control('display_header_text');
	$wp_customize->remove_setting('header_textcolor');
	$wp_customize->add_setting('etrigan_site_titlecolor', array(
	    'default'     => '#FFFFFF',
	    'sanitize_callback' => 'sanitize_hex_color',
	));
	
	$wp_customize->add_control(new WP_Customize_Color_Control( 
		$wp_customize, 
		'etrigan_site_titlecolor', array(
			'label' => __('Site Title Color','etrigan'),
			'section' => 'colors',
			'settings' => 'etrigan_site_titlecolor',
			'type' => 'color'
		) ) 
	);
	
	$wp_customize->add_setting('etrigan_header_desccolor', array(
	    'default'     => '#FFFFFF',
	    'sanitize_callback' => 'sanitize_hex_color',
	));
	
	$wp_customize->add_control(new WP_Customize_Color_Control( 
		$wp_customize, 
		'etrigan_header_desccolor', array(
			'label' => __('Site Tagline Color','etrigan'),
			'section' => 'colors',
			'settings' => 'etrigan_header_desccolor',
			'type' => 'color'
		) ) 
	);
	
	//Settings for Nav Area
	$wp_customize->add_section(
	    'etrigan_menu_basic',
	    array(
	        'title'     => __('Basic Settings','etrigan'),
	        'priority'  => 0,
	        'panel'     => 'nav_menus'
	    )
	);
	
	$wp_customize->add_setting( 'etrigan_disable_nav_desc' , array(
	    'default'     => true,
	    'sanitize_callback' => 'etrigan_sanitize_checkbox',
	) );
	
	$wp_customize->add_control(
	'etrigan_disable_nav_desc', array(
		'label' => __('Disable Description of Menu Items','etrigan'),
		'section' => 'etrigan_menu_basic',
		'settings' => 'etrigan_disable_nav_desc',
		'type' => 'checkbox'
	) );
	
	
	//Settings For Logo Area
	
	$wp_customize->add_setting(
		'etrigan_hide_title_tagline',
		array( 'sanitize_callback' => 'etrigan_sanitize_checkbox' )
	);
	
	$wp_customize->add_control(
			'etrigan_hide_title_tagline', array(
		    'settings' => 'etrigan_hide_title_tagline',
		    'label'    => __( 'Hide Title and Tagline.', 'etrigan' ),
		    'section'  => 'title_tagline',
		    'type'     => 'checkbox',
		)
	);
		
	function etrigan_title_visible( $control ) {
		$option = $control->manager->get_setting('etrigan_hide_title_tagline');
	    return $option->value() == false ;
	}
	
	//SLIDER
	// SLIDER PANEL
	$wp_customize->add_panel( 'etrigan_slider_panel', array(
	    'priority'       => 35,
	    'capability'     => 'edit_theme_options',
	    'theme_supports' => '',
	    'title'          => __('Main Slider','etrigan'),
	) );
	
	$wp_customize->add_section(
	    'etrigan_sec_slider_options',
	    array(
	        'title'     => __('Enable/Disable','etrigan'),
	        'priority'  => 0,
	        'panel'     => 'etrigan_slider_panel'
	    )
	);
	
	
	$wp_customize->add_setting(
		'etrigan_main_slider_enable',
		array( 'sanitize_callback' => 'etrigan_sanitize_checkbox' )
	);
	
	$wp_customize->add_control(
			'etrigan_main_slider_enable', array(
		    'settings' => 'etrigan_main_slider_enable',
		    'label'    => __( 'Enable Slider on HomePage.', 'etrigan' ),
		    'section'  => 'etrigan_sec_slider_options',
		    'type'     => 'checkbox',
		)
	);
	
	
	$wp_customize->add_setting(
		'etrigan_main_slider_count',
			array(
				'default' => '0',
				'sanitize_callback' => 'etrigan_sanitize_positive_number'
			)
	);
	
	// Select How Many Slides the User wants, and Reload the Page.
	$wp_customize->add_control(
			'etrigan_main_slider_count', array(
		    'settings' => 'etrigan_main_slider_count',
		    'label'    => __( 'No. of Slides(Min:0, Max: 3)' ,'etrigan'),
		    'section'  => 'etrigan_sec_slider_options',
		    'type'     => 'number',
		    'description' => __('Save the Settings, and Reload this page to Configure the Slides.','etrigan'),
		    
		)
	);
	
	for ( $i = 1 ; $i <= 3 ; $i++ ) :
		
		//Create the settings Once, and Loop through it.
		static $x = 0;
		$wp_customize->add_section(
		    'etrigan_slide_sec'.$i,
		    array(
		        'title'     => 'Slide '.$i,
		        'priority'  => $i,
		        'panel'     => 'etrigan_slider_panel',
		        
		    )
		);	
		
		$wp_customize->add_setting(
			'etrigan_slide_img'.$i,
			array( 'sanitize_callback' => 'esc_url_raw' )
		);
		
		$wp_customize->add_control(
		    new WP_Customize_Image_Control(
		        $wp_customize,
		        'etrigan_slide_img'.$i,
		        array(
		            'label' => '',
		            'section' => 'etrigan_slide_sec'.$i,
		            'settings' => 'etrigan_slide_img'.$i,			       
		        )
			)
		);
		
		$wp_customize->add_setting(
			'etrigan_slide_title'.$i,
			array( 'sanitize_callback' => 'sanitize_text_field' )
		);
		
		$wp_customize->add_control(
				'etrigan_slide_title'.$i, array(
			    'settings' => 'etrigan_slide_title'.$i,
			    'label'    => __( 'Slide Title','etrigan' ),
			    'section'  => 'etrigan_slide_sec'.$i,
			    'type'     => 'text',
			)
		);
		
		$wp_customize->add_setting(
			'etrigan_slide_desc'.$i,
			array( 'sanitize_callback' => 'sanitize_text_field' )
		);
		
		$wp_customize->add_control(
				'etrigan_slide_desc'.$i, array(
			    'settings' => 'etrigan_slide_desc'.$i,
			    'label'    => __( 'Slide Description','etrigan' ),
			    'section'  => 'etrigan_slide_sec'.$i,
			    'type'     => 'text',
			)
		);
		
		
		
		$wp_customize->add_setting(
			'etrigan_slide_CTA_button'.$i,
			array( 'sanitize_callback' => 'sanitize_text_field' )
		);
		
		$wp_customize->add_control(
				'etrigan_slide_CTA_button'.$i, array(
			    'settings' => 'etrigan_slide_CTA_button'.$i,
			    'label'    => __( 'Custom Call to Action Button Text(Optional)','etrigan' ),
			    'section'  => 'etrigan_slide_sec'.$i,
			    'type'     => 'text',
			)
		);
		
		$wp_customize->add_setting(
			'etrigan_slide_url'.$i,
			array( 'sanitize_callback' => 'esc_url_raw' )
		);
		
		$wp_customize->add_control(
				'etrigan_slide_url'.$i, array(
			    'settings' => 'etrigan_slide_url'.$i,
			    'label'    => __( 'Target URL','etrigan' ),
			    'section'  => 'etrigan_slide_sec'.$i,
			    'type'     => 'url',
			)
		);
		
	endfor;
	
	if ( class_exists('woocommerce') ) :
	// CREATE THE fcp PANEL
	$wp_customize->add_panel( 'etrigan_fcp_panel', array(
	    'priority'       => 40,
	    'capability'     => 'edit_theme_options',
	    'theme_supports' => '',
	    'title'          => 'Featured Product Showcase',
	    'description'    => '',
	) );
	
	
	//SQUARE BOXES
	$wp_customize->add_section(
	    'etrigan_fc_boxes',
	    array(
	        'title'     => __('Square Boxes','etrigan'),
	        'priority'  => 10,
	        'panel'     => 'etrigan_fcp_panel'
	    )
	);
	
	$wp_customize->add_setting(
		'etrigan_box_enable',
		array( 'sanitize_callback' => 'etrigan_sanitize_checkbox' )
	);
	
	$wp_customize->add_control(
			'etrigan_box_enable', array(
		    'settings' => 'etrigan_box_enable',
		    'label'    => __( 'Enable Square Boxes & Posts Slider.', 'etrigan' ),
		    'section'  => 'etrigan_fc_boxes',
		    'type'     => 'checkbox',
		)
	);
	
 
	$wp_customize->add_setting(
		'etrigan_box_title',
		array( 'sanitize_callback' => 'sanitize_text_field' )
	);
	
	$wp_customize->add_control(
			'etrigan_box_title', array(
		    'settings' => 'etrigan_box_title',
		    'label'    => __( 'Title for the Boxes','etrigan' ),
		    'section'  => 'etrigan_fc_boxes',
		    'type'     => 'text',
		)
	);
 
 	$wp_customize->add_setting(
	    'etrigan_box_cat',
	    array( 'sanitize_callback' => 'etrigan_sanitize_product_category' )
	);
	
	$wp_customize->add_control(
	    new Etrigan_WP_Customize_Product_Category_Control(
	        $wp_customize,
	        'etrigan_box_cat',
	        array(
	            'label'    => __('Product Category.','etrigan'),
	            'settings' => 'etrigan_box_cat',
	            'section'  => 'etrigan_fc_boxes'
	        )
	    )
	);
	
		
	//SLIDER
	$wp_customize->add_section(
	    'etrigan_fc_slider',
	    array(
	        'title'     => __('3D Cube Products Slider','etrigan'),
	        'priority'  => 10,
	        'panel'     => 'etrigan_fcp_panel',
	        'description' => 'This is the Posts Slider, displayed left to the square boxes.',
	    )
	);
	
	
	$wp_customize->add_setting(
		'etrigan_slider_title',
		array( 'sanitize_callback' => 'sanitize_text_field' )
	);
	
	$wp_customize->add_control(
			'etrigan_slider_title', array(
		    'settings' => 'etrigan_slider_title',
		    'label'    => __( 'Title for the Slider', 'etrigan' ),
		    'section'  => 'etrigan_fc_slider',
		    'type'     => 'text',
		)
	);
	
	$wp_customize->add_setting(
		'etrigan_slider_count',
		array( 'sanitize_callback' => 'etrigan_sanitize_positive_number' )
	);
	
	$wp_customize->add_control(
			'etrigan_slider_count', array(
		    'settings' => 'etrigan_slider_count',
		    'label'    => __( 'No. of Posts(Min:3, Max: 10)', 'etrigan' ),
		    'section'  => 'etrigan_fc_slider',
		    'type'     => 'range',
		    'input_attrs' => array(
		        'min'   => 3,
		        'max'   => 10,
		        'step'  => 1,
		        'class' => 'test-class test',
		        'style' => 'color: #0a0',
		    ),
		)
	);
		
	$wp_customize->add_setting(
		    'etrigan_slider_cat',
		    array( 'sanitize_callback' => 'etrigan_sanitize_product_category' )
		);
		
	$wp_customize->add_control(
	    new Etrigan_WP_Customize_Product_Category_Control(
	        $wp_customize,
	        'etrigan_slider_cat',
	        array(
	            'label'    => __('Category For Slider.','etrigan'),
	            'settings' => 'etrigan_slider_cat',
	            'section'  => 'etrigan_fc_slider'
	        )
	    )
	);
	
	
	endif; //end class exists woocommerce
	
	
	//Extra Panel for Users, who dont have WooCommerce
	
	// CREATE THE fcp PANEL
	$wp_customize->add_panel( 'etrigan_a_fcp_panel', array(
	    'priority'       => 40,
	    'capability'     => 'edit_theme_options',
	    'theme_supports' => '',
	    'title'          => 'Featured Posts Showcase',
	    'description'    => '',
	) );
	
	
	//SQUARE BOXES
	$wp_customize->add_section(
	    'etrigan_a_fc_boxes',
	    array(
	        'title'     => 'Square Boxes',
	        'priority'  => 10,
	        'panel'     => 'etrigan_a_fcp_panel'
	    )
	);
	
	$wp_customize->add_setting(
		'etrigan_a_box_enable',
		array( 'sanitize_callback' => 'etrigan_sanitize_checkbox' )
	);
	
	$wp_customize->add_control(
			'etrigan_a_box_enable', array(
		    'settings' => 'etrigan_a_box_enable',
		    'label'    => __( 'Enable Square Boxes & Posts Slider.', 'etrigan' ),
		    'section'  => 'etrigan_a_fc_boxes',
		    'type'     => 'checkbox',
		)
	);
	
 
	$wp_customize->add_setting(
		'etrigan_a_box_title',
		array( 'sanitize_callback' => 'sanitize_text_field' )
	);
	
	$wp_customize->add_control(
			'etrigan_a_box_title', array(
		    'settings' => 'etrigan_a_box_title',
		    'label'    => __( 'Title for the Boxes','etrigan' ),
		    'section'  => 'etrigan_a_fc_boxes',
		    'type'     => 'text',
		)
	);
 
 	$wp_customize->add_setting(
	    'etrigan_a_box_cat',
	    array( 'sanitize_callback' => 'etrigan_sanitize_product_category' )
	);
	
	$wp_customize->add_control(
	    new Etrigan_WP_Customize_Category_Control(
	        $wp_customize,
	        'etrigan_a_box_cat',
	        array(
	            'label'    => __('Posts Category.','etrigan'),
	            'settings' => 'etrigan_a_box_cat',
	            'section'  => 'etrigan_a_fc_boxes'
	        )
	    )
	);
	
		
	//SLIDER
	$wp_customize->add_section(
	    'etrigan_a_fc_slider',
	    array(
	        'title'     => __('3D Cube Products Slider','etrigan'),
	        'priority'  => 10,
	        'panel'     => 'etrigan_a_fcp_panel',
	        'description' => 'This is the Posts Slider, displayed left to the square boxes.',
	    )
	);
	
	
	$wp_customize->add_setting(
		'etrigan_a_slider_title',
		array( 'sanitize_callback' => 'sanitize_text_field' )
	);
	
	$wp_customize->add_control(
			'etrigan_a_slider_title', array(
		    'settings' => 'etrigan_a_slider_title',
		    'label'    => __( 'Title for the Slider', 'etrigan' ),
		    'section'  => 'etrigan_a_fc_slider',
		    'type'     => 'text',
		)
	);
	
	$wp_customize->add_setting(
		'etrigan_a_slider_count',
		array( 'sanitize_callback' => 'etrigan_sanitize_positive_number' )
	);
	
	$wp_customize->add_control(
			'etrigan_a_slider_count', array(
		    'settings' => 'etrigan_a_slider_count',
		    'label'    => __( 'No. of Posts(Min:3, Max: 10)', 'etrigan' ),
		    'section'  => 'etrigan_a_fc_slider',
		    'type'     => 'range',
		    'input_attrs' => array(
		        'min'   => 3,
		        'max'   => 10,
		        'step'  => 1,
		        'class' => 'test-class test',
		        'style' => 'color: #0a0',
		    ),
		)
	);
		
	$wp_customize->add_setting(
		    'etrigan_a_slider_cat',
		    array( 'sanitize_callback' => 'etrigan_sanitize_product_category' )
		);
		
	$wp_customize->add_control(
	    new Etrigan_WP_Customize_Category_Control(
	        $wp_customize,
	        'etrigan_a_slider_cat',
	        array(
	            'label'    => __('Category For Slider.','etrigan'),
	            'settings' => 'etrigan_a_slider_cat',
	            'section'  => 'etrigan_a_fc_slider'
	        )
	    )
	);
	
	
	
	//COVERFLOW
	
	$wp_customize->add_section(
	    'etrigan_a_fc_coverflow',
	    array(
	        'title'     => __('Top CoverFlow Slider','etrigan'),
	        'priority'  => 5,
	        'panel'     => 'etrigan_a_fcp_panel'
	    )
	);
	
	$wp_customize->add_setting(
		'etrigan_a_coverflow_title',
		array( 'sanitize_callback' => 'sanitize_text_field' )
	);
	
	$wp_customize->add_control(
			'etrigan_a_coverflow_title', array(
		    'settings' => 'etrigan_a_coverflow_title',
		    'label'    => __( 'Title for the Coverflow', 'etrigan' ),
		    'section'  => 'etrigan_a_fc_coverflow',
		    'type'     => 'text',
		)
	);
	
	$wp_customize->add_setting(
		'etrigan_a_coverflow_enable',
		array( 'sanitize_callback' => 'etrigan_sanitize_checkbox' )
	);
	
	$wp_customize->add_control(
			'etrigan_a_coverflow_enable', array(
		    'settings' => 'etrigan_a_coverflow_enable',
		    'label'    => __( 'Enable', 'etrigan' ),
		    'section'  => 'etrigan_a_fc_coverflow',
		    'type'     => 'checkbox',
		)
	);
	
	$wp_customize->add_setting(
		    'etrigan_a_coverflow_cat',
		    array( 'sanitize_callback' => 'etrigan_sanitize_category' )
		);
	
		
	$wp_customize->add_control(
	    new Etrigan_WP_Customize_Category_Control(
	        $wp_customize,
	        'etrigan_a_coverflow_cat',
	        array(
	            'label'    => __('Category For Image Grid','etrigan'),
	            'settings' => 'etrigan_a_coverflow_cat',
	            'section'  => 'etrigan_a_fc_coverflow'
	        )
	    )
	);
	
	$wp_customize->add_setting(
		'etrigan_a_coverflow_pc',
		array( 'sanitize_callback' => 'etrigan_sanitize_positive_number' )
	);
	
	$wp_customize->add_control(
			'etrigan_a_coverflow_pc', array(
		    'settings' => 'etrigan_a_coverflow_pc',
		    'label'    => __( 'Max No. of Posts in the Grid. Min: 5.', 'etrigan' ),
		    'section'  => 'etrigan_a_fc_coverflow',
		    'type'     => 'number',
		    'default'  => '0'
		)
	);
	
	
	// Layout and Design
	$wp_customize->add_panel( 'etrigan_design_panel', array(
	    'priority'       => 40,
	    'capability'     => 'edit_theme_options',
	    'theme_supports' => '',
	    'title'          => __('Design & Layout','etrigan'),
	) );
	
	$wp_customize->add_section(
	    'etrigan_design_options',
	    array(
	        'title'     => __('Blog Layout','etrigan'),
	        'priority'  => 0,
	        'panel'     => 'etrigan_design_panel'
	    )
	);
	
	
	$wp_customize->add_setting(
		'etrigan_blog_layout',
		array( 'sanitize_callback' => 'etrigan_sanitize_blog_layout' )
	);
	
	function etrigan_sanitize_blog_layout( $input ) {
		if ( in_array($input, array('grid','grid_2_column','etrigan','etrigan_3_column') ) )
			return $input;
		else 
			return '';	
	}
	
	$wp_customize->add_control(
		'etrigan_blog_layout',array(
				'label' => __('Select Layout','etrigan'),
				'settings' => 'etrigan_blog_layout',
				'section'  => 'etrigan_design_options',
				'type' => 'select',
				'choices' => array(
						'grid' => __('Standard Blog Layout','etrigan'),
						'etrigan' => __('Etrigan Theme Layout','etrigan'),
						'etrigan_3_column' => __('Etrigan Theme Layout (3 Columns)','etrigan'),
						'grid_2_column' => __('Grid - 2 Column','etrigan'),
					)
			)
	);
	
	$wp_customize->add_section(
	    'etrigan_sidebar_options',
	    array(
	        'title'     => __('Sidebar Layout','etrigan'),
	        'priority'  => 0,
	        'panel'     => 'etrigan_design_panel'
	    )
	);
	
	$wp_customize->add_setting(
		'etrigan_disable_sidebar',
		array( 'sanitize_callback' => 'etrigan_sanitize_checkbox' )
	);
	
	$wp_customize->add_control(
			'etrigan_disable_sidebar', array(
		    'settings' => 'etrigan_disable_sidebar',
		    'label'    => __( 'Disable Sidebar Everywhere.','etrigan' ),
		    'section'  => 'etrigan_sidebar_options',
		    'type'     => 'checkbox',
		    'default'  => false
		)
	);
	
	$wp_customize->add_setting(
		'etrigan_disable_sidebar_home',
		array( 'sanitize_callback' => 'etrigan_sanitize_checkbox' )
	);
	
	$wp_customize->add_control(
			'etrigan_disable_sidebar_home', array(
		    'settings' => 'etrigan_disable_sidebar_home',
		    'label'    => __( 'Disable Sidebar on Home/Blog.','etrigan' ),
		    'section'  => 'etrigan_sidebar_options',
		    'type'     => 'checkbox',
		    'active_callback' => 'etrigan_show_sidebar_options',
		    'default'  => false
		)
	);
	
	$wp_customize->add_setting(
		'etrigan_disable_sidebar_front',
		array( 'sanitize_callback' => 'etrigan_sanitize_checkbox' )
	);
	
	$wp_customize->add_control(
			'etrigan_disable_sidebar_front', array(
		    'settings' => 'etrigan_disable_sidebar_front',
		    'label'    => __( 'Disable Sidebar on Front Page.','etrigan' ),
		    'section'  => 'etrigan_sidebar_options',
		    'type'     => 'checkbox',
		    'active_callback' => 'etrigan_show_sidebar_options',
		    'default'  => false
		)
	);
	
	
	$wp_customize->add_setting(
		'etrigan_sidebar_width',
		array(
			'default' => 4,
		    'sanitize_callback' => 'etrigan_sanitize_positive_number' )
	);
	
	$wp_customize->add_control(
			'etrigan_sidebar_width', array(
		    'settings' => 'etrigan_sidebar_width',
		    'label'    => __( 'Sidebar Width','etrigan' ),
		    'description' => __('Min: 25%, Default: 33%, Max: 40%','etrigan'),
		    'section'  => 'etrigan_sidebar_options',
		    'type'     => 'range',
		    'active_callback' => 'etrigan_show_sidebar_options',
		    'input_attrs' => array(
		        'min'   => 3,
		        'max'   => 5,
		        'step'  => 1,
		        'class' => 'sidebar-width-range',
		        'style' => 'color: #0a0',
		    ),
		)
	);
	
	/* Active Callback Function */
	function etrigan_show_sidebar_options($control) {
	   
	    $option = $control->manager->get_setting('etrigan_disable_sidebar');
	    return $option->value() == false ;
	    
	}
	
	class Etrigan_Custom_CSS_Control extends WP_Customize_Control {
	    public $type = 'textarea';
	 
	    public function render_content() {
	        ?>
	            <label>
	                <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
	                <textarea rows="8" style="width:100%;" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
	            </label>
	        <?php
	    }
	}
	
	$wp_customize-> add_section(
    'etrigan_custom_codes',
    array(
    	'title'			=> __('Custom CSS','etrigan'),
    	'description'	=> __('Enter your Custom CSS to Modify design.','etrigan'),
    	'priority'		=> 11,
    	'panel'			=> 'etrigan_design_panel'
    	)
    );
    
	$wp_customize->add_setting(
	'etrigan_custom_css',
	array(
		'default'		=> '',
		'capability'           => 'edit_theme_options',
		'sanitize_callback'    => 'wp_filter_nohtml_kses',
		'sanitize_js_callback' => 'wp_filter_nohtml_kses'
		)
	);
	
	$wp_customize->add_control(
	    new Etrigan_Custom_CSS_Control(
	        $wp_customize,
	        'etrigan_custom_css',
	        array(
	            'section' => 'etrigan_custom_codes',
	            'settings' => 'etrigan_custom_css'
	        )
	    )
	);
	
	function etrigan_sanitize_text( $input ) {
	    return wp_kses_post( force_balance_tags( $input ) );
	}
	
	$wp_customize-> add_section(
    'etrigan_custom_footer',
    array(
    	'title'			=> __('Custom Footer Text','etrigan'),
    	'description'	=> __('Enter your Own Copyright Text.','etrigan'),
    	'priority'		=> 11,
    	'panel'			=> 'etrigan_design_panel'
    	)
    );
    
	$wp_customize->add_setting(
	'etrigan_footer_text',
	array(
		'default'		=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
		)
	);
	
	$wp_customize->add_control(	 
	       'etrigan_footer_text',
	        array(
	            'section' => 'etrigan_custom_footer',
	            'settings' => 'etrigan_footer_text',
	            'type' => 'text'
	        )
	);	
	
	
	//Select the Default Theme Skin
	$wp_customize->add_section(
	    'etrigan_skin_options',
	    array(
	        'title'     => __('Choose Skin','etrigan'),
	        'priority'  => 39,
	    )
	);
	
	$wp_customize->add_setting(
		'etrigan_skin',
		array(
			'default'=> 'default',
			'sanitize_callback' => 'etrigan_sanitize_skin' 
			)
	);
	
	$skins = array( 'default' => __('Default(blue)','etrigan'),
					'orange' =>  __('Orange','etrigan'),
					'red' =>  __('Red','etrigan'),
					 );
	
	$wp_customize->add_control(
		'etrigan_skin',array(
				'settings' => 'etrigan_skin',
				'section'  => 'etrigan_skin_options',
				'description' => __('<a target="_blank" href="https://rohitink.com/product/etrigan-pro/">Etrigan Pro</a> has options for Unlimited Skins and a Custom Skin Builder. Watch this <a target="_blank" href="https://www.youtube.com/watch?v=wpx3LnsS7sg">Tutorial video</a> on How Skin Designer Works.','etrigan'),
				'type' => 'select',
				'choices' => $skins,
			)
	);
	
	function etrigan_sanitize_skin( $input ) {
		if ( in_array($input, array('default','orange','red') ) )
			return $input;
		else
			return '';
	}
	
	
	//Fonts
	$wp_customize->add_section(
	    'etrigan_typo_options',
	    array(
	        'title'     => __('Google Web Fonts','etrigan'),
	        'priority'  => 41,
	        'description' => __('Defaults: Droid Serif, Ubuntu.','etrigan')
	    )
	);
	
	$font_array = array('Raleway','Khula','Open Sans','Droid Sans','Droid Serif','Roboto','Roboto Condensed','Lato','Bree Serif','Oswald','Slabo','Lora','Source Sans Pro','PT Sans','Ubuntu','Lobster','Arimo','Bitter','Noto Sans');
	$fonts = array_combine($font_array, $font_array);
	
	$wp_customize->add_setting(
		'etrigan_title_font',
		array(
			'default'=> 'Droid Serif',
			'sanitize_callback' => 'etrigan_sanitize_gfont' 
			)
	);
	
	function etrigan_sanitize_gfont( $input ) {
		if ( in_array($input, array('Raleway','Khula','Open Sans','Droid Sans','Droid Serif','Roboto','Roboto Condensed','Lato','Bree Serif','Oswald','Slabo','Lora','Source Sans Pro','PT Sans','Ubuntu','Lobster','Arimo','Bitter','Noto Sans') ) )
			return $input;
		else
			return '';	
	}
	
	$wp_customize->add_control(
		'etrigan_title_font',array(
				'label' => __('Title','etrigan'),
				'settings' => 'etrigan_title_font',
				'section'  => 'etrigan_typo_options',
				'type' => 'select',
				'choices' => $fonts,
			)
	);
	
	$wp_customize->add_setting(
		'etrigan_body_font',
			array(	'default'=> 'Ubuntu',
					'sanitize_callback' => 'etrigan_sanitize_gfont' )
	);
	
	$wp_customize->add_control(
		'etrigan_body_font',array(
				'label' => __('Body','etrigan'),
				'settings' => 'etrigan_body_font',
				'section'  => 'etrigan_typo_options',
				'type' => 'select',
				'choices' => $fonts
			)
	);
	
	// Social Icons
	$wp_customize->add_section('etrigan_social_section', array(
			'title' => __('Social Icons','etrigan'),
			'priority' => 44 ,
	));
	
	$social_networks = array( //Redefinied in Sanitization Function.
					'none' => __('-','etrigan'),
					'facebook' => __('Facebook','etrigan'),
					'twitter' => __('Twitter','etrigan'),
					'google-plus' => __('Google Plus','etrigan'),
					'instagram' => __('Instagram','etrigan'),
					'rss' => __('RSS Feeds','etrigan'),
					'vine' => __('Vine','etrigan'),
					'vimeo-square' => __('Vimeo','etrigan'),
					'youtube' => __('Youtube','etrigan'),
					'flickr' => __('Flickr','etrigan'),
				);
				
	$social_count = count($social_networks);
				
	for ($x = 1 ; $x <= ($social_count - 3) ; $x++) :
			
		$wp_customize->add_setting(
			'etrigan_social_'.$x, array(
				'sanitize_callback' => 'etrigan_sanitize_social',
				'default' => 'none'
			));

		$wp_customize->add_control( 'etrigan_social_'.$x, array(
					'settings' => 'etrigan_social_'.$x,
					'label' => __('Icon ','etrigan').$x,
					'section' => 'etrigan_social_section',
					'type' => 'select',
					'choices' => $social_networks,			
		));
		
		$wp_customize->add_setting(
			'etrigan_social_url'.$x, array(
				'sanitize_callback' => 'esc_url_raw'
			));

		$wp_customize->add_control( 'etrigan_social_url'.$x, array(
					'settings' => 'etrigan_social_url'.$x,
					'description' => __('Icon ','etrigan').$x.__(' Url','etrigan'),
					'section' => 'etrigan_social_section',
					'type' => 'url',
					'choices' => $social_networks,			
		));
		
	endfor;
	
	function etrigan_sanitize_social( $input ) {
		$social_networks = array(
					'none' ,
					'facebook',
					'twitter',
					'google-plus',
					'instagram',
					'rss',
					'vine',
					'vimeo-square',
					'youtube',
					'flickr'
				);
		if ( in_array($input, $social_networks) )
			return $input;
		else
			return '';	
	}
	
	$wp_customize->add_section(
	    'etrigan_sec_upgrade',
	    array(
	        'title'     => __('Discover ETRIGAN PRO','etrigan'),
	        'priority'  => 45,
	    )
	);
	
	$wp_customize->add_setting(
			'etrigan_upgrade',
			array( 'sanitize_callback' => 'esc_textarea' )
		);
			
	$wp_customize->add_control(
	    new Etrigan_WP_Customize_Upgrade_Control(
	        $wp_customize,
	        'etrigan_upgrade',
	        array(
	            'label' => __('More of Everything','etrigan'),
	            'description' => __('etrigan Pro has more of Everything. More New Features, More Options, More Colors, More Fonts, More Layouts, Configurable Slider, Inbuilt Advertising Options, Multiple Skins, More Widgets, and a lot more options and comes with Dedicated Support. To Know More about the Pro Version, click here: <a href="https://rohitink.com/product/etrigan-pro/">Upgrade to Pro</a>.','etrigan'),
	            'section' => 'etrigan_sec_upgrade',
	            'settings' => 'etrigan_upgrade',			       
	        )
		)
	);
	
	$wp_customize->add_section(
	    'etrigan_sec_upgrade_help',
	    array(
	        'title'     => __('Etrigan Theme - Help & Support','etrigan'),
	        'priority'  => 45,
	    )
	);
	
	$wp_customize->add_setting(
			'etrigan_upgrade_help',
			array( 'sanitize_callback' => 'esc_textarea' )
		);
			
	$wp_customize->add_control(
	    new Etrigan_WP_Customize_Upgrade_Control(
	        $wp_customize,
	        'etrigan_upgrade_help',
	        array(
	            'label' => __('Thank You','etrigan'),
	            'description' => __('Thank You for Choosing Etrigan Theme by Rohitink.com. Etrigan is a Powerful Wordpress theme which also supports WooCommerce in the best possible way. It is "as we say" the last theme you would ever need. It has all the basic and advanced features needed to run a gorgeous looking site. For any Help related to this theme, please visit  <a href="https://rohitink.com/2015/12/15/etrigan-multipurpose-theme/">Etrigan Help & Support</a>.','etrigan'),
	            'section' => 'etrigan_sec_upgrade_help',
	            'settings' => 'etrigan_upgrade_help',			       
	        )
		)
	);
	
	
	/* Sanitization Functions Common to Multiple Settings go Here, Specific Sanitization Functions are defined along with add_setting() */
	function etrigan_sanitize_checkbox( $input ) {
	    if ( $input == 1 ) {
	        return 1;
	    } else {
	        return '';
	    }
	}
	
	function etrigan_sanitize_positive_number( $input ) {
		if ( ($input >= 0) && is_numeric($input) )
			return $input;
		else
			return '';	
	}
	
	function etrigan_sanitize_category( $input ) {
		if ( term_exists(get_cat_name( $input ), 'category') )
			return $input;
		else 
			return '';	
	}
	
	function etrigan_sanitize_product_category( $input ) {
		if ( get_term( $input, 'product_cat' ) )
			return $input;
		else 
			return '';	
	}
	
	
}
add_action( 'customize_register', 'etrigan_customize_register' );


/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function etrigan_customize_preview_js() {
	wp_enqueue_script( 'etrigan_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'etrigan_customize_preview_js' );
