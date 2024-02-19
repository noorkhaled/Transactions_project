<?php

namespace App\Console\Commands;

use App\Models\Tasks;
use Illuminate\Console\Command;

class UpdateTaskStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:task_status {id} {new_status}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Task status';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $task_id = $this->argument('id');
        $new_status = $this->argument('new_status');

        $task = Tasks::find($task_id);
        if ($task){
            $task->update(['status'=>$new_status]);
            $this->info("Task status updated");
        }else{
            $this->error('task error');
        }
    }
}
