<?php
/**
 * The main template file for display error page.
 *
 * @package WordPress
*/


get_header(); 
?>

<!-- Begin content -->
<div id="page_content_wrapper">

    <div class="inner">
    
    	<!-- Begin main content -->
    	<div class="inner_wrapper">
    	
    		<div class="error_box">
				<p class="error_type">404</p>
			</div>
			<p class="error_text"><?php esc_html_e( 'Not Found!', 'grandnews' ); ?></p>
    	
	    	<div class="search_form_wrapper">
	    		<div class="content">
	    	    	<?php esc_html_e( "We're sorry, the page you have looked for does not exist in our content!", 'grandnews' ); ?><br/>
	    	    	<?php esc_html_e( "Perhaps you would like to go to our homepage or try searching below.", 'grandnews' ); ?>
	    		</div>
	    	    
	    	    <form class="searchform" role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
			    	<input style="width:100%" type="text" class="field searchform-s" name="s" value="<?php the_search_query(); ?>" placeholder="<?php esc_html_e( 'Type to search and hit enter...', 'grandnews' ); ?>">
			    </form>
    		</div>
    		<br/>
	    	
	    	<h5><?php esc_html_e( 'Or try to browse our latest posts instead?', 'grandnews' ); ?></h5><br/>
	    		
	    		<div class="sidebar_content full_width three_cols">
	    		<?php
				
				$query_string ="posts_per_page=6&post_type=post&paged=$paged";
				query_posts($query_string);
				$key = 0;
				
				if (have_posts()) : while (have_posts()) : the_post();
				
					$key++;	
					$image_thumb = '';
												
					if(has_post_thumbnail(get_the_ID(), 'large'))
					{
					    $image_id = get_post_thumbnail_id(get_the_ID());
					    $image_thumb = wp_get_attachment_image_src($image_id, 'large', true);
					}
				?>
				
				<!-- Begin each blog post -->
				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?> <?php if($key%3==0) { ?>data-column="last"<?php } ?>>
				
					<div class="post_wrapper">
					    
					    <div class="post_content_wrapper">
					    
					    	<div class="post_header">
						    	<?php
								    if(!empty($image_thumb))
								    {
								       	$small_image_url = wp_get_attachment_image_src($image_id, 'grandnews_blog_thumb', true);
								?>
								
								   	<div class="post_img static">
								   	    <a href="<?php the_permalink(); ?>">
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
							      			<a href="<?php the_permalink(); ?>"><span class="last-updated-time"> UPDATED ON <time itemprop="dateModified" content="<?php the_modified_date('F jS, Y'); ?>"><?php the_modified_date('F j, Y'); ?></time> </span></a>
							      		</span>
								  	</div>
							   </div>
							</div>
							
					    </div>
					    
					</div>
				
				</div>
				<!-- End each blog post -->
				
				<?php 
					if($key%3==0)
					{
						echo '<br class="clear"/>';
					}
				?>
				<?php endwhile; endif; ?>
	    		</div>
    		</div>
    		
    	</div>
    	
</div>
<?php get_footer(); ?>