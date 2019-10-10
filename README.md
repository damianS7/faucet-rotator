# Rotador de faucets
Esta aplicacion permite configurar compartir listas de faucets creadas por nosotros mismos. Se recomienda agregar tu direccion 
de referido como URL de forma que cada vez que un usuario visite una faucet usando tu referido ganaras dinero a traves de FaucetBox.

# Caracteristicas
- La aplicacion cuenta con un dashboard de administracion.
- Es posible agregar anuncios de Adsense o cualquier otra network desde el dashboard.
- Agrega, edita o elimina faucets desde el dashboard
- Sistema de reportes para ayudar al administrador a mantener la lista actualizada.
- Sistema de votacion, de esta forma los usuarios pueden votar aquellas faucets que mas les gusten.
- Ordenacion de lista a traves de diferentes criterios (Votos, Pago mas alto ...)

## Dashboard - Login
![Materials](https://raw.githubusercontent.com/damianS7/faucet-rotator/master/preview/login.png)

## Dashboard
![Materials](https://raw.githubusercontent.com/damianS7/faucet-rotator/master/preview/adding-faucet.png)
![Materials](https://raw.githubusercontent.com/damianS7/faucet-rotator/master/preview/admin-report-review.png)
![Materials](https://raw.githubusercontent.com/damianS7/faucet-rotator/master/preview/config.png)
![Materials](https://raw.githubusercontent.com/damianS7/faucet-rotator/master/preview/custom-ads-css.png)

## Rotator live
![Materials](https://raw.githubusercontent.com/damianS7/faucet-rotator/master/preview/faucet-dialogs.png)
![Materials](https://raw.githubusercontent.com/damianS7/faucet-rotator/master/preview/faucet-report.png)
![Materials](https://raw.githubusercontent.com/damianS7/faucet-rotator/master/preview/faucet-voting.png)
![Materials](https://raw.githubusercontent.com/damianS7/faucet-rotator/master/preview/rotator-live.png)

# Instalacion
- Entra en tu Cpanel y entra en phpmyadmin, selecciona la base de datos que usaras (puede ser la misma de faucetbox) a continuacion selecciona IMPORTAR y selecciona el archivo estructura.sql y pulsa importar.
- Descomprime el zip y copia la carpeta rotator en la raiz de tu servidor
- Si tienes una faucet de faucetbox copia y pega el config.php de tu faucet en la carpeta rotator (sobreescribelo).
- Si no posees una faucet configura el config.php con los datos de tu servidor de base de datos
- En estos momentos ya deberia esta funcional el rotador, no olvides entrar en tu panel de administrador con la contraseña 1234 y asegurate de cambiarla por una mas segura.
- Ya puedes empezar a añadir tus faucets (recuerda que sea un enlace de referido).


*** Para reiniciar la contraseña en caso de perdida ejecuta la consulta siguiente en phpmyadmin (habiendo seleccionado previamente la base de datos, despues presiona SQL en el menu de arriba y pega la siguiente consulta:

UPDATE rotator_config SET value = '$1$/PXNHx15$wqBnr68K355BeM09oyh7H/' WHERE name = 'passw';
