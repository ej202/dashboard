<?php

// Enqueue parent and child theme styles, including Font Awesome
function kadence_child_enqueue_styles() {
    $parent_style = 'kadence-style';
    wp_enqueue_style($parent_style, get_template_directory_uri() . '/style.css');
    wp_enqueue_style('kadence-child-style', get_stylesheet_directory_uri() . '/assets/css/style.css', array($parent_style), wp_get_theme()->get('Version'));
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css');
    wp_enqueue_style('navigation-style', get_stylesheet_directory_uri() . '/assets/css/navigation.css', array('kadence-child-style'), wp_get_theme()->get('Version'));
    wp_enqueue_style('today-style', get_stylesheet_directory_uri() . '/assets/css/today.css', array('kadence-child-style'), wp_get_theme()->get('Version'));
    wp_enqueue_style('modals-style', get_stylesheet_directory_uri() . '/assets/css/modals.css', array('kadence-child-style'), wp_get_theme()->get('Version'));
    wp_enqueue_style('breathe-style', get_stylesheet_directory_uri() . '/assets/css/breathe.css', array('kadence-child-style'), wp_get_theme()->get('Version'));
    wp_enqueue_style('now-style', get_stylesheet_directory_uri() . '/assets/css/now.css', array('kadence-child-style'), wp_get_theme()->get('Version'));
    wp_enqueue_style('meditate-style', get_stylesheet_directory_uri() . '/assets/css/meditate.css', array('kadence-child-style'), wp_get_theme()->get('Version'));
    wp_enqueue_style('sleep-style', get_stylesheet_directory_uri() . '/assets/css/sleep.css', array('kadence-child-style'), wp_get_theme()->get('Version'));
    wp_enqueue_style('music-style', get_stylesheet_directory_uri() . '/assets/css/music.css', array('kadence-child-style'), wp_get_theme()->get('Version'));
    wp_enqueue_style('more-style', get_stylesheet_directory_uri() . '/assets/css/more.css', array('kadence-child-style'), wp_get_theme()->get('Version'));
}
add_action('wp_enqueue_scripts', 'kadence_child_enqueue_styles');

// Enqueue custom scripts
function enqueue_custom_scripts() {
    wp_enqueue_script('jquery');
    wp_enqueue_script('custom-js', get_stylesheet_directory_uri() . '/assets/js/custom.js', array(), '1.0', true);
    wp_script_add_data('custom-js', 'type', 'module');
}
add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');

// Register custom REST API endpoints
function register_custom_api_endpoints() {
    register_rest_route('custom/v1', '/content/(?P<id>[a-zA-Z0-9-_]+)', array(
        'methods' => 'GET',
        'callback' => 'get_custom_content',
        'permission_callback' => '__return_true',
    ));
}
add_action('rest_api_init', 'register_custom_api_endpoints');

// Callback function for custom REST API
function get_custom_content($data) {
    $id = sanitize_text_field($data['id']);
    // Sample data for content
    $content = array(
        'home' => array(
            'player' => '
                <div class="player-container">
                    <div class="play-pause-button" id="playPauseButton">
                        <i class="fa fa-play" id="playPauseIcon"></i>
                    </div>
                    <div class="options">
                        <button id="selectDurationButton">Select Duration</button>
                        <button id="selectVoiceButton">Select Voice</button>
                    </div>
                </div>',
            'column1' => '<p>Additional content can go here for column 1.</p>',
            'column2' => '<p>Additional content can go here for column 2.</p>',
        ),
        'breathe' => array(
            'column1' => '<p>Breathe content for column 1.</p>',
            'column2' => '<p>Breathe content for column 2.</p>',
        ),
        'meditate' => array(
            'column1' => '<p>Meditate content for column 1.</p>',
            'column2' => '<p>Meditate content for column 2.</p>',
        ),
        'sleep' => array(
            'column1' => '<p>Sleep content for column 1.</p>',
            'column2' => '<p>Sleep content for column 2.</p>',
        ),
        'music' => array(
            'column1' => '<p>Music content for column 1.</p>',
            'column2' => '<p>Music content for column 2.</p>',
        ),
        'app' => array(
            'column1' => '<p>App content for column 1.</p>',
            'column2' => '<p>App content for column 2.</p>',
        ),
    );

    if (!isset($content[$id])) {
        return new WP_Error('no_content', 'Invalid content', array('status' => 404));
    }

    return rest_ensure_response($content[$id]);
}

// Register Custom Post Type for Daily Content and Today's Goals
function create_daily_content_post_type() {
    register_post_type('daily_content',
        array(
            'labels' => array(
                'name' => __('Daily Content'),
                'singular_name' => __('Daily Content')
            ),
            'public' => true,
            'has_archive' => true,
            'supports' => array('title', 'editor', 'custom-fields', 'page-attributes'), // Ensure 'page-attributes' is included
            'show_in_rest' => true, // Enable Gutenberg editor support
        )
    );
    register_post_type('today_goals',
        array(
            'labels' => array(
                'name' => __('Today\'s Goals'),
                'singular_name' => __('Today\'s Goal')
            ),
            'public' => true,
            'has_archive' => true,
            'supports' => array('title', 'editor', 'custom-fields'), // Ensure 'custom-fields' is included
            'show_in_rest' => true, // Enable Gutenberg editor support
        )
    );
}
add_action('init', 'create_daily_content_post_type');

