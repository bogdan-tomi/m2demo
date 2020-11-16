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

        // getObservable (https://github.com/SteveSanderson/knockout-es5) is used to access specific observables when track is used
        ko.getObservable(viewModel, 'value').subscribe(function (newValue) {
            console.log('Value changed to', newValue);
        })

        return viewModel;
    }
});
