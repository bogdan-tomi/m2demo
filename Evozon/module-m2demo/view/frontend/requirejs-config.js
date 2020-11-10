// this belongs under the area code folder (i.e. frontend), not under the web folder
var config = {
    map: {
        // * represents which RequireJS modules can use our alias, stands for all
        '*': {
            shortcut_dependency: 'Evozon_M2Demo/js/requirejs-dependency'
        }
    },
    config: {
        // mixins are a sort of around plugins, but for RequireJS modules
        mixins: {
            'Magento_Checkout/js/checkout-data': {
                'Evozon_M2Demo/js/checkout-data-mixin': true
            }
        }
    }
};
