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
            }
        },
        label: "My first UiComponent!",
        value: 15,
        someFunc: function () {
            return this.value * 10;
        }
    })
});
