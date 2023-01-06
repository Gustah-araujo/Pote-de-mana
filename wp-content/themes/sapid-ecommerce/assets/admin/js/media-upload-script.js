jQuery(document).ready(function($) {

  // on upload button click
  $('body').on( 'click', '.upload-input', function(e){
    var link = $(this);
    imgId = link.data('id');
    e.preventDefault();
    var button = link,
    custom_uploader = wp.media({
      title: link.data('uploader_title'),
      library : {
        type : 'image'
      },
      button: {
        text: link.data('uploader_button_text') // button label text
      },
      multiple: false
    }).on('select', function() { // it also has "open" and "close" events
      var attachment = custom_uploader.state().get('selection').first().toJSON();
      $("#upload_"+imgId+"_image").val(attachment.url);
      $(".sapid-upload-"+imgId).attr('src',attachment.url);
      $(".sapid-upload-"+imgId).show();
      $("#remove_"+imgId+"_image_button").removeClass('hide');
    }).open();
  
  });

  // on remove button click
  $('body').on('click', '.remove-input', function(e){
    e.preventDefault();
    var link = $(this);
    imgId = link.data('id');
    $("#upload_"+imgId+"_image").val('');
    $(".sapid-upload-"+imgId).attr('src','');
    $(".sapid-upload-"+imgId).hide();
    $("#remove_"+imgId+"_image_button").addClass('hide');
  });

});