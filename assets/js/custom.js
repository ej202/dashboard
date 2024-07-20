jQuery(document).ready(function($) {
    console.log('Document is ready');

    // Ensure modals are hidden initially
    $('#durationModal').hide();
    $('#voiceModal').hide();

    var audioElement = new Audio();
    var selectedDuration = '';
    var selectedVoice = '';

    function loadContent(target) {
        console.log('Loading content for target:', target);
        $('.content').hide(); // Hide all content areas
        $('#' + target).show(); // Show the target content area
    }

    function setupPlayer() {
        var isPlaying = false;
        var playPauseButton = $('#playPauseButton');
        var playPauseIcon = $('#playPauseIcon');
        var selectDurationButton = $('#selectDurationButton');
        var selectVoiceButton = $('#selectVoiceButton');
        var durationModal = $('#durationModal');
        var voiceModal = $('#voiceModal');
        var durationClose = $('#durationClose');
        var voiceClose = $('#voiceClose');

        selectDurationButton.off('click').on('click', function() {
            console.log('Opening duration modal');
            durationModal.fadeIn();
        });

        selectVoiceButton.off('click').on('click', function() {
            console.log('Opening voice modal');
            voiceModal.fadeIn();
        });

        $('.modal-option').off('click').on('click', function() {
            var value = $(this).data('value');
            if ($(this).parent().parent().attr('id') === 'durationModal') {
                selectedDuration = value;
                selectDurationButton.text(value + ' minutes');
            } else {
                selectedVoice = value;
                selectVoiceButton.text(value.charAt(0).toUpperCase() + value.slice(1));
            }
            $(this).parent().parent().fadeOut();
        });

        durationClose.off('click').on('click', function() {
            console.log('Closing duration modal');
            durationModal.fadeOut();
        });

        voiceClose.off('click').on('click', function() {
            console.log('Closing voice modal');
            voiceModal.fadeOut();
        });

        playPauseButton.off('click').on('click', function() {
            if (!selectedDuration || !selectedVoice) {
                alert('Please select both duration and voice.');
                return;
            }

            isPlaying = !isPlaying;
            if (isPlaying) {
                playPauseIcon.removeClass('fa-play').addClass('fa-pause');
                playSelectedAudio(selectedDuration, selectedVoice);
            } else {
                playPauseIcon.removeClass('fa-pause').addClass('fa-play');
                pauseAudio();
            }
        });

        function playSelectedAudio(duration, voice) {
            var audioSrc = getAudioSource(duration, voice);
            audioElement.src = audioSrc;
            audioElement.play();
        }

        function pauseAudio() {
            audioElement.pause();
        }

        function getAudioSource(duration, voice) {
            return `/wp-content/themes/kadence-child/audios/${voice}_${duration}.mp3`;
        }
    }

    function startBreathePacer() {
        const pacer = $('.breathe-pacer');
        const text = $('.breathe-text');
        let inhale = true;

        pacer.off('click').on('click', function() {
            if (pacer.hasClass('active')) return; // Prevent multiple intervals

            pacer.addClass('active');
            text.text('Inhale');
            pacer.addClass('shrink');
            setTimeout(() => {
                text.css('opacity', '1');
                setInterval(() => {
                    if (inhale) {
                        text.css('opacity', '0');
                        setTimeout(() => {
                            text.text('Exhale').css('opacity', '1');
                            pacer.removeClass('shrink');
                        }, 1000); // 1-second pause before changing to exhale
                    } else {
                        text.css('opacity', '0');
                        setTimeout(() => {
                            text.text('Inhale').css('opacity', '1');
                            pacer.addClass('shrink');
                        }, 1000); // 1-second pause before changing to inhale
                    }
                    inhale = !inhale;
                }, 6000); // 5 seconds for each inhale/exhale + 1-second pause
            }, 5000); // Initial shrink time
        });
    }

    // Make the Today link active by default and load its content
    var defaultTarget = 'today';
    loadContent(defaultTarget);

    $('.nav-item').click(function(e) {
        e.preventDefault();
        var target = $(this).data('target');

        // Remove active class from all links and add to the clicked link
        $('.nav-item').removeClass('active');
        $(this).addClass('active');

        // Load the content
        loadContent(target);

        // Additional setup for specific sections
        if (target === 'now') {
            setupPlayer();
        }
        if (target === 'breathe') {
            startBreathePacer();
        }
    });

    // Check for modal visibility
    function checkModals() {
        if ($('#durationModal').is(':visible')) {
            console.log('Duration modal is open');
        }
        if ($('#voiceModal').is(':visible')) {
            console.log('Voice modal is open');
        }
    }

    // Set an interval to check for modals being open
    setInterval(checkModals, 1000);

    // Ensure the lesson links are correctly found and event attached
    const lessonLinks = $('.lesson-link');
    console.log('Lesson links found:', lessonLinks.length);

    lessonLinks.each(function() {
        console.log('Setting up click event for:', $(this).data('url'));
        $(this).click(function(event) {
            event.preventDefault();
            const url = $(this).data('url');
            console.log("Click event captured, URL is:", url);  // Debugging statement
            if (url) {
                console.log("Redirecting to:", url);  // Debugging statement
                window.location.href = url;
            } else {
                console.log("No URL found for the clicked element.");
            }
        });
    });

    // Notification function
    function showNotification() {
        const notification = document.getElementById('notification');
        notification.classList.remove('hidden');
        notification.classList.add('visible');

        setTimeout(() => {
            notification.classList.remove('visible');
            notification.classList.add('hidden');
        }, 5000); // Notification will disappear after 5 seconds
    }

    if (window.showGoalNotification) {
        showNotification();
    }
});
