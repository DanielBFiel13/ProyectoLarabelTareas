<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $task1 = new Task();
        $task1->title = 'Task 1';
        $task1->description = 'Tarea de Admin';
        $task1->user_id = 1;
        $task1->save();

        $task2 = new Task();
        $task2->title = 'Task 2';
        $task2->description = 'Tarea de Daniel';
        $task2->user_id = 2;
        $task2->save();
    }
}
