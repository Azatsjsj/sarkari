<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\AdmitCard;

$ad = AdmitCard::where('slug', 'bihar-cet-bed-admit-card-2026')->with('job.category')->first();
if (!$ad) {
    echo "MISSING\n";
    exit(1);
}

$ad->increment('views');
$relatedAdmitCards = App\Models\AdmitCard::with('job')
    ->where('id', '!=', $ad->id)
    ->where('is_active', true)
    ->latest('admit_card_date')
    ->take(5)
    ->get();

$pageDisplayTitle = (new App\Http\Controllers\HomeController())->resolveDisplayTitle(
    $ad->title,
    $ad->short_description,
    $ad->description,
    $ad->job?->title,
    $ad->slug,
    'Admit Card Details'
);
$pageDisplayDescription = trim((string) ($ad->short_description ?: ($ad->description ?: ($ad->job?->description ?? 'Details will be updated soon.'))));

$view = view('admit-cards.show', compact('ad', 'admitCard', 'relatedAdmitCards', 'pageDisplayTitle', 'pageDisplayDescription'));

echo "RENDERED\n";
echo substr($view->render(), 0, 5000);
