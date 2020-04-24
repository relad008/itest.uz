var body = $('body'),
	_window = $(window);

const preloader = $('.preloader');

// Sidebar links

var asideLinks = $('.sidebar__list--drop-toggle > a');

asideLinks.click(function(){
	let _this = $(this),
		listItem = _this.parent(),
		dropdown = listItem.find('.sidebar__dropdown');
		
	if (listItem.hasClass('sidebar__list--active')) {
		listItem.removeClass('sidebar__list--active');
		dropdown.slideUp(300);
	}else{
		asideLinks.parent()
			      .removeClass('sidebar__list--active')
		          .find('.sidebar__dropdown')
		          .slideUp(300);

		listItem.addClass('sidebar__list--active');
		dropdown.slideDown(300);
	}
});

// Open menu if it has active inside

asideLinks.each(function(index, item){
	let _this = $(item),
		listItem = _this.parent();

	if (listItem.find('.sidebar__list--active').length > 0) {
		listItem.addClass('sidebar__list--active');
		listItem.find('.sidebar__dropdown').slideDown(300);
	}
});

// Make sidebar contract when overlay is clicked
$('.overlay').click(function(){
	SIDEBAR.contract();
});

var SIDEBAR = {
	toggle: $('.navbar__toggle'),

	isCompact: function(){
		return body.hasClass('compact-sidebar');
	},

	expand: function(){
		body.removeClass('compact-sidebar');
		$.cookie('isNavbarExpanded', 'true');
	},

	contract: function(){
		body.addClass('compact-sidebar');
		$.cookie('isNavbarExpanded', 'false');
	},

	init: function(){
		this.toggle.click(() => {
			if(SIDEBAR.isCompact()){
				SIDEBAR.expand();
			} else{
				SIDEBAR.contract();
			}
		});
	}
}

// Initialize sidebar toggle
SIDEBAR.init();

// On document load if window is less than > 768
// than contract the sidebar.

if (_window.width() <= 768 && !SIDEBAR.isCompact()) {
	SIDEBAR.contract();
}

if ($.cookie('isNavbarExpanded') === 'false') {
	SIDEBAR.contract();
}

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(window).on('load', function(){
	preloader.hide();
});

function initRedactor()
{
	tinymce.init({
        selector: '.js-redactor',
        height: 200,
        menubar: false,
        plugins:[
            'advlist autolink lists link image charmap print preview anchor',
            'searchreplace visualblocks code fullscreen',
            'insertdatetime media table contextmenu paste code'
              ],
        toolbar: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
        content_css: '//www.tinymce.com/css/codepen.min.css',
        file_browser_callback : function(field_name, url, type, win) { 

                // from http://andylangton.co.uk/blog/development/get-viewport-size-width-and-height-javascript
                var w = window,
                d = document,
                e = d.documentElement,
                g = d.getElementsByTagName('body')[0],
                x = w.innerWidth || e.clientWidth || g.clientWidth,
                y = w.innerHeight|| e.clientHeight|| g.clientHeight;

            var cmsURL = '/fm/index.html?&field_name='+field_name;

            if(type == 'image') {           
                cmsURL = cmsURL + "&type=images";
            }

            tinyMCE.activeEditor.windowManager.open({
                file : cmsURL,
                title : 'Filemanager',
                width : x * 0.8,
                height : y * 0.8,
                resizable : "yes",
                close_previous : "no"
            });         

        }
    });
}



