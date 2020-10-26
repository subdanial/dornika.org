/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo'

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     encrypted: true
// });

jQuery(function() {
    $.fn.button = function(action) {
        if (action === 'loading' && this.data('loading-text')) {
            this.data('original-text', this.html()).html(this.data('loading-text')).prop('disabled', true);
        }
        if (action === 'reset' && this.data('original-text')) {
            this.html(this.data('original-text')).prop('disabled', false);
        }
    };
    
    $('.upload-image').imageupload({
        allowedFormats: [ 'jpg', 'png' ],
        maxFileSizeKb: 1028,
    });

    (function(){

    var persianSort = [ 'آ', 'ا', 'ب', 'پ', 'ت', 'ث', 'ج', 'چ', 'ح', 'خ', 'د', 'ذ', 'ر', 'ز', 'ژ',
                        'س', 'ش', 'ص', 'ط', 'ظ', 'ع', 'غ', 'ف', 'ق', 'ک', 'گ', 'ل', 'م', 'ن', 'و', 'ه', 'ی', 'ي' ];
        
    function GetUniCode(source) {
        source = $.trim(source);
        var result = '';
        var i, index;
        for (i = 0; i < source.length; i++) {
            //Check and fix IE indexOf bug
            if (!Array.indexOf) {
                index = jQuery.inArray(source.charAt(i), persianSort);
            } else{
                index = persianSort.indexOf(source.charAt(i));
            }
            if (index < 0) {
                index = source.charCodeAt(i);
            }
            if (index < 10) {
                index = '0' + index;
            }
            result += '00' + index;
        }
        return 'a' + result;
    }
    
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.fn.dataTable.ext.buttons.reload = {
        text: 'Reload',
        action: function ( e, dt, node, config ) {
            dt.ajax.reload();
        }
    };

    jQuery.extend( jQuery.fn.dataTableExt.oSort, {
        "pstring-pre": function ( a ) {
            return GetUniCode(a.toLowerCase());
        },
        
        "pstring-asc": function ( a, b ) {
            return ((a < b) ? -1 : ((a > b) ? 1 : 0));
        },
        
        "pstring-desc": function ( a, b ) {
            return ((a < b) ? 1 : ((a > b) ? -1 : 0));
        },
    } );
        
    }());
    
    var menu_flag;
    $(".menu-visitor-settings").click(function () {
        $('#visitor-settings').modal();
    })
    $(".menu-setting").click(function () {
        menu_flag = "setting";
        $('.cover').fadeIn();
        $('.nav-right-setting').animate({
            "margin-right": '+=300'
        }, 400);
    })
    $(".menu-catalog").click(function () {
        menu_flag = "catalog";
        $('.cover').fadeIn();
        $('.nav-right-catalog').animate({
            "margin-right": '+=300'
        }, 400);
    })
    $(".menu-stuff").click(function () {
        menu_flag = "stuff";
        $('.cover').fadeIn();
        $('.nav-left').animate({
            "margin-left": '+=300'
        }, 400);
    })

    $('.saveSettings').click(function () {
        $('.saveSettingsForm').submit();
    });

    $(".cover").click(function () {
        var current_menu_class;
        switch (menu_flag) {
            case "setting":
                current_menu_class = ".nav-right-setting";
                margin_selector = "right";
                break;
            case "catalog":
                current_menu_class = ".nav-right-catalog";
                margin_selector = "right";
                break;
            case "stuff":
                current_menu_class = ".nav-left";
                margin_selector = "left";
                break;
        }
        $('.cover').fadeOut("");
        if (margin_selector == "right") {
            $(current_menu_class).animate({
                "margin-right": '-=300'
            }, 400);
        } else {
            $(current_menu_class).animate({
                "margin-left": '-=300'
            }, 400);
        }
    });
});

function objectifyForm(formArray) {
    var returnArray = {};
    for (var i = 0; i < formArray.length; i++){
      returnArray[formArray[i]['name']] = formArray[i]['value'];
    }
    return returnArray;
}

