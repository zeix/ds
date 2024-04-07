<?php

// Diretório onde os arquivos da fila serão armazenados
$queueDir = __DIR__ . '/../queue/';

// Verifica se o diretório da fila existe, senão cria
if (!file_exists($queueDir)) {
    mkdir($queueDir, 0777, true);
}

$msgType1 = "*Olá,*\n\nNós da *equipe Governamental do Programa Desenrola Brasil* estamos entrando em contato para relembrá-lo(a) de uma *pendência extremamente importante*: o pagamento de suas dívidas através da Parcela Única Federal (PUF) ainda não foi efetuado.\n\nEntendemos que imprevistos acontecem, mas é crucial destacar a importância deste pagamento não apenas para a regularização de sua situação financeira, mas também para evitar *impactos significativos e duradouros em seu futuro financeiro!*\n\nPedimos que, por favor, regularize sua situação o mais breve possível para evitar essas consequências graves. Estamos aqui para ajudar você a navegar por este processo e queremos vê-lo(a) alcançar sua liberdade financeira sem maiores obstáculos.\n\nAtenciosamente,\n\nEquipe Governamental do Programa Desenrola Brasil\n\n*CASO TODAS AS PENDÊNCIAS JÁ TENHAM SIDO PAGAS, IGNORE ESTA MENSAGEM.*";
$msgExtra1 = "URGENTE: SUA LIBERDADE FINANCEIRA ESTÁ EM RISCO!\n\nVocê está a apenas um passo de reconquistar sua liberdade financeira, graças à sua PUF (Parcela Única Federal) gerada pelo Desenrola Brasil. Este é um lembrete CRUCIAL para efetuar o pagamento antes do prazo de expiração. Não ignore esta oportunidade única.\n\n• Falhar em cumprir com o pagamento resultará em consequências severas e imediatas:\n\n• Bloqueio total de acesso a programas governamentais de crédito por um longo período de 5 anos.\n\n•Proibição completa de obter qualquer tipo de empréstimo bancário, fechando as portas do sistema financeiro para você.\n\nAção necessária AGORA! Não deixe que essa chance de limpar seu nome e reconstruir sua vida financeira escorregue por entre seus dedos. As consequências de inação são severas e duradouras. Priorize seu futuro financeiro.";
$msgExtra2 = "Olá,\n\nNós da equipe Governamental do Programa Desenrola Brasil estamos entrando em contato para relembrá-lo(a) de uma pendência extremamente importante: o pagamento de suas dívidas através da Parcela Única Federal (PUF) ainda não foi efetuado.\n\nEntendemos que imprevistos acontecem, mas é crucial destacar a importância deste pagamento não apenas para a regularização de sua situação financeira, mas também para evitar impactos significativos e duradouros em seu futuro financeiro!\n\nPedimos que, por favor, regularize sua situação o mais breve possível para evitar essas consequências graves. Estamos aqui para ajudar você a navegar por este processo e queremos vê-lo(a) alcançar sua liberdade financeira sem maiores obstáculos.\n\nAtenciosamente,\n\nEquipe Governamental do Programa Desenrola Brasil\n\nCASO TODAS AS PENDÊNCIAS JÁ TENHAM SIDO PAGAS, IGNORE ESTA MENSAGEM.";
// Verifica se o corpo da requisição está vazio
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    if(isset($data['to']) && isset($data['message_type'])){
        header('Content-Type: application/json');
        $token = "cyywaz7u51k04w77";
        $instance ="instance83056";
        $to = $data['to'] ?? '';
        $body = $data['message_type'] == 1 ? $msgType1 : $msgType1;

        // Cria um objeto de dados para a fila
        $data = [
            'token' => $token,
            'to' => $to,
            'body' => $body,
            'instance' => $instance,
            'sendAt' => time() + (10 * 60) // Agendar para 20 minutos a partir de agora
        ];
        $data2 = [
            'token' => $token,
            'to' => $to,
            'body' => $msgExtra1,
            'instance' => $instance,
            'sendAt' => time() + (15 * 60) // Agendar para 20 minutos a partir de agora
        ];
        $data3 = [
            'token' => $token,
            'to' => $to,
            'body' => $msgExtra2,
            'instance' => $instance,
            'sendAt' => time() + (20 * 60) // Agendar para 20 minutos a partir de agora
        ];



        // Gera um nome de arquivo único para o item da fila
        $fileName = uniqid("msg_", true) . '.json';
        $fileNameExtra = uniqid("msg_", true) . '.json';
        $fileNameExtra2 = uniqid("msg_", true) . '.json';
        // Salva os dados no arquivo JSON
        file_put_contents($queueDir . $fileName, json_encode($data));
        file_put_contents($queueDir . $fileNameExtra, json_encode($data2));
        file_put_contents($queueDir . $fileNameExtra2, json_encode($data3));
        echo json_encode(['status' => 'success', 'message' => 'Mensagem enfileirada para envio.']);
    }
} else {
    http_response_code(400); // Bad Request
    echo json_encode(['status' => 'error', 'message' => 'Requisição inválida.']);
}
