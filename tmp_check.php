<?php
require 'vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$pdo = new PDO('mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_DATABASE'] . ';charset=utf8mb4', $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD']);

$queries = [
    'admit_cards' => "SELECT id, title, slug, is_active FROM admit_cards WHERE slug LIKE '%ssc-chsl%' OR title LIKE '%SSC CHSL%' LIMIT 10",
    'answer_keys' => "SELECT id, title, slug, is_active FROM answer_keys WHERE slug LIKE '%upsssc%' OR title LIKE '%UPSSSC%' LIMIT 10",
    'documents' => "SELECT id, title, slug, is_active FROM documents WHERE slug LIKE '%bpsc%' OR title LIKE '%BPSC%' LIMIT 10",
    'admit_cards_exact' => "SELECT id, title, slug, is_active, job_id, description, short_description FROM admit_cards WHERE slug = 'up-police-constable-recruitment-2025-exam-city-and-admit-card-details-released' LIMIT 5",
    'answer_keys_exact' => "SELECT id, title, slug, is_active FROM answer_keys WHERE slug = 'upsssc-stenographer-recruitment-2023-revised-answer-key-2024-for-277-post' LIMIT 5",
    'documents_exact' => "SELECT id, title, slug, is_active FROM documents WHERE slug = 'bpsc-exam-calendar-2026-1775931989' LIMIT 5",
];

foreach ($queries as $table => $sql) {
    echo "== $table ==\n";
    $stmt = $pdo->query($sql);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (empty($rows)) {
        echo "NO_ROWS\n";
    } else {
        foreach ($rows as $row) {
            echo json_encode($row, JSON_UNESCAPED_SLASHES) . "\n";
        }
    }
}
