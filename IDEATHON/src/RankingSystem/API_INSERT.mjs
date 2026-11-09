import express from 'express';
import cors from 'cors';
import pool from '../../configs/dataBaseConnection.mjs';

export const router = express.Router();

router.post('/api/insertingInto', async (req, res) => {
    try {
        const { NameRide, LocIni, LocEnd, DataDate, DataHour, DataKm } = req.body;
        
        //  ajustada a quebra de linha
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

