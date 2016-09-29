<?php
  
    require 'database.php';

    if ( !empty($_POST)) {
        // keep track validation errors
                $unidadeError = null;
        $enderecoError = null;
        $latitudeError = null;
        $longitudeError = null;
      
        // keep track post values
        $unidade = $_POST['name'];
        $endereco = $_POST['address'];
        $latitude = $_POST['lat'];
                $longitude = $_POST['lng'];            
      
        // validate input
        $valid = true;
        if (empty($unidade)) {
            $unidadeError = 'Digite a unidade!';
            $valid = false;
        }
      
        $valid = true;
        if (empty($endereco)) {
            $enderecoError = 'Digite o endereço!';
            $valid = false;
        }
              
        $valid = true;
        if (empty($latitude)) {
            $latitudeError = 'Digite a Latitude!';
            $valid = false;
        }              
      
        if (empty($longitude)) {
            $longitudeError = 'Digite a Langitude!';
            $valid = false;
        }
      
        // insert data
        if ($valid) {
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO dados_mapa (name,address,lat,lng) values(?, ?, ?, ?)";
            $q = $pdo->prepare($sql);
            $q->execute(array($unidade,$endereco,$latitude,$longitude));
            Database::disconnect();
            header("Location: sucesso.php");
        }
    }

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
	<title>Cadastrar Unidade</title>	
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />            
	<meta name="author" content="pixelhint.com">
	<meta name="description" content="Magnetic is a stunning responsive HTML5/CSS3 photography/portfolio website  template"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0" />
	
        <link rel="stylesheet" type="text/css" href="css/reset.css">        
        <link href="css/bootstrap.min_form.css" rel="stylesheet">            
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">             
	<link rel="stylesheet" type="text/css" href="css/main.css">
        
        <script src="js/bootstrap.min.js"></script>
        <script src="js/jquery.min.js"></script>            
        <script type="text/javascript" src="js/jquery.js"></script>
        <script type="text/javascript" src="js/main.js"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBb2teujcc-yfUl3-N768iVbdzmxZAMoz0"charset=""type="text/javascript"></script>        
