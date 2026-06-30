<?php

namespace Database\Seeders;

use App\Models\Module;
use App\Models\Note;
use App\Models\Task;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TaskSeeder extends Seeder
{
    /**
     * Seed modules, tasks and notes for local development / demos.
     */
    public function run(): void
    {
        $modules = [
            ['name' => 'Frontend',     'color' => '#6366f1'],
            ['name' => 'Backend API',  'color' => '#ec4899'],
            ['name' => 'Mobile App',   'color' => '#10b981'],
        ];

        $statuses = ['pending', 'in_progress', 'completed'];

        // Plenty of pending-heavy titles so the columns overflow and scroll.
        $taskTitles = [
            'Design login page',
            'Set up authentication',
            'Build dashboard layout',
            'Create database schema',
            'Implement drag and drop',
            'Add image upload',
            'Write API endpoints',
            'Configure CI pipeline',
            'Add unit tests',
            'Optimize queries',
            'Build notifications',
            'Dark mode support',
            'Export to PDF',
            'Search functionality',
            'User profile page',
            'Role-based permissions',
            'Email reminders',
            'Activity timeline',
            'Settings screen',
            'Onboarding flow',
        ];

        $noteColors = ['#ef4444', '#f59e0b', '#10b981', '#3b82f6', '#8b5cf6'];

        foreach ($modules as $moduleData) {
            $module = Module::create([
                'name'  => $moduleData['name'],
                'slug'  => Str::slug($moduleData['name']) . '-' . Str::random(5),
                'color' => $moduleData['color'],
            ]);

            // 18 tasks per module, weighted toward "pending" so that column scrolls.
            for ($i = 0; $i < 18; $i++) {
                // 60% pending, 25% in_progress, 15% completed
                $roll = $i % 20;
                if ($roll < 12) {
                    $status = 'pending';
                } elseif ($roll < 17) {
                    $status = 'in_progress';
                } else {
                    $status = 'completed';
                }

                $task = Task::create([
                    'title'       => $taskTitles[$i % count($taskTitles)],
                    'description' => 'Auto-generated demo task for the ' . $module->name . ' module.',
                    'status'      => $status,
                    'module_id'   => $module->id,
                ]);

                // Add a couple of notes to some tasks.
                if ($i % 3 === 0) {
                    Note::create([
                        'task_id' => $task->id,
                        'content' => 'Remember to review this with the team.',
                        'color'   => $noteColors[$i % count($noteColors)],
                    ]);
                }
            }
        }
    }
}
