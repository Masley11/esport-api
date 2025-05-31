<?php
header('Content-Type: application/json');

// Remplace par tes infos réelles Supabase
$host = 'aws-0-eu-west-2.pooler.supabase.com';
$port = '6543';
$db   = 'postgres';
$user = 'postgres.ajtzkuhsnymajitgdlaw';
$pass = 'Fataw70359545'; // Remplace par le vrai mot de passe

$dsn = "pgsql:host=$host;port=$port;dbname=$db";

try {
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erreur de connexion', 'details' => $e->getMessage()]);
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
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($results);
