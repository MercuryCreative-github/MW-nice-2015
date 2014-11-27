jQuery(document).ready(function($) {
    $(document).on("click", ".upload_menu_image_icon_button", function() {

        jQuery.data(document.body, 'prevElement', $(this).prev());

        window.send_to_editor = function(html) {
            var imgurl = jQuery('img',html).attr('src');
            var inputText = jQuery.data(document.body, 'prevElement');

            if(inputText !== undefined && inputText !== '')
            {
                inputText.val(imgurl);
            }

            tb_remove();
        };

        tb_show('', 'media-upload.php?type=image&tab=library&TB_iframe=true');
        return false;
    });
});