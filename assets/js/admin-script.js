jQuery(document).ready(function($) {
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
            poll_sys_options: $('input[name="poll-sys-options[]"]').map(function() { return $(this).val(); }).get()
        }, function(response) {
            if (response.success) {
                alert(response.data.message);
                $('#poll-sys-form')[0].reset();
                $('#poll-sys-options').html('<label>Option:</label><input type="text" name="poll-sys-options[]" required>');
                // Append new poll to table
                $('#poll-sys-table-body').append('<tr><td>' + response.data.index + '</td><td>' + response.data.poll.title + '</td><td>' + response.data.poll.options.join(', ') + '</td></tr>');
            } else {
                alert(response.data.message);
            }
        });
    });
});
