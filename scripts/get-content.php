<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');

error_log("content-rotate.php: script started");

// Get current date and time in the correct format
$current_datetime = current_time('mysql'); // This gives 'Y-m-d H:i:s'
error_log("content-rotate.php: current datetime - $current_datetime");

// Query for the most recent daily content post with datetime check
$args = array(
    'post_type' => 'todays_practice',
    'meta_query' => array(
        array(
            'key' => 'daily_datetime',
            'value' => $current_datetime,
            'compare' => '<=',
            'type' => 'DATETIME'
        )
    ),
    'orderby' => 'meta_value',
    'order' => 'DESC',
    'posts_per_page' => 1 // Limit to only the most recent post
);

$query = new WP_Query($args);
error_log("Query Args: " . print_r($args, true));
error_log("Query Results: " . print_r($query->posts, true));

if ($query->have_posts()) {
    error_log("content-rotate.php: posts found");
    while ($query->have_posts()) {
        $query->the_post();
        $title = get_the_title();
        $subtitle = get_field('subtitle'); // ACF field for subtitle
        $duration = get_field('duration'); // ACF field for duration
        $content = get_the_content();

        // Log the format of the datetime stored in ACF
        $acf_datetime = get_post_meta(get_the_ID(), 'daily_datetime', true);
        error_log("Stored ACF datetime for post ID " . get_the_ID() . ": " . $acf_datetime);

        // Generate the link to the lesson page using the new template
        $lesson_link = add_query_arg(array(
            'template' => 'lesson-navigation',
            'part' => 0
        ), get_permalink());

        echo '<a href="' . esc_url($lesson_link) . '" class="lesson-link" data-content-id="' . get_the_ID() . '">';
        echo '<div class="lesson-content">';
        echo '<div class="lesson-details">';
        echo '<span class="lesson-subtitle">' . esc_html($subtitle) . '</span>';
        echo '<h3 class="lesson-title">' . esc_html($title) . '</h3>';
        echo '</div>';
        echo '<div class="lesson-duration">';
        echo '<span class="duration-label">' . esc_html($duration) . ' min</span>';
        echo '<span class="lesson-arrow">&#10132;</span>'; // Arrow link
        echo '</div>';
        echo '</div>';
        echo '</a>';
    }
} else {
    error_log("content-rotate.php: no posts found");
    echo 'No content available for today.';
}

wp_reset_postdata();