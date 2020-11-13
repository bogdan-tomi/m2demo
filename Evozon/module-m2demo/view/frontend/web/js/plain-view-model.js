define(function () {
    'use strict';

    return function (config) {
        return {
            title: 'Test title for a simple knockoutjs view model',
            getTitle: function () {
                return this.title;
            },
            getConfig: function () {
                return config;
            }
        }
    }
});
