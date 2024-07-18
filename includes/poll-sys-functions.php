<?php
function poll_sys_save_poll() {
    check_ajax_referer('poll_sys_nonce', 'security');

    $title = sanitize_text_field($_POST['poll_sys_title']);
    $options = isset($_POST['poll_sys_options']) ? array_map('sanitize_text_field', $_POST['poll_sys_options']) : array();

    if (empty($title) || empty($options) || !is_array($options) || count($options) < 2) {
        wp_send_json_error(array('message' => 'Invalid poll data.'));
    }

    $poll_data = array(
        'title' => $title,
        'options' => $options
    );

    $poll_id = isset($_POST['poll_sys_edit_index']) ? intval($_POST['poll_sys_edit_index']) : null;
    $polls = get_option('poll_sys_polls', array());

    if ($poll_id !== null && isset($polls[$poll_id])) {
        // Update existing poll
        $polls[$poll_id] = $poll_data;
        update_option('poll_sys_polls', $polls);

        $shortcode = '[poll id="' . $poll_id . '"]';
        wp_send_json_success(array(
            'message' => 'Poll updated successfully!',
            'poll' => $poll_data,
            'shortcode' => $shortcode
        ));
    } else {
        // Add new poll
        $polls[] = $poll_data;
        update_option('poll_sys_polls', $polls);

        $shortcode = '[poll id="' . (count($polls) - 1) . '"]';
        wp_send_json_success(array(
            'message' => 'Poll saved successfully!',
            'poll' => $poll_data,
            'shortcode' => $shortcode,
            'index' => count($polls) - 1
        ));
    }
}
add_action('wp_ajax_poll_sys_save_poll', 'poll_sys_save_poll');
add_action('wp_ajax_nopriv_poll_sys_save_poll', 'poll_sys_save_poll'); // For non-logged in users


function poll_sys_delete_poll() {
    check_ajax_referer('poll_sys_nonce', 'security');

    if (isset($_POST['poll_id'])) {
        $poll_id = intval($_POST['poll_id']);
        $polls = get_option('poll_sys_polls', array());

        if (isset($polls[$poll_id])) {
            unset($polls[$poll_id]);
            $polls = array_values($polls);
            update_option('poll_sys_polls', $polls);
            wp_send_json_success(array('message' => 'Poll deleted successfully!'));
        } else {
            wp_send_json_error(array('message' => 'Poll not found.'));
        }
    } else {
        wp_send_json_error(array('message' => 'Invalid poll ID.'));
    }
}
add_action('wp_ajax_poll_sys_delete_poll', 'poll_sys_delete_poll');
