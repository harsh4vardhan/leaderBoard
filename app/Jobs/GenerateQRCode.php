<?php

// app/Jobs/GenerateQRCode.php

namespace App\Jobs;

use App\Models\LeaderboardUser;
use Endroid\QrCode\QrCode;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class GenerateQRCode implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;

    public function __construct(LeaderboardUser $user)
    {
        $this->user = $user;
    }

    public function handle()
    {
        $qrCode = new QrCode($this->user->address);
        $qrCode->setSize(300);
        $qrCode->setMargin(10); // Optional, for adding margin
    
        // Generate QR code image and get it as a string
        $writer = new \Endroid\QrCode\Writer\PngWriter();
        $result = $writer->write($qrCode);
    
        $path = 'qr-codes/' . $this->user->id . '.png';
        Storage::disk('public')->put($path, $result->getString());
    }
}
