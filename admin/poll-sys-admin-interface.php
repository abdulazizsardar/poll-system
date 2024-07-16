<?php


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
                </tr>
            </thead>
            <tbody id="poll-sys-table-body">
                <?php foreach ($polls as $index => $poll): ?>
                    <tr>
                        <td><?php echo esc_html($index + 1); ?></td>
                        <td><?php echo esc_html($poll['title']); ?></td>
                        <td><?php echo esc_html(implode(', ', $poll['options'])); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
    </div>
    <?php
}
