<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Edit Module - Progress Tracking</title>
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
            
            .heading-gradient {
                background: linear-gradient(135deg, #ffffff 0%, #e0e7ff 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }
        </style>
    </head>
    <body class="antialiased">
        <div class="violet-gradient d-flex flex-column min-vh-100 position-relative">
            <div class="container py-5">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="card-custom p-5">
                            <div class="text-center mb-5">
                                <h1 class="display-5 fw-bold heading-gradient mb-3">Edit Module</h1>
                                <p class="mb-0" style="color: #4b5563;">Update module details</p>
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

                            <form action="{{ route('modules.update', $module) }}" method="POST">
                                @csrf
                                @method('PUT')
                                
                                <div class="mb-4">
                                    <label for="name" class="form-label">Module Name <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control @error('name') is-invalid @enderror" 
                                           id="name" 
                                           name="name" 
                                           value="{{ old('name', $module->name) }}" 
                                           placeholder="e.g., HR Module, Development, Marketing"
                                           required>
                                    @error('name')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="color" class="form-label">Color <span class="text-danger">*</span></label>
                                    <input type="color" 
                                           class="form-control form-control-color @error('color') is-invalid @enderror" 
                                           id="color" 
                                           name="color" 
                                           value="{{ old('color', $module->color) ?: '#8b5cf6' }}"
                                           style="height: 50px;"
                                           required>
                                    @error('color')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Choose a color for this module</small>
                                </div>

                                <div class="d-flex gap-3 justify-content-center mt-5">
                                    <a href="{{ route('modules.index') }}" class="btn-cancel">Cancel</a>
                                    <button type="submit" class="btn-submit">Update Module</button>
                                </div>
                            </form>
                        </div>

                        <div class="text-center mt-4">
                            <a href="{{ route('modules.index') }}" class="text-white text-decoration-none fw-medium" style="opacity: 0.85;">
                                ← Back to Modules
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
