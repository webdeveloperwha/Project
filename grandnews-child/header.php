<?php
/**
 * The Header for the template.
 *
 * @package WordPress
 */
 
if (!isset( $content_width ) ) $content_width = 1170;

if(session_id() == '') {
	session_start();
}
 
$grandnews_homepage_style = grandnews_get_homepage_style();

?><!DOCTYPE html>
<html <?php language_attributes(); ?> <?php if(isset($grandnews_homepage_style) && !empty($grandnews_homepage_style)) { echo 'data-style="'.esc_attr($grandnews_homepage_style).'"'; } ?>>
<head>

<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

<?php
	//Fallback compatibility for favicon
	if(!function_exists( 'has_site_icon' ) || ! has_site_icon() ) 
	{
		/**
		*	Get favicon URL
		**/
		$tg_favicon = kirki_get_option('tg_favicon');
		
		if(!empty($tg_favicon))
		{
?>
			<link rel="shortcut icon" href="<?php echo esc_url($tg_favicon); ?>" />
<?php
		}
	}
?> 

<?php
	/* Always have wp_head() just before the closing </head>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to add elements to <head> such
	 * as styles, scripts, and meta tags.
	 */
	wp_head();
?>
	
</head>
<style>
li#custom_html-3 {
    list-style: none;
}
</style>
<body <?php body_class(); ?>>

		
		
		<?php dynamic_sidebar( 'header-sidebar' ); ?>
		

    
