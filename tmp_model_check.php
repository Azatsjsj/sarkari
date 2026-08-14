<?php
require 'vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
$app = require 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$admitCard = App\Models\AdmitCard::where('slug', 'up-police-constable-recruitment-2025-exam-city-and-admit-card-details-released')->first();
if (!$admitCard) {
    echo "NOT_FOUND\n";
    exit;
}
echo 'ID=' . $admitCard->id . PHP_EOL;
echo 'TITLE=' . $admitCard->title . PHP_EOL;
echo 'SHORT=' . $admitCard->short_description . PHP_EOL;
echo 'DESC=' . $admitCard->description . PHP_EOL;
echo 'JOB=' . ($admitCard->job?->title ?? 'NO_JOB') . PHP_EOL;
