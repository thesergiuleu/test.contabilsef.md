function tinymce_init_callback(editor)
{
    editor.remove();
    editor = null;

    tinymce.init({
        menubar: false,
        selector: 'textarea.richTextBox',
        skin_url: $('meta[name="assets-path"]').attr('content') + '?path=js/skins/voyager',
        min_height: 600,
        resize: 'vertical',
        plugins: 'link, image, code, table, textcolor, lists',
        extended_valid_elements: 'input[id|name|value|type|class|style|required|placeholder|autocomplete|onclick]',
        media_live_embeds: true,
        file_browser_callback: function (field_name, url, type, win) {
            if (type == 'image') {
                $('#upload_file').trigger('click');
            }
        },
        external_plugins: {
            'media': '/js/admin/plugins/media/plugin.js',
            'youtube': '/js/admin/plugins/youtube/plugin.js',
        },
        toolbar: 'styleselect bold italic underline | forecolor backcolor | alignleft aligncenter alignright | bullist numlist outdent indent | link image media youtube table | code',
        convert_urls: false,
        image_caption: true,
        image_title: true,
    });
}
