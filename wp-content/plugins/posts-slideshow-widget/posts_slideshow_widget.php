
<?php
/*
  Plugin Name: Posts Slideshow Widget
  Description: This widget plugin displays recent posts as a tiny slider. You can configure many options like maximum posts, color of buttons etc.
  Author: Bilal
  Version: 1
 */

// Creating the widget 
class posts_slideshow_widget extends WP_Widget {

    function __construct() {
        parent::__construct(
                'posts_slideshow_widget', __('Posts Slideshow', 'posts_slideshow_widget_domain'), array('description' => __(
                    'This widget will display recent posts as slides.', 'posts_slideshow_widget_domain'
            ),
                )
        );
    }

    public function widget($args, $instance) {

        wp_enqueue_style('posts_slideshow_style', plugins_url('includes/css/jquery.bxslider.css', __FILE__));
        wp_enqueue_script('posts_slideshow_script', plugins_url('includes/js/jquery.bxslider.min.js', __FILE__));
        wp_enqueue_script('posts_slideshow_slider_script', plugins_url('includes/js/slider.js', __FILE__));

        $psw_title = apply_filters('widget_title', $instance['psw_title']);
        $psw_categories = $instance['psw_categories'];
        $psw_post_types = $instance['psw_post_types'];
        $psw_no_of_job_posts = $instance['psw_no_of_job_posts'];
        $psw_excerpt = $instance['psw_excerpt'];
        $psw_controls = $instance['psw_controls'];
        $psw_auto_transition = $instance['psw_auto_transition'];

        echo $args['before_widget'];

        if (!empty($psw_title)) {
            echo $args['before_title'] . $psw_title . $args['after_title'];
        }

        $args = array(
            'posts_per_page' => $psw_no_of_job_posts,
            'offset' => 0,
            'category' => $psw_categories,
            'orderby' => 'post_date',
            'order' => 'DESC',
            'include' => '',
            'exclude' => '',
            'meta_key' => '',
            'meta_value' => '',
            'post_type' => $psw_post_types,
            'post_mime_type' => '',
            'post_parent' => '',
            'post_status' => 'publish',
            'suppress_filters' => true);

        $posts_array = get_posts($args);

        echo '<div class="psw-slider-wrapper-' . uniqid() . '">';
        foreach ($posts_array as $post) {

            echo '<div class="slide">';
            echo '<h4><a href="' . $post->guid . '">';
            echo $post->post_name;
            echo '</a></h4>';
            $content = (strlen(strip_tags($post->post_content)) > $psw_excerpt) ?
                    strip_tags(substr($post->post_content, 0, $psw_excerpt)) .
                    '...<a href="' . $post->guid . '">read more</a>' :
                    strip_tags($post->post_content);
            echo $content;
            echo '</div>';
        }
        echo '</div>';
        echo '<div style="display: none;" class="psw-slider-opts" data-controls="' . $psw_controls .
        '" data-auto="' . $psw_auto_transition . '"></div>';

        echo $args['after_widget'];
    }

