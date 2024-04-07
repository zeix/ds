<?php
header('Content-Type: application/json');
// Verifica se o CPF foi enviado via GET
if (isset($_GET['cpf'])) {
    $cpf = $_GET['cpf'];

    // Monta a URL da API externa com o CPF recebido
    $url = "https://apiconsultas.store/dados/?usuario=dutra_839940201&consulta={$cpf}";

    // Utiliza a função file_get_contents para fazer a requisição GET na API externa
    $resultado = file_get_contents($url);

    // Verifica se a requisição foi bem-sucedida
    if ($resultado !== false) {
        // Retorna o resultado da API externa
        echo $resultado;
    } else {
        // Retorna um erro caso a requisição à API externa falhe
        echo json_encode(['erro' => 'Falha ao consultar a API externa.']);
    }
} else {
    // Retorna um erro se o CPF não for enviado
    echo json_encode(['erro' => 'CPF não fornecido.']);
}

?>
