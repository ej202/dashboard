export function handleDurationSelection() {
    const selectDurationButton = document.getElementById('selectDurationButton');
    const durationModal = document.getElementById('durationModal');
    const durationClose = document.getElementById('durationClose');

    if (selectDurationButton && durationModal) {
        selectDurationButton.addEventListener('click', () => {
            durationModal.style.display = 'block';
        });

        durationClose.addEventListener('click', () => {
            durationModal.style.display = 'none';
        });

        document.querySelectorAll('.modal-option').forEach(option => {
            option.addEventListener('click', () => {
                const value = option.getAttribute('data-value');
                selectDurationButton.textContent = value + ' minutes';
                durationModal.style.display = 'none';
            });
        });
    }
}
