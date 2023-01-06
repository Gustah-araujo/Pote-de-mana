jQuery(document).ready(function() {
    jQuery('.chosen-select').chosen({width: '100%'});

    jQuery(".nav-item a").click(function() {
        var link = jQuery(this);
        id = link.attr('id');
        localStorage.setItem('nav_item_id', id);
        activeDiv = id.substring(0, id.length - 2);
        jQuery('.sapid-group-tab-link-li').hide();
        jQuery('ul.sub-menu').hide();
        jQuery('.nav-item').removeClass('active');

        if (link.parent().find('ul').length) {
            link.parent().find('ul').show();
            sid = link.parent().find('ul').find("li:first-child a").attr('id');
            activeDiv = sid.substring(0, sid.length - 2);
            link.parent().find('ul').find("li:first-child").addClass('active');
        }
        jQuery('#' + activeDiv).show();

        if (link.parent().parent('.sub-menu').length) {
            link.parent().parent('.sub-menu').show();
            link.parent().parent().parent().addClass('active');
            link.parent().addClass('active');
        } else {
            link.parent().addClass('active');
        }
    });

    jQuery(".sapid-image-select li").click(function() {
        var link = jQuery(this);
        jQuery(".sapid-image-select li label").removeClass('sapid-image-select-selected');
        link.find('label').addClass('sapid-image-select-selected');
        link.find("input[type='radio']").prop("checked", true);
        id = link.find("input[type='radio']").data('id');
        value = link.find("input[type='radio']").val();
        classname = '.'+id+'-'+value;
        parentClass =  '.'+id+'-parent';
        jQuery(".sapid_options.is_sub_fields"+parentClass).hide();
        jQuery(".sapid_options.is_sub_fields"+classname).show();
    });
    
    jQuery(".nav-item").hover(function() {
        jQuery(this).toggleClass("box-hover");
    });

    jQuery( range_slider.slider ).each(function( index, val ) {
        jQuery( "#"+val ).slider({
            range: "min",
            value: range_slider.default[index],
            min: 1,
            max: range_slider.choice[index]['max'],
            slide: function( event, ui ) {
                jQuery( "#"+range_slider.id[index] ).val( ui.value );
            }
        });
        jQuery(  "#"+range_slider.id[index] ).val( jQuery( "#"+val ).slider( "value" ) );
    });

    jQuery(".sapid-field[data-type='radio-buttonset'] input[type=radio], .sapid-field[data-type='switch'] input[type=radio]").click(function() {
        var link = jQuery(this);
        id = link.data('id');
        value = link.val();
        classname = '.'+id+'-'+value;
        parentClass =  '.'+id+'-parent';
        jQuery(".sapid_options.is_sub_fields"+parentClass).hide();
        jQuery(".sapid_options.is_sub_fields"+classname).show();
    }); 
});


jQuery(window).load(function() {
    var nav_item_id = localStorage.getItem('nav_item_id');
    if(nav_item_id != ''){
        var link = jQuery('#'+nav_item_id);
        id = link.attr('id');
        activeDiv = id.substring(0, id.length - 2);
        jQuery('.sapid-group-tab-link-li').hide();
        jQuery('ul.sub-menu').hide();
        jQuery('.nav-item').removeClass('active');

        if (link.parent().find('ul').length) {
            link.parent().find('ul').show();
            sid = link.parent().find('ul').find("li:first-child a").attr('id');
            activeDiv = sid.substring(0, sid.length - 2);
            link.parent().find('ul').find("li:first-child").addClass('active');
        }
        jQuery('#' + activeDiv).show();

        if (link.parent().parent('.sub-menu').length) {
            link.parent().parent('.sub-menu').show();
            link.parent().parent().parent().addClass('active');
            link.parent().addClass('active');
        } else {
            link.parent().addClass('active');
        }
    }

    var arr = new Array();
    jQuery(".sapid-field[data-type='radio-buttonset'] input[type=radio], .sapid-field[data-type='switch'] input[type=radio], .sapid-field[data-type='radio-image'] input[type=radio]").each(function() {
        var link = jQuery(this);
        i = 0;
        id = link.data('id');
        parentClass =  '.'+id+'-parent';
        if (jQuery.inArray(id, arr) == -1){
            jQuery(".sapid_options.is_sub_fields"+parentClass).hide();
        }
        if (link.is(':checked')) {
            arr.push(id);
            value = link.val();
            classname = '.'+id+'-'+value;
            jQuery(".sapid_options.is_sub_fields"+classname).show();
        }
    });  

});

