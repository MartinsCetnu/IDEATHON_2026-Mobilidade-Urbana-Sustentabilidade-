<?php
// Inicia a sessão no topo absoluto do arquivo (regra de ouro do PHP)
session_start();
$_SESSION['usuario_id'] = $_SESSION['usuario_id'] ?? 1; 

// Configurações de conexão com o MySQL local (XAMPP) usando MySQLi
$host    = '127.0.0.1';
$usuario = 'root';
$senha   = '';
$banco   = 'ideathon_2026'; // Banco correto do seu arquivo SQL

// Criando a conexão com MySQLi
$conn = new mysqli($host, $usuario, $senha, $banco);

if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");

// Obtém o ID do passeio via GET na URL
$passeio_id = isset($_GET['id']) ? intval($_GET['id']) : 1;

// Busca os dados usando os nomes EXATOS das colunas da tabela 'passeios' no seu SQL
$sql = "SELECT passeio_titulo, passeio_descricao, passeio_locini, passeio_locfim, passeio_data, passeio_hora, passeio_distancia FROM passeios WHERE passeio_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $passeio_id);
$stmt->execute();
$result = $stmt->get_result();
$passeio = $result->fetch_assoc();
$stmt->close();

// Busca o total de pessoas interessadas neste passeio
$total_interessados = 0;
$sql_count = "SELECT COUNT(*) AS total FROM passeio_interesses WHERE passeio_id = ?";
$stmt_count = $conn->prepare($sql_count);
if ($stmt_count) {
    $stmt_count->bind_param("i", $passeio_id);
    $stmt_count->execute();
    $res_count = $stmt_count->get_result();
    if ($row_count = $res_count->fetch_assoc()) {
        $total_interessados = $row_count['total'];
    }
    $stmt_count->close();
}
?>
<?php
$conn->close();
?>
 
