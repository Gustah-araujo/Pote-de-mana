 $(window).scroll(function() {
    if(typeof frontend_header_object.header_sticky != 'undefined' && frontend_header_object.header_sticky == 1){    
        $(window).scrollTop() >= 50 ? $("header").addClass("fixed-header") : $("header").removeClass("fixed-header"); 
    }
});

$(document).ready(function() {
  jQuery(document).on("click", ".mega-dropdown", function(o) {
      o.stopPropagation();
    }),
    jQuery(document).on("click", ".navbar-nav > .dropdown", function(o) {
      o.stopPropagation();
    }),
    jQuery(document).on("click", "#test123 > .dropdown", function(o) {
      o.stopPropagation();
    }),
    $(".dropdown-submenu").click(function() {
      $(".dropdown-submenu > .dropdown-menu").toggleClass('show')
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



$(function() {
  $(document).click(function (event) {
    $('.navbar-collapse').collapse('hide');
  });
});

$('.op-clo').on('click', function() {
    $('body .h7-nav-box').toggleClass("show");
});

$('.tgl-cl').on('click', function() {
  $('body .h17-main-nav').toggleClass("show");
});


$(document).ready(function() {

    var toTop = $('#myBtn');

    // logic

    toTop.on('click', function() {

      $('html, body').animate({

        scrollTop: $('html, body').offset().top,

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

$(document).ready(function() {
    $(".sapid-live-search-input").keyup(function() {
        var link = jQuery(this);
        sapidLiveSearch(link)
    });
});