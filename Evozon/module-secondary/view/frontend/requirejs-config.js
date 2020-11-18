var config = {
    config: {
        mixins: {
            'Magento_Checkout/js/view/minicart': { // careful with this path, not all are right under the JS folder
                'Evozon_Secondary/js/view/minicart-mixin': true
            }
        }
    }
};
