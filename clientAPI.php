<?php
/*
 * @description Cliente con las funciones para consumir el API
 * @author michel.lugo@pragma.com.co, jomgarci@bancolombia.com.co
 */
include 'awsSigner.php';

$host = "a7zgalw2j0.execute-api.us-east-1.amazonaws.com";  
$channel = 'MF-001';

/**
 * Encapsula el consumo del servicio de validacion de cliente del API y retorna la respuesta del servicio
 */
function validateClient($clientId, $phoneNumber, $value) {
  $servicePath = "/qa/-services-clientservice-validateclient";
  $body = getBodyValidateClient($GLOBALS['channel'], $clientId, $phoneNumber, $value);
  $response = makeSignedRequest($GLOBALS['host'], $servicePath, 'POST', $body);  
  if(json_decode($response) == null){
    return $response;
  }else{
    return json_decode($response);
  }
}
/**
 * Forma el cuerpo para consumir el servicio de validación de cliente del API
 */
function getBodyValidateClient($channel, $clientId, $phoneNumber, $value){
  $messageId =  substr(strval((new DateTime())->getTimestamp()), 0, 9);
  return array(
    "RequestMessage"  => array(
      "RequestHeader"  => array (
        "Channel" => $channel,
        "RequestDate" => gmdate("Y-m-d\TH:i:s\\Z"),
        "MessageID" => $messageId,
        "ClientID" => $clientId),
      "RequestBody"  => array (
        "any" => array (
          "validateClientRQ" => array (
            "phoneNumber" => $phoneNumber,
            "value" => $value
            )
        )
      )
    )
  );
}

?>