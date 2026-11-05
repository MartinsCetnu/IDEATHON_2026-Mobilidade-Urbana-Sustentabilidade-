// Quilometragem (até agora) ->
// Sessão que irá receber uma tabela que consta a posição dos 'bicicleteiro'
//cadastrados no app.web em ordem crescente dos usuário com a maior
//quilometragem rodada. Esta informação será capturada no próprio BD e
//disposta em uma tabela dinâmica ranqueada.

const rankingDinamico = [
	  {nome: "Larissa", quant: 960},
		{nome: "Eduardo", quant: 720},
		{nome: "Isadora", quant: 640},
		{nome: "Augusto", quant: 620},
		{nome: "Claudio", quant: 423},
		{nome: "Roger",   quant: 322},
		{nome: "Douglas", quant: 239.1},
		{nome: "Maya",    quant: 239},
];

const divTabelaPerKm = document.getElementById("UltimoCorpoDaTabela");
const btnFunctionKm = document.getElementById("btnShowKm");
let finalNumberAux = 1;

function ShowLastTable() {
	divTabelaPerKm.innerHTML = "";

	rankingDinamico.forEach((dadoAtual,index) => {
		 const newLine = divTabelaPerKm.insertRow(-1);

		 const valorCelula = newLine.insertCell(0);
		 valorCelula.textContent = index + 1;

		 const novaCelula = newLine.insertCell(1);
		 novaCelula.textContent = dadoAtual.nome;

		 const ultimaCelula = newLine.insertCell(2);
		 ultimaCelula.textContent = dadoAtual.quant;
	});
}

function updateLevel() {
	for(let i = 0; i < rankingDinamico.length;i++) {
		rankingDinamico[i].quant += finalNumberAux * 2;
		finalNumberAux++;

		if(finalNumberAux == rankingDinamico.length+1) {
			finalNumberAux = 1;
		}
	}
	rankingDinamico.sort((a,b) => b.quant - a.quant);
	ShowLastTable();
}

ShowLastTable();

setInterval(updateLevel,2000);





