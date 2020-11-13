define(['ko'], function (ko) {
    'use strict';

    return function (config) {
        // set the title as observable so any changes to its value are reflected on frontend in all the property occurrences
        const title = ko.observable('Test title for a simple knockoutjs view model');

        title.subscribe(function (oldValue) {
            console.log('Will be changed from', oldValue)
        }, this, 'beforeChange');

        title.subscribe(function (newValue) {
            console.log('Changed to', newValue);
        });
        return {
            title: title,
            getTitle: function () {
                return title();
            },
            getConfig: function () {
                return config;
            }
        }
    }
});
