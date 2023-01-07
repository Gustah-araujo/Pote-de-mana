 jQuery(window).scroll(function() {
    if(typeof frontend_header_object.header_sticky != 'undefined' && frontend_header_object.header_sticky == 1){    
        jQuery(window).scrollTop() >= 50 ? jQuery("header").addClass("fixed-header") : jQuery("header").removeClass("fixed-header"); 
    }
});

jQuery(document).ready(function() {
  jQuery(document).on("click", ".mega-dropdown", function(o) {
      o.stopPropagation();
    }),
    jQuery(document).on("click", ".navbar-nav > .dropdown", function(o) {
      o.stopPropagation();
    }),
    jQuery(document).on("click", "#test123 > .dropdown", function(o) {
      o.stopPropagation();
    }),
    jQuery(".dropdown-submenu").click(function() {
      jQuery(".dropdown-submenu > .dropdown-menu").toggleClass('show')
    });
});

window.onscroll = function() {
	scrollFunction()
};

function scrollFunction() {
    if(document.getElementById("myBtn") !== null && document.getElementById("myBtn").length > 0){ 
        var mybutton = document.getElementById("myBtn");
    	if(document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    		mybutton.style.display = "block";
    	} else {
    		mybutton.style.display = "none";
    	}
    }
}

function topFunction() {
	document.body.scrollTop = 0;
	document.documentElement.scrollTop = 0;
}



jQuery(function() {
  jQuery(document).click(function (event) {
    // jQuery('.navbar-collapse').collapse('hide');
  });
});

jQuery('.op-clo').on('click', function() {
    jQuery('body .h7-nav-box').toggleClass("show");
});

jQuery('.tgl-cl').on('click', function() {
  jQuery('body .h17-main-nav').toggleClass("show");
});


jQuery(document).ready(function() {

    var toTop = jQuery('#myBtn');

    // logic

    toTop.on('click', function() {

      jQuery('html, body').animate({

        scrollTop: jQuery('html, body').offset().top,

      });

    });  

});

function sapidLiveSearch(link){
    if (link.val().length >= live_search_object.live_search_min_char_count) {
        jQuery.ajax({
            url: frontend_header_object.ajaxurl,
            type: 'post',
            data: { 
                action: 'sapid_live_search_posts', 
                search: link.val(),
            },
            success: function(data) {
                link.parents('.search-form.sapid-live-search').find('.sapid-search-results-wrapper .sapid-search-results').addClass('sapid-open-box');   
                link.parents('.search-form.sapid-live-search').find('.sapid-search-results-wrapper .sapid-search-results').html( data.html );
            }
        });
    }else{
       link.parents('.search-form.sapid-live-search').find('.sapid-search-results-wrapper .sapid-search-results').removeClass('sapid-open-box');   
    }
}

jQuery(document).ready(function() {
    jQuery('.navbar-collapse').unbind();

    jQuery(".sapid-live-search-input").keyup(function() {
        var link = jQuery(this);
        sapidLiveSearch(link)
    });
});