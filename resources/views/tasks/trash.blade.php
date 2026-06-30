<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Trash Bin - Progress Tracking</title>
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

            .task-image {
                width: 100%;
                height: 150px;
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
            
            .module-badge {
                display: inline-block;
                padding: 0.25rem 0.75rem;
                border-radius: 999px;
                font-size: 0.75rem;
                font-weight: 600;
                background: rgba(255, 255, 255, 0.9);
                border: 1px solid rgba(0,0,0,0.1);
                margin-bottom: 0.5rem;
            }
        </style>
    </head>
    <body class="antialiased">
        <div class="violet-gradient d-flex flex-column min-vh-100 position-relative">
            <div class="container py-5 px-4">
                <div class="mb-4">
                    <a href="{{ route('modules.index') }}" class="text-white text-decoration-none fw-medium" style="opacity: 0.85;">
                        ← Back to Modules
                    </a>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-5 flex-wrap gap-3">
                    <div>
                        <h1 class="display-5 fw-bold heading-gradient mb-1">Trash Bin</h1>
                        <p class="mb-0" style="color: rgba(255,255,255,0.8); font-weight: 500;">Review, restore, or permanently delete tasks</p>
                    </div>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="row g-4">
                    @forelse($tasks as $task)
                        <div class="col-md-4 col-lg-3">
                            <div class="card-custom p-3 h-100 d-flex flex-column">
                                @if($task->module)
                                    <div class="module-badge" style="color: {{ $task->module->color }}; border-left: 3px solid {{ $task->module->color }}">
                                        {{ $task->module->name }}
                                    </div>
                                @endif
                                
                                @if($task->image_path)
                                    <img src="{{ asset('storage/' . $task->image_path) }}" alt="{{ $task->title }}" class="task-image">
                                @endif
                                
                                <h3 class="h6 fw-bold mb-1" style="color: #1e1b4b;">{{ $task->title }}</h3>
                                <small class="text-muted mb-3 d-block">Deleted: {{ $task->deleted_at->format('M d, Y') }}</small>
                                
                                <div class="mt-auto d-flex gap-2">
                                    <form action="{{ route('tasks.restore', $task->id) }}" method="POST" class="flex-grow-1">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-sm btn-outline-primary w-100 fw-medium">Restore</button>
                                    </form>
                                    <form action="{{ route('tasks.forceDelete', $task->id) }}" method="POST" class="flex-grow-1">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger w-100 fw-medium" onclick="confirmForceDelete(event, this)">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="card-custom p-5 text-center">
                                <h3 class="h5 fw-bold mb-2" style="color: #4b5563;">Trash is Empty</h3>
                                <p class="mb-0 text-muted">No deleted tasks found.</p>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <!-- SweetAlert2 -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            function confirmForceDelete(event, button) {
                event.preventDefault();
                Swal.fire({
                    title: 'Permanently delete this task?',
                    text: "This action cannot be undone!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Yes, delete permanently!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        button.closest('form').submit();
                    }
                });
            }
        </script>
    </body>
</html>
