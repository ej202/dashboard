<?php
/*
Template Name: Lesson Navigation
*/

require_once($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');

if (have_posts()) :
    while (have_posts()) : the_post(); 
        $lesson_parts = get_field('lesson_parts');
        $lesson_id = get_the_ID(); // Get the lesson ID
        $part_index = isset($_GET['part']) ? intval($_GET['part']) : 0;
        if ($part_index >= count($lesson_parts)) {
            $part_index = count($lesson_parts) - 1;
        }
        if ($part_index < 0) {
            $part_index = 0;
        }
        $current_part = $lesson_parts[$part_index];
        $button_text = isset($current_part['button_text']) ? $current_part['button_text'] : 'Next';
        ?>
        <!DOCTYPE html>
        <html <?php language_attributes(); ?>>
        <head>
            <meta charset="<?php bloginfo('charset'); ?>">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title><?php the_title(); ?></title>
            <?php wp_head(); ?>
            <style>
                body, html {
                    margin: 0;
                    padding: 0;
                    height: 100%;
                    background: #C4DDFF; /* The blue color you mentioned */
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    color: white;
                    font-family: Arial, sans-serif;
                }
                .lesson-container {
                    display: flex;
                    flex-direction: column;
                    justify-content: center;
                    align-items: center;
                    text-align: center;
                    width: 80%;
                    height: 80%;
                    max-width: 800px;
                    padding: 20px;
                    background: transparent; /* do not change*/
                    border-radius: 10px;
                    
                }
                .lesson-container h1 {
                    margin-bottom: 20px;
                    font-size: 2.0em;
                    color: #022664;
                    font-family: -apple-system, Helvetica, Arial, sans-serif;
                }
                .lesson-container p {
                    font-size: 1.3em;
                    margin-bottom: 30px;
                    color: #16438f;
                    font-family: -apple-system, Helvetica, Arial, sans-serif;
                }
                .lesson-navigation {
                    margin-top: 20px;
                }
                .lesson-navigation button {
                    background: #a4c2f4; /* Light Blue */
                    color: #16438f;
                    border: none;
                    padding: 15px 30px;
                    cursor: pointer;
                    font-size: 1.1em;
                    border-radius: 5px;
                    transition: background 0.3s;
                }
                .lesson-navigation button:hover {
                    background: #000000; /* don't change this */
                }
            </style>
        </head>
        <body>
            <div class="lesson-container">
                <h1><?php the_title(); ?></h1>
                <div><?php echo $current_part['part_content']; ?></div>
                <div class="lesson-navigation">
                    <?php if ($part_index < count($lesson_parts) - 1) : ?>
                        <button class="next" onclick="navigateToPart(<?php echo $part_index + 1; ?>)"><?php echo esc_html($button_text); ?></button>
                    <?php else : ?>
                        <button class="next" onclick="completeLesson(<?php echo $lesson_id; ?>)"><?php echo esc_html($button_text); ?></button>
                    <?php endif; ?>
                </div>
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
            <?php wp_footer(); ?>
        </body>
        </html>
    <?php endwhile;
else :
    echo '<p>No content found</p>';
endif;
?>
