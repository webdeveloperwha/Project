<?php
/**
 *
 * Enqueue Styles and Scripts
 *
 */


add_action('wp_enqueue_scripts', function () {

    // Child Theme CSS
    // wp_enqueue_style( 'google-font', 'https://fonts.google.com/specimen/Open+Sans' );

    wp_enqueue_style('wha-style',   get_stylesheet_directory_uri() . '/css/custom.css');
    wp_enqueue_script('wha-script', get_stylesheet_directory_uri() . '/js/custom.js', array('jquery'), null, true);
});





add_filter('use_block_editor_for_post', '__return_false');

add_filter('gutenberg_can_edit_post_type', '__return_false');

/*
Remove Date Meta Tags Output by Yoast SEO
 * Credit: Yoast development team
 * Last Tested: Mar 01 2017 using Yoast SEO 4.4 on WordPress 4.7.2
*/

add_filter('wpseo_og_article_published_time', '__return_false');
add_filter('wpseo_og_og_updated_time', '__return_false');

/********************************* Static Blog Sidebar new ***************************/

// Register and load the widget
function wpb_load_widgets()
{
    register_widget('stmstwo_widget');
}
add_action('widgets_init', 'wpb_load_widgets');

// Creating the widget
class stmstwo_widget extends WP_Widget
{

    function __construct()
    {
        parent::__construct(

        'stmstwo_widget',

        __('Static Widget', 'wpb_widget_domain') ,

        array(
            'description' => __('Sample widget based on WPBeginner Tutorial', 'wpb_widget_domain') ,
        ));
    }

    // Creating widget front-end
    public function widget($args, $instance)
    {
        $title = apply_filters('widget_title', $instance['title']);
        $description = apply_filters('widget_desc', $instance['description']);
        $btntext = apply_filters('widget_btntext', $instance['btntext']);
        $btnurl = apply_filters('widget_btnurl', $instance['btnurl']);
        $widgetimg = apply_filters('widget_widgetimg', $instance['widgetimg']);
        $activestate = apply_filters('widget_activestate', $instance['activestate']);
        $widgetdisable = apply_filters('widget_widgetdisable', $instance['widgetdisable']);

        if ($widgetdisable != 'yes')
        {
            echo '<li><div id="dynamboitwo" class="dynamboi sidebar-dynam sidebar-static">

	<div class="sidebar-dynam-inner">';

            if ($activestate == 'text')
            {
                echo '<h2>' . $title . '</h2>
	<p>' . $description . '</p>

	<a class="theme-btn btn-style-one" href="' . $btnurl . '">' . $btntext . '</a>';

            }
            else
            {

                echo '<img src="' . $widgetimg . '" alt="Get help today" />';

            }

            echo '</div>

	</div></li>';

        }
    }

