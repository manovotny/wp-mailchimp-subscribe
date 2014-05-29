(function ($) {

    'use strict';

    var DEFAULT_ERROR_MESSAGE = 'Hrm... Something\'s not working right. Please try again later or let us know something is wrong.',
        DEFAULT_SUCCESS_MESSAGE = 'Almost finished... We need to confirm your email address. To complete the subscription process, please click the link in the email we just sent you.',

        $form,
        $input,
        $message,
        $submit;

    function updateFormForJson() {
        var action = $form.attr('action'),
            jsonAction = action.replace(/subscribe\/post/gi, 'subscribe/post-json');

        $form.attr('action', jsonAction);
        $form.attr('method', 'get');
    }

    function clearMessage() {
        $message.html('');
    }

    function setFocusOnEmailInput() {
        $input.focus();
    }

    function resetFormControls() {
        $input.val('');
    }

    function displayErrorMessage(message) {
        if (!message) {
            message = DEFAULT_ERROR_MESSAGE;
        }

        $message.html(message);
    }

    function displaySuccessMessage(message) {
        if (!message) {
            message = DEFAULT_SUCCESS_MESSAGE;
        }

        $message.html(message);
    }

    function onComplete() {
        $submit.prop('disabled', false);
    }

    function onSuccess(data) {
        if ('success' === data.result) {
            displaySuccessMessage(data.msg);
            resetFormControls();
        } else {
            displayErrorMessage(data.msg);
            setFocusOnEmailInput();
        }
    }

    function subscribe(event) {
        event.preventDefault();

        clearMessage();

        $submit.prop('disabled', true);

        $input.blur();

        $.ajax({
            crossDomain: true,
            data: $form.serialize(),
            dataType: 'jsonp',
            jsonp: 'c',
            type: $form.attr('method'),
            url: $form.attr('action'),
            contentType: 'application/json; charset=utf-8',
            complete: onComplete,
            success: onSuccess
        });
    }

    function init() {
        $form = $('.wp-mailchimp-subscribe-widget form');

        if ($form.length) {
            $input = $form.find('input');
            $message = $form.find('.message');
            $submit = $form.find(':submit');

            updateFormForJson();

            $form.on('submit', subscribe);
        }
    }

    init();

}(jQuery));