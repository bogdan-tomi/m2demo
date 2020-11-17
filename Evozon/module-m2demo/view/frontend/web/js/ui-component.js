define(['uiElement'], function (UiElement) {
    'use strict';

    return UiElement.extend({
        // defaults can be used to set specific default values
        defaults: {
            label: "My first defaults UiComponent! (1)",
            template: "Evozon_M2Demo/ui-component-template", // this looks for a ui-component-template HTML file under frontend/web/template
            tracks: {
                label: true,
                value: true
                // use the tracks property to make specific UiComponent properties observable
            },
            imports: {
                value: 'uiComponentToImport:value_to_import'
                // ensure the property being imported to is observable, otherwise the import depends on the load order of the components
                // also, the first part of the string doesn't need to be the index, it can be any selector
            }
        },
        label: "My first UiComponent!",
        value: 15,
        someFunc: function (value) {
            let return_val = value * 10;
            console.log('someFunc:', return_val);
            return return_val;
        }
    })
});
