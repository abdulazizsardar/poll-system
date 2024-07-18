<?
// Admin page callback
function poll_sys_admin_page() {
    $polls = get_option('poll_sys_polls', array());
    ?>
    <div class="wrap">
        <h1>Poll System</h1>
        <a class="button" href="admin.php?page=poll-system-add-new">Create Poll</a>
        <table class="widefat fixed">
            <thead>
                <tr>
                    <th class="manage-column">Serial Number</th>
                    <th class="manage-column">Title</th>
                    <th class="manage-column">Options</th>
                    <th class="manage-column">Shortcode</th>
                    <th class="manage-column">Actions</th>
                </tr>
            </thead>
            <tbody id="poll-sys-table-body">
                <?php foreach ($polls as $index => $poll): ?>
                    <tr>
                        <td><?php echo esc_html($index + 1); ?></td>
                        <td><?php echo esc_html($poll['title']); ?></td>
                        <td><?php echo esc_html(implode(', ', $poll['options'])); ?></td>
                        <td>[poll id="<?php echo esc_html($index); ?>"]</td>
                        <td>
                            <a href="admin.php?page=poll-system-edit&poll_id=<?php echo esc_attr($index); ?>" class="button">Edit</a>
                            <button class="button poll-sys-delete-btn" data-index="<?php echo esc_attr($index); ?>">Delete</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php
}

// Admin page for adding and editing polls
function poll_sys_admin_add_edit_page() {
    $polls = get_option('poll_sys_polls', array());
    $poll_id = isset($_GET['poll_id']) ? intval($_GET['poll_id']) : null;
    $poll = ($poll_id !== null && isset($polls[$poll_id])) ? $polls[$poll_id] : null;
    ?>
    <div class="wrap">
        <h1><?php echo $poll ? 'Edit Poll' : 'Add New Poll'; ?></h1>
        <form id="poll-sys-form">
            <?php wp_nonce_field('poll_sys_nonce', 'security'); ?>
            <label for="poll-sys-title">Title:</label>
            <input type="text" id="poll-sys-title" name="poll-sys-title" value="<?php echo esc_attr($poll ? $poll['title'] : ''); ?>" required>
            <div id="poll-sys-options">
                <?php if ($poll): ?>
                    <?php foreach ($poll['options'] as $option): ?>
                        <div>
                            <label>Option:</label>
                            <input type="text" name="poll-sys-options[]" value="<?php echo esc_attr($option); ?>" required>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div>
                        <label>Option:</label>
                        <input type="text" name="poll-sys-options[]" required>
                    </div>
                    <div>
                        <label>Option:</label>
                        <input type="text" name="poll-sys-options[]" required>
                    </div>
                <?php endif; ?>
            </div>
            <button type="button" id="poll-sys-add-option-btn" class="button">Add Option</button>
            <input type="hidden" id="poll-sys-edit-index" name="poll-sys-edit-index" value="<?php echo esc_attr($poll_id); ?>">
            <input type="submit" class="button button-primary" value="Save">
        </form>
    </div>
    <?php
}
