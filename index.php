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
        'keyboard' => array(array('Fazer Pedido'),array('Ajuda')),
        'one_time_keyboard' => true)));
        
    } else if ($text === "Fazer Pedido") {
        
       sendMessage("sendMessage", array('chat_id' => $chat_id, "text" => "ESCOLHA UMA DAS SEGUINTES PEÇAS \n\n 1-PLACA MÃE = R$500,00 \n\n 2-SSD 240Gb = R$280,00 \n\n 3-PROCESSADOR INTEL = R$8500,00 \n\n 4-GABINETE GAMER = R$1970,00 \n\n 5-FONTE 500W REAL = R$200,00"));
       
     sendMessage("sendMessage", array('chat_id' => $chat_id, "text" => 'DIGITE SOMENTE O NÚMERO DO PRODUTO EX: 1'));
     
 
    }else if ( $text === "1" ||  $text === "2" ||  $text === "3" || $text === "4" ||  $text === "5"  ){
        
        
        switch ($text) {
   case "1":
     sendMessage("sendMessage", array('chat_id' => $chat_id, "text" => "PLACA MÃE SELECIONADA \n Digite o comando /entrega"));
     $pc = "PLACA MÃE";
       break;
        
   case "2":
     sendMessage("sendMessage", array('chat_id' => $chat_id, "text" => "SSD 240Gb \n Digite seu endereço completo:"));
       break;
   case "3":
           sendMessage("sendMessage", array('chat_id' => $chat_id, "text" => "PROCESSADOR INTEL \n Digite seu endereço completo:"));

       break;
        case "4":
           sendMessage("sendMessage", array('chat_id' => $chat_id, "text" => "GABINETE GAMER \n Digite seu endereço completo:"));
       break;
        case "5":
           sendMessage("sendMessage", array('chat_id' => $chat_id, "text" => "FONTE 500W REAL\n Digite seu endereço completo:"));
       break;
       default:
        sendMessage("sendMessage", array('chat_id' => $chat_id, "text" => 'OPÇÃO SELECIONADA ERRADA'));

         break;
         
   
  
}

            
        
    }else if($text === "/entrega" ){
       sendMessage("sendMessage", array('chat_id' => $chat_id, "text" => 'DIGITE SEU ENDEREÇO COMPLETO: '));
       
   }else  if($text != "/entrega" && $text === $text && $text != "/sim" && $text != "/nao" ){
           
 
          sendMessage("sendMessage", array('chat_id' => $chat_id, "text" => 'SEU PEDIDO SERÁ ENTREGUE EM: ' . $text));


    
       
       
   }else if ($text === "Ajuda" || $text === "/help") {
        
sendMessage("sendMessage", array('chat_id' => $chat_id, "text" => 'Selecione uma das opções para Tirar sua Dúvida', 
		'reply_markup' => array('inline_keyboard' => array(
                                                     //linha 1
                                                     array(
                                                         array('text'=>'FORMA DE PAGAMENTO',"text" => "Temos 1-DÉBITO \n2-CRÉDITO \n 3-DINHEIRO \n 4-PIX"), //botão 1
                                                         array('text'=>'ENTREGA',"text" => "Nossa Entrega é realizada em seu endereço em até 5 horas , por um dos nossos motoboys parceiros")//botão 2
                                                      ),
                                                      //linha 2
                                                     array(
                                                         array('text'=>'SAC',"text" => "Para registrar uma reclamação use os seguintes canais: \n\n -EMAIL: <b>suporte55@bot.com.br</b> \n -Telefone:<b>0800-000-000</br> "), //botão 3
                                                        
                                                      )

                                        )
                                )));
        
        
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
