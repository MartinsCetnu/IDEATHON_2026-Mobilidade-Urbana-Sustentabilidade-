import express from 'express';
import pool from '../../configs/dataBaseConnection.mjs';

// Importa as rotas de cada um dos seus arquivos distintos
import { router as apiRanking } from './API.mjs';
import { router as apiComplx } from './API_Complx.mjs';
import { router as apiRide } from './API_Ride.mjs';
import { router as apiInsert } from './API_INSERT.mjs';

const aplicativo = express();

// middlewares de configuração de header e cors 
aplicativo.use((req, res, next) => {
    res.setHeader('Access-Control-Allow-Origin', '*');
    res.setHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
    res.setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization, ngrok-skip-browser-warning');
    res.setHeader('ngrok-skip-browser-warning', 'true');
    
    if (req.method === 'OPTIONS') {
        return res.sendStatus(200);
    }
    next();
});

aplicativo.use(express.json());

// rota  padrão (Elimina o erro de Content-Security-Policy do ngrok)
aplicativo.get('/', (req, res) => {
    res.status(200).send('API Central do Node.js funcionando perfeitamente!');
});

// integração dos arquivos importados;
aplicativo.use(apiRanking);
aplicativo.use(apiComplx);
aplicativo.use(apiRide);
aplicativo.use(apiInsert);

// listen para gerenciar as 4 APIS
aplicativo.listen(5000, () => console.log('Servidor unificado rodando com sucesso na porta 5000'));