    // Widget Backend
    public function form($instance)
    {

        if (isset($instance['title']))
        {
            $title = $instance['title'];
        }
        else
        {
			
			
			
			
			
            $title = __('New title', 'wpb_widget_domain');
        }

        //content
        if (isset($instance['description']))
        {
            $description = $instance['description'];
        }
        else
        {
            $description = __('New description', 'wpb_widget_domain');
        }

        //Button Text
        if (isset($instance['btntext']))
        {
            $btntext = $instance['btntext'];
        }
        else
        {
            $btntext = __('Button', 'wpb_widget_domain');
        }

        //Button URL
        if (isset($instance['btnurl']))
        {
            $btnurl = $instance['btnurl'];
        }
        else
        {
            $btnurl = __('', 'wpb_widget_domain');
        }

        //Widget Image
        if (isset($instance['widgetimg']))
        {
            $widgetimg = $instance['widgetimg'];
        }
        else
        {
            $widgetimg = __('', 'wpb_widget_domain');
        }

        //Widget disable
        if (isset($instance['widgetdisable']))
        {
            $widgetdisable = $instance['widgetdisable'];
        }
        else
        {
            $widgetdisable = __('', 'wpb_widget_domain');
        }

        //Active state
        if (isset($instance['activestate']))
        {
            $activestate = $instance['activestate'];
        }
        else
        {
            $activestate = __('text', 'wpb_widget_domain');
        }

        // Widget admin form
        
?>
<p>
<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
</p>

<p>
<label for="<?php echo $this->get_field_id('description'); ?>"><?php _e('Description:'); ?></label> 
<textarea class="widefat" id="<?php echo $this->get_field_id('description'); ?>" name="<?php echo $this->get_field_name('description'); ?>"><?php echo esc_attr($description); ?></textarea>
</p>

<p>
<label for="<?php echo $this->get_field_id('btntext'); ?>"><?php _e('Button Title:'); ?></label> 
<input class="widefat" id="<?php echo $this->get_field_id('btntext'); ?>" name="<?php echo $this->get_field_name('btntext'); ?>" type="text" value="<?php echo esc_attr($btntext); ?>" />
</p>

<p>
<label for="<?php echo $this->get_field_id('btnurl'); ?>"><?php _e('Button URL:'); ?></label> 
<input class="widefat" id="<?php echo $this->get_field_id('btnurl'); ?>" name="<?php echo $this->get_field_name('btnurl'); ?>" type="text" value="<?php echo esc_attr($btnurl); ?>" />
</p>

<p>
<label for="<?php echo $this->get_field_id('widgetimg'); ?>"><?php _e('Widget Image:'); ?></label> 
<input class="widefat" id="<?php echo $this->get_field_id('widgetimg'); ?>" name="<?php echo $this->get_field_name('widgetimg'); ?>" type="text" value="<?php echo esc_attr($widgetimg); ?>" />
</p>

<p>
<label for="<?php echo $this->get_field_id('activestate'); ?>"><?php _e('Widget Type:'); ?></label> 
<input class="widefat" name="<?php echo $this->get_field_name('activestate'); ?>" type="radio" value="text" <?php echo (esc_attr($activestate) == 'text') ? 'checked' : '' ?> /> Text Only
<input class="widefat" name="<?php echo $this->get_field_name('activestate'); ?>" type="radio" value="image" <?php echo (esc_attr($activestate) == 'image') ? 'checked' : '' ?> /> Image Only
</p>
<p>
<label for="<?php echo $this->get_field_id('widgetdisable'); ?>"><?php _e('Disable Widget:'); ?></label> 
<input class="widefat" id="<?php echo $this->get_field_id('widgetdisable'); ?>" name="<?php echo $this->get_field_name('widgetdisable'); ?>" type="checkbox" value="yes" <?php echo (esc_attr($widgetdisable) == 'yes') ? 'checked' : '' ?> />
</p>


<?php
    }

    // Updating widget replacing old instances with new
    public function update($new_instance, $old_instance)
    {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        $instance['description'] = (!empty($new_instance['description'])) ? strip_tags($new_instance['description']) : '';
        $instance['btntext'] = (!empty($new_instance['btntext'])) ? strip_tags($new_instance['btntext']) : '';
        $instance['btnurl'] = (!empty($new_instance['btnurl'])) ? strip_tags($new_instance['btnurl']) : '';
        $instance['widgetimg'] = (!empty($new_instance['widgetimg'])) ? strip_tags($new_instance['widgetimg']) : '';
        $instance['widgetdisable'] = (!empty($new_instance['widgetdisable'])) ? strip_tags($new_instance['widgetdisable']) : '';
        $instance['activestate'] = (!empty($new_instance['activestate'])) ? strip_tags($new_instance['activestate']) : '';
        return $instance;
    }
} // Class stmstwo_widget ends here


/************************* Sticky blog Sidebar  new  ******************************/

// Register and load the widget
function wpb_load_widget()
{
    register_widget('stms_widget');
}
add_action('widgets_init', 'wpb_load_widget');

