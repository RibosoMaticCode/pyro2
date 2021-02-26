<script src="https://cdn.tiny.cloud/1/ps5i07pvkamnbbmlhns1u03mtgsklhslpb2u013m2xropaor/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script>
$(function() {
  tinymce.init({
    selector: '#ta, .mceEditor, .mce_tiny',
    entity_encoding : "raw",
    menubar: false,
    convert_urls : false,
    language_url : '<?= G_SERVER ?>rb-admin/tinymce/langs/es_MX.js',
    height: 300,
    //forced_root_block : false,
    extended_valid_elements: "i[class], span, span[class]",
    plugins: [
      'advlist autolink lists link image charmap print preview anchor textcolor',
      'searchreplace visualblocks code fullscreen table',
      'insertdatetime media table contextmenu paste code'
    ],
    toolbar: 'insert | table |  formatselect | bold italic forecolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat code',
    content_css: '//www.tinymce.com/css/codepen.min.css',
    file_browser_callback   : function(field_name, url, type, win) {
      if (type == 'file') {
        var cmsURL       = 'gallery.explorer.tinymce.php?type=file';
      } else if (type == 'image') {
        var cmsURL       = 'gallery.explorer.tinymce.php?type=image';
      }

      tinymce.activeEditor.windowManager.open({
        file            : cmsURL,
        title           : 'Selecciona una imagen',
        width           : 860,
        height          : 600,
        resizable       : "yes",
        inline          : "yes",
        close_previous  : "yes"
      }, {
        window  : win,
        input   : field_name
      });
    }
  });
})
</script>
