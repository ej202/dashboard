export function handleLessonClick() {
    document.addEventListener('DOMContentLoaded', function() {
        const lessonLinks = document.querySelectorAll('.lesson-link');
        lessonLinks.forEach(link => {
            link.addEventListener('click', function(event) {
                // Allow default action to happen
                const lessonId = this.dataset.contentId;
                if (lessonId) {
                    console.log(`Navigating to lesson with ID: ${lessonId}`);
                    // You can add any additional logic here if needed
                    // window.location.href = `/wp-content/themes/kadence-child/scripts/get-content.php?id=${lessonId}`;
                }
            });
        });
    });
}