// Creating the widget
class stms_widget extends WP_Widget
{

    function __construct()
    {
        parent::__construct(


        'stms_widget',

        __('Sticky Widget', 'wpb_widget_domain') ,

        array(
            'description' => __('Sample widget based on WPBeginner Tutorial', 'wpb_widget_domain') ,
        ));
    }

    // Creating widget front-end
    public function widget($args, $instance)
    {
        $title = apply_filters('widget_title', $instance['title']);
        $description = apply_filters('widget_desc', $instance['description']);
        $btntext = apply_filters('widget_btntext', $instance['btntext']);
        $btnurl = apply_filters('widget_btnurl', $instance['btnurl']);
        $widgetimg = apply_filters('widget_widgetimg', $instance['widgetimg']);
        $activestate = apply_filters('widget_activestate', $instance['activestate']);
        $widgetdisable = apply_filters('widget_widgetdisable', $instance['widgetdisable']);

        /* echo $args['before_widget'];
        if ( ! empty( $title ) )
        echo $args['before_title'] . $title . $args['after_title'];
        
        echo __( 'Hello, World!', 'wpb_widget_domain' );
        echo $args['after_widget']; */
        if ($widgetdisable != 'yes')
        {
            echo '<li><div id="dynamboi" class="dynamboi sidebar-dynam">

	<div class="sidebar-dynam-inner">';

            if ($activestate == 'text')
            {
                echo '<h2>' . $title . '</h2>
	<p>' . $description . '</p>

	<a class="theme-btn btn-style-one" href="' . $btnurl . '">' . $btntext . '</a>';

            }
            else
            {

                echo '<img src="' . $widgetimg . '" alt="Get help today" />';

            }

            echo '</div>

	</div></li>';

        }
    }

    // Widget Backend
    public function form($instance)
    {

        if (isset($instance['title']))
        {
            $title = $instance['title'];
        }
        else
        {
            $title = __('New title', 'wpb_widget_domain');
        }

        //content
        if (isset($instance['description']))
        {
            $description = $instance['description'];
        }
        else
        {
            $description = __('New description', 'wpb_widget_domain');
        }

        //Button Text
        if (isset($instance['btntext']))
        {
            $btntext = $instance['btntext'];
        }
        else
        {
            $btntext = __('Button', 'wpb_widget_domain');
        }

        //Button URL
        if (isset($instance['btnurl']))
        {
            $btnurl = $instance['btnurl'];
        }
        else
        {
            $btnurl = __('', 'wpb_widget_domain');
        }

        //Widget Image
        if (isset($instance['widgetimg']))
        {
            $widgetimg = $instance['widgetimg'];
        }
        else
        {
            $widgetimg = __('', 'wpb_widget_domain');
        }

        //Widget disable
        if (isset($instance['widgetdisable']))
        {
            $widgetdisable = $instance['widgetdisable'];
        }
        else
        {
            $widgetdisable = __('', 'wpb_widget_domain');
        }

        //Active state
        if (isset($instance['activestate']))
        {
            $activestate = $instance['activestate'];
        }
        else
        {
            $activestate = __('text', 'wpb_widget_domain');
        }

        // Widget admin form
        
?>
<p>
<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
</p>

<p>
<label for="<?php echo $this->get_field_id('description'); ?>"><?php _e('Description:'); ?></label> 
<textarea class="widefat" id="<?php echo $this->get_field_id('description'); ?>" name="<?php echo $this->get_field_name('description'); ?>"><?php echo esc_attr($description); ?></textarea>
</p>

<p>
<label for="<?php echo $this->get_field_id('btntext'); ?>"><?php _e('Button Title:'); ?></label> 
<input class="widefat" id="<?php echo $this->get_field_id('btntext'); ?>" name="<?php echo $this->get_field_name('btntext'); ?>" type="text" value="<?php echo esc_attr($btntext); ?>" />
</p>

<p>
<label for="<?php echo $this->get_field_id('btnurl'); ?>"><?php _e('Button URL:'); ?></label> 
<input class="widefat" id="<?php echo $this->get_field_id('btnurl'); ?>" name="<?php echo $this->get_field_name('btnurl'); ?>" type="text" value="<?php echo esc_attr($btnurl); ?>" />
</p>

<p>
<label for="<?php echo $this->get_field_id('widgetimg'); ?>"><?php _e('Widget Image:'); ?></label> 
<input class="widefat" id="<?php echo $this->get_field_id('widgetimg'); ?>" name="<?php echo $this->get_field_name('widgetimg'); ?>" type="text" value="<?php echo esc_attr($widgetimg); ?>" />
</p>

<p>
<label for="<?php echo $this->get_field_id('activestate'); ?>"><?php _e('Widget Type:'); ?></label> 
<input class="widefat" name="<?php echo $this->get_field_name('activestate'); ?>" type="radio" value="text" <?php echo (esc_attr($activestate) == 'text') ? 'checked' : '' ?> /> Text Only
<input class="widefat" name="<?php echo $this->get_field_name('activestate'); ?>" type="radio" value="image" <?php echo (esc_attr($activestate) == 'image') ? 'checked' : '' ?> /> Image Only
</p>
<p>
<label for="<?php echo $this->get_field_id('widgetdisable'); ?>"><?php _e('Disable Widget:'); ?></label> 
<input class="widefat" id="<?php echo $this->get_field_id('widgetdisable'); ?>" name="<?php echo $this->get_field_name('widgetdisable'); ?>" type="checkbox" value="yes" <?php echo (esc_attr($widgetdisable) == 'yes') ? 'checked' : '' ?> />
</p>


<?php
    }

