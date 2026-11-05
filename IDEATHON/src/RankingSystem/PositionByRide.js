//Script para alteração dos valores dentro das 
//divs de rankings..:

//Div Tabelas:
// -> Posicao Ranking
const posicaoRanking = [
	{nome: "Larissa", quant: 10 },
	{nome: "Eduardo", quant: 8},
	{nome: "Isadora", quant: 7},
	{nome: "Augusto", quant: 5},
	{nome: "Claudio", quant: 5},
	{nome: "Roger", quant:   3},
	{nome: "Douglas", quant: 2},
	{nome: "Maya", quant: 0}
];



const  DivTabelas = document.getElementById("CorpoDaTabela");
const buttonFunction1 = document.getElementById("btnShowPass");


 function showRanks() {
 DivTabelas.innerHTML = "";
  posicaoRanking.forEach((dadoAtual,index) => {
	
	const newRow = DivTabelas.insertRow(-1);
  
	const valorCelula = newRow.insertCell(0);
	valorCelula.textContent = index +1;
	
	const novaCelula = newRow.insertCell(1);
	novaCelula.textContent = dadoAtual.nome;
	
	const ultimaCelula = newRow.insertCell(2);
	ultimaCelula.textContent = Math.floor(dadoAtual.quant);
});	

}


let numberAux = 1;

function changeRanks() {
		 for(let i = 0; i < posicaoRanking.length; i++) {
		 	 posicaoRanking[i].quant += numberAux + 1;
		 	 numberAux++;

if(numberAux == posicaoRanking.length+1) { 
   numberAux = 1;
}
	}

	posicaoRanking.sort((a,b) => b.quant - a.quant);
	showRanks();
	
}
showRanks();
	setInterval(changeRanks,3000);
	
//







