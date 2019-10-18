jQuery(function($){

  // Set all variables to be used in scope
  // ADD IMAGE LINK
  $(document).on( 'click', '.khaki-menu-bg-image .upload-custom-img', function( event ){
    event.preventDefault();
    var metaBox = $(this).parents('.khaki-menu-bg-image:eq(0)'); // Your meta box id here
    var addImgLink = metaBox.find('.upload-custom-img');
    var delImgLink = metaBox.find( '.delete-custom-img');
    var imgContainer = metaBox.find( '.custom-img-container');
    var imgIdInput = metaBox.find( '.custom-img-id' );

    // Create a new media frame
    var frame = wp.media({
      title: 'Select or Upload Media Of Your Chosen Persuasion',
      button: {
        text: 'Use this media'
      },
      multiple: false  // Set to true to allow multiple files to be selected
    });


    // When an image is selected in the media frame...
    frame.on( 'select', function() {

      // Get media attachment details from the frame state
      var attachment = frame.state().get('selection').first().toJSON();

      // Send the attachment URL to our custom image input field.
      imgContainer.append( '<img src="'+attachment.url+'" alt="" style="max-width:100%;"/>' );

      // Send the attachment id to our hidden input
      imgIdInput.val( attachment.id );

      // Hide the add image link
      addImgLink.addClass( 'hidden' );

      // Unhide the remove image link
      delImgLink.removeClass( 'hidden' );
    });

    // Finally, open the modal on click
    frame.open();
  });


  // DELETE IMAGE LINK

  $(document).on( 'click', '.khaki-menu-bg-image .delete-custom-img', function( event ){

    event.preventDefault();
    var metaBox = $(this).parents('.khaki-menu-bg-image:eq(0)'); // Your meta box id here
    var addImgLink = metaBox.find('.upload-custom-img');
    var delImgLink = metaBox.find( '.delete-custom-img');
    var imgContainer = metaBox.find( '.custom-img-container');
    var imgIdInput = metaBox.find( '.custom-img-id' );

    // Clear out the preview image
    imgContainer.html( '' );

    // Un-hide the add image link
    addImgLink.removeClass( 'hidden' );

    // Hide the delete image link
    delImgLink.addClass( 'hidden' );

    // Delete the image id from the hidden input
    imgIdInput.val( '' );

  });

});