    // Updating widget replacing old instances with new
    public function update($new_instance, $old_instance)
    {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        $instance['description'] = (!empty($new_instance['description'])) ? strip_tags($new_instance['description']) : '';
        $instance['btntext'] = (!empty($new_instance['btntext'])) ? strip_tags($new_instance['btntext']) : '';
        $instance['btnurl'] = (!empty($new_instance['btnurl'])) ? strip_tags($new_instance['btnurl']) : '';
        $instance['widgetimg'] = (!empty($new_instance['widgetimg'])) ? strip_tags($new_instance['widgetimg']) : '';
        $instance['widgetdisable'] = (!empty($new_instance['widgetdisable'])) ? strip_tags($new_instance['widgetdisable']) : '';
        $instance['activestate'] = (!empty($new_instance['activestate'])) ? strip_tags($new_instance['activestate']) : '';
        return $instance;
    }
} // Class stms_widget ends here


/************************* Horizontal  Banner widget  ******************************/

// Register and load the widget
function wpb_load_widgetq()
{
    register_widget('stms_widget_hori');
}
add_action('widgets_init', 'wpb_load_widgetq');

// Creating the widget
class stms_widget_hori extends WP_Widget
{

    function __construct()
    {
        parent::__construct(

        'stms_widget_hori',

        __('Sticky Top Bar', 'wpb_widget_domain') ,

        array(
            'description' => __('Sample widget based on WPBeginner Tutorial', 'wpb_widget_domain') ,
        ));
    }
    // Creating widget front-end
    public function widget($args, $instance)
    {
        $title = apply_filters('widget_title', $instance['title']);
        $btntext = apply_filters('widget_btntext', $instance['btntext']);
		$btnurl = apply_filters('widget_btnurl', $instance['btnurl']);
        $btntext_new = apply_filters('widget_btntext', $instance['btntext_new']);
        $activestate = apply_filters('widget_activestate', $instance['activestate']);
        $widgetdisable = apply_filters('widget_widgetdisable', $instance['widgetdisable']);

        if ($widgetdisable != 'yes')
        {
            echo '<section class="top-header">
	<div class="top-wrap">
		<div class="fit-i">
			<img src="https://playadelcarmen.com/blog/wp-content/uploads/wedding_icon3.png" style="width: 54px !important; vertical-align: middle;" alt="playadelcarmen" />
		</div>';
            echo '<p>' . $title . '</p>
	<div class="top-btn-wrap">
		<div class="top-btn">
			<a class="btn" href="' . $btnurl . '">' . $btntext . '</a>
		</div>
		<div class="top-btn">
			<a class="btn sec-btn" onclick="hideExpression();" href="javascript:;">' . $btntext_new . '</a>
		</div>';

            echo '</div>
	</div>
	</section>';

        }
    }

