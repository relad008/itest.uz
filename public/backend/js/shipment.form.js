var ShipmentForm = (function($){
    
    var p = {
        database: [],
        product: null,

        table: $('.js-products-table tbody'),
        productSelect2: $('.js-product-select2'),
        insertButton: $('.js-insert-button'),
        resetButton: $('.js-reset-button'),
        messageModal: $('.js-message-modal'),
        errorText: $('.js-error-text'),
        quantityInput: $('.js-quantity'),
        body: $('body'),


        /**
         * Get product by id
         * 
         * @param {integer}
         * @return {object}
         */
        get: function(product_id){
            let prod;

            this.database.forEach(function(product, index){
                if (product.product_id == product_id) {
                    prod = product;
                }
            });

            return prod;
        },

        /**
         * Insert into database
         * 
         * @param {object}
         */

        insert: function(product){
            this.database.push(product);
        },

        /**
         * Remove from database by 'product_id'
         * 
         * @param {integer}
         */

        remove: function(product_id){
            this.database.forEach(function(product, index){
                if (product.product_id == product_id) {
                    p.database.splice(index, 1);
                }
            });
        },

        /**
         * Edit row in database by 'product_id'
         * 
         * @param {integer}
         * @param {object}
         */
        update: function(product_id, editedProduct){
            this.database.forEach(function(product, index){
                if (product.product_id == product_id) {
                    $.extend(product, editedProduct);
                }
            });
        },
        
        /**
         * Check if given object exists in database by 'product_id'
         * 
         * @param {integer}
         * @return {boolean}
         */
        hasObject: function(product_id){
            let isExists = false;

            this.database.forEach(function(product, index){
                if (product.product_id == product_id) {
                    isExists = true;
                }
            });

            return isExists;
        },

        addProduct: function(){
            if (this.product !== null && p.quantityInput.val() > 0) {
                this.insert({
                    text: p.product.text,
                    product_id: p.product.id,
                    quantity: p.quantityInput.val()
                });
            }
        },

        /**
         * Render all rows in database
         */
        render: function(){
            let html = "";
            /* Generate the rows */
            this.database.forEach(function(product){
                html += '<tr>' +
                            '<td>' + product.text + '</td>' +

                            '<td>' + 
                                '<div class="input-group">' +
                                    '<span class="input-group-btn">' +
                                        '<button class="btn btn-success js-edit-action" data-value="1" data-id="' + product.product_id + '" type="button">+</button>' +
                                    '</span>' +

                                    '<input type="text" name="products['+ product.product_id +'][quantity]" value="' + product.quantity + '" readonly="readonly" class="form-control bg-white text-center">' +

                                    '<span class="input-group-btn">' +
                                         '<button class="btn btn-danger js-edit-action" data-value="-1" data-id="' + product.product_id + '" type="button">-</button>' +
                                    '</span>' +
                                '</div>' +
                            '</td>' +

                            '<td>' +
                                '<button class="btn btn-danger js-remove-button" data-id="' + product.product_id +'"><i class="fa fa-trash"></i></button> ' +
                            '</td>' +
                        '</tr>';
            });

            /* Append to table */
            this.table.html(html);
        },

        /**
         * Reset form
         */
        reset: function(){
            this.product = null;
            this.productSelect2.html('');
            this.quantityInput.val('');
        },


        showError: function(text){
            this.errorText.html(text);
            this.messageModal.modal('show');
        }
    }

    p.init = function(options) {
        this.o = options;
            
        // init Select2
        p.productSelect2.select2({
            theme: 'bootstrap',
            ajax : {
                url : p.o.products_url,
                dataType : 'JSON',

                data: function (params) {
                    return {
                        term: params.term
                    }
                },

                processResults: function (data) {
                    return {
                        results: $.map(data.items, function (item) {
                            return {
                                text: item.name_ru,
                                id: item.id,
                                quantity: item.quantity
                            }
                        })
                    }
                }  
            }
        }).on('select2:select', function(e){
            p.product = e.params.data;
            if (p.hasObject(p.product.id)){
                p.showError('Извините, данный товар уже добавлен, выберите другой товар.');
                p.reset();
            }else{
                // Sales.productDisplay.addClass('text-success')
                //                     .removeClass('text-danger')
                //                     .html(Sales.product.text);
                // Sales.priceInput.val(Sales.product.price);

                // Sales.enableButtons();
                // Sales.totalDisplay.html(Sales.calculateTotal());

                // // Set stock quantity
                // Sales.stock.set(Sales.product.in_stock - 1);
            }
        });

        /* Re-render all the after inserting new row */
        this.insertButton.click(function(e){
            e.preventDefault();
            if (p.product === null || p.product === undefined) {
                p.showError('Пожалуйста выберите продукт.');
            }
            else{
                p.addProduct();
                p.render();
                p.reset();
            }
        });

        /* Reset the form and their value on reset click */
        this.resetButton.click(function(e){
            e.preventDefault();
            p.reset();
        });

        /* Delete row */
        p.body.on('click', '.js-remove-button', function(e){
            e.preventDefault();
            // Removing the row from db
            p.remove($(this).data('id'));

            // Visually removing row
            $(this).parents('tr').remove();
        });

        p.body.on('click', '.js-edit-action', function(){
            let _this = $(this),
                product_id = _this.data('id'),
                product = p.get(product_id),
                value = _this.data('value');

                product.quantity = parseInt(product.quantity);
                
            if (product.quantity + value <= 0) {
                product.quantity += product.quantity;
                product.quantity = 1;
            }else{
                product.quantity += value;
            }

            p.update(product_id, product);
            p.render();
        });
    }

    return p;
}(jQuery));