(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
(function ($) {

    'use strict';

    var DEFAULT_ERROR_MESSAGE = 'Hrm... Something\'s not working right. Please try again later or let us know something is wrong.',
        DEFAULT_SUCCESS_MESSAGE = 'Almost finished... We need to confirm your email address. To complete the subscription process, please click the link in the email we just sent you.';

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
            message = DEFAULT_ERROR_MESSAGE;
        }

        $form.find('.message').html(message);
    }

    function displaySuccessMessage($form, message) {
        if (!message) {
            message = DEFAULT_SUCCESS_MESSAGE;
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
},{}]},{},[1]);
