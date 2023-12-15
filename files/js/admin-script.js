function open_media_uploader_image(field_id){
    var media_uploader = wp.media({
        frame:    "post", 
        state:    "insert",
        multiple: false
    });

    media_uploader.on("insert", function(){
        var json = media_uploader.state().get("selection").first().toJSON();
        var image_url = json.url;

        // Set the image URL to your custom field (hidden text field)
        jQuery('#' + field_id).val(image_url);

        // Update the image preview
        var preview = jQuery('#' + field_id + '_preview');
        preview.attr('src', image_url);
        preview.show(); // This will make the image visible if it was hidden
    });

    media_uploader.open();
}




jQuery(document).ready(function(){
    jQuery('.post-type-scholarships #post').attr('enctype', 'multipart/form-data');
    jQuery('post-type-scholarships #post').attr('encoding', 'multipart/form-data');
});
