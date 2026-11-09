<?php
session_start();

$host    = '127.0.0.1';
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

    // Verifica se já registrou interesse
    $sql_verifica = "SELECT pasint_id FROM passeio_interesses WHERE passeio_id = ? AND usuario_id = ?";
    $stmt_verifica = $conn->prepare($sql_verifica);
    $stmt_verifica->bind_param("ii", $passeio_id, $usuario_id);
    $stmt_verifica->execute();
    $stmt_verifica->store_result();
    $ja_tem_interesse = ($stmt_verifica->num_rows > 0);
    $stmt_verifica->close();

    //faz a inserção
    $status = "duplicado";
    if (!$ja_tem_interesse) {
        $sql = "INSERT INTO passeio_interesses (passeio_id, usuario_id) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("ii", $passeio_id, $usuario_id);
            $stmt->execute();
            $stmt->close();
            $status = "sucesso";
        }
    }

    // Busca o próximo ID de passeio disponível na tabela
    $sql_proximo = "SELECT passeio_id FROM passeios WHERE passeio_id > ? ORDER BY passeio_id ASC LIMIT 1";
    $stmt_prox = $conn->prepare($sql_proximo);
    $stmt_prox->bind_param("i", $passeio_id);
    $stmt_prox->execute();
    $res_prox = $stmt_prox->get_result();

    // Se encontrou um próximo passeio, define o ID 
    if ($row_prox = $res_prox->fetch_assoc()) {
        
        $proximo_id = $row_prox['passeio_id'];
    } else { // Se não houver mais nenhum passeio à frente, volta para o primeiro ID da tabela (loop)
        $sql_primeiro = "SELECT passeio_id FROM passeios ORDER BY passeio_id ASC LIMIT 1";
        $res_prim = $conn->query($sql_primeiro);
        $row_prim = $res_prim->fetch_assoc();
        $proximo_id = $row_prim['passeio_id'] ?? 1;
        $status .= "&fim=1"; // Tag opcional pra avisar que a lista acabou
    }
    
    $stmt_prox->close();
    $conn->close();

    // Redireciona o usuário diretamente para o NOVO ID gerado
    header("Location: passeios programados.php?id=" . $proximo_id . "&status=" . $status);
    exit;
}
?>
