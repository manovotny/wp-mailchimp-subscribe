(function ($) {

    'use strict';

    var options = require('./subscribe-options');

    function updateFormActions($forms) {
        var $form,
            action,
            jsonAction;

        _.each($forms, function (form) {
            $form = $(form);

            action = $form.attr('action');
            jsonAction = action.replace(/subscribe\/post/gi, 'subscribe/post-json');

            $form.attr('action', jsonAction);
            $form.attr('method', 'get');
        });

    }

    function setFocusOnEmailInput($form) {
        $form.find('input').focus();
    }

    function resetFormControls($form) {
        $form.find('input').val('');
    }

    function displayErrorMessage($form, message) {
        if (!message) {
            message = options.defaultErrorMessage;
        }

        $form.find('.message').html(message);
    }

    function displaySuccessMessage($form, message) {
        if (!message) {
            message = options.defaultSuccessMessage;
        }

        $form.find('.message').html(message);
    }

    function onComplete() {
        var $form = $(this.form); // jshint ignore:line

        $form.find(':submit').prop('disabled', false);
    }

    function onSuccess(data) {
        var $form = $(this.form); // jshint ignore:line

        if ('success' === data.result) {
            displaySuccessMessage($form, data.msg);
            resetFormControls($form);
        } else {
            displayErrorMessage($form, data.msg);
            setFocusOnEmailInput($form);
        }
    }

    function subscribe(event) {
        event.preventDefault();

        var form = event.currentTarget,
            $form = $(form);

        $form.find('.message').html('');
        $form.find(':submit').prop('disabled', true);
        $form.find('input').blur();

        $.ajax({
            crossDomain: true,
            data: $form.serialize(),
            dataType: 'jsonp',
            form: form,
            jsonp: 'c',
            type: $form.attr('method'),
            url: $form.attr('action'),
            contentType: 'application/json; charset=utf-8',
            complete: onComplete,
            success: onSuccess
        });
    }

    function init() {
        var $forms = $('.wp-mailchimp-subscribe-widget form');

        if ($forms.length) {
            updateFormActions($forms);

            $forms.on('submit', subscribe);
        }
    }

    init();

}(jQuery));
