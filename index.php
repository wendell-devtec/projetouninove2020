<?php

define('BOT_TOKEN', '5952104792:AAGaomMNP71YY2HpCrOYMLOcWoz3vjktoIY');
define('API_URL', 'https://api.telegram.org/bot'.BOT_TOKEN.'/');

function processMessage($message) {
  // processa a mensagem recebida
  $message_id = $message['message_id'];
  $chat_id = $message['chat']['id'];
  if (isset($message['text'])) {
    
    $text = $message['text'];//texto recebido na mensagem

    if (strpos($text, "/start") === 0) {
		//envia a mensagem ao usuário
      sendMessage("sendMessage", array('chat_id' => $chat_id, "text" => 'Olá,  '. $message['from']['first_name'].' '. $message['from']['last_name'].
      " Tudo bem ?!\n\n Sou seu Bot De Compra de Peça de Informática \n Para começar Clique em Fazer Pedido \n\n *LEMBRE SE TIVER DUVIDA DIGITE /help OU NO BOTÃO AJUDA*", 'reply_markup' => array(
        'keyboard' => array(array('Fazer Pedido')),
        'one_time_keyboard' => true)));
        
    } else if ($text === "Fazer Pedido") {
        
       sendMessage("sendMessage", array('chat_id' => $chat_id, "text" => "ESCOLHA UMA DAS SEGUINTES PEÇAS \n\n 1-PLACA MÃE = R$500,00 \n\n 2-SSD 240Gb = R$280,00 \n\n 3-PROCESSADOR INTEL = R$8500,00 \n\n 4-GABINETE GAMER = R$1970,00 \n\n 5-FONTE 500W REAL = R$200,00"));
       
     sendMessage("sendMessage", array('chat_id' => $chat_id, "text" => 'DIGITE SOMENTE O NÚMERO DO PRODUTO EX: 1'));
     
 
    }else if ( $text === "1" ||  $text === "2" ||  $text === "3" || $text === "4" ||  $text === "5" ){
        
        
        switch ($text) {
   case "1":
     sendMessage("sendMessage", array('chat_id' => $chat_id, "text" => "PLACA MÃE SELECIONADA \n Escolha uma forma de pagamento!\n\n Digite PIX ou CREDITO como forma de pagamento:"));
       break;
        
   case "2":
     sendMessage("sendMessage", array('chat_id' => $chat_id, "text" => "SSD 240Gb \n Digite PIX ou CREDITO como forma de pagamento:"));
       break;
   case "3":
           sendMessage("sendMessage", array('chat_id' => $chat_id, "text" => "PROCESSADOR INTEL \n Digite PIX ou CREDITO como forma de pagamento:"));

       break;
        case "4":
           sendMessage("sendMessage", array('chat_id' => $chat_id, "text" => "GABINETE GAMER \n Digite PIX ou CREDITO como forma de pagamento:"));
       break;
        case "5":
           sendMessage("sendMessage", array('chat_id' => $chat_id, "text" => "FONTE 500W REAL\n Digite PIX ou CREDITO como forma de pagamento:"));
       break;
       default:
        sendMessage("sendMessage", array('chat_id' => $chat_id, "text" => 'OPÇÃO SELECIONADA ERRADA'));

         break;
           
  
}
        }else if ( $text === "PIX"){
     sendMessage("sendMessage", array('chat_id' => $chat_id, "text" => "CREDITO SELECIONADO \n Digite seu endereço completo:"));
}
        
    }else if($text === "CREDITO"){
       sendMessage("sendMessage", array('chat_id' => $chat_id, "text" => 'Seu pedido será entregue no endereço informado'));
       
   }else sendMessage("sendMessage", array('chat_id' => $chat_id, "text" => "Desculpe não entendi!Peço que Siga o exemplo anterior"));



      
  } else if (isset($message['photo'])) { //checa se existe imagem na mensagem
	  $photo = $message['photo'][count($message['photo'])-1]; //obtém a imagem no tamanho original
	  //envia a imagem recebida com a legenda
	  sendMessage("sendPhoto", array('chat_id' => $chat_id, "photo" => $photo["file_id"], "caption" => "A legenda da foto foi: ".$$message["caption"]));
  } else {
    sendMessage("sendMessage", array('chat_id' => $chat_id, "text" => 'Desculpe, mas só compreendo mensagens em texto'));
  }
}


function sendMessage($method, $parameters) {
  $options = array(
  'http' => array(
    'method'  => 'POST',
    'content' => json_encode($parameters),
    'header'=>  "Content-Type: application/json\r\n" .
                "Accept: application/json\r\n"
    )
);

$context  = stream_context_create( $options );
file_get_contents(API_URL.$method, false, $context );
}

$update_response = file_get_contents("php://input");

$update = json_decode($update_response, true);

if (isset($update["message"])) {
  processMessage($update["message"]);
}
				      
?>
