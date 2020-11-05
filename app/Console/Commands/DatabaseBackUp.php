<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class DatabaseBackUp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'database:backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'backup justorder';

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

        $dirPath = 'D:\JustOrder_new_backup';
        if(!File::isDirectory($dirPath)){
           // dump('sdsd');
            File::makeDirectory($dirPath, 0777, true, true);

        }
        $filename = "backup-" . Carbon::now()->format('Y-m-d') . ".sql";

        $command = "mysqldump --user=" . env('DB_USERNAME') ." --password=" . env('DB_PASSWORD') . " --host=" . env('DB_HOST') ." --port=" . env('DB_PORT') . " " . env('DB_DATABASE') .
            "    > ".$dirPath . "/" . $filename;

        $returnVar = NULL;
        $output  = NULL;



        exec($command, $output, $returnVar);


        $OldFilename = "backup-" . Carbon::now()->subDays(2)->format('Y-m-d') . ".sql";
        dd($OldFilename);
        if(File::exists($dirPath . '/' . $OldFilename)){

            dd('s');
            File::delete($dirPath . '/' . $OldFilename);

        }else{

            dd('File does not exists.');

        }

    }
}