    public function form($instance) {

        if ($instance) {
            $psw_no_of_job_posts = esc_attr($instance['psw_no_of_job_posts']);
            $psw_categories = esc_attr($instance['psw_categories']);
            $psw_post_types = esc_attr($instance['psw_post_types']);
            $psw_title = esc_attr($instance['psw_title']);
            $psw_excerpt = esc_attr($instance['psw_excerpt']);
            $psw_controls = esc_attr($instance['psw_controls']);
            $psw_auto_transition = esc_attr($instance['psw_auto_transition']);
        } else {
            $psw_no_of_job_posts = 5;
            $psw_title = __('Recent Posts', 'psw_title');
            $psw_categories = 0;
            $psw_post_types = 0;
            $psw_excerpt = 100;
            $psw_controls = 0;
            $psw_auto_transition = 1;
        }

        $get_terms_args = array(
            'type' => 'post',
            'child_of' => 0,
            'parent' => '',
            'orderby' => 'name',
            'order' => 'ASC',
            'hide_empty' => 1,
            'hierarchical' => 1,
            'exclude' => '',
            'include' => '',
            'number' => '',
            'taxonomy' => 'category',
            'pad_counts' => false
        );
        
        $get_post_types_args = array(
            'public' => true,
            //'_builtin' => false,
        );
        
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('psw_title'); ?>"><?php _e('Title:'); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('psw_title'); ?>" 
                   name="<?php echo $this->get_field_name('psw_title'); ?>" type="text" 
                   value="<?php echo esc_attr($psw_title); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('psw_categories'); ?>"><?php _e('Category'); ?></label>
            <select id="<?php echo $this->get_field_id('psw_categories'); ?>" name="<?php echo $this->get_field_name('psw_categories'); ?>" class="widefat">
                <?php foreach (get_categories($get_terms_args) as $term) { ?>
                    <option <?php selected($instance['psw_categories'], $term->slug); ?> value="<?php echo $term->slug; ?>"><?php echo $term->slug; ?></option>
                <?php } ?>      
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('psw_post_types'); ?>"><?php _e('Post Type'); ?></label>
            <select id="<?php echo $this->get_field_id('psw_post_types'); ?>" name="<?php echo $this->get_field_name('psw_post_types'); ?>" class="widefat">
                <?php foreach (get_post_types($get_post_types_args, 'names', 'and') as $post_type) { ?>
                <?php print_r($ptype); ?>
                    <option <?php selected($instance['psw_post_types'], $post_type); ?> value="<?php echo $post_type; ?>"><?php echo $post_type; ?></option>
                <?php } ?>      
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('psw_no_of_job_posts'); ?>"><?php _e('No of Posts:'); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('psw_no_of_job_posts'); ?>" 
                   name="<?php echo $this->get_field_name('psw_no_of_job_posts'); ?>" 
                   type="text" value="<?php echo esc_attr($psw_no_of_job_posts); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('psw_excerpt'); ?>"><?php _e('Post Excerpt:'); ?></label> 
            <input id="<?php echo $this->get_field_id('psw_excerpt'); ?>" 
                   name="<?php echo $this->get_field_name('psw_excerpt'); ?>" 
                   type="text" value="<?php echo esc_attr($psw_excerpt); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('psw_controls'); ?>"><?php _e('Navigation Controls:'); ?></label> 
            <input id="<?php echo $this->get_field_id('psw_controls'); ?>" 
                   name="<?php echo $this->get_field_name('psw_controls'); ?>" type="checkbox" 
                   value="1" <?php checked('1', $psw_controls); ?> />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('psw_auto_transition'); ?>"><?php _e('Auto Transition:'); ?></label> 
            <input id="<?php echo $this->get_field_id('psw_auto_transition'); ?>" 
                   name="<?php echo $this->get_field_name('psw_auto_transition'); ?>" type="checkbox" 
                   value="1" <?php checked('1', $psw_auto_transition); ?> />
        </p>
        <?php
    }

    public function update($new_instance, $old_instance) {

        $instance = $old_instance;

        $instance['psw_no_of_job_posts'] = strip_tags($new_instance['psw_no_of_job_posts']);
        $instance['psw_title'] = strip_tags($new_instance['psw_title']);
        $instance['psw_categories'] = strip_tags($new_instance['psw_categories']);
        $instance['psw_post_types'] = strip_tags($new_instance['psw_post_types']);
        $instance['psw_excerpt'] = strip_tags($new_instance['psw_excerpt']);
        $instance['psw_controls'] = strip_tags($new_instance['psw_controls']);
        $instance['psw_auto_transition'] = strip_tags($new_instance['psw_auto_transition']);
        return $instance;
    }

}

function posts_slideshow_load_widget() {
    register_widget('posts_slideshow_widget');
}

add_action('widgets_init', 'posts_slideshow_load_widget');

