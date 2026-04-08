<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\AnomalyDetectionService;
use App\Models\User;

class DetectAnomalies extends Command
{
    protected $signature = 'anomaly:detect';
    protected $description = 'Learn user behavior baselines and detect anomalies';

    public function handle()
    {
        $this->info('Starting anomaly detection...');
        
        $service = app(AnomalyDetectionService::class);
        $users = User::all();
        
        $bar = $this->output->createProgressBar($users->count());
        
        foreach ($users as $user) {
            $service->learnUserBehavior($user->id);
            $bar->advance();
        }
        
        $bar->finish();
        $this->newLine();
        $this->info('Anomaly detection completed successfully!');
        
        return 0;
    }
}
