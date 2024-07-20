<?php
// Navigation Bar Partial
// Dependencies:
// - CSS: navigation.css
?>

<div class="navigation-bar">
    <div class="nav-links">
        <a href="#" class="nav-item today-link active" data-target="today">
            <div class="nav-icon-wrapper">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/today.png" alt="Today" class="nav-icon">
            </div>
            <span>Today</span>
        </a>
        <a href="#" class="nav-item now-link" data-target="now">
            <div class="nav-icon-wrapper">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/now.png" alt="Now" class="nav-icon">
            </div>
            <span>Now</span>
        </a>
        <a href="#" class="nav-item breathe-link" data-target="breathe">
            <div class="nav-icon-wrapper">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/breathe.png" alt="Breathe" class="nav-icon">
            </div>
            <span>Breathe</span>
        </a>
        <a href="#" class="nav-item meditate-link" data-target="meditate">
            <div class="nav-icon-wrapper">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/meditate.png" alt="Meditate" class="nav-icon">
            </div>
            <span>Meditate</span>
        </a>
        <a href="#" class="nav-item sleep-link" data-target="sleep">
            <div class="nav-icon-wrapper">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sleep.png" alt="Sleep" class="nav-icon">
            </div>
            <span>Sleep</span>
        </a>
        <a href="#" class="nav-item music-link" data-target="music">
            <div class="nav-icon-wrapper">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/music.png" alt="Music" class="nav-icon">
            </div>
            <span>Music</span>
        </a>
        <a href="#" class="nav-item more-link" data-target="more">
            <div class="nav-icon-wrapper">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/more.png" alt="More" class="nav-icon">
            </div>
            <span>More</span>
        </a>
    </div>
</div>
