<?php
const DBHOST = "db";
const DBNAME = "indiscovery";
const DBUSER = "test";
const DBPASS = "test";

$dsn = "mysql:host=" . DBHOST . ";dbname=" . DBNAME . ";charset=utf8";

try {
    $db = new PDO($dsn, DBUSER, DBPASS);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connexion réussie.<br>"; // Ajouté pour débogage
} catch(PDOException $error) {
    echo "Connexion échouée : " . $error->getMessage();
    exit;
}
?>