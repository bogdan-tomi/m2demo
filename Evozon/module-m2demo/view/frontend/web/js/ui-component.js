define(['uiElement'], function (UiElement) {
    'use strict';

    return UiElement.extend({
        // defaults can be used to set specific default values
        defaults: {
            label: "My first defaults UiComponent! (1)",
            template: "Evozon_M2Demo/ui-component-template" // this looks for a ui-component-template HTML file under frontend/web/template
        },
        label: "My first UiComponent!"
    })
});
