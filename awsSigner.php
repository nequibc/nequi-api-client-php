<?php

  include 'keys.php';

/*
 * @description Funcion para hacer una petición al API de Nequi
 * @author michel.lugo@pragma.com.co, jomgarci@bancolombia.com.co
 * @param $host(s), Host del API
 * @param $servicePath(s), Path del Servicio a llamar del API
 * @param $body(o), Objeto para enviar en la petición 
 * @return (o) Respuesta o error al consumir el servicio
 */
function makeSignedRequest($host, $servicePath, $method, $body, $region = 'us-east-1'){
    
    $apikey = $GLOBALS['apikey'];
    $secretKey = $GLOBALS['secretKey'];
    $access_key = $GLOBALS['access_key'];

    /*Constantes*/    
    $service = 'execute-api';    
    $algorithm = 'AWS4-HMAC-SHA256';
    $alg = 'sha256';
    /*Generar authorization header*/
    $options = array(); 
    $headers = array();
    $date = new DateTime( 'UTC' );
    $amzdate = $date->format( 'Ymd\THis\Z' );
    $amzdate2 = $date->format( 'Ymd' );

    if($body== null || empty($body)) 
    {
       $body = "";
    }else{
      $param = json_encode($body);
       if($param == "{}")
       {
        $param = "";
       }
    }

    $requestPayload = $param;
    $hashedPayload = hash($alg, $param,false);
    $canonical_uri = $servicePath;

    $canonical_querystring = '';
    $canonical_headers ="content-type:application/json"."\n".
                        "host:".$host."\n".
                        "x-api-key:".$apikey."\n";
    $signed_headers = "content-type;host;x-api-key";
        
    /*Generamos la canonical request y se hace el calculo para firmar la request*/
    $canonical_request = $method."\n".
                         $canonical_uri."\n".
                         $canonical_querystring."\n".
                         $canonical_headers."\n".
                         $signed_headers."\n".
                         $hashedPayload;
        
    $credential_scope = $amzdate2.'/'.$region.'/'.$service.'/'.'aws4_request';

    $string_to_sign  = $algorithm."\n".
                       $amzdate ."\n".
                       $credential_scope."\n".
                       hash('sha256', $canonical_request);      
         
    $kSecret = 'AWS4'.$secretKey;
    $kDate = hash_hmac( $alg, $amzdate2, $kSecret, true );
    $kRegion = hash_hmac( $alg, $region, $kDate, true );
    $kService = hash_hmac( $alg, $service, $kRegion, true );
    $kSigning = hash_hmac( $alg, 'aws4_request', $kService, true );
    $signature = hash_hmac( $alg, $string_to_sign,$kSigning);
    $authorization_header = $algorithm . ' ' . 'Credential=' . $access_key . '/' . $credential_scope . ', ' .  'SignedHeaders=' . $signed_headers . ', ' . 'Signature=' . $signature;

    /* Se inicia la petición*/
    $curl = curl_init();

    /* Solo para pruebas, en un ambiente productivo deben ser eliminadas */
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    /* */

    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://".$host.$servicePath,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => $method,
      CURLOPT_POSTFIELDS => $param,
      CURLOPT_HTTPHEADER => array("authorization:" .$authorization_header,    
        "content-type: application/json",
        "x-amz-date: ".$amzdate,
        "x-api-key: ".$apikey
      ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
     
    if ($err) {
      return "cURL Error #:" . $err;
    } else {
      return $response;
    }
}
?>