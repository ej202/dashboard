<?php
/**
 * Template Name: Single Lesson
 *
 * @package Kadence
 */

get_header();

if (isset($_GET['content_id'])) {
    $lesson_id = sanitize_text_field($_GET['content_id']);
    $post = get_post($lesson_id);
    if ($post) {
        $title = get_the_title($post);
        $content = apply_filters('the_content', $post->post_content);
        ?>
        <div id="lesson" class="content">
            <h1><?php echo esc_html($title); ?></h1>
            <div class="lesson-content">
                <?php echo $content; ?>
            </div>
            <div class="lesson-navigation">
                <!-- Add navigation to previous/next lessons if needed -->
            </div>
        </div>
        <?php
    } else {
        echo 'Lesson not found.';
    }
} else {
    echo 'Invalid lesson ID.';
}

get_footer();
?>
