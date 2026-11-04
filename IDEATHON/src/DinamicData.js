//Script para alteração dos valores dentro das 
//divs de rankings..:

//Div Tabelas
const posicaoRanking = [
	{posicao: "1", nome: "Larissa", quant: "926" },
	{posicao: "2", nome: "Eduardo", quant: "432"},
	{posicao: "3", nome: "Isadora", quant: "400"},
	{posicao: "4", nome: "Augusto", quant: "200"}
];

let i = 0;

const  DivTabelas = document.getElementById("CorpoDaTabela");
const buttonFunction = document.getElementById("btnAdd");

buttonFunction.addEventListener("click", () => {
 const dadoAtual = posicaoRanking[i];
	
	const newRow = DivTabelas.insertRow(-1);
  
	const valorCelula = newRow.insertCell(0);
	valorCelula.textContent = dadoAtual.posicao;
	const novaCelula = newRow.insertCell(1);
	novaCelula.textContent = dadoAtual.nome;
	const ultimaCelula = newRow.insertCell(2);
	ultimaCelula.textContent = dadoAtual.quant;

	i = (i+1) % posicaoRanking.length;
});





