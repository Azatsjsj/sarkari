<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\AdmitCard;

$slug = 'bihar-cet-bed-admit-card-2026';
$ad = AdmitCard::where('slug', $slug)->with('job.category')->first();
if (!$ad) {
    echo "MISSING\n";
    exit(0);
}

echo "FOUND\n";
echo "ID=" . $ad->id . "\n";
echo "TITLE=" . ($ad->title ?: '<NULL>') . "\n";
echo "SLUG=" . ($ad->slug ?: '<NULL>') . "\n";
echo "SHORT=" . ($ad->short_description ?: '<NULL>') . "\n";
echo "DESC=" . ($ad->description ?: '<NULL>') . "\n";
echo "FILE=" . ($ad->file_path ?: '<NULL>') . "\n";
echo "DOWNLOAD=" . ($ad->download_link ?: '<NULL>') . "\n";
echo "JOB_TITLE=" . ($ad->job->title ?? '<NULL>') . "\n";
echo "JOB_CATEGORY=" . ($ad->job->category->name ?? '<NULL>') . "\n";
