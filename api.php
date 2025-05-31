<?php
header('Content-Type: application/json');

$host = 'aws-0-eu-west-2.pooler.supabase.com';
$port = '6543';
$db   = 'postgres';
$user = 'postgres.ajtzkuhsnymajitgdlaw';
$pass = 'Fataw70359545'; // Ton vrai mot de passe Supabase ici

$dsn = "pgsql:host=$host;port=$port;dbname=$db";

try {
    $pdo = new PDO($dsn, $user, $pass);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Connexion échouée : ' . $e->getMessage()]);
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
echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
