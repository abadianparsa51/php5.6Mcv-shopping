function redirect(url)
{
    location.href = url;
}

$(document).ready(function () {

    $('[data-toggle="tooltip"]').tooltip();

    if($('#page').length > 0)
    {
        $('#page').keypress(function (e) {
            if( (e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode == 13) )
            {
                var page = parseInt($(this).val().trim());
                var totalPage = parseInt($(this).attr('data-total-page'));
                if(page <= 0)
                    page = 1;
                if(e.keyCode == 13)
                {
                    if(page <= totalPage)
                    {
                        var url = $(this).attr('data-url');
                        redirect(url+'&page='+page);
                    }
                    else
                        $('#page').popover('show');
                }
            }
            else
                return false;
        });
    }


    if($('#limit').length > 0)
    {
        $('#limit').change(function(){
            var limit = $(this).val();
            var url = $(this).attr('data-url');
            redirect(url+'&limit='+limit);
        });
    }


    $('.imageUploader').each(function(){
        $(this).click(function ()
        {
            var f = $(this);
            window.KCFinder = {
                callBack: function(url) {
                    f.val(url);
                    window.KCFinder = null;
                }
            };
            var win = window.open('kcfinder-3.12/browse.php?type=image', 'kcfinder_textbox',
                'status=0, toolbar=0, location=0, menubar=0, directories=0, ' +
                'resizable=1, scrollbars=0, width=800, height=600'
            );
            win.focus();
        });


    });


});




function  initEditor(obj,height_user) {
    height_user = (typeof height_user == 'undefined') ? 500 : height_user;
    tinymce.init({
        selector: obj,
        height: height_user,
        theme: 'modern',
        plugins: [
            'advlist autolink lists link image charmap print preview hr anchor pagebreak',
            'searchreplace wordcount visualblocks visualchars code fullscreen',
            'insertdatetime media nonbreaking table contextmenu directionality',
            'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc help'
        ],
        toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
        toolbar2: 'preview media | forecolor backcolor emoticons | codesample help',
        image_advtab: true,
        templates: [
        ],
        content_css: [
        ],
        file_browser_callback: function(field, url, type, win) {

            tinyMCE.activeEditor.windowManager.open({
                file: 'kcfinder-3.12/browse.php?opener=tinymce4&field=' + field + '&type=' + type,
                title: 'KCFinder',
                width: 800,
                height: 600,
                inline: true,
                close_previous: false
            }, {
                window: win,
                input: field
            });
            return false;
        }
    });

}


