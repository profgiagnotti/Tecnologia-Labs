<?php
//questo file di esempio è lo script php che viene eseguito all'interno del container
//per eseguire il file index.php è sufficiente richiamare l'url http://localhost:8080/index.php
//il server web apache è configurato per eseguire gli script php all'interno della cartella /var/www/html
//e per esporre il servizio sulla porta 8080
echo "<h1>Hello World!</h1>";
echo "<p>Il server web Apache è in esecuzione all'interno di un container Docker.</p>";
echo "<p>Il file index.php è stato eseguito correttamente.</p>";
?>