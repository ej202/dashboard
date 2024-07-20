<?php
get_header();

if ( have_posts() ) :
    while ( have_posts() ) : the_post(); ?>
        <div class="lesson-page-content">
            <h1><?php the_title(); ?></h1>
            <div class="lesson-content">
                <?php
                // Check if the lesson parts field exists
                $lesson_parts = get_field('lesson_parts');
                if ($lesson_parts && is_array($lesson_parts)) {
                    $part_index = isset($_GET['part']) ? intval($_GET['part']) : 0;

                    // Debugging statements
                    error_log("Lesson ID: " . get_the_ID());
                    error_log("Part Index: " . $part_index);
                    error_log("Lesson Parts: " . print_r($lesson_parts, true));

                    if ($part_index >= count($lesson_parts)) {
                        $part_index = count($lesson_parts) - 1;
                    }
                    if ($part_index < 0) {
                        $part_index = 0;
                    }
                    $current_part = $lesson_parts[$part_index];
                    $button_text = isset($current_part['button_text']) ? $current_part['button_text'] : 'Next';
                    ?>
                    <div><?php echo $current_part['part_content']; ?></div>
                    <div class="lesson-navigation">
                        <?php if ($part_index < count($lesson_parts) - 1) : ?>
                            <button class="next" onclick="navigateToPart(<?php echo $part_index + 1; ?>)"><?php echo esc_html($button_text); ?></button>
                        <?php else : ?>
                            <button class="next" onclick="completeLesson(<?php echo get_the_ID(); ?>)"><?php echo esc_html($button_text); ?></button>
                        <?php endif; ?>
                    </div>
                    <script>
                        function navigateToPart(part) {
                            const url = new URL(window.location.href);
                            url.searchParams.set('part', part);
                            window.location.href = url.toString();
                        }

                       function completeLesson(lessonId) {
    console.log('Completing lesson...');
    // Call the backend endpoint to mark the lesson as completed
    fetch('/wp-admin/admin-ajax.php?action=complete_lesson', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: new URLSearchParams({
            lesson_id: lessonId
        })
    })
    .then(response => {
        console.log('Received response:', response);
        return response.json();
    })
    .then(result => {
        console.log('Received result:', result);
        if (result.success) {
            alert("Lesson completed!");

            // Mark the goal as completed
            localStorage.setItem('todaysPracticeCompleted_' + lessonId, 'true');

            // Redirect back to the dashboard
            window.location.href = '/dashboard';
        } else {
            console.error('Error completing lesson:', result);
        }
    })
    .catch(error => console.error('Error completing lesson:', error));
}
                    </script>
                    <?php
                } else {
                    echo '<p>No lesson parts found</p>';
                }
                ?>
            </div>
        </div>
    <?php endwhile;
else :
    echo '<p>No content found</p>';
endif;

get_footer();
?>