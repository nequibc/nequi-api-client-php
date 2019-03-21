# nequi-api-client-php #

### Ejemplo para el consumo del API de Nequi en PHP  ###

El proposito de este ejemplo es ilustrativo para aquellos interesados en la integración con el API de Nequi. Con este ejemplo podra consumir el recurso de validación de cuenta y podra utilizar este código como base para el consumo del resto de recursos expuestos en el API. Para más información visite nuestro portal para desarrolladores [https://conecta.nequi.com.co](https://conecta.nequi.com.co "Nequi Conecta")

Éste ejemplo esta compuesto por 4 archivos:

- keys.php: Definición de las llaves como variables para el consumo del API.
- awsSigner.php: Permite consumir cualquier recurso del API firmando la petición con el mecanismo de seguridad AWS Sv4.
- clientAPI.php: Define las funciones que representan los recursos expuestos en el API.
- index.php: Ejemplo del consumo de las funciones expuestas en el client del API de Nequi.

Para que este ejemplo funcione debe definir las variables de entorno especificadas en el archivo `keys.php` con las llaves que le ha entregado el equipo de Nequi, sino tiene puede solicitarlas en nuestro portal para desarrolladores [https://conecta.nequi.com.co](https://conecta.nequi.com.co "Nequi Conecta")

Para ver en funcionamiento el ejemplo descargue los fuentes, desplieguelos en cualquier servidor donde corra PHP, puede ser Apache, y acceda al index.php desde un navegador web.

----------
*Made with ♥ at Nequi*

