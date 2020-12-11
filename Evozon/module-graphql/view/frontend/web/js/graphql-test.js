define(['uiComponent', 'jquery'], function (Component, $) {
    'use strict';

    const query = `query exampleProducts($count: Int = 1){
    products(filter:{} pageSize: $count, sort: {name:ASC}) {
        total_count
        items {
          id
          __typename
          name
          sku
          image {
            url
          }
        }
    }
}`;
    return Component.extend({
        defaults: {
            tracks: {
                result: true
            }
        },
        initialize: function () {
            const payload = {
                query: query,
                variables: {
                    count: 3
                }
            };
            new Promise((resolve, reject) => {
                $.ajax({
                    url: '/graphql',
                    contentType: 'application/json',
                    dataType: 'json',
                    method: 'POST', // or maybe POST for mutations
                    data: JSON.stringify(payload),
                    success: resolve,
                    error: reject
                });
            }).then(data => this.result = data)
                .catch(console.error);
            return this._super();
        }
    })
});
