import express from 'express';
import cors from 'cors';
import pool from '../../configs/dataBaseConnection.mjs';
import cron from 'node-cron';

const app = express();

app.use (cors());

app.get('/api/rankingCom', async(req, res) => {
	try {
		const [linhas_] = await pool.query('SELECT usuario_nome, passeios_finalizados FROM usuarios ORDER BY passeios_finalizados DESC');
		res.json(linhas_);
	}
	catch (erro) {
		console.error(erro);
		res.status(500).send('ERRO NA BUSCA!!');
	}
});

cron.schedule('*/5 * * * * *', async () => {
	try {
		const querySQL = `UPDATE usuarios u JOIN ( SELECT usuario_id, ROW_NUMBER() OVER (ORDER BY CAST (passeios_finalizados AS UNSIGNED) DESC, usuario_id ASC) 
		as posicao FROM usuarios ) r ON u.usuario_id = r.usuario_id
		SET u.passeios_finalizados = u.passeios_finalizados + r.posicao;
		`;
		await pool.query(querySQL);
		console.log("SUCESSO, Atualizado!!");
	} 
	catch (error) {
		console.error('Foi identificado um erro..:', error);
	}
})

app.listen(2000, () => console.log('Server Running on 2000'));
