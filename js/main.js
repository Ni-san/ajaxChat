function sendMessage() {
    var message = jQuery('#send-message-input').val();
    var author = jQuery('#send-message-author-input').val();

    jQuery.ajax({
        url: '',
        data: {
            message: message,
            author: author
        },
        method: 'post',
        success: function(data) {
            location.reload();
        }
    });
}

function update(maxId) {
    jQuery.ajax({
        url: '',
        data: {action: 'getNew', maxId: maxId},
        method: 'post',
        dataType: 'json',
        success: function(data) {
            console.log(data);

            var str = '';
            jQuery.each(data, function(i, e) {
                console.log(i);
                str += '<div data-id="' + e.id + '" class="message panel panel-default">';
                str += '<div class="panel-heading"><span>' + e.author + '</span><span class="pull-right">' + e.timestamp + '</span></div>';
                str += '<div class="panel-body">' + e.text + '</div></div>';

                //jQuery('#messages-container').prepend('<div data-id="' + e.id + '" class="message">' + e.text + '</div>');
                maxId = Math.max(maxId, e.id);
                console.log(str);
            });
            jQuery('#messages-container .messages').prepend(str);

            update(maxId);
        }
    });
}

jQuery(document).ready(function() {
    var maxId = 0;
    jQuery('.message').each(function(i, e) {
        maxId = Math.max(jQuery(e).data('id'), maxId);
    });
    update(maxId);
});
