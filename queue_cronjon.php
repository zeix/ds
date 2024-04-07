<?php

// Define o diretório da fila
$queueDir = __DIR__ . '/queue/';
require './vendor/autoload.php';
echo $queueDir;
// Função para enviar a mensagem
function sendMessage($data) {
    // Aqui você coloca a lógica para enviar a mensagem
    // Por exemplo, a lógica para fazer uma requisição HTTP para um serviço de mensagens
    echo "Enviando mensagem para: " . $data['to'] . "\n";
    $params=array(
        'token' => $data['token'],
        'to' => $data['to'],
        'body' => $data['body']
        );

        $request = new HTTP_Request2();

        $request->setUrl('https://api.ultramsg.com/'.$data['instance'].'/messages/chat');
        $request->setMethod(HTTP_Request2::METHOD_POST);
        $request->setConfig(array(
        'follow_redirects' => TRUE
        ));
        $request->setHeader(array(
        'Content-Type' => 'application/x-www-form-urlencoded'
        ));
        $request->addPostParameter($params);
        try {
        $response = $request->send();
        if ($response->getStatus() == 200) {
            echo $response->getBody();
        }
        else {
            echo 'Unexpected HTTP status: ' . $response->getStatus() . ' ' .
            $response->getReasonPhrase();
        }
        }
        catch(HTTP_Request2_Exception $e) {
        echo 'Error: ' . $e->getMessage();
        }

}

    $files = glob($queueDir . '*.json');
    foreach ($files as $file) {
        $data = json_decode(file_get_contents($file), true);
        
        // Verifica se é hora de enviar a mensagem
         if (time() >= $data['sendAt']) {
            // Chama a função de enviar a mensagem
            sendMessage($data);

            // Após enviar a mensagem, exclui o arquivo da fila
            unlink($file);
        }

        sleep(3);
    }

    sleep(1); 
