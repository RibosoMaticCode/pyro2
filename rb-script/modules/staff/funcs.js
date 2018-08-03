$(document).ready(function() {
  // Grabar staff
  $('#frmstaff').submit( function ( event ){
    event.preventDefault();
    tinyMCE.triggerSave();
    $.ajax({
      method: "post",
      url: "../rb-script/modules/staff/staff.save.php",
      data: $( this ).serialize()
    })
    .done(function( data ) {
      if(data.result){
        notify(data.message);
        setTimeout(function(){
          window.location.href = '../rb-admin/module.php?pag=staff&id='+data.id;
        }, 800);
      }else{
        notify(data.message);
      }
    });
  });

  // Eliminar depre
  $('.delete').click( function ( event ){
    event.preventDefault();
    var eliminar = confirm("¿Está seguro de eliminar?");
    if ( eliminar ) {
      var id = $(this).attr('data-id');
      $.ajax({
        method: "get",
        url: "../rb-script/modules/staff/staff.delete.php?id="+id
      })
      .done(function( data ) {
        if(data.result){
          notify(data.message);
          setTimeout(function(){
  					window.location.href = '../rb-admin/module.php?pag=staff';
  				}, 800);
        }else{
          notify(data.message);
        }
      });
    }
  });
});
