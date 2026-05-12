<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ClearExpiredOtps extends Command
{
    protected $signature = 'otp:clear';

    protected $description = 'Delete expired OTP records';

    public function handle()
    {
        DB::table('password_reset_tokens')
            ->where('expires_at', '<', Carbon::now())
            ->delete();

        $this->info('Expired OTPs deleted successfully');
    }
}
