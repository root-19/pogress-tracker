<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Modules - Progress Tracking</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
            
            body {
                font-family: 'Inter', sans-serif;
                color: #1e1b4b;
            }

            .violet-gradient {
                background:
                    radial-gradient(circle at 12% 18%, rgba(167, 139, 250, 0.55) 0%, transparent 45%),
                    radial-gradient(circle at 88% 12%, rgba(99, 102, 241, 0.55) 0%, transparent 45%),
                    radial-gradient(circle at 75% 85%, rgba(236, 72, 153, 0.30) 0%, transparent 50%),
                    linear-gradient(135deg, #4c1d95 0%, #6d28d9 40%, #7c3aed 70%, #8b5cf6 100%);
                background-attachment: fixed;
                min-height: 100vh;
            }

            .card-custom {
                background: rgba(255, 255, 255, 0.98);
                backdrop-filter: blur(20px);
                border-radius: 1.25rem;
                border: 1px solid rgba(255, 255, 255, 0.6);
                box-shadow: 0 1px 2px rgba(16, 8, 48, 0.06), 0 12px 24px -10px rgba(76, 29, 149, 0.25);
                transition: transform 0.25s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            }

            .card-custom:hover {
                transform: translateY(-4px);
                box-shadow: 0 4px 6px -2px rgba(16, 8, 48, 0.08), 0 24px 40px -12px rgba(76, 29, 149, 0.38);
            }

            .task-card {
                position: relative;
                overflow: hidden;
            }

            .task-card::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                bottom: 0;
                width: 4px;
                background: linear-gradient(180deg, #8b5cf6, #6366f1);
                opacity: 0.85;
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
                min-height: 200px;
                max-height: 65vh;
                overflow-y: auto;
                border-radius: 1rem;
                transition: background 0.3s ease, border 0.3s ease;
                padding: 0.5rem 0.5rem 1rem;
                background: rgba(255, 255, 255, 0.3);
            }

            .column-drop-zone.drag-over {
                background: rgba(255, 255, 255, 0.5);
                border: 2px dashed rgba(255, 255, 255, 0.5);
            }

            /* Custom scrollbar for columns */
            .column-drop-zone::-webkit-scrollbar {
                width: 8px;
            }

            .column-drop-zone::-webkit-scrollbar-track {
                background: transparent;
            }

            .column-drop-zone::-webkit-scrollbar-thumb {
                background: rgba(124, 58, 237, 0.35);
                border-radius: 999px;
            }

            .column-drop-zone::-webkit-scrollbar-thumb:hover {
                background: rgba(124, 58, 237, 0.6);
            }

            .column-drop-zone {
                scrollbar-width: thin;
                scrollbar-color: rgba(124, 58, 237, 0.45) transparent;
            }
            
            .module-header {
                background: rgba(255, 255, 255, 0.97);
                backdrop-filter: blur(14px);
                border-radius: 1.5rem;
                padding: 1.75rem 2rem;
                margin-bottom: 2rem;
                border: 1px solid rgba(255, 255, 255, 0.6);
                box-shadow: 0 10px 30px -12px rgba(76, 29, 149, 0.45);
            }

            .module-progress {
                height: 8px;
                border-radius: 999px;
                background: rgba(124, 58, 237, 0.12);
                overflow: hidden;
                margin-top: 1rem;
            }

            .module-progress-bar {
                height: 100%;
                border-radius: 999px;
                background: linear-gradient(90deg, #8b5cf6, #6366f1);
                transition: width 0.4s ease;
            }

            .task-count-badge {
                display: inline-flex;
                align-items: center;
                gap: 0.35rem;
                background: rgba(99, 102, 241, 0.1);
                color: #6d28d9;
                font-weight: 600;
                font-size: 0.8rem;
                padding: 0.25rem 0.75rem;
                border-radius: 999px;
            }
            
            .column-header {
                background: rgba(255, 255, 255, 0.96);
                backdrop-filter: blur(10px);
                border-radius: 0.9rem;
                padding: 0.85rem 1.25rem;
                margin-bottom: 1.25rem;
                border: 1px solid rgba(255, 255, 255, 0.6);
                box-shadow: 0 4px 6px -1px rgba(16, 8, 48, 0.1);
                border-top: 4px solid #c4b5fd;
            }

            .column-header h3 {
                margin: 0;
                font-weight: 700;
                display: flex;
                align-items: center;
                gap: 0.5rem;
            }

            .column-header h3::before {
                content: '';
                width: 10px;
                height: 10px;
                border-radius: 50%;
                background: currentColor;
            }

            .column-count {
                background: rgba(99, 102, 241, 0.12);
                color: inherit;
                padding: 0.2rem 0.7rem;
                border-radius: 1rem;
                font-size: 0.8rem;
                font-weight: 700;
                min-width: 2rem;
                text-align: center;
            }

            /* Per-status column theming */
            .col-pending     { border-top-color: #f59e0b; }
            .col-progress    { border-top-color: #3b82f6; }
            .col-completed   { border-top-color: #10b981; }

            .column-drop-zone.zone-pending.drag-over   { background: rgba(245, 158, 11, 0.18); border-color: rgba(245, 158, 11, 0.5); }
            .column-drop-zone.zone-progress.drag-over  { background: rgba(59, 130, 246, 0.18); border-color: rgba(59, 130, 246, 0.5); }
            .column-drop-zone.zone-completed.drag-over { background: rgba(16, 185, 129, 0.18); border-color: rgba(16, 185, 129, 0.5); }

            .empty-column {
                text-align: center;
                padding: 2rem 1rem;
                color: rgba(76, 29, 149, 0.45);
                font-size: 0.85rem;
                font-weight: 500;
                border: 2px dashed rgba(124, 58, 237, 0.2);
                border-radius: 1rem;
            }
            
            .notes-section {
                background: rgba(243, 244, 246, 0.8);
                border-radius: 0.75rem;
                padding: 0.75rem;
                margin-top: 0.75rem;
            }
            
            .note-item {
                background: rgba(255, 255, 255, 0.9);
                border-radius: 0.5rem;
                padding: 0.5rem;
                margin-bottom: 0.5rem;
                font-size: 0.875rem;
                position: relative;
            }
            
            .note-item:last-child {
                margin-bottom: 0;
            }
            
            .btn-add-note {
                background: rgba(139, 92, 246, 0.1);
                color: #6366f1;
                border: 1px solid rgba(139, 92, 246, 0.3);
                border-radius: 0.5rem;
                padding: 0.375rem 0.75rem;
                font-size: 0.75rem;
                font-weight: 600;
                transition: all 0.2s ease;
            }
            
            .btn-add-note:hover {
                background: rgba(139, 92, 246, 0.2);
                color: #4c1d95;
            }
            
            .btn-delete-note {
                background: none;
                border: none;
                color: #ef4444;
                font-size: 0.75rem;
                padding: 0.25rem;
                cursor: pointer;
                opacity: 0.6;
                transition: opacity 0.2s ease;
            }
            
            .btn-delete-note:hover {
                opacity: 1;
            }
            
            .heading-gradient {
                background: linear-gradient(135deg, #ffffff 0%, #e0e7ff 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }
            
            .task-image {
                width: 100%;
                height: 150px;
                object-fit: cover;
                border-radius: 1rem;
                margin-bottom: 1rem;
                cursor: zoom-in;
                transition: transform 0.2s ease;
            }

            .task-image:hover {
                transform: scale(1.02);
            }

            .image-lightbox {
                display: none;
                position: fixed;
                inset: 0;
                z-index: 1080;
                background: rgba(15, 10, 40, 0.85);
                backdrop-filter: blur(6px);
                align-items: center;
                justify-content: center;
                padding: 2rem;
                cursor: zoom-out;
            }

            .image-lightbox.show {
                display: flex;
            }

            .image-lightbox img {
                max-width: 90vw;
                max-height: 90vh;
                object-fit: contain;
                border-radius: 1rem;
                box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.6);
            }

            .image-lightbox .lightbox-close {
                position: absolute;
                top: 1.5rem;
                right: 2rem;
                font-size: 2.5rem;
                line-height: 1;
                color: #fff;
                background: none;
                border: none;
                cursor: pointer;
            }
        </style>
    </head>
    <body class="antialiased">
        <div class="violet-gradient d-flex flex-column min-vh-100 position-relative">
            <div class="container-fluid py-5 px-4">
                <div class="d-flex justify-content-between align-items-center mb-5 flex-wrap gap-3">
                    <div>
                        <h1 class="display-4 fw-bold heading-gradient mb-1">Modules</h1>
                        <p class="mb-0" style="color: rgba(255,255,255,0.8); font-weight: 500;">Track your tasks across every stage</p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('modules.create') }}" class="btn-create">+ Create Module</a>
                        <a href="{{ route('tasks.create') }}" class="btn-create">+ Create Task</a>
                    </div>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if($modules->count() > 0)
                    @foreach($modules as $module)
                        @php
                            $totalTasks = $module->tasks->count();
                            $doneTasks = $module->tasks->where('status', 'completed')->count();
                            $pct = $totalTasks > 0 ? round($doneTasks / $totalTasks * 100) : 0;
                        @endphp
                        <div class="module-header mb-5" style="border-left: 6px solid {{ $module->color }};">
                            <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
                                <div>
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <span style="width:14px;height:14px;border-radius:4px;background:{{ $module->color }};display:inline-block;"></span>
                                        <h2 class="h3 fw-bold mb-0" style="color: #1e1b4b;">{{ $module->name }}</h2>
                                    </div>
                                    <span class="task-count-badge">📋 {{ $totalTasks }} {{ Str::plural('task', $totalTasks) }} · {{ $pct }}% complete</span>
                                </div>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('modules.show', $module) }}" class="btn btn-sm btn-outline-primary">View</a>
                                    <a href="{{ route('modules.edit', $module) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                                    <form action="{{ route('modules.destroy', $module) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </div>
                            </div>

                            <div class="module-progress">
                                <div class="module-progress-bar" style="width: {{ $pct }}%;"></div>
                            </div>

                            <div class="row g-4 mt-3">
                                <!-- Pending Column -->
                                <div class="col-md-4">
                                    <div class="column-header col-pending d-flex justify-content-between align-items-center">
                                        <h3 class="h5 mb-0" style="color: #b45309;">Pending</h3>
                                        <span class="column-count" style="color: #b45309;">{{ $module->tasks->where('status', 'pending')->count() }}</span>
                                    </div>
                                    <div class="column-drop-zone zone-pending" data-status="pending" data-module-id="{{ $module->id }}">
                                        @forelse($module->tasks->where('status', 'pending') as $task)
                                            <div class="card-custom p-3 mb-3 task-card" draggable="true" data-task-id="{{ $task->id }}">
                                                @if($task->image_path)
                                                    <img src="{{ asset('storage/' . $task->image_path) }}" alt="{{ $task->title }}" class="task-image" draggable="false">
                                                @endif
                                                <h3 class="h6 fw-bold mb-1" style="color: #1e1b4b;">{{ $task->title }}</h3>
                                                <small class="text-muted">{{ $task->created_at->format('M d') }}</small>
                                                
                                                <!-- Notes Section -->
                                                <div class="notes-section">
                                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                                        <small class="fw-bold" style="color: #6366f1;">Notes ({{ $task->notes->count() }})</small>
                                                        <button class="btn-add-note" onclick="openNoteModal({{ $task->id }})">+ Add Note</button>
                                                    </div>
                                                    @if($task->notes->count() > 0)
                                                        @foreach($task->notes as $note)
                                                            <div class="note-item">
                                                                <div class="d-flex justify-content-between align-items-start">
                                                                    <div style="flex: 1; margin-right: 0.5rem; color: {{ $note->color }};">{{ $note->content }}</div>
                                                                    <button class="btn-delete-note" onclick="deleteNote({{ $note->id }}, {{ $task->id }})">×</button>
                                                                </div>
                                                                <small class="text-muted" style="font-size: 0.7rem;">{{ $note->created_at->format('M d, H:i') }}</small>
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        <small class="text-muted" style="font-size: 0.8rem;">No notes yet</small>
                                                    @endif
                                                </div>
                                            </div>
                                        @empty
                                            <div class="empty-column">No pending tasks</div>
                                        @endforelse
                                    </div>
                                </div>

                                <!-- In Progress Column -->
                                <div class="col-md-4">
                                    <div class="column-header col-progress d-flex justify-content-between align-items-center">
                                        <h3 class="h5 mb-0" style="color: #1d4ed8;">In Progress</h3>
                                        <span class="column-count" style="color: #1d4ed8;">{{ $module->tasks->where('status', 'in_progress')->count() }}</span>
                                    </div>
                                    <div class="column-drop-zone zone-progress" data-status="in_progress" data-module-id="{{ $module->id }}">
                                        @forelse($module->tasks->where('status', 'in_progress') as $task)
                                            <div class="card-custom p-3 mb-3 task-card" draggable="true" data-task-id="{{ $task->id }}">
                                                @if($task->image_path)
                                                    <img src="{{ asset('storage/' . $task->image_path) }}" alt="{{ $task->title }}" class="task-image" draggable="false">
                                                @endif
                                                <h3 class="h6 fw-bold mb-1" style="color: #1e1b4b;">{{ $task->title }}</h3>
                                                <small class="text-muted">{{ $task->created_at->format('M d') }}</small>
                                                
                                                <!-- Notes Section -->
                                                <div class="notes-section">
                                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                                        <small class="fw-bold" style="color: #6366f1;">Notes ({{ $task->notes->count() }})</small>
                                                        <button class="btn-add-note" onclick="openNoteModal({{ $task->id }})">+ Add Note</button>
                                                    </div>
                                                    @if($task->notes->count() > 0)
                                                        @foreach($task->notes as $note)
                                                            <div class="note-item">
                                                                <div class="d-flex justify-content-between align-items-start">
                                                                    <div style="flex: 1; margin-right: 0.5rem; color: {{ $note->color }};">{{ $note->content }}</div>
                                                                    <button class="btn-delete-note" onclick="deleteNote({{ $note->id }}, {{ $task->id }})">×</button>
                                                                </div>
                                                                <small class="text-muted" style="font-size: 0.7rem;">{{ $note->created_at->format('M d, H:i') }}</small>
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        <small class="text-muted" style="font-size: 0.8rem;">No notes yet</small>
                                                    @endif
                                                </div>
                                            </div>
                                        @empty
                                            <div class="empty-column">Nothing in progress</div>
                                        @endforelse
                                    </div>
                                </div>

                                <!-- Completed Column -->
                                <div class="col-md-4">
                                    <div class="column-header col-completed d-flex justify-content-between align-items-center">
                                        <h3 class="h5 mb-0" style="color: #047857;">Completed</h3>
                                        <span class="column-count" style="color: #047857;">{{ $module->tasks->where('status', 'completed')->count() }}</span>
                                    </div>
                                    <div class="column-drop-zone zone-completed" data-status="completed" data-module-id="{{ $module->id }}">
                                        @forelse($module->tasks->where('status', 'completed') as $task)
                                            <div class="card-custom p-3 mb-3 task-card" draggable="true" data-task-id="{{ $task->id }}">
                                                @if($task->image_path)
                                                    <img src="{{ asset('storage/' . $task->image_path) }}" alt="{{ $task->title }}" class="task-image" draggable="false">
                                                @endif
                                                <h3 class="h6 fw-bold mb-1" style="color: #1e1b4b;">{{ $task->title }}</h3>
                                                <small class="text-muted">{{ $task->created_at->format('M d') }}</small>
                                                
                                                <!-- Notes Section -->
                                                <div class="notes-section">
                                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                                        <small class="fw-bold" style="color: #6366f1;">Notes ({{ $task->notes->count() }})</small>
                                                        <button class="btn-add-note" onclick="openNoteModal({{ $task->id }})">+ Add Note</button>
                                                    </div>
                                                    @if($task->notes->count() > 0)
                                                        @foreach($task->notes as $note)
                                                            <div class="note-item">
                                                                <div class="d-flex justify-content-between align-items-start">
                                                                    <div style="flex: 1; margin-right: 0.5rem; color: {{ $note->color }};">{{ $note->content }}</div>
                                                                    <button class="btn-delete-note" onclick="deleteNote({{ $note->id }}, {{ $task->id }})">×</button>
                                                                </div>
                                                                <small class="text-muted" style="font-size: 0.7rem;">{{ $note->created_at->format('M d, H:i') }}</small>
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        <small class="text-muted" style="font-size: 0.8rem;">No notes yet</small>
                                                    @endif
                                                </div>
                                            </div>
                                        @empty
                                            <div class="empty-column">No completed tasks</div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-5">
                        <div class="card-custom p-5 d-inline-block">
                            <h3 class="h4 fw-bold mb-3" style="color: #1e1b4b;">No Modules Yet</h3>
                            <p class="mb-4" style="color: #4b5563;">Create your first module to start organizing your tasks!</p>
                            <a href="{{ route('modules.create') }}" class="btn-create">Create Module</a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Image Lightbox -->
        <div class="image-lightbox" id="imageLightbox">
            <button type="button" class="lightbox-close" aria-label="Close">&times;</button>
            <img src="" alt="Preview" id="lightboxImage">
        </div>

        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            // Image lightbox: click a task image to view it full size
            const imageLightbox = document.getElementById('imageLightbox');
            const lightboxImage = document.getElementById('lightboxImage');

            document.querySelectorAll('.task-image').forEach(img => {
                img.addEventListener('click', function (e) {
                    e.stopPropagation();
                    lightboxImage.src = this.src;
                    lightboxImage.alt = this.alt;
                    imageLightbox.classList.add('show');
                });
            });

            function closeLightbox() {
                imageLightbox.classList.remove('show');
                lightboxImage.src = '';
            }

            imageLightbox.addEventListener('click', closeLightbox);
            lightboxImage.addEventListener('click', e => e.stopPropagation());
            document.addEventListener('keydown', e => {
                if (e.key === 'Escape') closeLightbox();
            });

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
                const moduleId = e.currentTarget.dataset.moduleId;
                
                if (taskId && newStatus && moduleId) {
                    updateTaskStatus(taskId, newStatus, moduleId);
                }
            }
            
            function updateTaskStatus(taskId, newStatus, moduleId) {
                const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                
                fetch(`/tasks/${taskId}/status`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        status: newStatus
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Failed to update task status: ' + (data.errors ? JSON.stringify(data.errors) : 'Unknown error'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Failed to update task status. Please try again.');
                });
            }
            
            // Notes functionality
            function openNoteModal(taskId) {
                document.getElementById('taskIdInput').value = taskId;
                document.getElementById('noteContent').value = '';
                const modal = new bootstrap.Modal(document.getElementById('noteModal'));
                modal.show();
            }
            
            function saveNote() {
                const taskId = document.getElementById('taskIdInput').value;
                const content = document.getElementById('noteContent').value;
                const color = document.getElementById('noteColor').value;
                const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                
                if (!content.trim()) {
                    alert('Please enter a note');
                    return;
                }
                
                fetch('/notes', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({
                        task_id: taskId,
                        content: content,
                        color: color
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Failed to add note');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Failed to add note');
                });
            }
            
            function deleteNote(noteId, taskId) {
                const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                
                if (!confirm('Are you sure you want to delete this note?')) {
                    return;
                }
                
                fetch(`/notes/${noteId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': token
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Failed to delete note');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Failed to delete note');
                });
            }
        </script>
        
        <!-- Note Modal -->
        <div class="modal fade" id="noteModal" tabindex="-1" aria-labelledby="noteModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="noteModalLabel">Add Note</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="taskIdInput">
                        <div class="mb-3">
                            <label for="noteContent" class="form-label">Note</label>
                            <textarea class="form-control" id="noteContent" rows="4" placeholder="Enter your note, question, or progress update..."></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="noteColor" class="form-label">Text Color</label>
                            <input type="color" class="form-control form-control-color" id="noteColor" value="#1e1b4b" style="height: 50px;">
                            <small class="text-muted">Choose a color for the note text</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" onclick="saveNote()">Save Note</button>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
