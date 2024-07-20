<?php
// Ensure not to redeclare the complete_lesson function here

// Example AJAX handler for completing a lesson
if (!function_exists('complete_lesson_ajax_handler')) {
    function complete_lesson_ajax_handler() {
        // Ensure the complete_lesson function is available
        if (function_exists('complete_lesson')) {
            $lesson_id = isset($_POST['lesson_id']) ? intval($_POST['lesson_id']) : 0;
            if ($lesson_id > 0) {
                complete_lesson($lesson_id);
                wp_send_json_success(array('message' => 'Lesson completed successfully.'));
            } else {
                wp_send_json_error(array('message' => 'Invalid lesson ID.'));
            }
        } else {
            wp_send_json_error(array('message' => 'Function complete_lesson not found.'));
        }
    }
    add_action('wp_ajax_complete_lesson', 'complete_lesson_ajax_handler');
    add_action('wp_ajax_nopriv_complete_lesson', 'complete_lesson_ajax_handler');
}

// Example AJAX handler for another functionality
if (!function_exists('my_ajax_handler')) {
    function my_ajax_handler() {
        // Handle AJAX request here
        wp_send_json_success(array('message' => 'AJAX request handled successfully.'));
    }
    add_action('wp_ajax_my_action', 'my_ajax_handler');
    add_action('wp_ajax_nopriv_my_action', 'my_ajax_handler');
}

?>