<?php if ( function_exists( 'gtm4wp_the_gtm_tag' ) ) { gtm4wp_the_gtm_tag(); } ?>
	<?php
		//Check if disable right click
		$tg_enable_right_click = kirki_get_option('tg_enable_right_click');
		
		//Check if disable image dragging
		$tg_enable_dragging = kirki_get_option('tg_enable_dragging');
		
		//Check if use AJAX search
		$tg_menu_search_instant = kirki_get_option('tg_menu_search_instant');
		
		//Check if sticky menu
		$tg_fixed_menu = kirki_get_option('tg_fixed_menu');
		
		//Check if sticky sidebar
		$tg_sidebar_sticky = kirki_get_option('tg_sidebar_sticky');
		
		//Check if display top bar
		$tg_topbar = kirki_get_option('tg_topbar');
		if(THEMEDEMO && isset($_GET['topbar']) && !empty($_GET['topbar']))
		{
			$tg_topbar = true;
		}
		
		//Check if add blur effect
		$tg_page_title_img_blur = kirki_get_option('tg_page_title_img_blur');
		
		//Check filterable link option
		$tg_portfolio_filterable_link = kirki_get_option('tg_portfolio_filterable_link');
		
		//Check slider layout
		$tg_blog_slider_layout = kirki_get_option('tg_blog_slider_layout');
		if(THEMEDEMO && isset($_GET['layout']) && ($_GET['layout'] == 'fullwidth' OR $_GET['layout'] == 'full_fullwidth'))
		{
			$tg_blog_slider_layout = '3cols-slider';
		}
		
		//Get lightbox skin color
		$tg_lightbox_skin = kirki_get_option('tg_lightbox_skin');
		
		//Get lightbox thumbnails alignment
		$tg_lightbox_thumbnails = kirki_get_option('tg_lightbox_thumbnails');
		
		//Get lightbox overlay opacity
		$tg_lightbox_opacity = kirki_get_option('tg_lightbox_opacity');
		$tg_lightbox_opacity = $tg_lightbox_opacity/100;
		
		//Get lazy load
		$tg_enable_lazy = kirki_get_option('tg_enable_lazy');
	?>
	<input type="hidden" id="pp_enable_right_click" name="pp_enable_right_click" value="<?php echo esc_attr($tg_enable_right_click); ?>"/>
	<input type="hidden" id="pp_enable_dragging" name="pp_enable_dragging" value="<?php echo esc_attr($tg_enable_dragging); ?>"/>
	<input type="hidden" id="pp_image_path" name="pp_image_path" value="<?php echo get_template_directory_uri(); ?>/images/"/>
	<input type="hidden" id="pp_homepage_url" name="pp_homepage_url" value="<?php echo esc_url(home_url('/')); ?>"/>
	<input type="hidden" id="pp_ajax_search" name="pp_ajax_search" value="<?php echo esc_attr($tg_menu_search_instant); ?>"/>
	<input type="hidden" id="pp_fixed_menu" name="pp_fixed_menu" value="<?php echo esc_attr($tg_fixed_menu); ?>"/>
	<input type="hidden" id="tg_sidebar_sticky" name="tg_sidebar_sticky" value="<?php echo esc_attr($tg_sidebar_sticky); ?>"/>
	<input type="hidden" id="pp_topbar" name="pp_topbar" value="<?php echo esc_attr($tg_topbar); ?>"/>
	<input type="hidden" id="pp_page_title_img_blur" name="pp_page_title_img_blur" value="<?php echo esc_attr($tg_page_title_img_blur); ?>"/>
	<input type="hidden" id="tg_blog_slider_layout" name="tg_blog_slider_layout" value="<?php echo esc_attr($tg_blog_slider_layout); ?>"/>
	<input type="hidden" id="pp_back" name="pp_back" value="<?php esc_html_e( 'Back', 'grandnews' ); ?>"/>
	<input type="hidden" id="tg_lightbox_skin" name="tg_lightbox_skin" value="<?php echo esc_attr($tg_lightbox_skin); ?>"/>
	<input type="hidden" id="tg_lightbox_thumbnails" name="tg_lightbox_thumbnails" value="<?php echo esc_attr($tg_lightbox_thumbnails); ?>"/>
	<input type="hidden" id="tg_lightbox_opacity" name="tg_lightbox_opacity" value="<?php echo esc_attr($tg_lightbox_opacity); ?>"/>
	<input type="hidden" id="tg_enable_lazy" name="tg_enable_lazy" value="<?php echo esc_attr($tg_enable_lazy); ?>"/>
	
	<?php
		//Check footer sidebar columns
		$tg_footer_sidebar = kirki_get_option('tg_footer_sidebar');
	?>
	<input type="hidden" id="pp_footer_style" name="pp_footer_style" value="<?php echo esc_attr($tg_footer_sidebar); ?>"/>
	
	<!-- Begin mobile menu -->
	<a id="close_mobile_menu" href="javascript:;"></a>
	<div class="mobile_menu_wrapper">
		<a id="close_mobile_menu_button" href="javascript:;"><i class="fa fa-close"></i></a>
	
	    <?php 
	    	//Check if has custom menu
			if(is_object($post) && $post->post_type == 'page')
			{
			    $page_menu = get_post_meta($post->ID, 'page_menu', true);
			}	
			
			if ( has_nav_menu( 'side-menu' ) ) 
			{
			    //Get page nav
			    wp_nav_menu( 
			        array( 
			            'menu_id'			=> 'mobile_main_menu',
		                'menu_class'		=> 'mobile_main_nav',
			            'theme_location' 	=> 'side-menu',
			        )
			    ); 
			}
		?>
		
		<!-- Begin side menu sidebar -->
		<div class="page_content_wrapper">
			<div class="sidebar_wrapper">
		        <div class="sidebar">
		        
		        	<div class="content">
		        
		        		<ul class="sidebar_widget">
		        		<?php dynamic_sidebar('Side Menu Sidebar'); ?>
		        		</ul>
		        	
		        	</div>
		    
		        </div>
			</div>
		</div>
		<!-- End side menu sidebar -->
	</div>
	<!-- End mobile menu -->

	<!-- Begin template wrapper -->
	<div id="wrapper">
	
	<?php
	    //Get main menu layout
	    $tg_main_menu_layout = kirki_get_option('tg_main_menu_layout');
	    
	    switch($tg_main_menu_layout)
	    {
		    case 'left_align':
		    default:
		    	get_template_part("/templates/menu/template-left-align");
		    break;
		    
		    case 'center':
		    	get_template_part("/templates/menu/template-center");
		    break;
		    
		    case 'left_fullwidth':
		    	get_template_part("/templates/menu/template-left-fullwidth");
		    break;
	    }
	?>
<script>

function hideExpression(){
	
	jQuery('section.top-header').remove();
	jQuery('.header_style_wrapper, #page_content_wrapper .inner .inner_wrapper').css('padding-top', 0);
}	


jQuery(document).ready(function() {
 jQuery(window).scroll(function() {
    if (jQuery(document).scrollTop() > 100) {
      jQuery(".header_style_wrapper").addClass("test");
    } else {
      jQuery(".header_style_wrapper").removeClass("test");
    }
  });
});


	
</script>