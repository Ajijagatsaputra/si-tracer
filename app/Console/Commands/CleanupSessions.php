<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CleanupSessions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sessions:cleanup {--force : Force cleanup without confirmation}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean up expired sessions from the database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting session cleanup...');

        // Get session lifetime from config
        $sessionLifetime = config('session.lifetime', 120);
        $cutoffTime = Carbon::now()->subMinutes($sessionLifetime);

        // Count expired sessions
        $expiredCount = DB::table('sessions')
            ->where('last_activity', '<', $cutoffTime->timestamp)
            ->count();

        if ($expiredCount === 0) {
            $this->info('No expired sessions found.');
            return 0;
        }

        $this->warn("Found {$expiredCount} expired sessions to clean up.");

        // Ask for confirmation unless --force is used
        if (!$this->option('force')) {
            if (!$this->confirm("Do you want to delete {$expiredCount} expired sessions?")) {
                $this->info('Session cleanup cancelled.');
                return 0;
            }
        }

        // Delete expired sessions
        $deletedCount = DB::table('sessions')
            ->where('last_activity', '<', $cutoffTime->timestamp)
            ->delete();

        $this->info("Successfully deleted {$deletedCount} expired sessions.");

        // Show current session count
        $totalSessions = DB::table('sessions')->count();
        $this->info("Total sessions remaining: {$totalSessions}");

        return 0;
    }
}
