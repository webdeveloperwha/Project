<?php
/**
 * The main template file for display blog page.
 *
 * @package WordPress
*/

/**
*	Get Current page object
**/
if(!is_null($post))
{
	$page_obj = get_page($post->ID);
}

$current_page_id = '';

/**
*	Get current page id
**/

if(!is_null($post) && isset($page_obj->ID))
{
    $current_page_id = $page_obj->ID;
}

get_header(); 

$is_standard_wp_post = FALSE;
$page_sidebar = 'page-sidebar';

if(is_tag())
{
    $is_standard_wp_post = TRUE;
    $page_sidebar = 'tag-sidebar';
} 
elseif(is_category())
{
    $is_standard_wp_post = TRUE;
    $page_sidebar = 'category-sidebar';
}
elseif(is_archive())
{
    $is_standard_wp_post = TRUE;
    $page_sidebar = 'archives-sidebar';
} 
elseif(is_search())
{
    $is_standard_wp_post = TRUE;
    $page_sidebar = 'search-sidebar';
} 
		
get_header(); 

if(is_category() OR is_tag() OR is_archive() OR is_search())
{
	get_template_part("/templates/template-header");
}
else
{
?>
<div id="page_content_wrapper">
<?php
}
?>
    <div class="inner">

    	<!-- Begin main content -->
    	<div class="inner_wrapper">

    			<div class="sidebar_content two_cols mixed">
<?php
//Include post search bar
get_template_part("/templates/template-search");

$key = 0;
if (have_posts()) : while (have_posts()) : the_post();
	$image_thumb = '';
								
	if(has_post_thumbnail(get_the_ID(), 'large'))
	{
	    $image_id = get_post_thumbnail_id(get_the_ID());
	    $image_thumb = wp_get_attachment_image_src($image_id, 'large', true);
	}
?>

<?php
	//Check if first item
	if($key == 0)
	{
?>
<!-- Begin each blog post -->
<div id="post-<?php the_ID(); ?>" <?php post_class(array('first-child')); ?>>

	<div class="post_wrapper">
	    
	    <div class="post_content_wrapper">
	    
	    	<div class="post_header mixed">
	    	
	    		<div class="post_header_title">
				   	<?php
						//Get Post's Categories
					    $post_categories = wp_get_post_categories($post->ID);
					    if(!empty($post_categories))
					    {
					?>
					<div class="post_info_cat">
						<span>
					    <?php
					    	$i = 0;
					    	$len = count($post_categories);
					        foreach($post_categories as $c)
					        {
					        	$cat = get_category( $c );
					    ?>
					        <a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>"><?php echo esc_html($cat->name); ?></a>
					    <?php
					    		if ($i != $len - 1) {
					    ?>
					        &nbsp;/
					    <?php
					    		}
					    		$i++;
					        }
					    ?>
						</span>
					</div>
					<?php
						}
					?>
			      	<h5><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h5>
			      	<div class="post_detail post_date">
			      		<span class="post_info_author">
			      			<?php
			      				$author_name = get_the_author();
			      			?>
			      			<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ); ?>"><span class="gravatar"><?php echo get_avatar( get_the_author_meta('email'), '60' ); ?></span><?php echo esc_html($author_name); ?></a>
			      		</span>
			      		<span class="post_info_date">
			      			<a href="<?php the_permalink(); ?>"><span class="last-updated-time"> UPDATED ON <time itemprop="dateModified" content="<?php the_modified_date('F jS, Y'); ?>"><?php the_modified_date('F j, Y'); ?></time> </span></a>
			      		</span>
				  	</div>
			   </div>
			   
			   <br class="clear"/>
	    	
	    		<?php
				    if(!empty($image_thumb))
				    {
				        $small_image_url = wp_get_attachment_image_src($image_id, 'grandnews_blog', true);
				        $image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
				?>
				
				    <div class="post_img">
				        <a href="<?php the_permalink(); ?>">
				        	<?php echo grandnews_get_post_featured_type_icon($post->ID); ?>
				        	<img <?php echo esc_html(grandnews_get_src_attr()); ?>="<?php echo esc_url($small_image_url[0]); ?>" alt="<?php echo esc_attr($image_alt); ?>" class="" style="width:<?php echo esc_attr($small_image_url[1]); ?>px;height:<?php echo esc_attr($small_image_url[2]); ?>px;"/>
					    </a>
				    </div>
				
				<?php
				    }
				?>
			   
			   	<br class="clear"/>
			      
			    <?php
			      	$tg_blog_display_full = kirki_get_option('tg_blog_display_full');
			      	
			      	if(!empty($tg_blog_display_full))
			      	{
			      		the_content();
			      	}
			      	else
			      	{
			      		the_excerpt();
			      	}
			    ?>
			    
			    <br class="clear"/>
			    
			    <div class="post_button_wrapper">
			    	<a class="readmore" href="<?php the_permalink(); ?>"><?php echo esc_html_e( 'Continue Reading', 'grandnews' ); ?></a>
			    </div>
			    
			    <div class="post_info_comment">
					<a href="<?php comments_link(); ?>"><i class="fa fa-commenting"></i><?php echo get_comments_number(); ?></a>
				</div>
				
				<?php 
					$post_view_count = grandnews_get_post_view($post->ID);
				
					if(!empty($post_view_count))
					{
				?>
				<div class="post_info_view">
				    <i class="fa fa-eye"></i><?php echo esc_html($post_view_count); ?>&nbsp;<?php echo esc_html_e( 'Views', 'grandnews' ); ?>
			    </div>
			    <?php
			    	}
			    	
			    	if( function_exists('zilla_likes') ) zilla_likes();
			    ?>
				
				<br class="clear"/><hr class="post_divider"/><hr class="post_divider double"/>
			</div>
			
	    </div>
	    
	</div>

