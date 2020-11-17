define(['uiComponent'], function (Component) {

    'use strict';

    return Component.extend({
        defaults: {
            value_to_import: 1204,
            exported_to_value: 'Export',
            tracks: {
                exported_to_value: true
            },
            exports: {
                value_to_import: 'exampleUiComponent:someFunc'
                // this export calls the given function once upon components creation with the given value used as param
            }
        }
    })
});
