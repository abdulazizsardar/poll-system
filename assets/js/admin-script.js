jQuery(document).ready(function($) {
    //new form add and edit
    $('#poll-sys-add-option-btn').on('click', function() {
        $('#poll-sys-options').append('<div><label>Option:</label><input type="text" name="poll-sys-options[]" required></div>');
    });

    $('#poll-sys-form').on('submit', function(e) {
        e.preventDefault();
        var data = $(this).serialize();

        $.post(pollSysAjax.ajax_url, {
            action: 'poll_sys_save_poll',
            security: pollSysAjax.nonce,
            poll_sys_title: $('#poll-sys-title').val(),
            poll_sys_options: $('input[name="poll-sys-options[]"]').map(function() { return $(this).val(); }).get(),
            poll_sys_edit_index: $('#poll-sys-edit-index').val()
        }, function(response) {
            if (response.success) {
                alert(response.data.message);
                window.location.href = 'admin.php?page=poll-system';
            } else {
                alert(response.data.message);
            }
        });
    });

    // Delete Data table with confirmation
    $('body').on('click', '.poll-sys-delete-btn', function() {
        if (confirm('Are you sure you want to delete this poll?')) {
            var row = $(this).closest('tr');
            var index = $(this).data('index');
            var data = {
                action: 'poll_sys_delete_poll',
                security: pollSysAjax.nonce,
                poll_id: index
            };

            $.post(pollSysAjax.ajax_url, data, function(response) {
                if (response.success) {
                    row.remove();
                } else {
                    alert(response.data.message);
                }
            });
        }
    });
});
