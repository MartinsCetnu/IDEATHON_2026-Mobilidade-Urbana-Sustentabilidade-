//Caso queiram rodar na máquina de vocês, o node vocês rodam o npm install 'mysql2'
import mysql from 'mysql2'; //pega o pacote 'mysql' no qual foi instalado em 'Node-Modules'

	const pool = mysql.createPool({
	host:"localhost",
	user:"root",
	password:"",	
	database:"ideathon_2026",
	waitFoConnections: true,
	connectionLimit: 10,
	queueLimit: 0
})

export default pool.promise();
