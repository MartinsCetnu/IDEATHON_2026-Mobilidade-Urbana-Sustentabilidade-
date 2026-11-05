<?php
// Inicia a sessão no topo absoluto do arquivo (regra de ouro do PHP)
session_start();
$_SESSION['usuario_id'] = $_SESSION['usuario_id'] ?? 1; 

// Configurações de conexão com o MySQL local (XAMPP) usando MySQLi
$host    = 'localhost';
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
$sql = "SELECT passeio_titulo, passeio_descricao, passeio_imagem, passeio_locini, passeio_locfim, passeio_data, passeio_hora FROM passeios WHERE passeio_id = ?";
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

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Passeio</title>
</head>
<body>

    <header>
        <nav>
            <a href="index.php">Pedal que Move</a>
            <ul>
                <li><a href="index.php">Início</a></li>
                <li><a href="XYZ.php">Conquistas e Ranqueamento</a></li>
                <li><a href="ABC.php">Criar um Passeio</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h1>passeios</h1>

        <?php if ($passeio): ?>
            <article>
                <header>
                    <h2><?php echo htmlspecialchars($passeio['passeio_titulo']); ?></h2>
                </header>

                <figure>
                    <img 
                        src="<?php echo htmlspecialchars($passeio['passeio_imagem'] ?? 'caminho/para/imagem_padrao.jpg'); ?>" 
                        alt="Imagem do percurso"
                    >
                </figure>

                <section>
                    <p><strong>início:</strong> <?php echo htmlspecialchars($passeio['passeio_locini']); ?></p>
                    <p><strong>data:</strong> <?php echo date('d/m/Y', strtotime($passeio['passeio_data'])); ?></p>
                    <p><strong>fim:</strong> <?php echo htmlspecialchars($passeio['passeio_locfim']); ?></p>
                    <p><strong>hora:</strong> <?php echo date('H:i', strtotime($passeio['passeio_hora'])); ?></p>
                    <p><strong>pessoas interessadas:</strong> <?php echo $total_interessados; ?> ciclistas</p>
                </section>

                <!-- Formulário apontando para salvar_interesse.php -->
                <form action="salvar_interesse.php" method="POST">
                    <input type="hidden" name="passeio_id" value="<?php echo $passeio_id; ?>">
                    <input type="hidden" name="usuario_id" value="<?php echo $_SESSION['usuario_id']; ?>">
                    <button type="submit">tenho interesse</button>
                </form>
            </article>
        <?php else: ?>
            <p>Passeio não encontrado ou tabela vazia. Certifique-se de inserir um registro no banco.</p>
        <?php endif; ?>
    </main>

    <footer>
        <div class="copyRights">
            <p>&copy; 2026 PedalQueMove. Todos os direitos reservados.</p>
        </div>
    </footer>

</body>
</html>

<?php
$conn->close();
?>
