$(document).ready(function() {
  // resizable inner_header, then wrapper_header too
  $( "#inner_header" ).resizable({
    alsoResize: "#wrapper_header",
    handles: 's'
  });

});
