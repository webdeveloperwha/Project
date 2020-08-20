<?php
/**
 * The main template file for display single post page.
 *
 * @package WordPress
*/

get_header(); 

$grandnews_topbar = grandnews_get_topbar();

/**
*	Get current page id
**/

$current_page_id = $post->ID;

//If display feat content
$tg_blog_feat_content = kirki_get_option('tg_blog_feat_content');


/**
*	Get current page id
**/

$current_page_id = $post->ID;
$post_gallery_id = '';
if(!empty($tg_blog_feat_content))
{
	$post_gallery_id = get_post_meta($current_page_id, 'post_gallery_id', true);
}

//Include custom header feature
get_template_part("/templates/template-post-header");

//Get post type
$post_ft_type = get_post_meta(get_the_ID(), 'post_ft_type', true);
?>

<div class="inner">

	<!-- Begin main content -->
	<div class="inner_wrapper">

		<div class="sidebar_content">
					
<?php
if (have_posts()) : while (have_posts()) : the_post();
?>
						
<!-- Begin each blog post -->
<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="post_wrapper">
	    
	    <div class="post_content_wrapper">
	    
	    	<?php
	    		if($post_ft_type != 'Fullwidth Image')
	    		{
	    	?>
	    
	    	<div class="post_header">
				<div class="post_header_title">
				 	<div class="post_info_cat">
				 		<?php grandnews_breadcrumb(); ?>
				 	</div>
				   	<h1><?php the_title(); ?></h1>
				   	<div class="post_detail post_date">
			      		<span class="post_info_author">
			      			<?php
			      				$author_name = get_the_author();
			      			?>
			      			<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ); ?>"><span class="gravatar"><?php echo get_avatar( get_the_author_meta('email'), '60' ); ?></span><?php echo esc_html($author_name); ?></a>
			      		</span>
			      		<span class="post_info_date">
			      			<span class="last-updated-time"> UPDATED ON <time itemprop="dateModified" content="<?php the_modified_date('F jS, Y'); ?>"><?php the_modified_date('F j, Y'); ?></time> </span>
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
					    	
					    	if( function_exists('zilla_likes') ) zilla_likes();
					    ?>
				  	</div>
				</div>
			</div>
			
			<hr class="post_divider"/><br class="clear"/>
			
			<?php
				}
			?>
			
			<?php
				//Get share button
				get_template_part("/templates/template-post-share");
			?>
	    
	    	<?php
				//Get post featured content
			    $post_ft_type = get_post_meta(get_the_ID(), 'post_ft_type', true);			    
			    $image_id = get_post_thumbnail_id(get_the_ID());
			    $small_image_url = wp_get_attachment_image_src($image_id, 'grandnews_blog', true);
			    $image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
			    ?>

				<!-- Social Warfare Icons -->
				<?php echo do_shortcode('[social_warfare]'); ?>
			    <div class="post_img static">
	    	    	<img <?php echo esc_html(grandnews_get_src_attr()); ?>="<?php echo esc_url($small_image_url[0]); ?>" alt="<?php echo esc_attr($image_alt); ?>" class="" style="width:<?php echo esc_attr($small_image_url[1]); ?>px;height:<?php echo esc_attr($small_image_url[2]); ?>px;"/>
	    	    </div>
			    <?php
			    
			    switch($post_ft_type)
			    {
			    	case 'Image11':
			    		$image_id = get_post_thumbnail_id(get_the_ID());
			        	$small_image_url = wp_get_attachment_image_src($image_id, 'grandnews_blog', true);
			        	$image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
			?>
			
			    	    <div class="post_img static">
			    	    	<img <?php echo esc_html(grandnews_get_src_attr()); ?>="<?php echo esc_url($small_image_url[0]); ?>" alt="<?php echo esc_attr($image_alt); ?>" class="" style="width:<?php echo esc_attr($small_image_url[1]); ?>px;height:<?php echo esc_attr($small_image_url[2]); ?>px;"/>
			    	    </div>
			
			<?php
			    	break;
			    	
			    	case 'Gallery':
			    		$post_ft_gallery = get_post_meta(get_the_ID(), 'post_ft_gallery', true);
	
						//Get gallery images
						$all_photo_arr = get_post_meta($post_ft_gallery, 'wpsimplegallery_gallery', true);
						
						//Get gallery sorting
						$all_photo_arr = grandnews_resort_gallery_img($all_photo_arr);
						
						if(!empty($all_photo_arr))
						{
			?>
			<div class="post_gallery_wrapper">
			<?php
							$all_photo_count = count($all_photo_arr);
							$plus_photo_count = 0;
							
							if($all_photo_count > 6)
							{
								$plus_photo_count = $all_photo_count - 6;
							}
							
							foreach($all_photo_arr as $key => $photo_id)
							{
							    $small_image_url = '';
							    $hyperlink_url = get_permalink($photo_id);
							    $thumb_image_url = '';
							    
							    if(!empty($photo_id))
							    {
							    	//if mobile or tablet then use smaller image size for better performance
							    	if(!wp_is_mobile())
							    	{
								    	$image_size = 'original';
							    	}
							    	else
							    	{
								    	$image_size = 'large';
							    	}
							    	$image_url = wp_get_attachment_image_src($photo_id, $image_size, true);
							    	$thumb_image_url = wp_get_attachment_image_src($photo_id, 'thumbnail', true);
							    }
							    
							    //Get image meta data
							    $image_caption = get_post_field('post_excerpt', $photo_id);
							    $image_alt = get_post_meta($photo_id, '_wp_attachment_image_alt', true);
							    $tg_lightbox_enable_caption = kirki_get_option('tg_lightbox_enable_caption');
							    
							    //First image large
							    if($key == 0)
							    {
			?>
							    <div class="post_img post_gallery_featured">
							    	<a <?php if(!empty($tg_lightbox_enable_caption)) { ?>title="<?php if(!empty($image_caption)) { ?><?php echo esc_attr($image_caption); ?><?php } ?>"<?php } ?> class="fancy-gallery" href="<?php echo esc_url($image_url[0]); ?>">
								    	<img src="<?php echo esc_url($image_url[0]); ?>" alt="<?php echo esc_attr($image_alt); ?>"/>
									</a>
								</div>
			<?php
							    }
							    else
							    {
							    	$last_class = '';
							    	if(($key)%5 == 0)
							    	{
								    	$last_class = 'last';
							    	}
							    	
							    	$hidden_class = '';
							    	if($key > 5)
							    	{
								    	$hidden_class = 'hidden';
							    	}
			?>
								<div class="one_fifth <?php echo esc_attr($last_class); ?> <?php echo esc_attr($hidden_class); ?>">
									<a <?php if(!empty($tg_lightbox_enable_caption)) { ?>title="<?php if(!empty($image_caption)) { ?><?php echo esc_attr($image_caption); ?><?php } ?>"<?php } ?> class="fancy-gallery" href="<?php echo esc_url($image_url[0]); ?>">
								    	<?php
								    		if($key == 5)
								    		{
									    ?>
									    <div class="more_gallery_count">+<?php echo intval($plus_photo_count); ?></div>
									    <?php
								    		}
								    	?>
								    	<img src="<?php echo esc_url($thumb_image_url[0]); ?>" alt="<?php echo esc_attr($image_alt); ?>"/>
									</a>
								</div>
			<?php
							    }
							}
						}
			?>
			</div><br class="clear"/>
			<?php
						
			    	break;
			    	
			    } //End switch
			?>

		    <div class="post_header single">
				
				<?php
				    the_content();
				    wp_link_pages( array(
					    'before'           => '<hr class="post_pagination_divider"/><div class="post_pagination">',
					    'after'            => '</div>',
					    'link_before'      => '',
					    'link_after'       => '',
					    'next_or_number'   => 'next',
					    'separator'        => ' ',
					    'nextpagelink'     => esc_html__( 'Next', 'grandnews' ).' <i class="fa fa-angle-double-right"></i>',
					    'previouspagelink' => '<i class="fa fa-angle-double-left"></i> '.esc_html__( 'Back', 'grandnews' ),
					    'pagelink'         => '%',
					    'echo'             => 1
					    )
					);
				?>
				
				<!-- Social Warfare Icons -->
				<div class="swp_social_panel_post_bottom">
					<?php echo do_shortcode('[social_warfare]'); ?>
				</div>

				<div class="post_share_center">
				<?php
					//Get share button
					get_template_part("/templates/template-post-share");
				?>
				</div>
				<hr/>
				
				<?php echo do_shortcode(grandnews_get_ads('pp_ads_single_after_content')); ?>
			</div>

		    <?php
			 $tg_blog_display_tags = kirki_get_option('tg_blog_display_tags');
			
			    if(has_tag() && !empty($tg_blog_display_tags))
			    {
			?>
			    <div class="post_excerpt post_tag">
			    	<i class="fa fa-tags"></i>
			    	<?php the_tags('', '', '<br />'); ?>
			    </div>
			<?php
			    }
			?>
			<br class="clear"/>
			
			<?php
			    //Get post author
				get_template_part("/templates/template-author");
			?>
			
			<?php
				//Get trending posts
				$tg_blog_display_trending = kirki_get_option('tg_blog_display_trending');
				
				if($tg_blog_display_trending)
				{	
					$tg_blog_display_trending_by = kirki_get_option('tg_blog_display_trending_by');
					$trending_posts = grandnews_trending_posts($tg_blog_display_trending_by, 2);
					
					if(!empty($trending_posts))
					{
			?>
				<h5 class="single_subtitle"><?php echo esc_html_e( 'Trending Now', 'grandnews' ); ?></h5>
			  	<div class="post_trending">
			<?php
						foreach($trending_posts as $key => $trending_post)
						{
							$last_class = '';
							if(($key+1)%2==0)
							{
						       	$last_class = 'last';
							}
			?>
						<div class="one_half <?php echo esc_attr($last_class); ?>">
							<div class="post_wrapper grid_layout">
						<?php
							if(has_post_thumbnail($trending_post->ID, 'grandnews_blog_thumb'))
							{
							    $image_id = get_post_thumbnail_id($trending_post->ID);
							    $trending_post_thumb = wp_get_attachment_image_src($image_id, 'grandnews_blog_thumb', true);
							    
							    if(isset($trending_post_thumb[0]) && !empty($trending_post_thumb[0]))
							    {
						?>
								<div class="post_img small static">
								    <a href="<?php echo esc_url(get_permalink($trending_post->ID)); ?>">
								    	<?php echo grandnews_get_post_featured_type_icon($trending_post->ID); ?>
								    	<img <?php echo esc_html(grandnews_get_src_attr()); ?>="<?php echo esc_url($trending_post_thumb[0]); ?>" alt="" class="" style="width:<?php echo esc_attr($trending_post_thumb[1]); ?>px;height:<?php echo esc_attr($trending_post_thumb[2]); ?>px;"/>
								    </a>
								</div>
						<?php
								}
							} //End if has post featured image
						?>
								<div class="blog_grid_content">
									<div class="post_header grid">
									    <h6><a href="<?php echo esc_url(get_permalink($trending_post->ID)); ?>" title="<?php esc_attr($trending_post->post_title); ?>"><?php echo esc_html($trending_post->post_title); ?></a></h6>
									    <div class="post_detail post_date">
								      		<span class="post_info_author">
								      			<?php
								      				$post_author_id = get_post_field('post_author', $trending_post->ID);
								      				$author_name = get_the_author_meta('display_name', $post_author_id);
								      				$author_nice_name = get_the_author_meta( 'user_nicename', $post_author_id )
								      			?>
								      			<a href="<?php echo get_author_posts_url($post_author_id, $author_nice_name ); ?>"><?php echo esc_html($author_name); ?></a>
								      		</span>
								      		<span class="post_info_date">
								      			<?php echo date_i18n(THEMEDATEFORMAT, strtotime($trending_post->post_date)); ?>
								      		</span>
									  	</div>
									</div>
							    </div>
							</div>
						</div>
			<?php
						} //End foreach trending posts
			?>
			  	</div>
			<?php
					} //End if has trending posts
				} //End if display trending posts
			?>
			
			<?php echo do_shortcode(grandnews_get_ads('pp_ads_single_before_related')); ?>
			
			<?php
				//Get related posts
			    $tg_blog_display_related = kirki_get_option('tg_blog_display_related');
			    
			    if($tg_blog_display_related)
			    {
			?>
			
			<?php
			//for use in the loop, list 9 post titles related to post's tags on current post
			$tags = wp_get_post_tags($post->ID);
			
			if ($tags) {
			
			    $tag_in = array();
			  	//Get all tags
			  	foreach($tags as $tags)
			  	{
			      	$tag_in[] = $tags->term_id;
			  	}
			
			  	$args=array(
			      	  'tag__in' => $tag_in,
			      	  'post__not_in' => array($post->ID),
			      	  'showposts' => 3,
			      	  'ignore_sticky_posts' => 1,
			      	  'orderby' => 'date',
			      	  'order' => 'DESC'
			  	 );
			  	$my_query = new WP_Query($args);
			  	$i_post = 1;
			  	
			  	if( $my_query->have_posts() ) {
			 ?>
			  	<h5 class="single_subtitle"><?php echo esc_html_e( 'You may also like', 'grandnews' ); ?></h5>
			  	<div class="post_related">
			    <?php
			       while ($my_query->have_posts()) : $my_query->the_post();
			       
			       $last_class = '';
			       if($i_post%3==0)
			       {
				       $last_class = 'last';
			       }
			       
			       $image_thumb = '';
								
					if(has_post_thumbnail(get_the_ID(), 'large'))
					{
					    $image_id = get_post_thumbnail_id(get_the_ID());
					    $image_thumb = wp_get_attachment_image_src($image_id, 'large', true);
					}
			    ?>
			       <div class="one_third <?php echo esc_attr($last_class); ?>">
					   <!-- Begin each blog post -->
						<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						
							<div class="post_wrapper grid_layout">
							
								<?php
								    //Get post featured content
									if(!empty($image_thumb))
									{
								       $small_image_url = wp_get_attachment_image_src($image_id, 'grandnews_blog_thumb', true);
								?>
								
								   <div class="post_img small static">
								       <a href="<?php the_permalink(); ?>">
								       	<?php echo grandnews_get_post_featured_type_icon(get_the_ID()); ?>
								       	<img <?php echo esc_html(grandnews_get_src_attr()); ?>="<?php echo esc_url($small_image_url[0]); ?>" alt="" class="" style="width:<?php echo esc_attr($small_image_url[1]); ?>px;height:<?php echo esc_attr($small_image_url[2]); ?>px;"/>
								       </a>
								   </div>
								
								<?php
									}
								?>
							    
							    <div class="blog_grid_content">
									<div class="post_header grid">
									    <strong><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></strong>
									    <div class="post_attribute info_date">
									        <span class="last-updated-time"> UPDATED ON <time itemprop="dateModified" content="<?php the_modified_date('F jS, Y'); ?>"><?php the_modified_date('F j, Y'); ?></time> </span>
									    </div>
									</div>
							    </div>
							    
							</div>
						
						</div>
						<!-- End each blog post -->
			       </div>
			     <?php
			     	$i_post++;
			       	endwhile;
			       	
			       	wp_reset_postdata();
			     ?>
			  	</div>
			<?php
			  	}
			}
			?>
			
			<?php
			    } //end if show related
			?>
			
			<?php
				//Get next post
				$tg_blog_display_next = kirki_get_option('tg_blog_display_next');
				
				if($tg_blog_display_next)
				{
					$next_post = get_next_post();
					
					if(!empty($next_post))
					{
			?>
			<div class="read_next_wrapper">
			<?php
					//Get post thumbnail
					$next_post_thumb = '';
					    		
					if(has_post_thumbnail($next_post->ID, 'grandnews_blog_thumb'))
					{
					    $image_id = get_post_thumbnail_id($next_post->ID);
					    $next_post_thumb = wp_get_attachment_image_src($image_id, 'grandnews_blog_thumb', true);
					    
					    if(isset($next_post_thumb[0]) && !empty($next_post_thumb[0]))
					    {
			?>
						<div class="post_img next_post">
						    <a href="<?php echo esc_url(get_permalink($next_post->ID)); ?>"><img <?php echo esc_html(grandnews_get_src_attr()); ?>="<?php echo esc_url($next_post_thumb[0]); ?>" alt="<?php echo esc_attr($next_post->post_title); ?>"/></a>
						</div>
			<?php
						}
			?>
			<?php
					} //End if has post thumbnail
			?>
						<div class="post_content">
						    <div class="read_next_label"><a href="<?php echo esc_url(get_permalink($next_post->ID)); ?>"><?php esc_html_e( 'Read Next', 'grandnews' ); ?></a></div>
						    <div class="next_post_title">
						    	<h3><a href="<?php echo esc_url(get_permalink($next_post->ID)); ?>"><?php echo esc_html($next_post->post_title); ?></a></h3>
						    </div>
						</div>
			</div>
			<?php
					} //End if has next post
				}
				//End get next post
			?>
			
	    </div>
	    
	</div>

</div>
<!-- End each blog post -->

<?php echo do_shortcode(grandnews_get_ads('pp_ads_single_before_comment')); ?>

<?php
if (comments_open($post->ID)) 
{
?>
<div class="fullwidth_comment_wrapper sidebar">
	<?php comments_template( '', true ); ?>
</div>
<?php
}
?>

<?php endwhile; endif; ?>
						
    	</div>

    		<div class="sidebar_wrapper">
    		
    			<div class="sidebar_top"></div>
    		
    			<div class="sidebar">
    			
    				<div class="content">

    					<?php 
						if (is_active_sidebar('single-post-sidebar')) { ?>
		    	    		<ul class="sidebar_widget">
		    	    		<?php dynamic_sidebar('single-post-sidebar'); ?>
		    	    		</ul>
		    	    	<?php } ?>
    				
    				</div>
    		
    			</div>
    			<br class="clear"/>
    	
    			<div class="sidebar_bottom"></div>
    		</div>
    
    </div>
    <!-- End main content -->
   
</div>

</div>

<?php
	//Include Post Bar
	get_template_part("/templates/template-post-bar");
?>
<?php get_footer(); ?>