<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');

header('Content-Type: application/json');

// Get the current user ID
$user_id = get_current_user_id();
if (!$user_id) {
    echo json_encode(array('goals' => array()));
    exit;
}

// Get the list of completed lessons for the current user
$completed_lessons = get_user_meta($user_id, 'completed_lessons', true);
if (!is_array($completed_lessons)) {
    $completed_lessons = array();
}

// Query for the next lesson that has not been completed
$args = array(
    'post_type' => 'daily_content',
    'post__not_in' => $completed_lessons,
    'orderby' => 'date',
    'order' => 'ASC',
    'posts_per_page' => 1 // Limit to only the next lesson
);

$query = new WP_Query($args);
if ($query->have_posts()) {
    $query->the_post();
    $current_lesson_id = get_the_ID();
} else {
    $current_lesson_id = null;
}

error_log('Current lesson ID in get-goals.php: ' . $current_lesson_id);

if (!$current_lesson_id) {
    echo json_encode(array('goals' => array()));
    exit;
}

// Check if the current lesson is completed for the user
$lesson_completed = get_user_meta($user_id, 'lesson_completed_' . $current_lesson_id, true);

// Use ACF to fetch related goals directly
$goals = get_field('lesson_goals', $current_lesson_id);
error_log('Goals fetched from ACF: ' . print_r($goals, true));

// Fetch primary goal ID
$primary_goal_id = null;
foreach ($goals as $goal_item) {
    if (!empty($goal_item['primary_goal'])) {
        $primary_goal_id = $goal_item['goal']->ID;
        break;
    }
}
error_log('Primary goal ID fetched from ACF: ' . $primary_goal_id);

$response = array();
if ($goals) {
    foreach ($goals as $goal_item) {
        $goal = $goal_item['goal'];
        $goal_id = is_object($goal) ? $goal->ID : intval($goal);
        $goal_post = get_post($goal_id);
        error_log('Goal post object: ' . print_r($goal_post, true));

        if ($goal_post) {
            // Directly query the database for the post content
            $goal_content = $wpdb->get_var($wpdb->prepare("SELECT post_content FROM {$wpdb->prefix}posts WHERE ID = %d", $goal_id));
            error_log('Direct DB Goal post content: ' . $goal_content);

            // Fallback: Check if custom field is used
            if (empty($goal_content)) {
                $goal_content = get_post_meta($goal_id, 'goal_content', true);
                error_log('Goal custom field content: ' . $goal_content);
            }

            $response[] = array(
                'lesson_id' => $current_lesson_id,
                'goal_id' => $goal_id,
                'content' => $goal_content,
                'primary' => $goal_id == $primary_goal_id,
                'completed' => !empty($lesson_completed)
            );
            error_log('Goal found: ' . $goal_post->post_title);
        } else {
            error_log('Goal post not found for ID: ' . $goal_id);
        }
    }
}

echo json_encode(array('goals' => $response));