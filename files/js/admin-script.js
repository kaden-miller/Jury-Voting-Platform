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
    });

    media_uploader.open();
}
