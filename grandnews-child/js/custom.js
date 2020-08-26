(function ($) {
    $(document).ready(function () {

        $('.social-sharing-wrp ul li a').hover(
            function () {
                //$(this).find('.swp_share').animate({'width':50},1000);
                //$(this).find('.swp_share').fadeIn(1000);
            },
            function () {
                //$(this).find('.swp_share').animate({'width':0},1000);
                //$(this).find('.swp_share').fadeOut();
            }
        );

    });
})(jQuery);

(function() {
    tinymce.PluginManager.add('true_mce_button', function( editor, url ) {
        editor.addButton('true_mce_button', {
            //text: 'Social sharing',
            title: 'Add Social Sharing',
            icon: 'perec',
            onclick: function() {
                editor.insertContent('[social-sharing]');
            }
        });
    });
})();