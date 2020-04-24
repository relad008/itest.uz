var ProductForm = {
	f_container: $('.js-feature-container'),
	f_group_orders: $('.js-feature_group_orders')
};

ProductForm.initLang = function() {
	$('.js-lang-selector').on('change', function(e) {
        $('.js-lang').removeClass('active in');
        $('.js-lang-' +$(this).val()).addClass('active in');
    });
    
    $('.js-lang-' +$('.js-lang-selector :selected').val()).addClass('active in');
}

ProductForm.initList = function() {
	var _parent;

	$(".js-nested-list-item").on('click', function(e) {

		if (e.target.tagName.toLowerCase() == "a") {
			_parent = $(this).parent();
			_parent.toggleClass('nested-list__item--active');
			_parent.find('> ul').eq(0).animate({
	            height: 'toggle'
	        });
	        e.preventDefault();
	    }   
    });
}

/**
 * Initialize uploaded product images 
 */
ProductForm.initThumbnails = function() {
	var _this,
		type,
		element = $('.js-product-img'),
		remove = $('.js-product-remove'),
		elementText = '<span class="label label-success product-label">основной</span>',
		input = $('.js-main-image'),
		trash = [];

	/**
	 * Set main image for cover
	 * 
	 * @param int key
	 */
	function setMain(key) {
		$('.product-label').remove();
		element.parent().eq(key).append(elementText);
		input.val(key);
	}

	// /**
	//  * Reset all keys after delete
	//  */
	// function resetKeys() {
	// 	element = $('.js-product-img');
	// 	element.each(function(i, elem){
	// 		$(elem).parent().data('key', i);
	// 	});
	// }

	element.on('click', function(e) {
		_this = $(this).parent();
		setMain(_this.data('key'));
		e.preventDefault();
	});

	remove.on('click', function(e) {
		e.preventDefault();
		_this = $(this).parent();
        trash.push(_this.data('key'));
        $('.js-removed-images').val(trash.join(','));
        
        var _this = _this.hide();
    	// resetKeys();

   		if (_this.data('key') == input.val()) {
	    	input.val(0);
   		} 

	});

	setMain(0);
}

ProductForm.initFeature = function() {
	var _template = $('.js-feature-templete'),
		_f_c = $('.js-feature-row').length - 1,
		_f_e = 0,
		_this,
		_values,
		_value_el;

	// Add new value
	$('.js-add-feature').on('click', function(e) {

		e.preventDefault();
		var _current_group = $('.js-feature-group.active').data('id'),
			_item;

		_f_e = _template.clone().hide();
		_f_e.find('select,input').each(function(i, item) {
			$(this).attr('name', $(this).attr('name').replace(/#n#/, _f_c));
		});
		_f_e.attr('data-group_id', _current_group);
			
		_f_e.find('[data-type=option]').each(function(i, item) {
			_item = $(item);
			if(_item.data('group_id') != _current_group) {
				_item.remove();
			}
		});

		_f_e.appendTo(ProductForm.f_container).slideDown(300);
		_f_c++;
	});

	// Remove value
	$('body').on('click', '.js-remove-feature', function(e) {
		$(this).closest('.js-feature-row').slideUp(300, function() {
			$(this).remove();
		});
		e.preventDefault();
	});

	// Feature values
	$('body').on('change', '.js-feature', function() {
		_this = $(this),
		_values = '';
		_feature_row = _this.closest('.js-feature-row');
		_feature_row.find('.js-feature-custom-value').val('');
		_value_el = _feature_row.find('.js-feature-value');
		_value_el.prop('disabled', true);

		$.ajax({
			method: 'POST',
			url: ProductForm.o.feature_values_url,
			data: {feature_id: _this.val()},

			success: function(response) {
				$.each(response, function(id, item) {
					_values += '<option value="' + id + '">' + item  + '</option>';
				})
				if (response.length != 0) {
					_value_el.prop('disabled', false);
				}
				_value_el.html(_values)
			}
		})
	});

	var _category_id = $('[name=category_id]:checked').val();
	this.hideShowGroups(_category_id); 

	$('[name=category_id]').on('change', function(){
		ProductForm.hideShowGroups($(this).val());
		ProductForm.initFeatreGroups($(this).val());
		ProductForm.hasGroups(true);
	});

	$('.js-feature-group').on('click', function(){
		ProductForm.hideShowFeatures($(this).data('id'));
	});

	if(_category_id > 0) {
		this.hasGroups(true);
		this.initFeatreGroups(_category_id);
	} else {
		this.hasGroups(false);
	}

}


ProductForm.hasGroups = function (has){
	if (has) {
		$('.js-features-empty').hide();
		$('.js-features').show();
	} else {
		$('.js-features-empty').show();
		$('.js-features').hide();
	}
}

ProductForm.hideShowFeatures = function (group_id) {
	var _item;
	$('.js-feature-group').removeClass('active');
	$('.js-feature-group[data-id='+ group_id +']').addClass('active');

	ProductForm.f_container.find('.js-feature-row')
			   .each(function (i, item) {

		_item = $(item);

		if (_item.data('group_id') == group_id) {
			_item.show();
		} else {
			_item.hide();
		}
	});
}

ProductForm.hideShowGroups = function (category_id) {
	var category_feature_group = ProductForm.o.feature_groups[category_id],
		_first = true;

	$('.js-feature-group').each(function(i, item) {
		_item = $(item);

		if ($.inArray( _item.data('id'), category_feature_group ) != -1) {
			if (_first) {
				_first = false;
				ProductForm.hideShowFeatures(_item.data('id'));
			}
			_item.show();
		} else {
			_item.hide();
		}
	});

}



ProductForm.initFeatreGroups = function(category_id) {
	var category_feature_group = ProductForm.o.feature_groups[category_id];

	var _item;
	var feature_groups = $('.js-feature-groups').sortable({
		onDrop: function ($item, container, _super) {
			var data = feature_groups.sortable("serialize").get();
			var jsonString = JSON.stringify(data);
			ProductForm.f_group_orders.val(jsonString);
			_super($item, container);
			console.log(jsonString);
		},
		serialize: function (parent, children, isContainer) {

			_item = $(parent);

			if (!isContainer && $.inArray( _item.data('id'), category_feature_group ) != -1) { 
				return _item.data('id');
			}

			return children;
		}
	}),
	groups_json = JSON.stringify(feature_groups.sortable("serialize").get());
	ProductForm.f_group_orders.val(groups_json);

}

ProductForm.initSelect2 = function() {
	$('.js-manufacturer-select').select2({
        theme: 'bootstrap',
        ajax : {
            url : ProductForm.o.manufacturer_url,
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
                        }
                    })
                }
            }  
        }
    });

    $('.js-gifts, .js-accessories').select2({
        theme: 'bootstrap',
        tags: true,
        ajax : {
            url : ProductForm.o.products_url,
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
                        }
                    })
                }
            }  
        }
    });
}

ProductForm.saveAndStay = function() {
	var form = $('#form');
	$('.js-save-and-stay').click(function () {
		$('<input />').attr('type', 'hidden')
          .attr('name', "continue")
          .attr('value', "1")
          .appendTo(form);
		
		form.submit();
	});
}

ProductForm.init = function(options) {
	this.o = options;
	initRedactor();
	this.initLang();
	this.initList();
	this.initFeature();
	this.initSelect2();
	this.initThumbnails();
	this.saveAndStay();
}




        
