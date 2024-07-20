<?php
/*
Template Name: Members Page
*/
get_header();

if (!is_user_logged_in()) {
    wp_redirect(home_url('/login/'));
    exit;
}

$user = wp_get_current_user();
$user_roles = $user->roles;
$is_admin = in_array('administrator', $user_roles);

?>

<div id="preloader" style="display: none;">
    <div id="loader"></div>
</div>

<div class="members-page">
    <?php get_template_part('partials/navigation-bar'); ?>

    <div class="content-wrapper">
        <div id="notification" class="notification hidden">
            Congratulations! You have completed today's practice.
        </div>
        <div id="goal-container">
            <!-- Placeholder for goal-container -->
        </div>
        
        <?php
        // Get the current user's next lesson
        $user_id = get_current_user_id();
        $daily_content = get_daily_content($user_id);

        if ($daily_content) {
            setup_postdata($daily_content);
            ?>
            <h2>Today's Lesson: <?php echo get_the_title($daily_content); ?></h2>
            <p><?php echo get_the_excerpt($daily_content); ?></p>
            <a href="<?php echo get_permalink($daily_content); ?>">Start Lesson</a>
            <?php
            wp_reset_postdata();
        } else {
            // Trigger the notification without displaying a message
            ?>
            <script type="text/javascript">
                window.showGoalNotification = true;
            </script>
            <?php
        }
        ?>

        <?php get_template_part('partials/content', 'today'); ?>
        <?php get_template_part('partials/content', 'now'); ?>
        <?php get_template_part('partials/content', 'breathe'); ?>
        <?php get_template_part('partials/content', 'meditate'); ?>
        <?php get_template_part('partials/content', 'sleep'); ?>
        <?php get_template_part('partials/content', 'music'); ?>
        <?php get_template_part('partials/content', 'more'); ?>
    </div>
</div>

<!-- Modals -->
<?php get_template_part('partials/modals'); ?>

<?php get_footer(); ?>

<script>
function showNotification() {
    const notification = document.getElementById('notification');
    notification.classList.remove('hidden');
    notification.classList.add('visible');

    setTimeout(() => {
        notification.classList.remove('visible');
        notification.classList.add('hidden');
    }, 5000); // Notification will disappear after 5 seconds
}

document.addEventListener('DOMContentLoaded', (event) => {
    if (window.showGoalNotification) {
        showNotification();
    }
});
</script>

<style>
.notification {
    position: fixed;
    top: 20px;
    right: 20px;
    background-color: #28a745;
    color: white;
    padding: 15px;
    border-radius: 5px;
    z-index: 1000;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: opacity 0.5s ease-in-out;
}

.notification.hidden {
    opacity: 0;
    visibility: hidden;
}

.notification.visible {
    opacity: 1;
    visibility: visible;
}
</style>
