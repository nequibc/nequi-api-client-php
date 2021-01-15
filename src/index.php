<?php

require_once './AppConf.php';

$appCfg = new AppConf;

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
        <div class="content p-2">
            <h1 class="title">Nequi Conecta</h1>
            <p>
                A continuación podrás encontrar ejemplos prácticos de cómo integrarte con Nequi Conecta, las API y servicios de última generación que Nequi tiene para tu negocio. 
            </p>
        </div>
        <div class="columns is-desktop">
            <!-- Environment vars -->
            <div class="column is-half-desktop">
                <div class="container p-2">
                    <h1 class="title">Configuración básica</h1>
                    <h2 class="subtitle is-6">A continuación puede ver sus variables de configuración, asegúrese de que todas tengan un valor correcto.</h2>
                    <fieldset disabled>
                        <div class="field is-horizontal">
                            <div class="field-label">
                                <label class="label">Client Id</label>
                            </div>
                            <div class="field-body">
                                <div class="field">
                                    <div class="control">
                                        <input value="<?php echo $appCfg->getClientId() ?>" class="input is-small" type="text" placeholder="Small sized input">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="field is-horizontal">
                            <div class="field-label">
                                <label class="label">Client Secret</label>
                            </div>
                            <div class="field-body">
                                <div class="field">
                                    <div class="control">
                                        <input value="<?php echo $appCfg->getClientSecret() ?>" class="input is-small" type="text" placeholder="Small sized input">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="field is-horizontal">
                            <div class="field-label">
                                <label class="label">Auth URI</label>
                            </div>
                            <div class="field-body">
                                <div class="field">
                                    <div class="control">
                                        <input value="<?php echo $appCfg->getAuthUri() ?>" class="input is-small" type="text" placeholder="Small sized input">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="field is-horizontal">
                            <div class="field-label">
                                <label class="label">API Base Path</label>
                            </div>
                            <div class="field-body">
                                <div class="field">
                                    <div class="control">
                                        <input value="<?php echo $appCfg->getApiBasePath() ?>" class="input is-small" type="text" placeholder="Small sized input">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>

            <!-- Links to use cases -->
            <div class="column is-half-desktop">
                <div class="container p-2">
                    <h1 class="title">Probar las APIs de Nequi</h1>
                    <h6 class="subtitle is-6">Aquí podrás encontrar ejemplos para los servicios</h6>
                    
                    <ul>
                        <h3 class="title is-4 mt-1">
                            Pagos con código QR
                        </h3>
                        <li>
                            <span class="icon">
                                <i class="fas fa-qrcode"></i>
                            </span>
                            <a href="./payment/GenerateQR.php">Generar un código QR</a>
                        </li>
                        <li>
                            <span class="icon">
                                <i class="fas fa-search"></i>
                            </span>
                            <a href="./payment/GetStatusPayment.php">Consultar el estado del pago</a>
                        </li>
                        <li>
                            <span class="icon">
                                <i class="fas fa-undo"></i>
                            </span>
                            <a href="./payment/ReverseTx.php">Reversar un transacción</a>
                        </li>
                    </ul>

                    <ul class="mt-4">
                        <h3 class="title is-4 mt-1">
                            Depósitos y Retiros
                        </h3>
                        <li>
                            <span class="icon">
                                <i class="fas fa-user-shield"></i>
                            </span>
                            <a href="./deposit_withdrawal/ValidateClient.php">Validar cliente</a>
                        </li>
                    </ul>
                </p2>
            </div>
        </div>
    </body>
</html>