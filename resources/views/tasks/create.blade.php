<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Create Task - Progress Tracking</title>
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
            }
            
            .form-control, .form-control:focus {
                border-radius: 0.75rem;
                border: 2px solid #e5e7eb;
                padding: 0.875rem 1rem;
                transition: all 0.2s ease;
            }
            
            .form-control:focus {
                border-color: #8b5cf6;
                box-shadow: 0 0 0 4px rgba(139, 92, 246, 0.1);
            }
            
            .form-label {
                font-weight: 600;
                color: #1e1b4b;
                margin-bottom: 0.5rem;
            }
            
            .btn-submit {
                background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
                color: white;
                font-weight: 700;
                padding: 0.875rem 2.5rem;
                border-radius: 2rem;
                border: none;
                box-shadow: 0 10px 25px -5px rgba(99, 102, 241, 0.4);
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }
            
            .btn-submit:hover {
                transform: translateY(-2px);
                box-shadow: 0 20px 35px -5px rgba(99, 102, 241, 0.5);
                color: white;
            }
            
            .btn-cancel {
                background: rgba(255, 255, 255, 0.3);
                color: #4c1d95;
                font-weight: 600;
                padding: 0.875rem 2.5rem;
                border-radius: 2rem;
                border: 2px solid rgba(255, 255, 255, 0.5);
                transition: all 0.3s ease;
                text-decoration: none;
            }
            
            .btn-cancel:hover {
                background: rgba(255, 255, 255, 0.5);
                color: #4c1d95;
            }
            
            .image-upload-area {
                border: 3px dashed #c4b5fd;
                border-radius: 1rem;
                padding: 3rem;
                text-align: center;
                transition: all 0.3s ease;
                background: rgba(255, 255, 255, 0.5);
                cursor: pointer;
            }
            
            .image-upload-area:hover {
                border-color: #8b5cf6;
                background: rgba(255, 255, 255, 0.7);
            }
            
            .image-upload-area input[type="file"] {
                display: none;
            }
            
            .heading-gradient {
                background: linear-gradient(135deg, #ffffff 0%, #e0e7ff 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }
            
            .alert-custom {
                background: rgba(255, 255, 255, 0.9);
                backdrop-filter: blur(10px);
                border-radius: 1rem;
                border: 1px solid rgba(255, 255, 255, 0.5);
            }
        </style>
    </head>
    <body class="antialiased">
        <div class="violet-gradient d-flex flex-column min-vh-100 position-relative">
            <div class="container py-5">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="card-custom p-5">
                            <div class="text-center mb-5">
                                <h1 class="display-5 fw-bold text-dark mb-3">Create New Task</h1>
                                <p class="mb-0" style="color: #2065c5ff;">Add a new task to track your progress</p>
                            </div>

                            @if($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>Error:</strong> Please fix the following errors.
                                    <ul class="mb-0 mt-2">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            <form action="{{ route('tasks.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                
                                <div class="mb-4">
                                    <label for="module_id" class="form-label">Module <span class="text-danger">*</span></label>
                                    <select class="form-select @error('module_id') is-invalid @enderror" 
                                            id="module_id" 
                                            name="module_id" 
                                            required>
                                        <option value="">Select a module</option>
                                        @foreach($modules as $module)
                                            <option value="{{ $module->id }}" {{ (old('module_id') ?? request('module_id')) == $module->id ? 'selected' : '' }}>
                                                {{ $module->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('module_id')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="title" class="form-label">Task Title <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control @error('title') is-invalid @enderror" 
                                           id="title" 
                                           name="title" 
                                           value="{{ old('title') }}" 
                                           placeholder="Enter task title"
                                           required>
                                    @error('title')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="description" 
                                              name="description" 
                                              rows="4" 
                                              placeholder="Enter task description (optional)">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                    <select class="form-select @error('status') is-invalid @enderror" 
                                            id="status" 
                                            name="status" 
                                            required>
                                        <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                        <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-5">
                                    <label class="form-label">Task Image</label>
                                    <div class="image-upload-area" onclick="document.getElementById('image').click()">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#8b5cf6" class="mx-auto mb-3" style="width: 64px; height: 64px;">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                        </svg>
                                        <p class="mb-0 fw-semibold" style="color: #6b7280;">Click to upload an image</p>
                                        <p class="mb-0 small text-muted">PNG, JPG, GIF up to 2MB</p>
                                        <input type="file" 
                                               class="form-control @error('image') is-invalid @enderror" 
                                               id="image" 
                                               name="image" 
                                               accept="image/*"
                                               onchange="previewImage(this)">
                                    </div>
                                    @error('image')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                    
                                    <div id="imagePreview" class="mt-3" style="display: none;">
                                        <img id="previewImg" src="" alt="Preview" style="max-width: 100%; max-height: 300px; border-radius: 1rem; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
                                    </div>
                                </div>

                                <div class="d-flex gap-3 justify-content-center">
                                    <a href="{{ route('tasks.index') }}" class="btn-cancel">Cancel</a>
                                    <button type="submit" class="btn-submit">Create Task</button>
                                </div>
                            </form>
                        </div>

                        <div class="text-center mt-4">
                            <a href="{{ url('/') }}" class="text-white text-decoration-none fw-medium" style="opacity: 0.85;">
                                ← Back to Home
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <script>
            function previewImage(input) {
                const preview = document.getElementById('imagePreview');
                const img = document.getElementById('previewImg');
                
                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    
                    reader.onload = function(e) {
                        img.src = e.target.result;
                        preview.style.display = 'block';
                    }
                    
                    reader.readAsDataURL(input.files[0]);
                } else {
                    preview.style.display = 'none';
                }
            }
        </script>
        
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
