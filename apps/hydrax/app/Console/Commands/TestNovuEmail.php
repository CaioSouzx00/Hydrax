<?php

namespace App\Console\Commands;

use App\Services\Novu\NovuService;
use Illuminate\Console\Command;

class TestNovuEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'novu:test {email : The email address to send test to}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test Novu email sending functionality';

    /**
     * Execute the console command.
     */
    public function handle(NovuService $novuService)
    {
        $email = $this->argument('email');

        $this->info("Testing Novu email sending to: {$email}");

        try {
            $result = $novuService->sendCodigoVerificacao(
                subscriberId: 'test_subscriber',
                email: $email,
                codigo: '123456'
            );

            if ($result['success']) {
                $this->info("✅ Test email sent successfully!");
                $this->info("Response data: " . json_encode($result['data']));
                return Command::SUCCESS;
            } else {
                $this->error("❌ Failed to send test email");
                $this->error("Error: " . $result['error']);
                return Command::FAILURE;
            }
        } catch (\Exception $e) {
            $this->error("❌ Exception occurred: " . $e->getMessage());
            $this->error("Please check your NOVU_API_KEY in .env file");
            return Command::FAILURE;
        }
    }
}