jQuery(document).on('click', '.number-spinner button', function (e) {    
    e.preventDefault();
	var btn = $(this),
		oldValue = btn.closest('.number-spinner').find('input').val().trim(),
		newVal = 0;
	
	if (btn.attr('data-dir') == 'up') {
		newVal = parseInt(oldValue) + 1;
	} else {
		if (oldValue > 1) {
			newVal = parseInt(oldValue) - 1;
		} else {
			newVal = 0;
		}
	}
	btn.closest('.number-spinner').find('input').val(newVal);
});

jQuery(document).on('click', '.number-spinner-ajax button', function (e) {    
    e.preventDefault();
	var btn = $(this),
		oldValue = btn.closest('.number-spinner-ajax').find('input').val().trim(),
		stuff = btn.parents('.stuff'),
		newVal = 0;
	
	if (btn.attr('data-dir') == 'up') {
		newVal = parseInt(oldValue) + 1;
	} else {
		if (oldValue > 1) {
			newVal = parseInt(oldValue) - 1;
		} else {
			newVal = 0;
		}
    }
    
    // if ( newVal == 0 ) {
    //     return false;
    // }

    var item = stuff.data('item'),
        cart = stuff.data('cart');

    stuff.addClass('changing');
    axios.post('/api/changeItem', {
        'cart': cart,
        'item': item,
        'number': newVal
    } )
    .then(res => {
        stuff.removeClass('changing');
        $('.total-cart').html(res.data.price);
        $('.commission-cart').html(res.data.commission);
        btn.closest('.number-spinner-ajax').find('input').val(res.data.number);
        btn.parents('.float-right').find('.box-spinner-ajax input').val(res.data.box);
        btn.parents('.clearfix').find('.stuff-price').html(res.data.item_price);
    })
    .catch(err => {
        stuff.removeClass('changing');
        btn.closest('.number-spinner-ajax').find('input').val(oldValue);
    })  
});

jQuery(document).on('click', '.box-spinner-ajax button', function (e) {    
    e.preventDefault();
	var btn = $(this),
		oldValue = btn.closest('.box-spinner-ajax').find('input').val().trim(),
		stuff = btn.parents('.stuff'),
		newVal = 0;
	
	if (btn.attr('data-dir') == 'up') {
		newVal = parseInt(oldValue) + 1;
	} else {
		if (oldValue > 1) {
			newVal = parseInt(oldValue) - 1;
		} else {
			newVal = 0;
		}
    }
    
    // if ( newVal == 0 ) {
    //     return false;
    // }

    var item = stuff.data('item'),
        cart = stuff.data('cart');

    stuff.addClass('changing');
    axios.post('/api/changeItemBox', {
        'cart': cart,
        'item': item,
        'box': newVal
    } )
    .then(res => {
        stuff.removeClass('changing');
        $('.total-cart').html(res.data.price);
        $('.commission-cart').html(res.data.commission);
        btn.closest('.box-spinner-ajax').find('input').val(res.data.box);
        btn.parents('.float-right').find('.number-spinner-ajax input').val(res.data.number);
        btn.parents('.clearfix').find('.stuff-price').html(res.data.item_price);
    })
    .catch(err => {
        stuff.removeClass('changing');
        btn.closest('.box-spinner-ajax').find('input').val(oldValue);
    })  
});

jQuery('.deleteItemCart').on('click', function () {
    var id = $(this).data('item'),
        stuff = $(this).parents('.stuff');
    if ( id ) {
        stuff.addClass('changing');
        axios.post('/api/removeItem', {
            id: id
        })
        .then(res => {
            stuff.removeClass('changing');
            $('.total-cart').html(res.data.price);
            $('.commission-cart').html(res.data.commission);
            stuff.remove();
        })
        .catch(err => {
            stuff.removeClass('changing');
            console.error(err); 
        })
    }
});