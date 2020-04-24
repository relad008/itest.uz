const Sales = {
    database: [],
    table: $('.js-products-table tbody'),
    select: $('.js-product-select'),

    percent: 1,
    bankPercent: 1,
    cardPercent: 1,

    /* --- Product which is selected --- */
    product: null,
    amount: 1,

    /* --- Displays --- */
    productDisplay: $('.js-product-display span'),
    totalDisplay: $('.js-total-display span'),
    sumDisplay: $('.js-sum-display span'),
    
    /* --- Panels --- */
    panels:                 $('.js-order-panel'),
    successPanel:           $('.js-success-panel'),

    /* --- Buttons & Inputs --- */
    actionButtons: $('.js-action-button'),
    insertButton: $('.js-insert-button'),
    resetButton: $('.js-reset-button'),
    saveButton: $('.js-save-button'),
    amountInput: $('.js-amount-input'),
    commentInput: $('.js-comment-input'),
    paymentMethod: $('[name=payment_method]'),

    /* Hidden inputs */
    productsHiddenInput:    $('[name="products"]'), 
    commentsHiddenInput:    $('[name="comment"]'),

    /* Edit modal inputs only */
    modalInputs: $('.js-edit-modal .form-control'),
    saveRowButton: $('.js-save-row-button'),
    lastEditId: 0,

    /* --- Main CRUD methods --- */

    /**
     * Get product by id
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
     * @param {object}
     */

    insert: function(product){
        this.database.push(product);
    },

    /**
     * Remove from database by 'product_id'
     * @param {integer}
     */

    remove: function(product_id){
        this.database.forEach(function(product, index){
            if (product.product_id == product_id) {
                Sales.database.splice(index, 1);
            }
        });
    },

    /**
     * Edit row in database by 'product_id'
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

    /* First insert the product into database */
    addProduct: function(){
        if (this.product !== null) {
            this.insert({
                name: Sales.product.text,
                product_id: Sales.product.id,
                price: Sales.product.price,
                tmp_price: Sales.product.tmp_price,
                amount: Sales.amount,
                total: Sales.calculateTotal(), 
            });
        }
    },

    /**
     * Render all rows in database
     */

    render: function(){
        let html = "";

        /*

            
            '<div class="input-group">' +
              '<span class="input-group-btn">' +
                '<button class="btn btn-default" type="button">+</button>' +
              '</span>' +
              <input type="text" class="form-control" placeholder="Search for..."> +
            '</div>' +
    

        */

        /* Generate the rows */
        this.database.forEach(function(product){
            html += '<tr>' +
                        '<td>' + product.name + '</td>' +
                        '<td>' + product.price + '</td>' +

                        '<td>' + 
                            '<div class="input-group">' +
                                '<span class="input-group-btn">' +
                                    '<button class="btn btn-success js-edit-action" data-value="1" data-id="' + product.product_id + '" type="button">+</button>' +
                                '</span>' +

                                '<input type="text" value="' + product.amount + '" disabled class="form-control bg-white">' +

                                '<span class="input-group-btn">' +
                                     '<button class="btn btn-danger js-edit-action" data-value="-1" data-id="' + product.product_id + '" type="button">-</button>' +
                                '</span>' +
                            '</div>' +
                        '</td>' +

                        '<td>' + product.total + '</td>' +

                        '<td>' +
                            '<button class="btn btn-danger js-remove-button" data-id="' + product.product_id +'"><i class="fa fa-trash"></i></button> ' +
                        '</td>' +
                    '</tr>';
        });

        /* Append to table */
        this.table.html(html);

        /* Calculate total price */
        this.sumDisplay.html(this.sumTotals());
    },

    /**
     * Change amount of product
     * @param {integer}
     * @return {boolean}
     */

    amountChange: function(value){
        if (this.amount + value <= 0) {
            this.stock.add(this.amount - 1);
            this.amount = 1;
        }else if(this.stock.amount - value <= -1){
            this.showError('На складе осталось ' + this.stock.amount + ' товаров.');
        }else{
            this.amount += value;
            this.stock.subtract(value);
        }
    },

    /**
     * Calculate total for one product
     * @return {integer}
     */

    calculateTotal: function(product){
        if (product) {
            return Math.round(product.price * product.amount); 
        }

        return Math.round(this.product.price * this.amount); 
    },

    /**
     * Sum totals of all products
     * @return {integer}
     */

    sumTotals: function(){
        let total = 0;

        this.database.forEach(function(product){
            total += product.total;
        });

        return total;
    },

    getPercent: function(value) {
        if (value == 'bank') {
            return Sales.bankPercent;
        }
        else if(value == 'card') {
            return Sales.cardPercent;
        }

        return 1;
    },

    /**
     * Show error text
     * @param {string}
     */

    showError: function(errorString){
        window.alert(errorString);
    },

    /**
     * Enable & Disable buttons
     */

    enableButtons: function(){
        this.actionButtons.attr('disabled', false);
    },

    disableButtons: function(){
        this.actionButtons.attr('disabled', true);
    },

    /**
     * Stock object
     */

    stock: {
        amount: 0,
        amountDisplay: $('.js-stock-amount-display span'),

        set: function(value){
            this.amount = value;
            this.display();
        },

        subtract: function(value){
            this.amount -= value;
            this.display();
        },

        add: function(value){
            this.amount += value;
            this.display();
        },

        display: function(){
            this.amountDisplay.html(this.amount);
        }
    },  

    /**
     * Reset form
     */

    reset: function(){
        this.disableButtons();
        this.product = null;

        this.productDisplay.addClass('text-danger')
                           .removeClass('text-success')
                           .html('Не выбрано');

        this.stock.set(0);

        this.totalDisplay.html(0);
        this.amount = 1;
        this.amountInput.val(this.amount);
    },

    /**
     * Save the order
     */

    save: function(){
        // Show preloader
        preloader.show();

        // Get the comment if there is
        this.commentsHiddenInput.val(this.commentInput.val());
        Sales.productsHiddenInput.val(JSON.stringify(Sales.database));

        // Send ajax
        $.ajax({
            url: '/orders/form/' + $('[name="order_id"]').val(),
            type: 'POST',

            data: {
                payment_method: this.paymentMethod.val(),
                products:  this.productsHiddenInput.val(),
                comment: this.commentsHiddenInput.val()
            },

            success: function(){
                preloader.hide();

                Sales.reset();

                Sales.panels.fadeOut(200, function(){
                    Sales.successPanel.fadeIn(200);
                });
            }
        });
    },  


}

