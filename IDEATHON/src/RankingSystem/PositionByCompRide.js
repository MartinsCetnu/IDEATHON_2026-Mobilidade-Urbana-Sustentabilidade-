//Script para alteração dos valores dentro das 
//divs de rankings(RotasComplexas)..:

//Div Tabelas:
// -> Posicao Ranking dos participantes
const posicaoRankingCom = [
	{nome: "Augusto", quant: 4},
	{nome: "Isadora", quant: 3},
	{nome: "Eduardo", quant: 3},
	{nome: "Claudio", quant: 3},
	{nome: "Larissa", quant: 2},
	{nome: "Roger",   quant: 2},
	{nome: "Douglas", quant: 1},
	{nome: "Maya",    quant: 0}
];



const  DivTabelasCom = document.getElementById("SegundoCorpoDaTabela");
const buttonFunction = document.getElementById("btnShowCom");


 function ShowPlayers() {
 DivTabelasCom.innerHTML = "";
  posicaoRankingCom.forEach((dadoAtual,index) => {
	
	const newRow = DivTabelasCom.insertRow(-1);
  
	const valorCelula = newRow.insertCell(0);
	valorCelula.textContent = index +1;
	
	const novaCelula = newRow.insertCell(1);
	novaCelula.textContent = dadoAtual.nome;
	
	const ultimaCelula = newRow.insertCell(2);
	ultimaCelula.textContent = Math.floor(dadoAtual.quant);
});	

}


let numberAuxi = 1;

function updateRanks() {
		 for(let i = 0; i < posicaoRankingCom.length; i++) {
		 	 posicaoRankingCom[i].quant += numberAuxi + 2;
		 	 numberAuxi++;

if(numberAuxi == posicaoRankingCom.length+1) { 
   numberAuxi = 1;
}
	}

	posicaoRankingCom.sort((a,b) => b.quant - a.quant);
	ShowPlayers();
	
}
ShowPlayers();
	setInterval(updateRanks,5000);
	
//






 