</head>
<body onLoad="initialize()">
    <section class="main clearfix">
	<section class="top">	
	    <div class="wrapper content_header clearfix">
		<div class="work_nav">				
                    <ul class="btn clearfix">
                        <li><a href="index.php" class="close-btn" ></a></li>
		    </ul>												
		</div><!-- end work_nav --> 
		<h1 class="title">Cadastrar Unidade</h1>
	    </div>		
	</section><!-- end top -->                      
	<section class="wrapper">
            <div class="content">
        <!--<div class="dividir-pagina">  -->              
            <form  id="cadastro" name="cadastro" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>"> 
                    <div style="position:relative; margin-top:0px;"align="center">
                        <ul class="demo-3">
                            <li>
                                <figure>
                                    <img src="img/dica_1.png" alt=""/>
                                    <figcaption>
                                        <h2>Dica #1</h2>
                                        <p>Para iniciar a busca pela Unidade Prisional, adicionar o endereço COMPLETO no campo abaixo.</p>
                                    </figcaption>
                                </figure>
                            </li>
                        </ul>
                        <ul class="demo-3">
                            <li>
                                <figure>
                                    <img src="img/dica_2.png" alt=""/>
                                    <figcaption>
                                        <h2>Dica #2</h2>
                                        <p>Para iniciar a busca pela Unidade Prisional, adicionar o endereço COMPLETO no campo abaixo.</p>
                                    </figcaption>
                                </figure>
                            </li>
                        </ul>    
                        <ul class="demo-3">
                            <li>
                                <figure>
                                    <img src="img/dica_3.png" alt=""/>
                                    <figcaption>
                                        <h2>Dica #3</h2>
                                        <p>Para iniciar a busca pela Unidade Prisional, adicionar o endereço COMPLETO no campo abaixo.</p>
                                    </figcaption>
                                </figure>
                            </li>
                        </ul>                        
                    </div> 
                <br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
                    <div style="position:relative; margin-top:0px;"align="center">                                                                                                                                                   
                        <label class="control-label">Digite o endereço da Unidade:</label>
                        <input type="text" class="form_contato" id="address" style="width:300px; margin-right:15px;"/>      
                        <input type="button" value="Localizar Endereço" onClick="geocode()" class="btn btn-success"/>
                    </div>                
                    <div style="position:relative; margin-top:20px;"align="center">
                        <div id="map_canvas" style="width:40%; height:400px"></div>
                        <div id="crosshair"></div>
                    </div>             

                <div style="position:relative; margin-top:40px;"align="center">
                <!-- <div style="position: relative; width:980px; left:50%; margin-left:-490px; height:40px; margin-top:-200px;  "align="center"> -->
                    Latitude / Longitude: <span id="latlng"></span>
                    - Nivel do zoom: <span id="zoom_level"></span><br />  
                    Endereço: <span id="formatedAddress"></span><br /><br>                    
                    <div style="position:relative; margin-top:40px;"align="center">
                        <p><h4>Segundo passo: <i>Após a localização, centralizar a imagem bem ao centro do mapa e depois de centralizada, utilizar o botão abaixo "Adicionar ponto no mapa".</i> </h4></p>
                        <p><h5>DICA: Utilizar o zoom (+ / -) no mapa para ajudar na centralização da unidade.</h5></p>
                    </div>                                                  
                </div>
                    <div style="position:relative; margin-top:0px;"align="center">                   
                        <input type="button" value="Adicionar ponto no mapa" onClick="addMarkerAtCenter()" class="btn btn-danger"/>
                    </div>                 

                <div style="position:relative; margin-top:0px;"align="center">                               
                    <div style="position:relative; right:-10px; top:3px;">
                        <p><h4>Terceiro passo: <i>Preencher os campos abaixo, utilizando as coordenadas que estão logo abaixo do mapa.</i></h4></p>
                        <p></p>
                    </div>                

                    <div style="position:relative; margin-top:0px;"align="center">  
                        <div class="control-group <?php echo !empty($unidadeError)?'error':'';?>">
                            <label class="control-label">Unidade</label>
                            <div class="controls">
                                <input id="name" name="name" type="text"  placeholder="Unidade" value="<?php echo !empty($unidade)?$unidade:'';?>"/>
                                <?php if (!empty($unidadeError)): ?>
                                <span class="help-inline"><?php echo $unidadeError;?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="control-group <?php echo !empty($enderecoError)?'error':'';?>">
                            <label class="control-label">Endereço/local:</label>
                            <div class="controls">
                                <input id="address" name="address" type="text"  placeholder="Endereço" value="<?php echo !empty($endereco)?$endereco:'';?>"/>
                                <?php if (!empty($enderecoError)): ?>
                                    <span class="help-inline"><?php echo $enderecoError;?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="control-group <?php echo !empty($latitudeError)?'error':'';?>">
                            <label class="control-label">Latitude:</label>
                            <div class="controls">
                                <input id="lat" name="lat" type="text"  placeholder="Latitude" value="<?php echo !empty($latitude)?$latitude:'';?>"/>
                                <?php if (!empty($latitudeError)): ?>
                                    <span class="help-inline"><?php echo $latitudeError;?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="control-group <?php echo !empty($longitudeError)?'error':'';?>">
                            <label class="control-label">Longitude:</label>
                            <div class="controls">
                                <input id="lng" name="lng" type="text"  placeholder="Longitude" value="<?php echo !empty($longitude)?$longitude:'';?>"/>
                                <?php if (!empty($longitudeError)): ?>
                                    <span class="help-inline"><?php echo $longitudeError;?></span>
                                <?php endif; ?>
                            </div>
                        </div>               
                        <div style="position:relative; margin-top:0px;"align="center"> 
                            <button type="submit" class="btn btn-success">Salvar</button>
                            <!-- <a class="btn" href="index.php">Voltar</a> -->
                        </div>             
                    </div>             
                </div>
                    
            </form>
            
            <!--</div><!-- end content -->   -->
            <div class="row footer">
                <a href="http://www.porfolio">Ricardo Tales</a> <span>Copyright &copy; 2016 All right reserved</span>
            </div>            
	</section>
    </section><!-- end main -->

