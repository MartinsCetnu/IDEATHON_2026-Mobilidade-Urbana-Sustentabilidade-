import express from 'express';
import cors from 'cors';
import pool from '../../configs/dataBaseConnection.mjs';
import cron from 'node-cron';


const aplicativo = express();

aplicativo.use(cors()); //Aqui vai ficar a permissão para o HTML acessa a API.

aplicativo.get('/api/ranking', async(req, res) => {
	try {
		const [linhas] = await pool.query('SELECT usuario_nome, quilometragem_rodada FROM usuarios ORDER BY quilometragem_rodada DESC');
		res.json(linhas);
	} 
	catch (erro) {
		console.error(erro);
		res.status(500).send('ERRO NA BUSCA!');
	}
});

cron.schedule('*/3 * * * * *', async () => {
	try {
		const querySQL = `UPDATE usuarios u JOIN ( SELECT usuario_id, ROW_NUMBER() OVER (ORDER BY CAST (passeios_finalizados AS UNSIGNED) DESC, usuario_id ASC) 
				as posicao FROM usuarios ) r ON u.usuario_id = r.usuario_id
				SET u.quilometragem_rodada = u.quilometragem_rodada + r.posicao;
				`;
		await pool.query(querySQL);
		console.log("SUCESSO(2)!!");
	} 
	catch (error) {
			console.error('Foi identificado um erro..:', error);
		}
})

aplicativo.listen(3000, () => console.log('Server Running on 3000'));
