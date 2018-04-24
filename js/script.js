jQuery(document).ready( function($) {

    jQuery('#your-profile').attr('enctype', 'multipart/form-data');

    jQuery('.upload-content .upload-file-buttom').on('change', function(e) {
        jQuery(this).parent().find('.upload-file-preview').hide()
    });

});


function validateYouTubeUrl()
{
    var url = $('#youTubeUrl').val();
    if (url != undefined || url != '') {
        var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=|\?v=)([^#\&\?]*).*/;
        var match = url.match(regExp);
        if (match && match[2].length == 11) {
            // Do anything for being valid
            // if need to change the url to embed url then use below line
            $('#ytplayerSide').attr('src', 'https://www.youtube.com/embed/' + match[2] + '?autoplay=0');
        }
        else {
            // Do anything for not being valid
        }
    }
}