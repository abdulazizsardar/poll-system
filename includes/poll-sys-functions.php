<?php
function poll_sys_save_poll() {
   
    check_ajax_referer('poll_sys_nonce', 'security');


    if (isset($_POST['poll_sys_title']) && isset($_POST['poll_sys_options'])) {
        $title = sanitize_text_field($_POST['poll_sys_title']);
        $options = array_map('sanitize_text_field', $_POST['poll_sys_options']);

        if (empty($title) || empty($options) || !is_array($options) || count($options) < 2) {
            wp_send_json_error(array('message' => 'Invalid poll data. Title and at least two options are required.'));
        }

 
        $poll_data = array(
            'title' => $title,
            'options' => $options
        );
        $polls = get_option('poll_sys_polls', array());
        $polls[] = $poll_data;
        update_option('poll_sys_polls', $polls);


        $shortcode = '[poll id="' . (count($polls) - 1) . '"]';
        wp_send_json_success(array(
            'message' => 'Poll saved successfully!',
            'poll' => $poll_data,
            'shortcode' => $shortcode,
            'index' => count($polls)
        ));
    } else {
        wp_send_json_error(array('message' => 'Invalid poll data.'));
    }
}
add_action('wp_ajax_poll_sys_save_poll', 'poll_sys_save_poll');
