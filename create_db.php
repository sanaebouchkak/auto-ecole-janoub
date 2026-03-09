<?php
try {
    $pdo = new PDO('mysql:host=127.0.0.1;port=3306', 'root', '');
    $pdo->exec('CREATE DATABASE IF NOT EXISTS auto_ecole_app');
    echo "OK DB\n";
} catch (Exception $e) {
    echo "Erreur DB: " . $e->getMessage() . "\n";
}
