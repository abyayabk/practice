document.addEventListener('DOMContentLoaded', function() {
    var uploadButton = document.getElementById('upload-button');
    var customField = document.getElementById('imgSrc');

    uploadButton.addEventListener('click', function(event) {
        event.preventDefault();

        var mediaUploader = wp.media({
            title: 'Choose Image',
            button: {
                text: 'Choose Image'
            },
            multiple: false
        });

        mediaUploader.on('select', function() {
            var attachment = mediaUploader.state().get('selection').first().toJSON();
            customField.value = attachment.url;
        });

        mediaUploader.open();
    });
});
