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