    // Widget Backend
    public function form($instance)
    {

        if (isset($instance['title']))
        {
            $title = $instance['title'];
        }
        else
        {
            $title = __('New title', 'wpb_widget_domain');
        }

        //Button Text
        if (isset($instance['btntext']))
        {
            $btntext = $instance['btntext'];
        }
        else
        {
            $btntext = __('Accept Button Label', 'wpb_widget_domain');
        }

        //Button Text
        if (isset($instance['btntext_new']))
        {
            $btntext_new = $instance['btntext_new'];
        }
        else
        {
            $btntext_new = __('Reject Button Label', 'wpb_widget_domain');
        }

		//Button URL
        if (isset($instance['btnurl']))
        {
            $btnurl = $instance['btnurl'];
        }
        else
        {
            $btnurl = __('', 'wpb_widget_domain');
        }
		
        //Widget disable
        if (isset($instance['widgetdisable']))
        {
            $widgetdisable = $instance['widgetdisable'];
        }
        else
        {
            $widgetdisable = __('', 'wpb_widget_domain');
        }

        //Active state
        if (isset($instance['activestate']))
        {
            $activestate = $instance['activestate'];
        }
        else
        {
            $activestate = __('text', 'wpb_widget_domain');
        }

        // Widget admin form
        
?>
<p>
<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
</p>

<p>
<label for="<?php echo $this->get_field_id('btntext'); ?>"><?php _e('Button Title YES:'); ?></label> 
<input class="widefat" id="<?php echo $this->get_field_id('btntext'); ?>" name="<?php echo $this->get_field_name('btntext'); ?>" type="text" value="<?php echo esc_attr($btntext); ?>" />
</p>

<p>
<label for="<?php echo $this->get_field_id('btnurl'); ?>"><?php _e('Button URL:'); ?></label> 
<input class="widefat" id="<?php echo $this->get_field_id('btnurl'); ?>" name="<?php echo $this->get_field_name('btnurl'); ?>" type="text" value="<?php echo esc_attr($btnurl); ?>" />
</p>

<p>
<label for="<?php echo $this->get_field_id('btntext_new'); ?>"> <?php _e('Button Title NO:'); ?></label> 
<input class="widefat" id="<?php echo $this->get_field_id('btntext_new'); ?>" name="<?php echo $this->get_field_name('btntext_new'); ?>" type="text" value="<?php echo esc_attr($btntext_new); ?>" />
</p>

<p>
<label for="<?php echo $this->get_field_id('widgetdisable'); ?>"><?php _e('Disable Widget:'); ?></label> 
<input class="widefat" id="<?php echo $this->get_field_id('widgetdisable'); ?>" name="<?php echo $this->get_field_name('widgetdisable'); ?>" type="checkbox" value="yes" <?php echo (esc_attr($widgetdisable) == 'yes') ? 'checked' : '' ?> />
</p>

<?php
    }

