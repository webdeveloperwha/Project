<?php
/**
*	Get Current page object
**/
$page = get_page($post->ID);

/**
*	Get current page id
**/

if(!isset($current_page_id) && isset($page->ID))
{
    $current_page_id = $page->ID;
}

//Get page header display setting
$page_title = get_the_title();
$post_ft_type = get_post_meta(get_the_ID(), 'post_ft_type', true);

if(has_post_thumbnail($current_page_id, 'full') && $post_ft_type == 'Fullwidth Image')
{
	$pp_page_bg = '';
	
	//Get page featured image
	if(has_post_thumbnail($current_page_id, 'full'))
    {
        $image_id = get_post_thumbnail_id($current_page_id); 
        $image_thumb = wp_get_attachment_image_src($image_id, 'full', true);
        
        if(isset($image_thumb[0]) && !empty($image_thumb[0]))
        {
        	$pp_page_bg = $image_thumb[0];
        }
        
        //Check if add blur effect
		$tg_page_title_img_blur = kirki_get_option('tg_page_title_img_blur');
    }
    
    $grandnews_topbar = grandnews_get_topbar();
    $grandnews_screen_class = grandnews_get_screen_class();
?>
<div id="page_caption" class="<?php if(!empty($pp_page_bg)) { ?>hasbg parallax<?php } ?> <?php if(!empty($grandnews_topbar)) { ?>withtopbar<?php } ?> <?php if(!empty($grandnews_screen_class)) { ?>split<?php } ?>">

	<?php if(!empty($pp_page_bg)) { ?>
		<div id="bg_regular" style="background-image:url(<?php echo esc_url($pp_page_bg); ?>);"></div>
	<?php } ?>
	
	<div class="page_title_wrapper">
	    <div class="standard_wrapper">
	    	<div class="post_info_cat">
				<?php grandnews_breadcrumb(); ?>
			</div>
	    	<h1 <?php if(!empty($pp_page_bg) && !empty($grandnews_topbar)) { ?>class ="withtopbar"<?php } ?>><?php the_title(); ?></h1>
	    	<div class="post_detail post_date">
			    <span class="post_info_author">
			    	<?php
							$post_author_id = get_post_field('post_author', $post->ID);
							$author_name = get_the_author_meta('display_name', $post_author_id);
							$author_email = get_the_author_meta('email', $post_author_id);
					?>
			    	<a href="<?php echo get_author_posts_url($post_author_id); ?>"><span class="gravatar"><?php echo get_avatar($author_email, '60' ); ?></span><?php echo esc_html($author_name); ?></a>
			    </span>
			    <span class="post_info_date">
			    	<span class="last-updated-time"> UPDATED ON <time itemprop="dateModified" content="<?php the_modified_date('F jS, Y'); ?>"><?php the_modified_date('F j, Y'); ?></time> </span></a>
			    </span>
			</div>
			<div class="post_detail post_comment">
			    <div class="post_info_comment">
			    	<a href="<?php comments_link(); ?>"><i class="fa fa-commenting"></i><?php echo get_comments_number(); ?></a>
			    </div>
			    
			    <?php 
			    	$post_view_count = grandnews_get_post_view($post->ID);
			    
			    	if(!empty($post_view_count))
			    	{
			    ?>
			    <div class="post_info_view">
			        <i class="fa fa-eye"></i><?php echo $post_view_count; ?>&nbsp;<?php echo esc_html_e( 'Views', 'grandnews' ); ?>
			    </div>
			    <?php
			    	}
			    ?>
			</div>
	    </div>
	</div>
	
	<?php
	    if(!empty($tg_page_title_img_blur) && !empty($pp_page_bg) && $grandnews_screen_class != 'split')
	    {
	    	$grandnews_ajax_nonce = wp_create_nonce('tgajax-post-contact-nonce');
	?>
	<div id="bg_blurred" style="background-image:url(<?php echo admin_url('admin-ajax.php').'?action=grandnews_blurred_image&src='.esc_url($pp_page_bg).'&tg_security='.$grandnews_ajax_nonce; ?>);"></div>
	<?php
	    }
	?>
</div>
<?php
}
?>

<?php
if($post_ft_type == 'Youtube Video' OR $post_ft_type == 'Vimeo Video')
{
?>
<div id="video_caption">
	<?php
		switch($post_ft_type)
		{
			case 'Vimeo Video':
				$post_ft_vimeo = get_post_meta(get_the_ID(), 'post_ft_vimeo', true);
				//echo do_shortcode('[tg_vimeo video_id="'.$post_ft_vimeo.'" width="670" height="377"]');
				echo '<iframe src="//player.vimeo.com/video/'.$post_ft_vimeo.'?title=0&amp;byline=0&amp;portrait=0" width="670" height="377" frameborder="0"></iframe>';
			
			break;
			
			case 'Youtube Video':
			    $post_ft_youtube = get_post_meta(get_the_ID(), 'post_ft_youtube', true);
			    //echo do_shortcode('[tg_youtube video_id="'.$post_ft_youtube.'" width="670" height="377"]');
			    echo '<iframe title="YouTube video player" width="670" height="377" src="//www.youtube.com/embed/'.$post_ft_youtube.'?theme=dark&rel=0&wmode=transparent" frameborder="0" allowfullscreen></iframe>';
			break;
		}
	?>
</div>
<?php
}
?>

<!-- Begin content -->
<?php
$grandnews_page_content_class = grandnews_get_page_content_class();
?>
<div id="page_content_wrapper" class="<?php if(!empty($pp_page_bg)) { ?>hasbg <?php } ?><?php if(!empty($pp_page_bg) && !empty($grandnews_topbar)) { ?>withtopbar <?php } ?><?php if(!empty($grandnews_page_content_class)) { echo esc_attr($grandnews_page_content_class); } ?>">