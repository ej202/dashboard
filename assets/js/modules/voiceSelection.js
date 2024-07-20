export function handleVoiceSelection() {
    const selectVoiceButton = document.getElementById('selectVoiceButton');
    const voiceModal = document.getElementById('voiceModal');
    const voiceClose = document.getElementById('voiceClose');

    if (selectVoiceButton && voiceModal) {
        selectVoiceButton.addEventListener('click', () => {
            voiceModal.style.display = 'block';
        });

        voiceClose.addEventListener('click', () => {
            voiceModal.style.display = 'none';
        });

        document.querySelectorAll('.modal-option').forEach(option => {
            option.addEventListener('click', () => {
                const value = option.getAttribute('data-value');
                selectVoiceButton.textContent = value.charAt(0).toUpperCase() + value.slice(1);
                voiceModal.style.display = 'none';
            });
        });
    }
}
