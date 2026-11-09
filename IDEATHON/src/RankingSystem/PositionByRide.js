//Script para alteração dos valores dentro das 
//divs de rankings..:

//Div Tabelas:
// -> Posicao Ranking


async function updateRankPerRide() {
  
   const divTabelas = document.getElementById("Corpo__");
	try {
	 const callAPI_ = await fetch('/api/rankingCom', {
	 	method:'GET',
	 	headers: {
	 		'ngrok-skip-browser-warning': 'true'
	 	}
	 });
	 if(!callAPI_.ok) throw new Error ('Infelizmente houve um erro na comunicacao(1)...');

	 const dadosTraduzido_ = await callAPI_.json();

	 divTabelas.innerHTML = "";

	 dadosTraduzido_.forEach((registroInserido, cont) => {
	 	 const line_ = document.createElement('tr');

	 	 line_.innerHTML = `
		<td>${cont + 1}º</td>
		<td>${registroInserido.usuario_nome}</td>
		<td>${registroInserido.passeios_finalizados}</td>
	 	 `;
	 	 divTabelas.appendChild(line_);
	 });
	}  catch(erro) {
		console.error('FALHA IDENTIFICADA..: ',erro);

		divTabelas.innerHTML = `
 		<tr> 
		  <td>Erro ao carregar o ranking(1)</td>
 		</tr>
		`;
	}
}
window.addEventListener('DOMContentLoaded',updateRankPerRide);
setInterval(updateRankPerRide,5000);
