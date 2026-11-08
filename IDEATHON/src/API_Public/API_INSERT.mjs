import express from 'express';
import cors from 'cors';
import pool from '../../configs/dataBaseConnection.mjs';

const applicativo = express();

// MIDDLEWARES
applicativo.use(cors());
applicativo.use(express.json()); // 💡 OBRIGATÓRIO: Sem isso, o req.body será 'undefined'

applicativo.post('/api/insertingInto', async (req, res) => {
    try {
        const { NameRide, LocIni, LocEnd, DataDate, DataHour, DataKm } = req.body;
        
        // 💡 CORREÇÃO: Removido o '(' antes do INSERT e ajustada a quebra de linha
        const mySqlQuery = `INSERT INTO passeios 
            (passeio_titulo, passeio_locini, passeio_locfim, passeio_data, passeio_hora, passeio_distancia) 
            VALUES (?, ?, ?, ?, ?, ?)`;
            
        const [result] = await pool.execute(mySqlQuery, [NameRide, LocIni, LocEnd, DataDate, DataHour, DataKm]);
        
        // Retorna o resultado da inserção (geralmente contém o insertId)
        res.status(201).json(result); 
    }
    catch (erro) {
        console.error(erro);
        res.status(500).send('ERRO NA INSERÇÃO!!');
    }
});

applicativo.listen(3001, () => console.log('Server Running on 3001'));
