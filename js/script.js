jQuery(document).ready( function($) {

    jQuery('#your-profile').attr('enctype', 'multipart/form-data');

    jQuery('.upload-content .upload-file-buttom').on('change', function(e) {
        jQuery(this).parent().find('.upload-file-preview').hide()
    });

});
