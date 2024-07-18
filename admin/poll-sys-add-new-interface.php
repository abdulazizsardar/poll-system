<?php
// Add New Poll page callback
function poll_sys_add_new_page() {
    ?>
    <div class="wrap">
        <h1>Add New Poll</h1>
        <form id="poll-sys-form">
            <?php wp_nonce_field('poll_sys_nonce', 'security'); ?>
            <label for="poll-sys-title">Title:</label>
            <input type="text" id="poll-sys-title" name="poll-sys-title" required>
            <div id="poll-sys-options">
                <label>Option:</label>
                <input type="text" name="poll-sys-options[]" required>
            </div>
            <button type="button" id="poll-sys-add-option-btn">Add Option</button>
            <button type="submit" id="poll-sys-save-btn">Save Poll</button>
        </form>
    </div>
    <?php
}
