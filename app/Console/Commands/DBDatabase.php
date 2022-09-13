<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class DBDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:dv_trading';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backing Up Database';

    protected $process;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        // if (!is_dir(storage_path('backups')))
        //     mkdir(storage_path('backups'));

        // $this->process = new Process(sprintf(
        //     'mysqldump --compact --skip-comments -u%s -p%s %s > %s',
        //     config('database.connections.mysql.username'),
        //     config('database.connections.mysql.password'),
        //     config('database.connections.mysql.database'),
        //     storage_path("backup-dv_trading" . Carbon::now()->format('Y-m-d') . ".sql")
        // ));
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $filename = "backup-" . Carbon::now()->format('Y-m-d') . ".gz";
  
        $command = "mysqldump --user=" . env('DB_USERNAME') ." --password=" . env('DB_PASSWORD') . " --host=" . env('DB_HOST') . " " . env('DB_DATABASE') . "  | gzip > " . storage_path() . "/app/backup/" . $filename;
  
        $returnVar = NULL;
        $output  = NULL;
  
        exec($command, $output, $returnVar);
        // try {
        //     $this->process->mustRun();
        //     Log::info('Daily DB Backup - Success');
        // } catch (ProcessFailedException $exception) {
        //     Log::error('Daily DB Backup - Failed');
        // }
    }
}
