// Quilometragem (até agora) ->
// Sessão que irá receber uma tabela que consta a posição dos 'bicicleteiro'
//cadastrados no app.web em ordem crescente dos usuário com a maior
//quilometragem rodada. Esta informação será capturada no próprio BD e
//disposta em uma tabela dinâmica ranqueada.

async function updateRankPerKm() {

const divTabelaPerKm = document.getElementById("Corpo");

try {
	const callAPI = await fetch('http://localhost:3000/api/ranking');
	if(!callAPI.ok) throw new Error ('Infelizmente houve um erro na comunicacao...');

	const dadosTraduzido = await callAPI.json();

divTabelaPerKm.innerHTML = "";

	dadosTraduzido.forEach((registroInserido, contador) => {
		const line = document.createElement('tr');

		line.innerHTML = `
		<td>${contador+1}º</td>
		<td>${registroInserido.usuario_nome}</td>
		<td>${registroInserido.quilometragem_rodada}</td>
		`;

		divTabelaPerKm.appendChild(line);
	});
	}	 	catch (erro) {
	console.error('Erro na renderização das linhas..:',erro);

	divTabelaPerKm.innerHTML = `
    <tr>
              <td colspan="3" style="text-align: center; color: red; font-weight: bold;">
                Erro ao carregar o ranking...
              </td>
            </tr>
	`;	
 }
}

window.addEventListener('DOMContentLoaded',updateRankPerKm);
setInterval(updateRankPerKm,5000);
