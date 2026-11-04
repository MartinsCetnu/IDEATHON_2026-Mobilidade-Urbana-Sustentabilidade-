<?php
session_start();

$host    = 'localhost';
$usuario = 'root';
$senha   = '';
$banco   = 'nome_do_seu_banco';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $passeio_id = intval($_POST['passeio_id']);
    $usuario_id = intval($_POST['usuario_id']);

    // Criando a conexão com MySQLi
    $conn = new mysqli($host, $usuario, $senha, $banco);

    if ($conn->connect_error) {
        die("Erro na conexão: " . $conn->connect_error);
    }

    $conn->set_charset("utf8mb4");

    // Insere o interesse na tabela relacional usando Prepared Statement
    $sql = "INSERT INTO passeio_interesses (passeio_id, usuario_id) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("ii", $passeio_id, $usuario_id);
        $stmt->execute();
        $stmt->close();
        
        // Redireciona de volta com aviso de sucesso
        header("Location: index.php?id=" . $passeio_id . "&status=sucesso");
        exit;
    } else {
        echo "Erro ao preparar a consulta: " . $conn->error;
    }

    $conn->close();
}
?>