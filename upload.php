<?php
$nomePasta = "pastaUploads";

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_FILES['arquivos']['name'][0])) {
    // Cria a pasta se ela não existir
    if (!is_dir($nomePasta)) {
        mkdir($nomePasta, 0777, true);
    }

    $arquivos = $_FILES['arquivos'];
    $quantidadeArquivos = count($arquivos['name']);
    $uploadStatus = true;
    $mensagens = [];

    for ($i = 0; $i < $quantidadeArquivos; $i++) {
        if ($arquivos['error'][$i] === UPLOAD_ERR_OK) {
            $caminhoSalvar = $nomePasta . '/' . basename($arquivos['name'][$i]);
            if (move_uploaded_file($arquivos['tmp_name'][$i], $caminhoSalvar)) {
                $mensagens[] = "O arquivo " . htmlspecialchars($arquivos['name'][$i]) . " foi enviado com sucesso!";
            } else {
                $uploadStatus = false;
                $mensagens[] = "Desculpe, houve um erro ao enviar o arquivo " . htmlspecialchars($arquivos['name'][$i]) . ".";
            }
        } else {
            $uploadStatus = false;
            $mensagens[] = "Erro ao enviar " . htmlspecialchars($arquivos['name'][$i]) . ". Código de erro: " . $arquivos['error'][$i];
        }
    }
}
?>