jQuery(document).on("click", '.social-header', function() {
    var link = jQuery(this);
    id = link.data('id');
    link.parent().find('.social-body').toggle();
    link.find('.clickable').toggleClass('ui-icon-plus');
    link.find('.clickable').toggleClass('ui-icon-minus');
});

jQuery(document).on("click", '.sapidredux-repeaters-remove', function() {
    jQuery(this).parent().parent().remove();
});

jQuery(document).on("click", '.sapid-repeaters-add', function() {
    var link = jQuery(this);
    name = link.data('name');
    materialicons = false;
    index = jQuery(".main-social-body-"+name+" .social-card[data-field='"+name+"']").length;
    clone_repeator = jQuery('.clone_repeator-'+name);
    clone_repeator.find('.social-card').attr('data-field', name);
    clone_repeator.find('input:text, textarea, select').each(function () {
        var clname = jQuery(this).data("name");
        if(clname =='icon'){
            materialicons = true;
        }
        jQuery(this).attr('name', 'sapid_options['+name+']['+index+']['+clname+']');
    });

    clone_repeator.find('.ch-chosen-select').addClass('chone-chosen-select');
    jQuery('.main-social-body-'+name).append(clone_repeator.html());
    clone_repeator.find('.ch-chosen-select').removeClass('chone-chosen-select');
    clone_repeator.find('.social-card').attr('data-field', 'field');

    clone_repeator.find('input:text, textarea, select').each(function () {
        var clname = jQuery(this).data("name");
        jQuery(this).attr('name', clname);
    });

    jQuery('.chone-chosen-select').chosen({width: '100%'});

    if (materialicons == true){
        iconselector = 'sapid_options['+name+']['+index+'][icon]';
        jQuery("input[name='"+iconselector+"']").before('<i class="material-icons mdi material-icon-picker-prefix prefix"></i>');
        jQuery("input[name='"+iconselector+"']").on('focusin', function () {
            jQuery(this).parent().find('.material-icon-picker').fadeIn(200);
        });
        var $search = jQuery("input[name='"+iconselector+"']").parent().find('.material-icon-picker input[type="text"]');
        $search.on('keyup', function () {
            var search = $search.val().toLowerCase();
            var $icons = jQuery(this).siblings('.icons');
            $icons.find('i').css('display', 'none');
            $icons.find('i:contains('+search+')').css('display', 'inline-block');
        });

        var $icon = jQuery("input[name='"+iconselector+"']").parent().find('.material-icon-picker .icons .material-icons');

        $icon.on('click', function () {
            jQuery(this).closest('.material-icon-picker').prev().val(jQuery(this).text()).trigger('change');
            jQuery(this).closest('.material-icon-picker').prev().prev().removeClass();
            jQuery(this).closest('.material-icon-picker').prev().prev().addClass('material-icons mdi material-icon-picker-prefix prefix');
            jQuery(this).closest('.material-icon-picker').prev().prev().addClass(jQuery(this).text());
        });
    }
});

jQuery(document).on('change', '.chone-chosen-select, .chosen-select', function() {
    var link = jQuery(this);
    link.parent().parent().find('.social-header .sapid-repeater-header').text(link.val());
});

jQuery(document).on('keyup', '.sapid-custom-font-name', function() {
    var link = jQuery(this);
    link.parent().parent().find('.social-header .sapid-repeater-header').text(link.val());
});

jQuery(document).on("click", '#sapid-export-copy-data', function() {
    var code_field = jQuery( '#sapid-export-code-field' );
    if ( code_field.is( ':visible' ) ) {
        code_field.slideUp().text( '' );
    } else {
        code_field.slideDown(
            'slow', function() {
                var options = backend_object.options;
                options['sapid-backup'] = 1;
                code_field.text( JSON.stringify( options ) ).focus().select();
            }
        );
    }
});

jQuery(document).on("click", '#sapid-import-data', function() {
    var link = jQuery(this);
    jQuery('.loader').show();
    jQuery.ajax({
        url: backend_object.ajaxurl,
        type: 'POST',
        data: { 
            action: 'sapid_theme_setting_import', 
            nonce : backend_object.ajax_nonce,
        },
        dataType: 'JSON',
        success: function(data) {
            jQuery('.loader').hide();
            if(data.status == 1){
                link.parent().find('span.alert-text').removeClass('text-green');
                link.parent().find('span.alert-text').addClass('text-green');
                link.parent().find('span.alert-text').html(data.message);
            }else{
                link.parent().find('span.alert-text').html(data.message)
            }
        }
    });
});