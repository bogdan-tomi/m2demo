define(['ko', 'Evozon_Secondary/js/plain/pixelbg'], function (ko, pixelBackground) {
    'use strict';

    function execute(node, valueAccessor, allBindings, existingCanvas) {
        const value = ko.unwrap(valueAccessor()) || {};
        // we need to build the configuration object that we need to pass to our custom ko (e.g. pixelbackground)
        const config = {
            // we need to check if the value is string, because sometimes the value is an object
            // e.g. <h1 data-bind="pixelbg: {src: '<?= $block->getViewFileUrl($image); ?>', pixelSize: 50}">
            src: typeof value === 'string' ? value : value.src,
            pixelSize: typeof value === 'string' ? allBindings.get('pixelSize') : value.pixelsize,
            opacity: typeof value === 'string' ? allBindings.get('opacity') : value.opacity
        };
        // we return the result so we can store it on the viewModel
        return pixelBackground(config, node, existingCanvas);
    }

    // the name of this property is what we used as a binding
    ko.bindingHandlers.pixelbg = {
        // the first argument is the DOM node that contains our binding (e.g. h1)
        // valueAccessor is a function that returns the value of our binding (e.g. img src)
        // allBindings is an object with a get method that allows us to retrieve other properties
        // on the DOM element (e.g. pixelSize)
        init: function (node, valueAccessor, allBindings, viewModel, bindingContext) {
            const canvas = execute(node, valueAccessor, allBindings);
            bindingContext.$data.pixelbg = {canvas: canvas};
        },

        // for update, we need to re-use the object (e.g. canvas), so we need to store it on the viewModel after init
        // viewModel is deprecated, so we use bindingContext.$data
        update: function (node, valueAccessor, allBindings, viewModel, bindingContext) {
            const canvas = bindingContext.$data.pixelbg.canvas;
            execute(node, valueAccessor, allBindings, canvas);
        }
    };

    return ko;
});
