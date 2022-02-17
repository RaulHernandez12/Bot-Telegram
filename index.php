<?php
$token = '5233641563:AAHUv-Dn4QuqUIJAp6nCK4nFx_ZsFgIowps';
$website = 'https://api.telegram.org/bot'.$token;

$input = file_get_contents('php://input');
$update = json_decode($input, TRUE);

$chatId = $update['message']['chat']['id'];
$message = $update['message']['text'];

switch($message) {
    case '/start':
        $response = 'Me has iniciado';
        sendMessage($chatId, $response,FALSE);
        break;
    case '/info':
        $response = 'Hola! Soy un bot de telegram';
        sendMessage($chatId, $response,TRUE);
        break;
    case '/adios':
        $response = 'Hasta luego';
        sendMessage($chatId, $response,FALSE);
        break;
    case '/video':
        keyBot($chatId,$response,true);
        break;
    case '/canal':
        $response = 'Que canal quieres ver?';
        sendMessage($chatId, $response,TRUE);
        break;
    default:
        $response = 'No te he entendido';
        sendMessage($chatId, $response,FALSE);
        break;
}


function keyBot ($chatId,$reponse){
    $keyBot = 'AIzaSyAvWKk9QNoGiBPj7vhFtTO6kN4ZnVppumc';

    $maximo = '5';
    $region = 'ES';
    $url = 'https://www.googleapis.com/youtube/v3/search?key=AIzaSyAvWKk9QNoGiBPj7vhFtTO6kN4ZnVppumc&c='.$response.'&max_results='.$maximo;
    $resultado = file_get_contents($url);
    $hola = json_decode($resultado,true);

    for($i = 0 ; $i < 5 ; $i++){
        $idVideo = $hola['items'][$i]['id']['videoId'];
        $urlVideo = "https://www.youtube.com/watch?v=".$idVideo;
        sendMessage($chatId,$urlVideo,TRUE);
    }
    
};

function sendMessage($chatId,$response,$repl){
    if ($repl == TRUE){
        $reply_mark = array('force_reply' => True);
        $url = $GLOBALS['website'].'/sendMessage?chat_id='.$chatId.'&parse_mode=HTML&reply_markup='.json_encode($reply_mark).'&text='.urlencode($response);
    }else{
        $url = $GLOBALS['website'].'/sendMessage?chat_id='.$chatId.'&parse_mode=HTML&text='.urlencode($response);
    }
    file_get_contents($url);
};


?>
