<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$slug = 'up-police-constable-recruitment-2025-exam-city-and-admit-card-details-released';
$admitCard = App\Models\AdmitCard::where('slug', $slug)->first();
if (!$admitCard) {
    echo "NO_RECORD\n";
    exit;
}

echo "id=" . $admitCard->id . "\n";
echo "slug=" . $admitCard->slug . "\n";
echo "title=" . var_export($admitCard->title, true) . "\n";
echo "short=" . var_export($admitCard->short_description, true) . "\n";
echo "description=" . var_export($admitCard->description, true) . "\n";
if ($admitCard->job) {
    echo "job_title=" . var_export($admitCard->job->title, true) . "\n";
} else {
    echo "job_title=NULL\n";
}

$controller = new App\Http\Controllers\HomeController();
$response = $controller->showAdmitCard($admitCard);
$data = $response->getData();
var_export($data->pageDisplayTitle ?? null);
echo "\n";
var_export($data->pageDisplayDescription ?? null);
echo "\n";