// Add ACF Fields for Daily Content and Today's Goals
if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
    'key' => 'group_1',
    'title' => 'Daily Content Fields',
    'fields' => array(
        array(
            'key' => 'field_1',
            'label' => 'Subtitle',
            'name' => 'subtitle',
            'type' => 'text',
            'instructions' => '',
            'required' => 1,
        ),
        array(
            'key' => 'field_2',
            'label' => 'Duration',
            'name' => 'duration',
            'type' => 'text',
            'instructions' => 'Enter the duration to complete the lesson',
            'required' => 1,
        ),
        array(
            'key' => 'field_3',
            'label' => 'Reward Value',
            'name' => 'reward_value',
            'type' => 'number',
            'instructions' => 'Enter the reward points for completing this lesson',
            'required' => 1,
        ),
        array(
            'key' => 'field_5',
            'label' => 'Lesson Parts',
            'name' => 'lesson_parts',
            'type' => 'repeater',
            'instructions' => 'Add parts of the lesson',
            'required' => 1,
            'sub_fields' => array(
                array(
                    'key' => 'field_5a',
                    'label' => 'Part Content',
                    'name' => 'part_content',
                    'type' => 'wysiwyg',
                    'instructions' => 'Enter the content for this part of the lesson',
                    'required' => 1,
                ),
                array(
                    'key' => 'field_5b',
                    'label' => 'Button Text',
                    'name' => 'button_text',
                    'type' => 'text',
                    'instructions' => 'Enter the text for the navigation button for this part',
                    'required' => 1,
                ),
            ),
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'daily_content',
            ),
        ),
    ),
));

acf_add_local_field_group(array(
    'key' => 'group_2',
    'title' => 'Today\'s Goals Fields',
    'fields' => array(
        array(
            'key' => 'field_6',
            'label' => 'Goal Content',
            'name' => 'goal_content',
            'type' => 'wysiwyg',
            'instructions' => 'Enter the content for this goal',
            'required' => 1,
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'today_goals',
            ),
        ),
    ),
));

acf_add_local_field_group(array(
    'key' => 'group_3',
    'title' => 'Lesson Goals',
    'fields' => array(
        array(
            'key' => 'field_7',
            'label' => 'Lesson Goals',
            'name' => 'lesson_goals',
            'type' => 'repeater',
            'instructions' => 'Add goals for this lesson',
            'required' => 1,
            'sub_fields' => array(
                array(
                    'key' => 'field_8',
                    'label' => 'Goal',
                    'name' => 'goal',
                    'type' => 'post_object',
                    'instructions' => 'Select the goal',
                    'required' => 1,
                    'post_type' => array('today_goals'),
                ),
                array(
                    'key' => 'field_9',
                    'label' => 'Primary Goal',
                    'name' => 'primary_goal',
                    'type' => 'checkbox',
                    'instructions' => 'Check this box if this is the primary goal',
                    'choices' => array(
                        '1' => 'Primary Goal',
                    ),
                ),
            ),
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'daily_content',
            ),
        ),
    ),
));

endif;

// Filter to handle custom template parameter
function apply_custom_template($template) {
    if (isset($_GET['template']) && $_GET['template'] === 'lesson-navigation') {
        $new_template = locate_template(array('lesson-navigation.php'));
        if ($new_template) {
            return $new_template;
        }
    }
    return $template;
}
add_filter('template_include', 'apply_custom_template');

// Function to mark lesson as completed and fetch next lesson
if (!function_exists('complete_lesson')) {
    function complete_lesson($lesson_id) {
        $user_id = get_current_user_id();

        // Mark the lesson as completed
        $completed_lessons = get_user_meta($user_id, 'completed_lessons', true);
        if (!$completed_lessons) {
            $completed_lessons = array();
        }
        $completed_lessons[] = $lesson_id;
        update_user_meta($user_id, 'completed_lessons', $completed_lessons);

        // Fetch the next lesson
        $next_lesson = get_next_lesson($completed_lessons);

        // Update user meta with the next lesson
        update_user_meta($user_id, 'current_lesson', $next_lesson);
    }
}

// Function to get the next lesson
if (!function_exists('get_next_lesson')) {
    function get_next_lesson($completed_lessons) {
        $args = array(
            'post_type' => 'lesson',
            'post__not_in' => $completed_lessons,
            'posts_per_page' => 1,
            'orderby' => 'menu_order',
            'order' => 'ASC'
        );

        $lessons_query = new WP_Query($args);

        if ($lessons_query->have_posts()) {
            $lessons_query->the_post();
            $next_lesson = get_the_ID();
            wp_reset_postdata();
            return $next_lesson;
        } else {
            // When no more lessons are available
            update_user_meta(get_current_user_id(), 'current_lesson', null);
            return null;
        }
    }
}

// Function to get daily content based on user's progress
if (!function_exists('get_daily_content')) {
    function get_daily_content($user_id) {
        $current_lesson = get_user_meta($user_id, 'current_lesson', true);
        if ($current_lesson) {
            return get_post($current_lesson);
        } else {
            return null;
        }
    }
}

require_once get_stylesheet_directory() . '/ajax-handlers.php'; // Ensure AJAX handlers are included

?>
