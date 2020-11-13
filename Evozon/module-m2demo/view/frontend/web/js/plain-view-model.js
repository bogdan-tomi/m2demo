define(['ko'], function (ko) {
    'use strict';

    return function (config) {
        return {
            // set the title as observable so any changes to its value are reflected on frontend in all the property occurrences
            title: ko.observable('Test title for a simple knockoutjs view model'),
            getTitle: function () {
                return this.title();
            },
            getConfig: function () {
                return config;
            }
        }
    }
});
