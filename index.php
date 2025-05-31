<?php
header('Content-Type: application/json');

$host = 'aws-0-eu-west-2.pooler.supabase.com';
$port = '6543';
$db   = 'postgres';
$user = 'postgres.ajtzkuhsnymajitgdlaw';
$pass = 'Fataw70359545'; // Mets ton mot de passe ici

$dsn = "pgsql:host=$host;port=$port;dbname=$db;port=$port";

try {
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Connexion à Supabase échouée']);
    exit;
}

$filter = $_GET['game'] ?? 'all';
$sql = "SELECT * FROM results";
$params = [];

if ($filter !== 'all') {
    $sql .= " WHERE game_name = ?";
    $params[] = $filter;
}

$sql .= " ORDER BY match_date DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$results = $stmt->fetchAll();

echo json_encode($results);
