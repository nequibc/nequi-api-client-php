<?php

class AppConf {
    private $clientId = null; 
    private $clientSecret = null;
    private $authUri = null;
    private $authGrantType = null;
    private $apiBasePath = null;

    public function __construct() {
        $this->loadEnvVars();
    }

    private function loadEnvVars() {
        $this->clientId = getenv('NEQUI_CLIENT_ID');
        $this->clientSecret = getenv('NEQUI_CLIENT_SECRET');
        $this->authUri = getenv('NEQUI_AUTH_URI');
        $this->authGrantType = getenv('NEQUI_AUTH_GRANT_TYPE');
        $this->apiBasePath = getenv('NEQUI_API_BASE_PATH');
    }

    public function getClientId() {
        return $this->clientId;
    }

    public function getClientSecret() {
        return $this->clientSecret;
    }

    public function getAuthUri() {
        return $this->authUri;
    }

    public function getAuthGrantType() {
        return $this->authGrantType;
    }

    public function getApiBasePath() {
        return $this->apiBasePath;
    }
}

?>