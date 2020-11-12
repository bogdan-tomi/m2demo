// this belongs under the area code folder (i.e. frontend), not under the web folder
var config = {
    map: {
        // * represents which RequireJS modules can use our alias, stands for all
        '*': {
            shortcut_dependency: 'Evozon_M2Demo/js/requirejs-dependency' // SKIP .JS SUFFIX!
        }
    },
    config: {
        // mixins are a sort of around plugins, but for RequireJS modules
        mixins: {
            'Magento_Checkout/js/checkout-data': {
                'Evozon_M2Demo/js/checkout-data-mixin': true
            }
        }
    },
    // 'load' this for all pages, before other modules
    deps: ['Evozon_M2Demo/js/logs-when-loaded'],
    // 'load' this before specific module
    shim: {
        'Magento_Catalog/js/view/compare-products': {
            deps: ['Evozon_M2Demo/js/before-products-compare']
        }
    }
    // },
    // // paths can be used to map aliases globally, similar to map, but whereas map can only alias full RequireJS modules,
    // // paths can be used for specific paths. map can de declared to be valid only within a certain module, while
    // // paths is always applied globally
    // paths: {
    //     'evozon': 'Evozon_M2Demo/js/v1'
    // }
};
