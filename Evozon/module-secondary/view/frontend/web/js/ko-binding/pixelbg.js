define([
    'ko',
    'Magento_Ui/js/lib/knockout/template/renderer',
    'Evozon_Secondary/js/plain/pixelbg'
], function (ko, renderer, pixelBackground) {
    'use strict';

    // as seen in angular/angular.js, the node type for comments is 8
    const TYPE_COMMENT = 8;

    function isVirtualElement(node) {
        return node.nodeType === TYPE_COMMENT;
    }

    // depending on the desired behaviour, we need to consider the case when the node is of type comment
    // for example, in our case, we want to create a div,  get all the child nodes of the virtual element, empty it,
    // insert the children into the div, then inject the div into the virtual element. then, instead of the virtual element,
    // we return the created div
    function makeRealElement(virtualElement) {
        const div = document.createElement('div');
        // use ko.virtualElements methods to treat comments as real elements
        const children = ko.virtualElements.childNodes(virtualElement);
        ko.virtualElements.emptyNode(virtualElement);

        for (let i = 0; i < children.length; i++) {
            div.appendChild(children[i]);
        }

        ko.virtualElements.insertAfter(virtualElement, div);

        return div;
    }

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
            // this is required for supporting both virtual elements and regular usages
            const element = isVirtualElement(node) ? makeRealElement(node) : node;
            const canvas = execute(element, valueAccessor, allBindings);
            bindingContext.$data.pixelbg = {canvas: canvas, element: element};
        },

        // for update, we need to re-use the object (e.g. canvas), so we need to store it on the viewModel after init
        // viewModel is deprecated, so we use bindingContext.$data
        update: function (node, valueAccessor, allBindings, viewModel, bindingContext) {
            // we need to retrieve the existing element, for it not to be recreated
            const element = bindingContext.$data.pixelbg.element;
            const canvas = bindingContext.$data.pixelbg.canvas;
            execute(element, valueAccessor, allBindings, canvas);
        }
    };

    // we need to add the custom biding to this property, in order to be used as a virtual element
    ko.virtualElements.allowedBindings.pixelbg = true;

    // the virtual elements is also required for custom nodes/attributes to work, as, under the hood,
    // the Magento template renderer converts custom attributes into the data-bind syntax
    // and custom elements into virtual elements, before passing the template string to ko, to apply the view model bindings

    // allows pixelbg to be used as a custom node inside ko HTML templates
    renderer.addNode('pixelbg');

    // a different binding can be specified by using an object as the second argument, as seen at
    // magento/module-ui/view/base/web/js/lib/knockout/bindings/i18n.js::174

    // allows pixelbg to be used as a custom attribute ko HTML templates
    renderer.addAttribute('pixelbg');

    return ko;
});
