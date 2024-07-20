<div id="today" class="content">
    <div class="main-content">
        <div class="section-header">
            <h2>Today's Practice</h2>
            <button class="view-all-button">View All</button>
        </div>
        <div class="todays-practice">
            <!-- Content will be loaded here by JavaScript -->
        </div>

        <div class="section-header">
            <h2>Today's Goals</h2>
            <button class="view-all-button">View My Progress</button>
        </div>
        <div id="goals-container">
            <!-- Goals will be loaded here by JavaScript -->
        </div>
        <!-- Other content sections -->

    </div>

    <div class="right-sidebar">
        <div class="side-content">
            <div>
                <!-- Side content element 1 -->
            </div>
            <div>
                <!-- Side content element 2 -->
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const contentDiv = document.querySelector('.todays-practice');
    const goalsContainer = document.getElementById('goals-container');

    // Fetch initial content
    fetch('/wp-content/themes/kadence-child/scripts/get-next-content.php')
        .then(response => response.text())
        .then(data => {
            contentDiv.innerHTML = data;
            document.querySelectorAll('.lesson-link').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const url = this.href;
                    window.location.href = url;
                });
            });
        })
        .catch(error => console.error('Error fetching content:', error));

    // Fetch goals
    fetch('/wp-content/themes/kadence-child/scripts/get-goals.php')
        .then(response => response.json())
        .then(data => {
            goalsContainer.innerHTML = '';
            if (data.goals && data.goals.length > 0) {
                data.goals.forEach(goal => {
                    const goalElement = document.createElement('div');
                    goalElement.className = 'goal-item';
                    goalElement.innerHTML = `<p${goal.primary && goal.completed ? ' style="text-decoration: line-through;"' : ''}>${goal.content}</p>`;
                    goalsContainer.appendChild(goalElement);
                });
            } else {
                goalsContainer.innerHTML = '<p>No goals found for the current lesson.</p>';
            }
        })
        .catch(error => console.error('Error fetching goals:', error));
});
</script>