var $body = $('body'),
    $window = $(window),
    $document = $(document);

var baseInput = $('.input');

if (baseInput) {
    baseInput.each(function() {
        var _this = $(this);
        if (_this.val() != '') {
            _this.siblings('.label').addClass('open');
        }
    });
}

baseInput.on('input', function() {
    var _this = $(this);
    if (_this.val() != '') {
        _this.siblings('.label').addClass('open');
    }
    else {
        _this.siblings('.label').removeClass('open');
    }
});


$document.ready(function() {

    // Modal
    var transitionEnd = function() {
        var t,
            e = document.createElement('div');

        var transitions = {
            "transition": "transitionend",
            "OTransition": "oTransitionEnd",
            "MozTransition": "transitionend",
            "WebkitTransition": "webkitTransitionEnd"
        };

        for (t in transitions) {
            if (e.style[t] !== undefined) {
                return transitions[t];
            }
        }
    }();

    var Modal = function() {
        var obj = function(options) {
            var _ = this;

            _.modal = options.modal;
            _.openBtn = options.openBtn;
            _.closeBtn = options.closeBtn;
            _.modal_content = _.modal.find('.modal__content');
            _.isOpen = false;
            _.isAnimating = false;
            _.fadeDuration = options.fadeDuration || 400;

            _.afterClose = options.afterClose || null;

            _.init();
        };

        var _proto = obj.prototype;

        _proto.init = function() {
            var _ = this;

            _.openBtn.click(function(e) {
                e.preventDefault();

                if (!_.isOpen && !_.isAnimating) {
                    _.openModal();
                }
            });

            _.closeBtn.click(function(e) {
                e.preventDefault();

                if (_.isOpen && !_.isAnimating) {
                    _.closeModal();
                }
            });

            _.modal.click(function(e) {
                if (_.isOpen && !_.isAnimating) {
                    if ($(e.target).is(_.modal)) {
                        _.closeModal();
                    }
                }
            });
        };

        _proto.openModal = function() {
            var _ = this;

            _.isAnimating = true;

            $body.addClass('o-hidden');

            _.modal.fadeIn(_.fadeDuration);

            window.setTimeout(function() {
                _.modal_content.addClass('modal__content--in').one(transitionEnd, function() {
                    _.isAnimating = false;
                    _.isOpen = true;
                });
            }, _.fadeDuration / 1.5);
        };

        _proto.closeModal = function() {
            var _ = this;

            _.isAnimating = true;

            _.modal_content.removeClass('modal__content--in').one(transitionEnd, function() {
                _.modal.fadeOut(_.fadeDuration, function() {
                    _.isAnimating = false;
                    _.isOpen = false;
                    $body.removeClass('o-hidden');

                    if(_.afterClose != null)
                        _.afterClose();
                });
            });
        };
        return obj;
    }();

    var teachersModal = new Modal({
        modal: $('.js-teacher-modal'),
        openBtn: $('.js-teacher-modal-toggler'),
        closeBtn: $('.js-teacher-modal-dismisser'),
    });
    
});