<?php
// assign-reward.php

if (isset($_POST['id'])) {
    $post_id = intval($_POST['id']);

    $reward_value = get_field('reward_value', $post_id);
    if ($reward_value) {
        // Assign the reward to the user
        // This could involve updating user meta, adding to a log, etc.
        // Example:
        $user_id = get_current_user_id();
        $current_rewards = get_user_meta($user_id, 'total_rewards', true);
        $new_rewards = $current_rewards + $reward_value;
        update_user_meta($user_id, 'total_rewards', $new_rewards);

        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Reward value not found.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}
?>
