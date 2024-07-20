<?php
// Modals Partial
// Dependencies:
// - CSS: modals.css
// - JavaScript: custom.js (for modal interactions)
?>

<div id="durationModal" class="modal" style="display:none;">
    <div class="modal-content">
        <div class="modal-option" data-value="3">3 minutes</div>
        <div class="modal-option" data-value="5">5 minutes</div>
        <div class="modal-option" data-value="10">10 minutes</div>
        <div class="modal-close" id="durationClose">×</div>
    </div>
</div>

<div id="voiceModal" class="modal" style="display:none;">
    <div class="modal-content">
        <div class="modal-option" data-value="male">Male</div>
        <div class="modal-option" data-value="female">Female</div>
        <div class="modal-close" id="voiceClose">×</div>
    </div>
</div>
