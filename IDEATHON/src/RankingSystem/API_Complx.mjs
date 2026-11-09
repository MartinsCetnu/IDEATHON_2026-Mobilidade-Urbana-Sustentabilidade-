//Mesma Lógica da API.mjs
import express from 'express';
import cors from 'cors';
import pool from '../../configs/dataBaseConnection.mjs';
import cron from 'node-cron';
const app = express();

app.use (cors());

app.get('/api/rankingRide', async(req, res) => {
	try {
		const [linhas_] = await pool.query('SELECT usuario_nome, passeios_complexos FROM usuarios ORDER BY passeios_complexos DESC');
		res.json(linhas_);
	}
	catch (erro) {
		console.error(erro);
		res.status(500).send('ERRO NA BUSCA!!');
	}
});

cron.schedule('*/10 * * * * *', async () => {
	try {
		const querySQL = `UPDATE usuarios u JOIN ( SELECT usuario_id, ROW_NUMBER() OVER (ORDER BY passeios_complexos  DESC, usuario_id ASC) 
		as posicao FROM usuarios ) r ON u.usuario_id = r.usuario_id
		SET u.passeios_complexos = u.passeios_complexos + r.posicao;
		`;
		await pool.query(querySQL);
		console.log("SUCESSO, Atualizado(1)!!");
	} 
	catch (error) {
		console.error('Foi identificado um erro..:', error);
	}
})




app.listen(5000, () => console.log('Server Running on 5000'));
