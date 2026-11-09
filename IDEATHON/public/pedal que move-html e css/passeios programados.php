<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../../src/Passeios.php';
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="icon" type="image/x-icon" href="Icons/man-riding-bike-or-cycling-green-rounded-circle-symbol-18948.svg">		
		<base href="/ideathon/IDEATHON/public/pedal que move-html e css/">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100..900;1,100..900&family=Syncopate:wght@700&display=swap">
		<link rel="stylesheet" href="pedal(2).css">
		<link rel="stylesheet" href="leaflet.css">
		<script src="leaflet.js"></script>
		
		<title>Passeios Programados</title>
	</head>
	<body>
		<div class = "conta"> </div>
		<div class = "menubackground">
			<a href = "Criar_Cronograma.html">	
				<div class = "menuoptions"> criar cronograma </div> 
			</a>	
			<div class = "menuselected"> verificar passeios </div>
			<a href = "rankings.html">
				<div class = "menuoptions"> rankings e conquistas </div>
			</a>	
		</div>
		<div class = "conteudo-conteiner"> 
			<div class = "conteudo-title">PASSEIOS PROGRAMADOS</div>
			<div class = "conteudo">
				<div class = "mapa" id="map"> </div>
				<div class = "conteudo-escrito"> 
					 <h3 class="passeio-titulo">Passeio Disponível</h3>
        
        <div class="passeio-info">
            <p><strong>Partida:</strong> <span id="ponto-partida"> <?php echo htmlspecialchars($passeio['passeio_locini'] ?? 'Não Informado'); ?></span></p>
            <p><strong>Destino:</strong> <span id="ponto-final"><?php echo htmlspecialchars($passeio['passeio_locfim'] ?? 'Não informado'); ?></span></p>
            <p><strong>Horário:</strong> <span id="horario"><?php echo !empty($passeio['passeio_hora']) ? date('H:i', strtotime($passeio['passeio_hora'])) : '--:--'; ?></span></p>
            <p><strong>Data:</strong> <span id="data"><?php echo isset($passeio['passeio_data']) ? date('d/m/Y', strtotime($passeio['passeio_data'])) : '--/--/----';  ?></span></p>
            <p><strong>Distância:</strong> <span id="distancia"><?php echo htmlspecialchars($passeio['passeio_distancia'] ?? 'Valor não encontrado');   ?> km</span></p> 
            <p><strong>Interessados:</strong> <span id="interessados"> <?php echo $total_interessados ?? 0; ?></span></p>
        </div>
			<form action="Salvar_Interesse.php" method="POST">
			                    <input type="hidden" name="passeio_id" value="<?php echo $passeio_id ?? ''; ?>">
			                    <input type="hidden" name="usuario_id" value="<?php echo $_SESSION['usuario_id'] ?? ''; ?>">
			                    <button type="submit" class="btn-interesse">Tenho Interesse</button>
			                </form>
				 </div>
			</div>
		</div>
		<script>
			const mapa = L.map('map').setView([-21.2089, -50.4408], 13);
			
			 		 L.tileLayer('https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png', {
			 		     attribution: '© OpenStreetMap contributors'
			 		 }).addTo(mapa);
			 		 
			
					mapa.whenReady(function() {
						setTimeout(() => {
							mapa.invalidateSize();
						}, 250);
					});
			
			
			 		 let listaDeCordenadas = [];
			 		 let linhaParaRota = null;
			 		 let marcadores = [];
			
			 		 mapa.on('click', function (evento) {
			 		 	const latlng = evento.latlng;
			
			 		 	listaDeCordenadas.push([latlng.lat, latlng.lng]);
			
			 		 	const newPin = L.marker([latlng.lat, latlng.lng]).addTo(mapa);
			 		 	marcadores.push(newPin);
			
			 		 	 if(listaDeCordenadas.length > 1) {
			 		 	 		if(linhaParaRota) 
			 		 	 		{
			 		 	 			linhaParaRota.setLangs(listaDeCordenadas);
			 		 	 		}
			 		 	 		else 
			 		 	 		{
			 		 	 			linhaParaRota = L.polyline(listaDeCordenadas, {
			 		 	 				color: '#438d7d',
			 		 	 				weight: 5,
			 		 	 				opacity: 0.8
			 		 	 			}).addTo(mapa);	
			 		 	 			
			 		 	 		}
			 		 	 }
			 		 }); 
		</script>
	</body>
</html>