</body>
</html>

        <script type="text/javascript">
            var map;
            var geocoder;
            var centerChangedLast;
            var reverseGeocodedLast;
            var currentReverseGeocodeResponse;

            function initialize() {
                var latlng = new google.maps.LatLng(-19.918954025630963,-43.93854807116395);
                var myOptions = {
                    zoom:18   ,
                    center: latlng,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                };
                map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
                geocoder = new google.maps.Geocoder();

                setupEvents();
                centerChanged();
            }

            function setupEvents() {
                reverseGeocodedLast = new Date();
                centerChangedLast = new Date();

                setInterval(function() {
                    if((new Date()).getSeconds() - centerChangedLast.getSeconds() > 1) {
                    if(reverseGeocodedLast.getTime() < centerChangedLast.getTime())
                        reverseGeocode();
                    }
                }, 1000);

                google.maps.event.addListener(map, 'zoom_changed', function() {
                document.getElementById("zoom_level").innerHTML = map.getZoom();
                });

                google.maps.event.addListener(map, 'center_changed', centerChanged);
                google.maps.event.addDomListener(document.getElementById('crosshair'),'dblclick', function() {
                map.setZoom(map.getZoom() + 1);
                });
            }

            function getCenterLatLngText() {
                return '(' + map.getCenter().lat() +', '+ map.getCenter().lng() +')';
            }

            function centerChanged() {
                centerChangedLast = new Date();
                var latlng = getCenterLatLngText();
                    document.getElementById('latlng').innerHTML = latlng;
                    document.getElementById('formatedAddress').innerHTML = '';
                    currentReverseGeocodeResponse = null;
            }

            function reverseGeocode() {
                reverseGeocodedLast = new Date();
                geocoder.geocode({latLng:map.getCenter()},reverseGeocodeResult);
            }

            function reverseGeocodeResult(results, status) {
                currentReverseGeocodeResponse = results;
                if(status == 'OK') {
                    if(results.length == 0) {
                        document.getElementById('formatedAddress').innerHTML = 'None';
                    } else {
                            document.getElementById('formatedAddress').innerHTML = results[0].formatted_address;
                        }
                } else {
                    document.getElementById('formatedAddress').innerHTML = 'Error';
                    }
            }

            function geocode() {
                var address = document.getElementById("address").value;
                    geocoder.geocode({
                    'address': address,
                    'partialmatch': true}, geocodeResult);
            }

            function geocodeResult(results, status) {
                if (status == 'OK' && results.length > 0) {
                    map.fitBounds(results[0].geometry.viewport);
                } else {
                    alert("Resultado da busca: " + status + " Entre com um valo valido!");
                    }
            }

            function addMarkerAtCenter() {
                var marker = new google.maps.Marker({
                    position: map.getCenter(),
                    map: map
                });

                var text = 'Lat/Lng: ' + getCenterLatLngText();
                    if(currentReverseGeocodeResponse) {
                        var addr = '';
                        if(currentReverseGeocodeResponse.size == 0) {
                            addr = 'None';
                        } else {
                            addr = currentReverseGeocodeResponse[0].formatted_address;
                            }
                        text = text + '<br>' + 'address: <br>' + addr;
                    }

                    var infowindow = new google.maps.InfoWindow({ content: text });
                        google.maps.event.addListener(marker, 'click', function() {
                            infowindow.open(map,marker);
                        });
            }
        </script>  
