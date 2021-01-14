<?php

require_once './AppConf.php';

echo "Testing Nequi APIs<br/><br/>";

$appCfg = new AppConf;

echo 'ClientId-> ' . $appCfg->getClientId() . '<br/>';
echo 'ClientSecret-> ' . $appCfg->getClientSecret() . '<br/>';
echo 'AuthUri-> ' . $appCfg->getAuthUri() . '<br/>';
echo 'ApiBasePath-> ' . $appCfg->getApiBasePath() . '<br/>';

?>