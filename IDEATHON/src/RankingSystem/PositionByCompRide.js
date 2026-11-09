//Script para alteração dos valores dentro das 
//divs de rankings(RotasComplexas)..:
//Div Tabelas:
// -> Posicao Ranking dos participantes


async function updateRankPerComp() {

	const DivTabelasCom = document.getElementById("Corpo_");
	try {
		const callAPI__ = await fetch ('/api/rankingRide', {
			method: 'GET',
			headers: {
				'ngrok-skip-browser-warning': 'true'
			}
		});
		
		if(!callAPI__.ok) throw new Error ('Erro de Comunicacao IDENTIFICADO!!');

		const dadosTraduzido__ = await callAPI__.json();

		DivTabelasCom.innerHTML = "";

		dadosTraduzido__.forEach((registroInserido, cont) => {
			const line__ = document.createElement('tr');

			line__.innerHTML = `
			<td>${cont +1}º</td>
			<td>${registroInserido.usuario_nome}</td>
			<td>${registroInserido.passeios_complexos}</td>
			`;
			DivTabelasCom.appendChild(line__);
		});
	} catch(erro) {
		console.error('FALHA CAPTURADA..: ',erro);

		DivTabelasCom.innerHTML = `
		<tr>
 			<td>Erro ao carregar o ranking(2)</td>
		</tr>
		`;
	}
}

window.addEventListener('DOMContentLoaded',updateRankPerComp);
setInterval(updateRankPerComp,4000);