</div>
<br class="clear"/>
<!-- End each blog post -->
<?php
} //End if first item
else
{
?>
<!-- Begin each blog post -->
<div id="post-<?php the_ID(); ?>" <?php post_class(); ?> <?php if($key%2==0) { ?>data-column="last"<?php } ?>>

	<div class="post_wrapper">
	    
	    <div class="post_content_wrapper">
	    
	    	<div class="post_header">
		    	<?php
				    if(!empty($image_thumb))
				    {
				       	$small_image_url = wp_get_attachment_image_src($image_id, 'grandnews_blog_thumb', true);
				?>
				
				   	<div class="post_img static small">
				   	    <a href="<?php the_permalink(); ?>">
				   	    	<?php echo grandnews_get_post_featured_type_icon($post->ID); ?>
				   	    	<img <?php echo esc_html(grandnews_get_src_attr()); ?>="<?php echo esc_url($small_image_url[0]); ?>" alt="" class="" style="width:<?php echo esc_attr($small_image_url[1]); ?>px;height:<?php echo esc_attr($small_image_url[2]); ?>px;"/>
				   	    </a>
				   	</div>
			   <?php
			   		}
			   	?>
			   	<br class="clear"/>
			   	
			   	<div class="post_header_title">
			      	<h5><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h5>
			      	<div class="post_detail post_date">
			      		<span class="post_info_author">
			      			<?php
			      				$author_name = get_the_author();
			      			?>
			      			<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ); ?>"><?php echo esc_html($author_name); ?></a>
			      		</span>
			      		<span class="post_info_date">
			      			<span class="last-updated-time"> UPDATED ON <time itemprop="dateModified" content="<?php the_modified_date('F jS, Y'); ?>"><?php the_modified_date('F j, Y'); ?></time> </span>
			      		</span>
			      		<?php if( function_exists('zilla_likes') ) zilla_likes(); ?>
				  	</div>
			   </div>
			      
			    <?php
			      	//echo '<p>'.grandnews_get_excerpt_by_id(get_the_ID()).'</p>';
			    ?>
			</div>
			
	    </div>
	    
	</div>

</div>
<!-- End each blog post -->
<?php
}

//incriment counter
$key++;
?>

<?php endwhile; endif; ?>

	    	<?php 
				if(!isset($paged) OR empty($paged))
				{
					$paged = 1;
				}
			?>
			
	    	<div class="pagination"><div class="pagination_page"><?php echo esc_html($paged); ?></div><?php posts_nav_link(' ', '<i class="fa fa-angle-double-left"></i>'.esc_html__('Newer Posts', 'grandnews' ), esc_html__('Older Posts', 'grandnews' ).'<i class="fa fa-angle-double-right"></i>'); ?></div>
    		
			</div>
    	
    		<div class="sidebar_wrapper">
    		
    			<div class="sidebar">
    			
    				<div class="content">

    					<?php 
						if (is_active_sidebar($page_sidebar)) { ?>
		    	    		<ul class="sidebar_widget">
		    	    			<?php dynamic_sidebar($page_sidebar); ?>
		    	    		</ul>
		    	    	<?php } ?>
    				
    				</div>
    		
    			</div>
    			<br class="clear"/>
    		</div>
    		
    	</div>
    <!-- End main content -->
	</div>
</div>
<?php get_footer(); ?>