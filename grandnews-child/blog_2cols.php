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

if(is_tag())
{
    $is_standard_wp_post = TRUE;
} 
elseif(is_category())
{
    $is_standard_wp_post = TRUE;
}
elseif(is_archive())
{
    $is_standard_wp_post = TRUE;
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
    <div class="inner two_cols">

    	<!-- Begin main content -->
    	<div class="inner_wrapper">

    			<div class="sidebar_content full_width two_cols">
<?php
//Include post search bar
get_template_part("/templates/template-search");

$key = 0;
if (have_posts()) : while (have_posts()) : the_post();
	$image_thumb = '';
	$key++;
								
	if(has_post_thumbnail(get_the_ID(), 'large'))
	{
	    $image_id = get_post_thumbnail_id(get_the_ID());
	    $image_thumb = wp_get_attachment_image_src($image_id, 'large', true);
	}
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
				       	$image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
				?>
				
				   	<div class="post_img static small">
				   	    <a href="<?php the_permalink(); ?>">
				   	    	<?php echo grandnews_get_post_featured_type_icon($post->ID); ?>
				   	    	<img <?php echo esc_html(grandnews_get_src_attr()); ?>="<?php echo esc_url($small_image_url[0]); ?>" alt="<?php echo esc_attr($image_alt); ?>" class="" style="width:<?php echo esc_attr($small_image_url[1]); ?>px;height:<?php echo esc_attr($small_image_url[2]); ?>px;"/>
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
			      			<a href="<?php the_permalink(); ?>"><span class="last-updated-time"> UPDATED ON <time itemprop="dateModified" content="<?php the_modified_date('F jS, Y'); ?>"><?php the_modified_date('F j, Y'); ?></time> </span></a>
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
<?php if($key%2==0) { ?><br class="clear"/><?php } ?>

<?php endwhile; endif; ?>

	    	<?php 
				if(!isset($paged) OR empty($paged))
				{
					$paged = 1;
				}
			?>
			
	    	<div class="pagination"><div class="pagination_page"><?php echo esc_html($paged); ?></div><?php posts_nav_link(' ', '<i class="fa fa-angle-double-left"></i>'.esc_html__('Newer Posts', 'grandnews' ), esc_html__('Older Posts', 'grandnews' ).'<i class="fa fa-angle-double-right"></i>'); ?></div>
    		
			</div>
    		
    	</div>
    <!-- End main content -->
	</div>
</div>
<?php get_footer(); ?>