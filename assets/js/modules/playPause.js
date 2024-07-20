export function handlePlayPauseButton(audioElement, selectedDuration, selectedVoice) {
    const playPauseButton = document.getElementById('playPauseButton');
    const playPauseIcon = document.getElementById('playPauseIcon');

    if (playPauseButton && playPauseIcon) {
        playPauseButton.addEventListener('click', () => {
            if (!selectedDuration || !selectedVoice) {
                alert('Please select both duration and voice.');
                return;
            }

            if (playPauseIcon.classList.contains('fa-play')) {
                playPauseIcon.classList.remove('fa-play');
                playPauseIcon.classList.add('fa-pause');
                playSelectedAudio(audioElement, selectedDuration, selectedVoice);
            } else {
                playPauseIcon.classList.remove('fa-pause');
                playPauseIcon.classList.add('fa-play');
                pauseAudio(audioElement);
            }
        });
    }
}

function playSelectedAudio(audioElement, duration, voice) {
    const audioSrc = getAudioSource(duration, voice);
    audioElement.src = audioSrc;
    audioElement.play();
}

function pauseAudio(audioElement) {
    audioElement.pause();
}

function getAudioSource(duration, voice) {
    return `/wp-content/themes/kadence-child/audios/${voice}_${duration}.mp3`;
}
