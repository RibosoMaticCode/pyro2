<script src="https://cdn.tiny.cloud/1/ps5i07pvkamnbbmlhns1u03mtgsklhslpb2u013m2xropaor/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
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