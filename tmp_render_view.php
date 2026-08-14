<?php
require 'vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
$app = require 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$admitCard = App\Models\AdmitCard::where('slug', 'up-police-constable-recruitment-2025-exam-city-and-admit-card-details-released')->first();
$admitCard->load(['job.category']);
$displayTitle = trim((string) ($admitCard->title ?: ($admitCard->short_description ?: ($admitCard->description ?: ($admitCard->job?->title ?? 'Admit Card Details')))));
$displayDescription = trim((string) ($admitCard->short_description ?: ($admitCard->description ?: ($admitCard->job?->description ?? 'Details will be updated soon.'))));

$html = view('admit-cards.show', ['admitCard' => $admitCard, 'relatedAdmitCards' => collect(), 'displayTitle' => $displayTitle, 'displayDescription' => $displayDescription])->render();
if (strpos($html, $displayTitle) !== false) {
    echo "RENDERED_TITLE_OK\n";
} else {
    echo "RENDERED_TITLE_MISSING\n";
}
if (strpos($html, 'Admit Card Details') !== false) {
    echo "FALLBACK_PRESENT\n";
} else {
    echo "FALLBACK_MISSING\n";
}
$lines = explode("\n", $html);
foreach ($lines as $line) {
    if (strpos($line, 'Name of Admit Card') !== false || strpos($line, $displayTitle) !== false || strpos($line, 'Admit Card Details') !== false) {
        echo $line . "\n";
    }
}
