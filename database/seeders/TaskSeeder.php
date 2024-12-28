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
        $task = new Task();
        $task->title = 'Leer documentación';
        $task->save();

        $task = new Task();
        $task->title = 'Programar diariamente';
        $task->save();

        $task = new Task();
        $task->title = 'Aprender sobre patrones de diseño';
        $task->save();

        $task = new Task();
        $task->title = 'Crear paginas web';
        $task->save();

        $task = new Task();
        $task->title = 'Estudiar protocolos';
        $task->save();

        $task = new Task();
        $task->title = 'Apoyar a mis compañeros';
        $task->save();

        $task = new Task();
        $task->title = 'Estudiar redes';
        $task->save();

        $task = new Task();
        $task->title = 'Estudiar lenguajes de programación';
        $task->save();


    }
}
