@extends('backend.layout.app')
@section('title', 'Create Product | '.Helper::getSettings('application_name') ?? 'Machine Tool Solution')
@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mt-2">Create New Product</h4>
            <a href="{{ route('admin.product.index') }}" class="btn btn-secondary">
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
                Product Details
            </div>
            <div class="card-body">
                <form action="{{ route('admin.product.store') }}" method="POST" id="productForm" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="CategoryId" class="form-label">Category <span class="text-danger">*</span></label>
                                <select class="form-select @error('CategoryId') is-invalid @enderror" 
                                        id="CategoryId" name="CategoryId" required>
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('CategoryId') == $category->id ? 'selected' : '' }}>
                                            {{ $category->categoryName }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('CategoryId')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="SubCategoryId" class="form-label">Sub Category <span class="text-danger">*</span></label>
                                <select class="form-select @error('SubCategoryId') is-invalid @enderror" 
                                        id="SubCategoryId" name="SubCategoryId" required>
                                    <option value="">Select Sub Category</option>
                                    @if(isset($subcategories) && $subcategories->count())
                                        @foreach($subcategories as $subcategory)
                                            <option value="{{ $subcategory->id }}" {{ old('SubCategoryId') == $subcategory->id ? 'selected' : '' }}>
                                                {{ $subcategory->SubCategoryName }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('SubCategoryId')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="ProductName" class="form-label">Product Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('ProductName') is-invalid @enderror" 
                                       id="ProductName" name="ProductName" 
                                       value="{{ old('ProductName') }}" 
                                       placeholder="Enter product name" required>
                                @error('ProductName')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="ProductDetails" class="form-label">Product Details</label>
                                <textarea class="form-control @error('ProductDetails') is-invalid @enderror" 
                                          id="ProductDetails" name="ProductDetails" 
                                          rows="3" placeholder="Enter product description">{{ old('ProductDetails') }}</textarea>
                                @error('ProductDetails')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
    <div class="col-md-12">
        <div class="mb-3">
            <label for="images" class="form-label">Product Images</label>
            <input type="file" class="form-control @error('images') is-invalid @enderror" 
                   id="images" name="images[]" multiple 
                   accept="image/*">
            @error('images')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="text-muted">You can select multiple images. First image will be set as primary.</small>
            
            <!-- Image preview container -->
            <div id="imagePreview" class="mt-3 row g-2">
                @if(isset($product) && $product->images->count() > 0)
                    @foreach($product->images as $image)
                        <div class="col-md-2 image-item" data-id="{{ $image->id }}">
                            <div class="card">
                                <img src="{{ asset('storage/' . $image->image_path) }}" 
                                     class="card-img-top" 
                                     alt="Product Image"
                                     style="height: 100px; object-fit: cover;">
                                <div class="card-body p-2 text-center">
                                    @if($image->is_primary)
                                        <span class="badge bg-success mb-1">Primary</span>
                                    @else
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-primary mb-1 set-primary" 
                                                data-id="{{ $image->id }}">
                                            Set Primary
                                        </button>
                                    @endif
                                    <button type="button" 
                                            class="btn btn-sm btn-outline-danger delete-image" 
                                            data-id="{{ $image->id }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="Price" class="form-label">Price <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" min="0" 
                                       class="form-control @error('Price') is-invalid @enderror" 
                                       id="Price" name="Price" 
                                       value="{{ old('Price') }}" 
                                       placeholder="0.00" required>
                                @error('Price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="OfferPrice" class="form-label">Offer Price</label>
                                <input type="number" step="0.01" min="0" 
                                       class="form-control @error('OfferPrice') is-invalid @enderror" 
                                       id="OfferPrice" name="OfferPrice" 
                                       value="{{ old('OfferPrice') }}" 
                                       placeholder="0.00">
                                @error('OfferPrice')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Leave empty if no offer</small>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="ProductSize" class="form-label">Product Size/Variant</label>
                                <input type="text" class="form-control @error('ProductSize') is-invalid @enderror" 
                                       id="ProductSize" name="ProductSize" 
                                       value="{{ old('ProductSize') }}" 
                                       placeholder="e.g., 12ml, One Size, 70x110cm">
                                @error('ProductSize')
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
                                <i class="fas fa-save"></i> Create Product
                            </button>
                            <a href="{{ route('admin.product.index') }}" class="btn btn-secondary">
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
            $('#productForm').validate({
                rules: {
                    CategoryId: {
                        required: true
                    },
                    SubCategoryId: {
                        required: true
                    },
                    ProductName: {
                        required: true,
                        minlength: 2,
                        maxlength: 255
                    },
                    Price: {
                        required: true,
                        number: true,
                        min: 0
                    },
                    OfferPrice: {
                        number: true,
                        min: 0,
                        lessThan: '#Price'
                    },
                    ProductSize: {
                        maxlength: 100
                    },
                    status: {
                        required: true
                    }
                },
                messages: {
                    CategoryId: {
                        required: "Please select category"
                    },
                    SubCategoryId: {
                        required: "Please select sub category"
                    },
                    ProductName: {
                        required: "Please enter product name",
                        minlength: "Product name must be at least 2 characters",
                        maxlength: "Product name cannot exceed 255 characters"
                    },
                    Price: {
                        required: "Please enter price",
                        number: "Please enter a valid number",
                        min: "Price cannot be negative"
                    },
                    OfferPrice: {
                        number: "Please enter a valid number",
                        min: "Offer price cannot be negative",
                        lessThan: "Offer price must be less than regular price"
                    },
                    ProductSize: {
                        maxlength: "Size cannot exceed 100 characters"
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

            // Custom validation method for offer price
            $.validator.addMethod("lessThan", function(value, element, param) {
                if (value === "") return true; // Allow empty
                var price = $(param).val();
                return parseFloat(value) < parseFloat(price);
            }, "Offer price must be less than regular price");

            // Dynamic subcategory loading
            $('#CategoryId').change(function() {
                var categoryId = $(this).val();
                var subcategorySelect = $('#SubCategoryId');
                
                if (categoryId) {
                    $.ajax({
                        url: '{{ url("admin/product/get-subcategories") }}/' + categoryId,
                        type: 'GET',
                        dataType: 'json',
                        beforeSend: function() {
                            subcategorySelect.prop('disabled', true);
                            subcategorySelect.html('<option value="">Loading...</option>');
                        },
                        success: function(response) {
                            subcategorySelect.prop('disabled', false);
                            subcategorySelect.html('<option value="">Select Sub Category</option>');
                            
                            if (response.success && response.data.length > 0) {
                                $.each(response.data, function(key, value) {
                                    subcategorySelect.append('<option value="' + value.id + '">' + value.SubCategoryName + '</option>');
                                });
                            } else {
                                subcategorySelect.append('<option value="">No sub categories found</option>');
                            }
                            
                            // Select old value if exists
                            var oldSubCategoryId = '{{ old("SubCategoryId") }}';
                            if (oldSubCategoryId) {
                                subcategorySelect.val(oldSubCategoryId);
                            }
                        },
                        error: function() {
                            subcategorySelect.prop('disabled', false);
                            subcategorySelect.html('<option value="">Error loading subcategories</option>');
                        }
                    });
                } else {
                    subcategorySelect.prop('disabled', true);
                    subcategorySelect.html('<option value="">Select Category First</option>');
                }
            });

            // Trigger change on page load if category is already selected
            var oldCategoryId = '{{ old("CategoryId") }}';
            if (oldCategoryId) {
                $('#CategoryId').val(oldCategoryId).trigger('change');
            }
        });
    </script>
    @endpush
@endsection