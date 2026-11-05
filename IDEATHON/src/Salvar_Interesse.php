<?php
session_start();

$host    = 'localhost';
$usuario = 'root';
$senha   = '';
$banco   = 'ideathon_2026';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $passeio_id = intval($_POST['passeio_id']);
    $usuario_id = intval($_POST['usuario_id']);

    $conn = new mysqli($host, $usuario, $senha, $banco);

    if ($conn->connect_error) {
        die("Erro na conexão: " . $conn->connect_error);
    }

    $conn->set_charset("utf8mb4");

    // 1. Verifica se o usuário já registrou interesse
    $sql_verifica = "SELECT pasint_id FROM passeio_interesses WHERE passeio_id = ? AND usuario_id = ?";
    $stmt_verifica = $conn->prepare($sql_verifica);
    $stmt_verifica->bind_param("ii", $passeio_id, $usuario_id);
    $stmt_verifica->execute();
    $stmt_verifica->store_result();

    if ($stmt_verifica->num_rows > 0) {
        // se ká tiver redireciona com aviso
        $stmt_verifica->close();
        $conn->close();
        header("Location: Passeios.php?id=" . $passeio_id . "&status=duplicado");
        exit;
    }
    $stmt_verifica->close();

    // 2. Se não faz a inserção normalmente
    $sql = "INSERT INTO passeio_interesses (passeio_id, usuario_id) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("ii", $passeio_id, $usuario_id);
        $stmt->execute();
        $stmt->close();
        
        // Redireciona com sucesso
        header("Location: Passeios.php?id=" . $passeio_id . "&status=sucesso");
        exit;
    } else {
        echo "Erro ao preparar a consulta: " . $conn->error;
    }

    $conn->close();
}
?>
