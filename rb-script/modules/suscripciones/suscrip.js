$(document).ready(function() {
	// Fancybox advanced Form - Oculta boton de cerrar y evitar cerrar al clickear en fondo oscuro
	$('.fancySuscrip').fancybox({
		closeBtn    : false, // hide close button
		closeClick  : false, // prevents closing when clicking INSIDE fancybox
		helpers     : {
			// prevents closing when clicking OUTSIDE fancybox
			overlay : {closeClick: false}
		},
		keys : {
			// prevents closing when press ESC button
			close  : null
		}
	});
});