Sales.init = function(){

    /* Set default amount to '1' */
    this.amountInput.val(1);

    /* --- Initialize select --- */

    this.select.select2({
        theme: 'bootstrap',
        ajax : {
            url : '/product/select-to',
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
                            text: item.name,
                            id: item.id,
                            price: item.price,
                            in_stock: item.in_stock
                        }
                    })
                }
            }  
        }
    }).on('select2:select', function(e){
        Sales.product = e.params.data;
        Sales.product.tmp_price = Sales.product.price;
        Sales.product.price = Math.round(Sales.product.price*Sales.percent);

        if (Sales.hasObject(Sales.product.id)){
            Sales.showError('Извините, данный товар уже добавлен, выберите другой товар.');
            Sales.reset();
        }else{
            Sales.productDisplay.addClass('text-success')
                                .removeClass('text-danger')
                                .html(Sales.product.text);

            Sales.enableButtons();
            Sales.totalDisplay.html(Sales.calculateTotal());

            // Set stock amount
            Sales.stock.set(Sales.product.in_stock - 1);
        }
    });

    /* --- Initialize events --- */

    /* Change amount value when actions are triggered */
    this.actionButtons.click(function(e){
        e.preventDefault(); 

        Sales.amountChange( $(this).data('value') );

        Sales.amountInput.val(Sales.amount);

        Sales.totalDisplay.html(Sales.calculateTotal());
    });

    /* Re-render all the after inserting new row */
    this.insertButton.click(function(e){
        e.preventDefault(); 

        if (Sales.product === null || Sales.product === undefined) {
            Sales.showError('Пожалуйста выберите продукт.');
        }
        else{
            Sales.addProduct();
            Sales.render();
            Sales.reset();
        }
    });

    /* Reset the form and their value on reset click */
    this.resetButton.click(function(e){
        e.preventDefault(); Sales.reset();
    });

    /* Delete row */
    body.on('click', '.js-remove-button', function(){
        // Removing the row from db
        Sales.remove($(this).data('id'));

        // Displaying the new sum of all prods
        Sales.sumDisplay.html(Sales.sumTotals());

        // Visually removing row
        $(this).parents('tr').remove();
    });

    body.on('click', '.js-edit-action', function(){
        let _this = $(this),
            product_id = _this.data('id'),
            product = Sales.get(product_id),
            value = _this.data('value');

        if (product.amount + value <= 0) {
            product.in_stock += product.amount;
            product.amount = 1;
        }else if(product.in_stock - value <= -1){
            Sales.showError('На складе осталось ' + product.in_stock + ' товаров.');
        }else{
            product.amount += value;
            product.in_stock -= value;
        }

        product.total = Sales.calculateTotal(product);
        Sales.update(product_id, product);
        
        Sales.sumDisplay.val(Sales.sumTotals());
        Sales.render();
    }); 

    /* Save order when clicked (Send AJAX) */
    this.saveButton.click(function(e){
        e.preventDefault(); 

        if (Sales.database.length > 0) {
            Sales.save();
        }else{
            Sales.showError('Пожалуйста добавьте хотя бы один товар.');
        }
    });

    /* Percent for plastic card */
    this.paymentMethod.change(function(){
        Sales.percent = Sales.getPercent($(this).val());
        $.each(Sales.database, function(i) {
            Sales.database[i].price = Math.round(Sales.database[i].tmp_price * Sales.percent);
            Sales.database[i].total = Sales.database[i].price * Sales.database[i].amount;
        });

        if (Sales.product !== null) {
            Sales.product.price = Math.round(Sales.product.tmp_price*Sales.percent);
            Sales.totalDisplay.html(Sales.product.price*Sales.amount);
        }

        Sales.render();
    });

    /* On load method */
    // this.paymentMethod.find('option:selected').val() == 'bank' ? Sales.bankPercent : 1; 
}





