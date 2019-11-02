/**
 * attach_video VC control
 */
;(function ($) {
    $('#vc_ui-panel-edit-element').on('click', '.awb_attach_audio_btn', function(e) {
        e.preventDefault();
        var $this = $(this);
        var $input = $this.prev('.awb_attach_audio').children('input');
        var $label = $this.next('.awb_attach_audio_label');
        var frame = $this.data('wp-frame');

        // if selected - remove
        if ($this.hasClass('awb_attach_audio_btn_selected')) {
            $input.val('');
            $label.html('');
            $this.html($this.attr('data-select-title'));
            $this.removeClass('awb_attach_audio_btn_selected');
            return;
        }

        // If the media frame already exists, reopen it.
        if (frame) {
            frame.open();
            return;
        }

        if (!wp.media) {
            console.error('Can not access wp.media object.');
            return;
        }

        // Create a new media frame
        frame = wp.media({
            title: 'Select or Upload Audio',
            button: {
                text: 'Use this audio'
            },
            multiple: false,
            library: {
                type : 'audio'
            }
        });
        $this.data('wp-frame', frame);


        // When an video is selected in the media frame...
        frame.on('select', function() {
            // Get media attachment details from the frame state
            var attachment = frame.state().get('selection').first().toJSON();

            if (attachment) {
                console.log(attachment);
                $input.val(attachment.id);
                $label.html(attachment.filename);
                $this.html($this.attr('data-remove-title'));
                $this.addClass('awb_attach_audio_btn_selected');
            }
        });

        // Finally, open the modal on click
        frame.open();
    });
})(jQuery);