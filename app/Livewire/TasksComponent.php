<?php

namespace App\Livewire;

use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TasksComponent extends Component
{
    public $tasks = [];
    public $modal = false;
    public $title;
    public $description;

    public $task_id;

    public function mount()
    {
        $this->getTasks();
    }

    public function getTasks()
    {
        $user = Auth::User();
        $userTasks = $user->tasks();
        $sharedTasks = $user->sharedTasks();
        $this->tasks = $sharedTasks->merge($userTasks);
    }

    public function openCreateModal()
    {
        $this->resetInput();
        $this->modal = true;
    }

    public function closeCreateModal()
    {
        $this->modal = false;
        $this->resetInput();
    }
    
    private function resetInput()
    {
        $this->title = '';
        $this->description = '';
        $this->task_id = null;
    }

    public function createTask()
    {
        $this->validate([
            'title' => 'required|string',
            'description' => 'required|string',
        ]);

        Task::create([
            'title' => $this->title,
            'description' => $this->description,
            'user_id' => Auth::user()->id
        ]);
        $this->closeCreateModal();
        $this->getTasks();
    }

    public function editTask($id)
    {
        $task = Task::find($id);
        if ($task && $task->user_id == Auth::id()) {
            $this->task_id = $task->id;
            $this->title = $task->title;
            $this->description = $task->description;
            $this->modal = true;
        }
    }

    public function updateTask()
    {
        $this->validate([
            'title' => 'required|string',
            'description' => 'required|string',
        ]);

        $task = Task::find($this->task_id);
        if ($task && $task->user_id == Auth::id()) {
            $task->update([
                'title' => $this->title,
                'description' => $this->description,
            ]);
        }
        $this->closeCreateModal();
        $this->getTasks();
    }

    public function deleteTask($id)
    {
        $task = Task::find($id);
        if ($task && $task->user_id == Auth::id()) {
            $task->delete();
            $this->getTasks();
        }
    }
    
    public function render()
    {
        return view('livewire.tasks-component');
    }
}