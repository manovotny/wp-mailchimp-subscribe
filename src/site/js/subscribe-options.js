(function (global) {

    'use strict';

    var options = global.wp_mailchimp_subscribe.options;

    module.exports = {
        defaultErrorMessage: options.default_error_message,
        defaultSuccessMessage: options.default_success_message
    };

}(global));
