<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<link href="uploadfile.css" rel="stylesheet">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="jquery.uploadfile.js"></script>
</head>
<body>
<div id="mulitplefileuploader">Seleccionar archivos</div>

<div id="status"></div>
<script>
$(document).ready(function(){
	var settings = {
	    url: "upload.php",
	    dragDrop:true,
	    fileName: "myfile",
	    allowedTypes:"jpg,png,gif,doc,pdf,zip",	
	    returnType:"html", //json
		onSuccess:function(files,data,xhr)
	    {
	       // alert((data));
	       //$('.ajax-file-upload-statusbar').delay(2000).slideUp('slow');
	       $("#status").append("Subido con exito");
	    },
	    //showDelete:true,
	    deleteCallback: function(data,pd)
		{
	    for(var i=0;i<data.length;i++)
	    {
	        $.post("delete.php",{op:"delete",name:data[i]},
	        function(resp, textStatus, jqXHR)
	        {  
	            $("#status").append("<div>Archivo borrado</div>");      
	        });
	     }      
	    pd.statusbar.show("hello"); //You choice to hide/not.
	
	}
}

var uploadObj = $("#mulitplefileuploader").uploadFile(settings);


});
</script>
</body>
</html>
