<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<script>
$(function() {
    tinymce.init({
        selector: 'textarea',
        menubar: false,
        plugins: [
            'code'
        ],
        toolbar: 'formatselect | bold italic  | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | code',
        content_css: [
            '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
            '//www.tinymce.com/css/codepen.min.css']
    }); 
});
</script>