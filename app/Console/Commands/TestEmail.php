<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Helpers\MailHelper;

class TestEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:email {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a test email to verify EWS configuration';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $email = $this->argument('email');
        $this->info("Sending test email to {$email}...");

        $result = MailHelper::sendMail($email, 'Test Subject', 'This is a test message.');

        if ($result) {
            $this->info("Success! Test email sent to {$email}.");
        } else {
            $this->error("Failed to send email. Check storage/logs/laravel.log for details.");
        }

        return 0;
    }
}
