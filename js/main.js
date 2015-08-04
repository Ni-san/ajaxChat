function sendMessage() {
    var message = jQuery('#send-message-input').val();

    jQuery.ajax({
        url: '',
        data: {message: message},
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
                jQuery('#messages-container').append('<div data-id="' + e.id + '" class="message">' + e.text + '</div>');
                maxId = Math.max(maxId, e.id);
            });

            update(maxId);
        }/*,
        error: function() {
            console.log('error');
            update(maxId);
        }*/
    });
}

jQuery(document).ready(function() {
    var maxId = 0;
    jQuery('.message').each(function(i, e) {
        maxId = Math.max(jQuery(e).data('id'), maxId);
    });
    update(maxId);
});
