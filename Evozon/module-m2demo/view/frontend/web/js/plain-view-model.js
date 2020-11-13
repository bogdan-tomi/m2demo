define(['ko', 'jquery'], function (ko, $) {
    'use strict';

    return function (config) {

        let currencyInfo = ko.observable();
        $.getJSON(config.base_url + 'rest/V1/directory/currency', currencyInfo); // we cannot pass a value because the observable would be updated
        const viewModel = {
            // set the title as observable so any changes to its value are reflected on frontend in all the property occurrences
            title: ko.observable('Test title for a simple knockoutjs view model'),
            label: ko.observable('Currency Info')
        };

        viewModel.title.subscribe(function (oldValue) {
            console.log('Will be changed from', oldValue)
        }, this, 'beforeChange');

        viewModel.title.subscribe(function (newValue) {
            console.log('Changed to', newValue);
        });

        // any time an observable is changed inside the computed function, the function is re-called.
        // we need to delay the computed in order for the viewModel to already be created,
        // otherwise cannot read property of undefined errors occur (for the label in this case)
        viewModel.output = ko.computed(function () {
            if (!currencyInfo()) {
                return '...loading';
            }
            return this.label() + ':' + JSON.stringify(currencyInfo(), null, 2);
        }.bind(viewModel));

        viewModel.getTitle = function () {
            return this.title();
        };

        viewModel.getConfig = function () {
            return config;
        };

        return viewModel;
    }
});
