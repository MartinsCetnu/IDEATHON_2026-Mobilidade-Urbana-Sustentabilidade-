<?php
// Configurações de conexão com o MySQL local (XAMPP) usando MySQLi
$host    = 'localhost';
$usuario = 'root';
$senha   = '';
$banco   = 'nome_do_seu_banco';

// Criando a conexão com MySQLi
$conn = new mysqli($host, $usuario, $senha, $banco);

// Verifica se houve erro na conexão
if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

// Define o charset para utf8mb4 para aceitar acentuação corretamente
$conn->set_charset("utf8mb4");

// Obtém o ID do passeio via GET na URL (ex: index.php?id=1). Se não houver, assume o ID 1
$passeio_id = isset($_GET['id']) ? intval($_GET['id']) : 1;

// Busca os dados do passeio no banco de dados usando Prepared Statement do MySQLi
$sql = "SELECT titulo, descricao, imagem, inicio, fim, data, hora FROM passeios WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $passeio_id);
$stmt->execute();
$result = $stmt->get_result();

$passeio = $result->fetch_assoc();

// Fecha o statement de busca
$stmt->close();

// Simulação do ID do usuário logado na sessão (substitua pela sua lógica de auth)
session_start();
$_SESSION['usuario_id'] = $_SESSION['usuario_id'] ?? 1; 
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
            <!-- Logo -->
            <a href="index.php">Pedal que Move</a>

            <!-- Links -->
            <ul>
                <li><a href="index.php">Início</a></li>
                <!-- Página do Augusto -->
                <li><a href="XYZ.php">Conquistas e Ranqueamento</a></li>
                <!-- Página do Douglas -->
                <li><a href="ABC.php">Criar um Passeio</a></li>
            </ul>

        </nav>
    </header>

    <main>
        <h1>passeios</h1>

        <?php if ($passeio): ?>
            <article>
                <header>
                    <h2><?php echo htmlspecialchars($passeio['titulo']); ?></h2>
                </header>

                <!-- Mapa do passeio -->
                <figure>
                    <img 
                        src="<?php echo htmlspecialchars($passeio['imagem'] ?? 'caminho/para/imagem_padrao.jpg'); ?>" 
                        alt="Imagem do percurso do passeio: <?php echo htmlspecialchars($passeio['titulo']); ?>"
                    >
                </figure>

                <!-- Revisar mediante apresentação das tabelas do BD -->
                <section>
                    <p><strong>início:</strong> <?php echo htmlspecialchars($passeio['inicio']); ?></p>
                    <p><strong>data:</strong> <?php echo date('d/m/Y', strtotime($passeio['data'])); ?></p>
                    <p><strong>fim:</strong> <?php echo htmlspecialchars($passeio['fim']); ?></p>
                    <p><strong>hora:</strong> <?php echo date('H:i', strtotime($passeio['hora'])); ?></p>
                    <p><strong>pessoas interessadas:</strong> <!-- Aqui pode ser inserida uma query de contagem --></p>
                </section>

                <!-- Botão registrar o participante -->
                <form action="salvar_interesse.php" method="POST">
                    <input type="hidden" name="passeio_id" value="<?php echo $passeio_id; ?>">
                    <input type="hidden" name="usuario_id" value="<?php echo $_SESSION['usuario_id']; ?>">
                    <button type="submit">tenho interesse</button>
                </form>
            </article>
        <?php else: ?>
            <p>Passeio não encontrado.</p>
        <?php endif; ?>
    </main>

    <footer>
        <div class="copyRights">
        <p>&copy; 2026 PedalQueMove. Todos os direitos reservados.</p>
        
        <ul class="linksDeRodape">
            <li><a href="termos.php">Termos de Uso</a></li>
            <li><a href="privacidade.php">Política de Privacidade</a></li>
            <li><a href="contato.php">Contato</a></li>
        </ul>
                <!-- Precisa convalidar -->
        <div class="social-links">
            <a href="#" target="_blank">Instagram</a> | 
            <a href="#" target="_blank">Strava</a>
        </div>
    </div>
    </footer>

</body>
</html>

<?php
$conn->close();
?>