    // Updating widget replacing old instances with new
    public function update($new_instance, $old_instance)
    {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        $instance['btntext'] = (!empty($new_instance['btntext'])) ? strip_tags($new_instance['btntext']) : '';
		$instance['btnurl'] = (!empty($new_instance['btnurl'])) ? strip_tags($new_instance['btnurl']) : '';
        $instance['btntext_new'] = (!empty($new_instance['btntext_new'])) ? strip_tags($new_instance['btntext_new']) : '';
        $instance['widgetdisable'] = (!empty($new_instance['widgetdisable'])) ? strip_tags($new_instance['widgetdisable']) : '';
        $instance['activestate'] = (!empty($new_instance['activestate'])) ? strip_tags($new_instance['activestate']) : '';
        return $instance;
    }
} // Class stms_widget ends here




/**
 * ------------------------------------
 * Add Social Networks Buttons on Posts
 * ------------------------------------
 */

add_shortcode('social-sharing', function () {

    $html       = '';
    $class_icon = '';
    $class_item = '';

    if ( get_post_type() === 'post' ):

        $html  = '<div class="social-sharing-wrp"><ul>';

        if (have_rows('social_networks')):

            while ( have_rows('social_networks') ) : the_row();

                $arr_icons = [
                   1 => 'swp_pinterest_icon',
                   2 => 'swp_twitter_icon',
                   3 => 'swp_facebook_icon',
                   4 => 'swp_email_icon',
                   5 => 'swp_whatsapp_icon',
                   6 => 'swp_linkedin_icon',
                   7 => 'swp_viber_icon',
                   8 => 'swp_blogger_icon',
                   9 => 'swp_mix_icon',
                   10 => 'swp_buffer_icon',
                   11 => 'swp_evernote_icon',
                   12 => 'swp_print_icon',
                   13 => 'swp_tumblr_icon',
                ];

                foreach ( $arr_icons as $key => $val) {

                    if( $key == get_sub_field('icon_social') ) {
                        $class_icon = $val;
                        switch ( $key ) {
                            case 1: $class_item = 'bg_pinterest'; break;
                            case 2: $class_item = 'bg_twitter'; break;
                            case 3: $class_item = 'bg_facebook'; break;
                            case 4: $class_item = 'bg_email'; break;
                            case 5: $class_item = 'bg_whatsapp'; break;
                            case 6: $class_item = 'bg_linkedin'; break;
                            case 7: $class_item = 'bg_viber'; break;
                            case 8: $class_item = 'bg_blogger'; break;
                            case 9: $class_item = 'bg_mix_icon'; break;
                            case 10: $class_item = 'bg_buffer_icon'; break;
                            case 11: $class_item = 'bg_evernote_icon'; break;
                            case 12: $class_item = 'bg_print_icon'; break;
                            case 13: $class_item = 'bg_tumblr_icon'; break;
                            default: $class_item = 'bg_default'; break;
                        }
                    }
                }

                $html .= '<li>
                             <a class="'.$class_item.'" href="'.get_sub_field('url_social').'" target="_blank">
                             <i class="sw '. $class_icon .'"></i>
                             '.get_sub_field('text_social').'
                             </a>                        
                          </li>';
            endwhile;

        endif;

        $html .= '</ul></div>';

    endif;

    return $html;
});

// Add button in visual editor
function true_add_mce_button() {
    if ( !current_user_can( 'edit_posts' ) && !current_user_can( 'edit_pages' ) ) {
        return;
    }
    if ( 'true' == get_user_option( 'rich_editing' ) ) {
        add_filter( 'mce_external_plugins', 'true_add_tinymce_script' );
        add_filter( 'mce_buttons', 'true_register_mce_button' );
    }
}
add_action('admin_head', 'true_add_mce_button');

function true_add_tinymce_script( $plugin_array ) {
    $plugin_array['true_mce_button'] = get_stylesheet_directory_uri() .'/js/custom.js';
    return $plugin_array;
}

function true_register_mce_button( $buttons ) {
    array_push( $buttons, 'true_mce_button' );
    return $buttons;
}

add_action( 'admin_enqueue_scripts', function () {
    wp_enqueue_style('wha-admin-style',   get_stylesheet_directory_uri() . '/css/custom.css');
});





























