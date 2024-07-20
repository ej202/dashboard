<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');

// Get the current user ID
$user_id = get_current_user_id();

// Fetch the user's progress (this could be stored in user meta or a custom table)
$completed_lessons = get_user_meta($user_id, 'completed_lessons', true);
if (!$completed_lessons) {
    $completed_lessons = array();
}

// Query for the next daily content post
$args = array(
    'post_type' => 'daily_content',
    'post__not_in' => $completed_lessons,
    'orderby' => 'date',
    'order' => 'ASC',
    'posts_per_page' => 1
);

$query = new WP_Query($args);

if ($query->have_posts()) {
    while ($query->have_posts()) {
        $query->the_post();
        $title = get_the_title();
        $subtitle = get_field('subtitle');
        $duration = get_field('duration');
        $content = get_the_content();

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
        echo '<span class="lesson-arrow">&#10132;</span>';
        echo '</div>';
        echo '</div>';
        echo '</a>';
    }
} else {
    echo 'No more content available.';
}

wp_reset_postdata();
?>