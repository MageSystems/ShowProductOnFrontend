define([
    'Magento_Ui/js/grid/columns/column',
    'jquery',
], function (Column, $) {
    'use strict';

    return Column.extend({
        defaults: {
            bodyTmpl: 'MageSystems_ShowProductOnFrontend/ui/grid/cells/link',
            fieldClass: {
                'data-grid-link-cell': true
            }
        },

        getFieldHandler: function(){
            return false;
        }
    });
});
