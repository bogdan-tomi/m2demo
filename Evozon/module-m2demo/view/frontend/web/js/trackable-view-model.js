define(['ko'], function (ko) {
    'use strict';

    return function () {
        const viewModel = ko.track({
            label: 'A view model with trackable observables',
            value: 2,
            power: function () {
                return this.value * this.value;
            }
        });

        return viewModel;
    }
});
