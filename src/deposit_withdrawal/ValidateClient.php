<?php

require_once __DIR__ . '/../AppConf.php';
require_once __DIR__ . '/../AuthController.php';
require_once __DIR__ . '/../lib/requests/Requests.php';
require_once __DIR__ . '/../utils/Constants.php';
require_once __DIR__ . '/../utils/Utils.php';

class ValidateClient {
    const RestEndpoint = '/agents/v2/-services-clientservice-validateclient';
    static $logs = array();

    public static function call() {
        $appCfg = new AppConf;
        $authController = new AuthController;

        $headers = array(
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => $authController->getToken(true),
            'x-api-key' => $appCfg->getApiKey()
        );

        $options = array(
            'timeout' => 30
        );

        $endpoint = $appCfg->getApiBasePath() . self::RestEndpoint;

        $body = json_encode(array(
            'RequestMessage' => array(
                'RequestHeader' => array(
                    'Channel' => 'MF-001',
                    'RequestDate' => '2020-01-14T10:26:12.654Z',
                    'MessageID' => '1234567890',
                    'ClientID' => $appCfg->getClientId(),
                    'Destination' => array(
                        'ServiceName' => 'RechargeService',
                        'ServiceOperation' => 'validateClient',
                        'ServiceRegion' => 'C001',
                        'ServiceVersion' => '1.4.0'
                    )
                ),
                'RequestBody' => array(
                    'any' => array(
                        'validateClientRQ' => array(
                            // 'phoneNumber' => '399876464300', // Reemplace por este número para experimentar un error
                            'phoneNumber' => '3998764643',
                            'value' => '10000'
                        )
                    )
                )
            )
        ));

        self::$logs[] = array('type' => 'info', 'msg' => 'Listo para la enviar la petición');

        $request = Requests::post($endpoint, $headers, $body, $options);

        if (
            isset($request->status_code) && $request->status_code == 200 
            && isset($request->body) && !empty($request->body)
        ) {
            self::$logs[] = array('type' => 'info', 'msg' => 'La petición retornó un estado HTTP 200');

            try {
                $response = json_decode($request->body);

                $status = $response->ResponseMessage->ResponseHeader->Status;
                $statusCode = isset($status) ? $status->StatusCode : '';
                $statusDesc = isset($status) ? $status->StatusDesc : '';

                if ($statusCode == Constants::NEQUI_STATUS_CODE_SUCCESS) {
                    self::$logs[] = array('type' => 'success', 'msg' => 'Cliente validado correctamente');

                    $client = $response->ResponseMessage->ResponseBody->any->validateClientRS;
                    $customerName = isset($client) ? $client->customerName : '';
                    $availableLimit = isset($client) ? $client->availableLimit : '';

                    self::$logs[] = array('type' => 'success', 'msg' => 'Nombre del cliente:' . $customerName);
                    self::$logs[] = array('type' => 'success', 'msg' => 'Límite disponible:' . $availableLimit);
                } else {
                    throw new Exception('Error ' . $statusCode . ' = ' . $statusDesc);
                }
            } catch (Exception $e) {
                throw $e;
            }
        } else {
            throw new Exception('Unable to connect to Nequi, please check the information sent.');
        }
    }
}

try {
    ValidateClient::call();
} catch (Exception $e) {
    ValidateClient::$logs[] = array('type' => 'danger', 'msg' => $e->getMessage());
}

?>

<html>
    <head>
        <title>Conecta Nequi - Api Client</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/png" href="/favicon.png">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.1/css/bulma.min.css">
        <script defer src="https://use.fontawesome.com/releases/v5.14.0/js/all.js"></script>
    </head>
    <body>
        <div class="container p-2">
            <h1 class="title">Depósitos y Retiros</h1>
            <h2 class="subtitle">Validar cliente</h2>

            <h5 class="subtitle is-5">Logs</h5>
            <?php Utils::printLogs(ValidateClient::$logs); ?>
        </div>
        <footer class="container mt-3">
            <a class="button is-primary is-outlined" href="/">
            <span class="icon is-small">
                <i class="fas fa-home"></i>
            </span>
            <span>Volver al inicio</span>
            </a>
        </footer>
    </body>
</html> 