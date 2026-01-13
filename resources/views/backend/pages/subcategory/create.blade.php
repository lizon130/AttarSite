@extends('backend.layout.app')
@section('title', 'Create Sub Category | '.Helper::getSettings('application_name') ?? 'Machine Tool Solution')
@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mt-2">Create New Sub Category</h4>
            <a href="{{ route('admin.subcategory.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
        </div>

        <!-- Flash Messages -->
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-plus me-1"></i>
                Sub Category Details
            </div>
            <div class="card-body">
                <form action="{{ route('admin.subcategory.store') }}" method="POST" id="subCategoryForm">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="categoryId" class="form-label">Category <span class="text-danger">*</span></label>
                                <select class="form-select @error('categoryId') is-invalid @enderror" 
                                        id="categoryId" name="categoryId" required>
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('categoryId') == $category->id ? 'selected' : '' }}>
                                            {{ $category->categoryName }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('categoryId')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="SubCategoryName" class="form-label">Sub Category Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('SubCategoryName') is-invalid @enderror" 
                                       id="SubCategoryName" name="SubCategoryName" 
                                       value="{{ old('SubCategoryName') }}" 
                                       placeholder="Enter sub category name" required>
                                @error('SubCategoryName')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-select @error('status') is-invalid @enderror" 
                                        id="status" name="status" required>
                                    <option value="">Select Status</option>
                                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Create Sub Category
                            </button>
                            <a href="{{ route('admin.subcategory.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    @push('footer')
    <script>
        $(document).ready(function() {
            // Form validation
            $('#subCategoryForm').validate({
                rules: {
                    categoryId: {
                        required: true
                    },
                    SubCategoryName: {
                        required: true,
                        minlength: 2,
                        maxlength: 255
                    },
                    status: {
                        required: true
                    }
                },
                messages: {
                    categoryId: {
                        required: "Please select category"
                    },
                    SubCategoryName: {
                        required: "Please enter sub category name",
                        minlength: "Sub category name must be at least 2 characters",
                        maxlength: "Sub category name cannot exceed 255 characters"
                    },
                    status: {
                        required: "Please select status"
                    }
                },
                errorElement: 'span',
                errorPlacement: function (error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.mb-3').append(error);
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
    </script>
    @endpush
@endsection