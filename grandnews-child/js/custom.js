(function ($) {
    $(document).ready(function () {});
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