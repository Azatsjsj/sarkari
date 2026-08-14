<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
use App\Models\AdmitCard;
$slug = 'up-cnet-admit-card-2026';
$admitCard = AdmitCard::with(['job.category'])->where('slug', $slug)->first();
if (!$admitCard) {
    echo "NOT_FOUND\n";
    exit(0);
}
echo "ID=" . $admitCard->id . "\n";
echo "TITLE=" . ($admitCard->title ?? 'NULL') . "\n";
echo "JOB_ID=" . ($admitCard->job_id ?? 'NULL') . "\n";
echo "JOB=" . ($admitCard->job ? ($admitCard->job->title ?? 'NULL') : 'NULL') . "\n";
echo "CATEGORY=" . ($admitCard->job && $admitCard->job->category ? ($admitCard->job->category->name ?? 'NULL') : 'NULL') . "\n";
echo "ADMIT_CARD_DATE=" . ($admitCard->admit_card_date ?? 'NULL') . "\n";
echo "EXAM_DATE=" . ($admitCard->exam_date ?? 'NULL') . "\n";
echo "EXAM_VENUE=" . ($admitCard->exam_venue ?? 'NULL') . "\n";
echo "EXAM_TIME=" . ($admitCard->exam_time ?? 'NULL') . "\n";
echo "DOWNLOAD_LINK=" . ($admitCard->download_link ?? 'NULL') . "\n";
echo "FILE_PATH=" . ($admitCard->file_path ?? 'NULL') . "\n";
echo "ADMIT_CARD_PDF=" . ($admitCard->admit_card_pdf ?? 'NULL') . "\n";
echo "ADMIT_CARD_FILE=" . ($admitCard->admit_card_file ?? 'NULL') . "\n";
echo "NOTIFICATION_PDF=" . ($admitCard->job && $admitCard->job->notification_pdf ? $admitCard->job->notification_pdf : 'NULL') . "\n";
echo "OFFICIAL_WEBSITE=" . ($admitCard->job && $admitCard->job->official_website ? $admitCard->job->official_website : 'NULL') . "\n";
