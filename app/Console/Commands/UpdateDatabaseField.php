<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UpdateDatabaseField extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:field';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Database Field';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        DB::table('users')->where('account_id','=',1)->update(['balance'=>2900]);
        $this->info('Database field updated successfully!');
    }
}
