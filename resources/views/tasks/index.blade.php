<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Progress Tracking - Tasks</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
            
            body {
                font-family: 'Inter', sans-serif;
            }
            
            .violet-gradient {
                background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 25%, #a78bfa 50%, #c4b5fd 75%, #ddd6fe 100%);
                min-height: 100vh;
            }
            
            .card-custom {
                background: rgba(255, 255, 255, 0.98);
                backdrop-filter: blur(20px);
                border-radius: 1.5rem;
                border: 1px solid rgba(255, 255, 255, 0.5);
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06), 0 20px 25px -5px rgba(139, 92, 246, 0.15);
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }
            
            .card-custom:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05), 0 25px 50px -12px rgba(139, 92, 246, 0.25);
            }
            
            .status-badge {
                padding: 0.375rem 1rem;
                border-radius: 2rem;
                font-size: 0.875rem;
                font-weight: 600;
            }
            
            .status-pending {
                background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
                color: #92400e;
            }
            
            .status-in-progress {
                background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
                color: #1e40af;
            }
            
            .status-completed {
                background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
                color: #065f46;
            }
            
            .btn-create {
                background: linear-gradient(135deg, #ffffff 0%, #e0e7ff 100%);
                color: #4c1d95;
                font-weight: 700;
                padding: 0.75rem 2rem;
                border-radius: 2rem;
                border: 2px solid rgba(255, 255, 255, 0.5);
                box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.2);
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                text-decoration: none;
            }
            
            .btn-create:hover {
                transform: translateY(-2px);
                box-shadow: 0 20px 35px -5px rgba(0, 0, 0, 0.3);
                color: #4c1d95;
            }
            
            .task-image {
                width: 100%;
                height: 200px;
                object-fit: cover;
                border-radius: 1rem;
                margin-bottom: 1rem;
            }
            
            .heading-gradient {
                background: linear-gradient(135deg, #ffffff 0%, #e0e7ff 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }
            
            .column-header {
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(10px);
                border-radius: 1rem;
                padding: 1rem 1.5rem;
                margin-bottom: 1.5rem;
                border: 1px solid rgba(255, 255, 255, 0.5);
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            }
            
            .column-header h3 {
                margin: 0;
                font-weight: 700;
            }
            
            .column-count {
                background: rgba(255, 255, 255, 0.8);
                padding: 0.25rem 0.75rem;
                border-radius: 1rem;
                font-size: 0.875rem;
                font-weight: 600;
            }
            
            .task-card {
                cursor: grab;
            }
            
            .task-card:active {
                cursor: grabbing;
            }
            
            .task-card.dragging {
                opacity: 0.5;
                transform: scale(0.95);
            }
            
            .column-drop-zone {
                min-height: 400px;
                border-radius: 1rem;
                transition: all 0.3s ease;
                padding-bottom: 2rem;
            }
            
            .column-drop-zone.drag-over {
                background: rgba(255, 255, 255, 0.2);
                border: 2px dashed rgba(255, 255, 255, 0.5);
            }
        </style>
    </head>
    <body class="antialiased">
        <div class="violet-gradient d-flex flex-column min-vh-100 position-relative">
            <div class="container-fluid py-5 px-4">
                <div class="d-flex justify-content-between align-items-center mb-5">
                    <h1 class="display-4 fw-bold heading-gradient mb-0">Progress Tasks</h1>
                    <a href="{{ route('tasks.create') }}" class="btn-create">+ Create Task</a>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if($tasks->count() > 0)
                    <div class="row g-5">
                        <!-- Pending Column -->
                        <div class="col-md-4">
                            <div class="column-header d-flex justify-content-between align-items-center">
                                <h3 class="h5 mb-0" style="color: #92400e;">Pending</h3>
                                <span class="column-count" style="color: #92400e;">{{ $tasks->where('status', 'pending')->count() }}</span>
                            </div>
                            <div class="column-drop-zone" data-status="pending">
                                @foreach($tasks->where('status', 'pending') as $task)
                                    <div class="card-custom p-4 mb-4 task-card" draggable="true" data-task-id="{{ $task->id }}">
                                        @if($task->image_path)
                                            <img src="{{ asset('storage/' . $task->image_path) }}" alt="{{ $task->title }}" class="task-image">
                                        @endif
                                        
                                        <h3 class="h5 fw-bold mb-2" style="color: #1e1b4b;">{{ $task->title }}</h3>
                                        
                                        @if($task->description)
                                            <p class="mb-2" style="color: #4b5563; line-height: 1.6;">
                                                {{ Str::limit($task->description, 150) }}
                                            </p>
                                        @endif
                                        
                                        <div class="mt-3 pt-3 border-top" style="border-color: rgba(139, 92, 246, 0.2) !important;">
                                            <small class="text-muted">
                                                {{ $task->created_at->format('M d, Y') }}
                                            </small>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- In Progress Column -->
                        <div class="col-md-4">
                            <div class="column-header d-flex justify-content-between align-items-center">
                                <h3 class="h5 mb-0" style="color: #1e40af;">In Progress</h3>
                                <span class="column-count" style="color: #1e40af;">{{ $tasks->where('status', 'in_progress')->count() }}</span>
                            </div>
                            <div class="column-drop-zone" data-status="in_progress">
                                @foreach($tasks->where('status', 'in_progress') as $task)
                                    <div class="card-custom p-4 mb-4 task-card" draggable="true" data-task-id="{{ $task->id }}">
                                        @if($task->image_path)
                                            <img src="{{ asset('storage/' . $task->image_path) }}" alt="{{ $task->title }}" class="task-image">
                                        @endif
                                        
                                        <h3 class="h5 fw-bold mb-2" style="color: #1e1b4b;">{{ $task->title }}</h3>
                                        
                                        @if($task->description)
                                            <p class="mb-2" style="color: #4b5563; line-height: 1.6;">
                                                {{ Str::limit($task->description, 150) }}
                                            </p>
                                        @endif
                                        
                                        <div class="mt-3 pt-3 border-top" style="border-color: rgba(139, 92, 246, 0.2) !important;">
                                            <small class="text-muted">
                                                {{ $task->created_at->format('M d, Y') }}
                                            </small>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Completed Column -->
                        <div class="col-md-4">
                            <div class="column-header d-flex justify-content-between align-items-center">
                                <h3 class="h5 mb-0" style="color: #065f46;">Completed</h3>
                                <span class="column-count" style="color: #065f46;">{{ $tasks->where('status', 'completed')->count() }}</span>
                            </div>
                            <div class="column-drop-zone" data-status="completed">
                                @foreach($tasks->where('status', 'completed') as $task)
                                    <div class="card-custom p-4 mb-4 task-card" draggable="true" data-task-id="{{ $task->id }}">
                                        @if($task->image_path)
                                            <img src="{{ asset('storage/' . $task->image_path) }}" alt="{{ $task->title }}" class="task-image">
                                        @endif
                                        
                                        <h3 class="h5 fw-bold mb-2" style="color: #1e1b4b;">{{ $task->title }}</h3>
                                        
                                        @if($task->description)
                                            <p class="mb-2" style="color: #4b5563; line-height: 1.6;">
                                                {{ Str::limit($task->description, 150) }}
                                            </p>
                                        @endif
                                        
                                        <div class="mt-3 pt-3 border-top" style="border-color: rgba(139, 92, 246, 0.2) !important;">
                                            <small class="text-muted">
                                                {{ $task->created_at->format('M d, Y') }}
                                            </small>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @else
                    <div class="text-center py-5">
                        <div class="card-custom p-5 d-inline-block">
                            <h3 class="h4 fw-bold mb-3" style="color: #1e1b4b;">No Tasks Yet</h3>
                            <p class="mb-4" style="color: #4b5563;">Start tracking your progress by creating your first task!</p>
                            <a href="{{ route('tasks.create') }}" class="btn-create">Create Your First Task</a>
                        </div>
                    </div>
                @endif

                <div class="mt-5 text-center">
                    <a href="{{ url('/') }}" class="text-white text-decoration-none fw-medium" style="opacity: 0.85;">
                        ← Back to Home
                    </a>
                </div>
            </div>
        </div>
        
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            // Drag and drop functionality
            const taskCards = document.querySelectorAll('.task-card');
            const dropZones = document.querySelectorAll('.column-drop-zone');
            
            taskCards.forEach(card => {
                card.addEventListener('dragstart', handleDragStart);
                card.addEventListener('dragend', handleDragEnd);
            });
            
            dropZones.forEach(zone => {
                zone.addEventListener('dragover', handleDragOver);
                zone.addEventListener('dragleave', handleDragLeave);
                zone.addEventListener('drop', handleDrop);
            });
            
            function handleDragStart(e) {
                e.currentTarget.classList.add('dragging');
                e.dataTransfer.setData('text/plain', e.currentTarget.dataset.taskId);
                e.dataTransfer.effectAllowed = 'move';
            }

            function handleDragEnd(e) {
                e.currentTarget.classList.remove('dragging');
            }
            
            function handleDragOver(e) {
                e.preventDefault();
                e.dataTransfer.dropEffect = 'move';
                e.currentTarget.classList.add('drag-over');
            }
            
            function handleDragLeave(e) {
                e.currentTarget.classList.remove('drag-over');
            }
            
            function handleDrop(e) {
                e.preventDefault();
                e.currentTarget.classList.remove('drag-over');
                
                const taskId = e.dataTransfer.getData('text/plain');
                const newStatus = e.currentTarget.dataset.status;
                
                if (taskId && newStatus) {
                    updateTaskStatus(taskId, newStatus);
                }
            }
            
            function updateTaskStatus(taskId, newStatus) {
                const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                
                fetch(`/tasks/${taskId}/status`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({
                        status: newStatus
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Failed to update task status');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Failed to update task status');
                });
            }
        </script>
    </body>
</html>
