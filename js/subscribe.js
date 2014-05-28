(function ($) {

    'use strict';

    var $form;

    function displayErrorMessage() {
        // Display error message.
    }

    function displaySuccessMessage() {
        // Display success message.
    }

    function onError(data) {
        // Display error message.
        var i = 0;
    }

    function onSuccess(data) {
        if ('success' !== data.result) {
            displayErrorMessage();
        } else {
            displaySuccessMessage()
        }
    }

    function signup(event) {
        event.preventDefault();

        // TODO: Validate email address.

        $.ajax({
            type: $form.attr('method'),
            url: $form.attr('action'),
            data: $form.serialize(),
            cache: false,
            dataType: 'jsonp',
            jsonp: 'c',
            contentType: 'application/json; charset=utf-8',
            error: onError,
            success: onSuccess
        });
    }

    function init() {
        $form = $('#mailchimp-signup');

        $form.on('submit', signup);
    }

    init();

}(jQuery));