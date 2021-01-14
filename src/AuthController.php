<?php

require_once './AppConf.php';
require_once './lib/requests/Requests.php';

Requests::register_autoloader();

class AuthController {
    private $appCfg;
    private $token;
    private $tokenType;
    private $tokenExpiresAt;

    public function __construct() {
        $this->appCfg = new AppConf;
    }

    private function auth() {
        try {
            $authorization = 'Basic ' . base64_encode($this->appCfg->getClientId() . ':' . $this->appCfg->getClientSecret());

            $headers = array(
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Accept' => 'application/json',
                'Authorization' => $authorization
            );
            $endpoint = $this->appCfg->getAuthUri() . '?grant_type=' . $this->appCfg->getAuthGrantType();
            
            $request = Requests::post($endpoint, $headers);

            if (
                isset($request->status_code) && $request->status_code == 200 
                && isset($request->body) && !empty($request->body)
            ) {
                $response = json_decode($request->body);

                $this->tokenExpiresAt = new DateTime();
                $this->tokenExpiresAt->add(new DateInterval('PT' . $response->expires_in . 'S'));
                $this->token = $response->access_token;
                $this->tokenType = $response->token_type;
            } else {
                throw new Exception('Unable to connect to Nequi, please check the information sent.');
            }
            
        } catch(Exception $e) {
            throw $e;
        }
    }

    public function getToken($full = false) {
        if (!$this->isValidToken()) {
            $this->auth();
        }

        return $full ? $this->tokenType . ' ' . $this->token : $this->token;
    }

    public function isValidToken() {
        if (!isset($this->tokenExpiresAt)) {
            return false;
        }

        return new DateTime() < $this->tokenExpiresAt;
    }
}

?>