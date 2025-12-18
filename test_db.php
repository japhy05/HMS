<?php
require_once "config.php";

try {
    // Show current database
    $stmt = $pdo->query("SELECT DATABASE()");
    $currentDB = $stmt->fetchColumn();

    echo "✅ Connected to database: " . $currentDB . "<br><br>";

    // Show tables
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);

    if ($tables) {
        echo "Tables in DB:<br>";
        foreach ($tables as $table) {
            echo "- " . $table . "<br>";
        }
    } else {
        echo "⚠️ No tables found in this database.";
    }
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage();
}
