<?php
function poll_sys_edit_page() {
    if (!isset($_GET['poll_id']) || !ctype_digit($_GET['poll_id'])) {
        echo '<div class="error"><p>Invalid poll ID.</p></div>';
        return;
    }
    $poll_id = isset($_GET['poll_id']) ? absint($_GET['poll_id']) : 0;

    $polls = get_option('poll_sys_polls', array());
    if (!isset($polls[$poll_id])) {
        echo '<div class="error"><p>Poll not found.</p></div>';
        return;
    }
    ?>
    <div class="wrap">
        <h1>Edit Poll</h1>
        <div id="poll-sys-form-container">
            <form id="poll-sys-form">
                <?php wp_nonce_field('poll_sys_nonce', 'poll_sys_nonce'); ?>
                <input type="hidden" id="poll-sys-edit-index" name="poll-sys-edit-index" value="<?php echo esc_attr($poll_id); ?>">
                <label for="poll-sys-title">Title:</label>
                <input type="text" id="poll-sys-title" name="poll-sys-title" value="<?php echo esc_attr($polls[$poll_id]['title']); ?>" required>
                <div id="poll-sys-options">
                    <?php foreach ($polls[$poll_id]['options'] as $option): ?>
                        <div><label>Option:</label><input type="text" name="poll-sys-options[]" value="<?php echo esc_attr($option); ?>" required></div>
                    <?php endforeach; ?>
                </div>
                <button type="button" id="poll-sys-add-option-btn">Add Option</button>
                <button type="submit" id="poll-sys-save-btn">Save Poll</button>
            </form>
        </div>
    </div>
    <?php
}
