<?php
if(isset($_GET['c'])):
	$coordenadas = $_GET['c']; 
else:
	$coordenadas = "-8.1255203,-79.0339985";
endif;
if(isset($_GET['t'])):
	$ubicacion = $_GET['t']; 
else:
	$ubicacion = "Blackpyro";
endif;
if(isset($_GET['h'])):
	$altura = $_GET['h']; 
else:
	$altura = "450";
endif;
?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">

		<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
		Remove this if you use the .htaccess -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

		<title>map</title>
		<meta name="description" content="">
		<meta name="author" content="Branding Emocion">

		<meta name="viewport" content="width=device-width,initial-scale=1.0">


		<!-- Replace favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
		<link rel="shortcut icon" href="favicon.ico">
		<link rel="apple-touch-icon" href="apple-touch-icon.png">
		
		<style type="text/css">
			*{
				margin:0;
				padding:0;
			}
		</style>
	
		<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>	
	    <script>
			
	    	function initialize() {
	    		 var styles = [
				    {
				        "stylers": [
				            {
				                "hue": "#dd0d0d"
				            }
				        ]
				    },
				    {
				        "featureType": "road",
				        "elementType": "labels",
				        "stylers": [
				            {
				                "visibility": "off"
				            }
				        ]
				    },
				    {
				        "featureType": "road",
				        "elementType": "geometry",
				        "stylers": [
				            {
				                "lightness": 100
				            },
				            {
				                "visibility": "simplified"
				            }
				        ]
				    }
				];
			  var styledMap = new google.maps.StyledMapType(styles,
			  	{name: "Styled Map"});
    
	        	var myLatlng = new google.maps.LatLng(<?= $coordenadas ?>);	// varia
	        	var mapOptions = {
	        		
	        		panControl:false, //girar
					zoomControl:true,
					zoomControlOptions: {
					    style:google.maps.ZoomControlStyle.SMALL
					},
					mapTypeControl:false, 
					scaleControl:false,
					streetViewControl:true,
					
					overviewMapControl:false, // no se funcion
					rotateControl:false, // no se funcion
					
	          		zoom: 18,	
	          		center: myLatlng,	
	          		mapTypeId: google.maps.MapTypeId.ROADMAP,
	          		
	          		mapTypeControlOptions: {
      					mapTypeIds: [google.maps.MapTypeId.ROADMAP, 'map_style']
    				}
	        	}
	        	
	        	var contentString = "<h2><?= $ubicacion ?></h2>";  // varia
	        	
	        	var infowindow = new google.maps.InfoWindow({
      				content: contentString
  				});
  
	        	var image = 'marker.png';
		        var map = new google.maps.Map(document.getElementById('map_canvas'), mapOptions);
		        
		        //Associate the styled map with the MapTypeId and set it to display.
	        	/*map.mapTypes.set('map_style', styledMap);
		        map.setMapTypeId('map_style');*/
		        
	        	var marker = new google.maps.Marker({
	            	position: myLatlng,
	            	map: map,
	            	title: '<?= $ubicacion ?>',
	            	icon: image
	        	});
	        	google.maps.event.addListener(marker, 'click', function() {
    				infowindow.open(map,marker);
  				});
  				//open default
  				infowindow.open(map,marker);
	      	}
	    </script>
	</head>

	<body onload="initialize()">
		<div style="width:100%;min-height:<?= $altura ?>px;" id="map_canvas">
			
		</div>
	</body>
</html>
