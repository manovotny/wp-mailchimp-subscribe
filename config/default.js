module.exports = (function () {

    'use strict';

    return {
        author: {
            email: 'manovotny@gmail.com',
            name: 'Michael Novotny',
            url: 'http://manovotny.com',
            username: 'manovotny'
        },
        files: {
            browserify: 'bundle'
        },
        paths: {
            curl: 'curl_downloads',
            source: 'src',
            translations: 'lang'
        },
        project: {
            composer: 'manovotny/wp-mailchimp-subscribe',
            description: 'A MailChimp subscription widget for WordPress.',
            git: 'git://github.com/manovotny/wp-mailchimp-subscribe.git',
            name: 'WP MailChimp Subscribe',
            slug: 'wp-mailchimp-subscribe',
            type: 'plugin', // Should be `plugin` or `theme`.
            url: 'https://github.com/manovotny/wp-mailchimp-subscribe',
            version: '1.0.0'
        }
    };

}());
