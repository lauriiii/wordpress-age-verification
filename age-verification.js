jQuery(function() {
    jQuery('.age-verification-btn-yes').on('click', function(e) {
        e.preventDefault();

        jQuery.ajax({
            type: 'POST',
            url: my_ajax_obj.ajax_url,
            data: {
                _ajax_nonce: my_ajax_obj.nonce,
                action: 'set_age_verification_cookie'
            },
            success: function(response) {
                jQuery('.age-verification-overlay').remove();
            }
        });
    });
});