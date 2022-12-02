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
      sendMessage("sendMessage", array('chat_id' => $chat_id, "text" => 'Olá, '. $message['from']['first_name'].' '. $message['from']['last_name'].
		'! Sou seu Bot para fazer sua solicitação de delivery de peças 
		By GRUPO DE PROJETO CIÊNCIA DA COMPUTAÇÃO UNINOVE TURMA 31 ', 'InlineKeyboardMarkup' => array(
        'InlineKeyboardButton' => array(array('Fazer Pedido'),array('Formas de Pagamento')),
        'one_time_keyboard' => true)));
    } else if ($text === "Fazer Pedido") {
	    
        
       sendMessage("sendMessage", array('chat_id' => $chat_id, "text" => 'Escolha entre as seguintes peças'
.'1-PLACA MÃE = R$500,00'.'<br>'."'2-SSD 240 = R$280,00'.'<br>'.'3-PROCESSADOR INTEL = R$8555,00'.'<br>'.'4-GABINETE GAMER = R$1970,00'.'<br>'.'5-FONTE 500W REAL = R$200,00'));
        sendMessage("sendMessage", array('chat_id' => $chat_id, "text" => 'DIGITE SOMENTE O NOME DO PRODUTO EX: /PLACA'));
       
 
       
    } else       if ( $text == '/PLACA' ) 
{
	sendMessage("sendMessage", array('chat_id' => $chat_id, "text" => 'PLACA MÃE SOLICITADA'));
		sendMessage("sendMessage", array('chat_id' => $chat_id, "text" => 'DIGITE /entrega para adicionar seu endereço'));

}else       if ( $text == '/SSD' ) 
{
	sendMessage("sendMessage", array('chat_id' => $chat_id, "text" => 'SSD 240 SOLICITADO'));
		sendMessage("sendMessage", array('chat_id' => $chat_id, "text" => 'DIGITE /entrega para adicionar seu endereço'));

}

else       if ( $text == '/PROCESSADOR' ) 
{
	sendMessage("sendMessage", array('chat_id' => $chat_id, "text" => 'PROCESSADOR SOLICITADO'));
		sendMessage("sendMessage", array('chat_id' => $chat_id, "text" => 'DIGITE /entrega para adicionar seu endereço'));

}

else       if ( $text == '/GABINETE' ) 
{
	sendMessage("sendMessage", array('chat_id' => $chat_id, "text" => 'GABINETE SOLICITADO'));
		sendMessage("sendMessage", array('chat_id' => $chat_id, "text" => 'DIGITE /entrega para adicionar seu endereço'));

}

else       if ( $text == '/FONTE' ) 
{
	sendMessage("sendMessage", array('chat_id' => $chat_id, "text" => 'FONTE SOLICITADA'));
		sendMessage("sendMessage", array('chat_id' => $chat_id, "text" => 'DIGITE /entrega para adicionar seu endereço'));

}else if($text === "/entrega") {
       	sendMessage("sendMessage", array('chat_id' => $chat_id, "text" => 'DIGITE SEU ENDEREÇO COMPLETO: '));
	
          
       
    }else if($text === $text) {
        sendMessage("sendMessage", array('chat_id' => $chat_id, "text" => ''.$message['from']['first_name'].'   QUAL A FORMA DE PAGAMENTO? DIGITE 1 PARA DÉBITO , 2 PARA CRÉDITO , 3 PARA DINHEIRO'));

    }else if($text === "1"){
            sendMessage("sendMessage", array('chat_id' => $chat_id, "text" => 'DÉBITO SELECIONADO'));

        }else if($text === "2"){
            sendMessage("sendMessage", array('chat_id' => $chat_id, "text" => 'CRÉDITO SELECIONADO')); 
        }else if($text === "3"){
            sendMessage("sendMessage", array('chat_id' => $chat_id, "text" => 'DINHEIRO')); 
        }
	  
	 
        
        else if ($text === "Formas de Pagamento") {
        
      sendMessage("sendMessage", array('chat_id' => $chat_id, "text" => '1-DÉBITO , 2-CRÉDITO , 3- DINHEIRO -> TODAS AS FORMAS SÃO PAGAS NA ENTREGA'));
      
    }  else {
      sendMessage("sendMessage", array('chat_id' => $chat_id, "text" => 'Desculpe esse comando eu não entendo , poderia escolher um que eu saiba por favor:('));
    }
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
