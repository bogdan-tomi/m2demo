define(['ko'], function (ko) {
    'use strict';

    return function () {
        const viewModel = {
            exchange_rates: ko.observableArray([
                {
                    currency_to: 'USD',
                    rate: 1.0
                }
            ]),
            plain_values: ko.observableArray([
                1,
                2,
                3,
                4
            ])
        };

        return viewModel;
    }
});
