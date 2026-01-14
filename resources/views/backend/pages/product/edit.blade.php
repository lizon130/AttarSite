@extends('backend.layout.app')
@section('title', 'Edit Product | '.Helper::getSettings('application_name') ?? 'Machine Tool Solution')
@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mt-2">Edit Product</h4>
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
                <i class="fas fa-edit me-1"></i>
                Edit Product Details
            </div>
            <div class="card-body">
                <form action="{{ route('admin.product.update', $product->id) }}" method="POST" id="productForm" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="CategoryId" class="form-label">Category <span class="text-danger">*</span></label>
                                <select class="form-select @error('CategoryId') is-invalid @enderror" 
                                        id="CategoryId" name="CategoryId" required>
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" 
                                            {{ old('CategoryId', $product->CategoryId) == $category->id ? 'selected' : '' }}>
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
                                    <option value="">Select Category First</option>
                                    @foreach($subcategories as $subcategory)
                                        <option value="{{ $subcategory->id }}" 
                                            {{ old('SubCategoryId', $product->SubCategoryId) == $subcategory->id ? 'selected' : '' }}>
                                            {{ $subcategory->SubCategoryName }}
                                        </option>
                                    @endforeach
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
                                       value="{{ old('ProductName', $product->ProductName) }}" 
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
                                          rows="3" placeholder="Enter product description">{{ old('ProductDetails', $product->ProductDetails) }}</textarea>
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
                                       value="{{ old('Price', $product->Price) }}" 
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
                                       value="{{ old('OfferPrice', $product->OfferPrice) }}" 
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
                                       value="{{ old('ProductSize', $product->ProductSize) }}" 
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
                                    <option value="active" {{ old('status', $product->status) == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('status', $product->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
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
                                <i class="fas fa-save"></i> Update Product
                            </button>
                            <a href="{{ route('admin.product.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </div>
                </form>
                
                <!-- Product Stats -->
                <hr class="my-4">
                <div class="row">
                    <div class="col-md-3">
                        <div class="card bg-light">
                            <div class="card-body text-center">
                                <h5 class="card-title">Category</h5>
                                <h6 class="text-muted">{{ $product->category->categoryName ?? 'N/A' }}</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-light">
                            <div class="card-body text-center">
                                <h5 class="card-title">Sub Category</h5>
                                <h6 class="text-muted">{{ $product->subCategory->SubCategoryName ?? 'N/A' }}</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-light">
                            <div class="card-body text-center">
                                <h5 class="card-title">Discount</h5>
                                @if($product->OfferPrice && $product->Price > 0)
                                    @php
                                        $discount = round((($product->Price - $product->OfferPrice) / $product->Price) * 100, 2);
                                    @endphp
                                    <h4 class="text-danger">{{ $discount }}% OFF</h4>
                                @else
                                    <h6 class="text-muted">No Discount</h6>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-light">
                            <div class="card-body text-center">
                                <h5 class="card-title">Created On</h5>
                                <h6 class="text-muted">{{ date('d-m-Y', strtotime($product->created_at)) }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @push('footer')
    <script>
        $(document).ready(function() {
            // Dynamic subcategory loading
            $('#CategoryId').change(function() {
                var categoryId = $(this).val();
                var subcategorySelect = $('#SubCategoryId');
                
                if (categoryId) {
                    $.ajax({
                        url: '{{ url("admin/admin/product/get-subcategories") }}/' + categoryId,
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
                            
                            // Select current subcategory
                            var currentSubCategoryId = '{{ $product->SubCategoryId }}';
                            if (currentSubCategoryId) {
                                subcategorySelect.val(currentSubCategoryId);
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

            // Trigger change on page load
            $('#CategoryId').trigger('change');

            // Image preview for newly selected files (client-side only)
            $('#images').change(function() {
                var preview = $('#imagePreview');

                if (this.files) {
                    $.each(this.files, function(i, file) {
                        var reader = new FileReader();

                        reader.onload = function(e) {
                            var html = '<div class="col-md-2 image-item new-item">' +
                                       '<div class="card">' +
                                       '<img src="' + e.target.result + '" ' +
                                       'class="card-img-top" ' +
                                       'style="height: 100px; object-fit: cover;">' +
                                       '<div class="card-body p-2 text-center">' +
                                       '<span class="badge bg-secondary">New</span>' +
                                       ' <button type="button" class="btn btn-sm btn-outline-danger remove-new-image"><i class="fas fa-trash"></i></button>' +
                                       '</div></div></div>';

                            preview.append(html);
                        }

                        reader.readAsDataURL(file);
                    });
                }
            });

            // Remove preview-only new image
            $(document).on('click', '.remove-new-image', function() {
                $(this).closest('.image-item').remove();
            });

            // Delete existing image
            $(document).on('click', '.delete-image', function() {
                var imageId = $(this).data('id');
                var imageItem = $(this).closest('.image-item');

                if (confirm('Are you sure you want to delete this image?')) {
                    $.ajax({
                        url: '{{ url("admin/admin/product/delete-image") }}/' + imageId,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.success) {
                                imageItem.remove();
                                toastr.success(response.message);
                            } else {
                                toastr.error(response.message || 'Error deleting image');
                            }
                        },
                        error: function() {
                            toastr.error('Error deleting image');
                        }
                    });
                }
            });

            // Set image as primary
            $(document).on('click', '.set-primary', function() {
                var imageId = $(this).data('id');
                var button = $(this);

                $.ajax({
                    url: '{{ url("admin/admin/product/set-primary-image") }}/' + imageId,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            // Convert any existing primary badge back to a Set Primary button
                            $('#imagePreview .image-item').each(function() {
                                var id = $(this).data('id');
                                if ($(this).find('.badge.bg-success').length) {
                                    $(this).find('.badge.bg-success').replaceWith('<button type="button" class="btn btn-sm btn-outline-primary mb-1 set-primary" data-id="' + id + '">Set Primary</button>');
                                }
                            });

                            // Show primary badge for selected image
                            button.replaceWith('<span class="badge bg-success mb-1">Primary</span>');
                            toastr.success(response.message);
                        } else {
                            toastr.error(response.message || 'Error setting primary');
                        }
                    },
                    error: function() {
                        toastr.error('Error setting primary');
                    }
                });
            });

            // Make images sortable and persist order
            if ($('#imagePreview .image-item').length > 0) {
                $('#imagePreview').sortable({
                    update: function(event, ui) {
                        var order = [];
                        $('#imagePreview .image-item').each(function(index) {
                            var id = $(this).data('id');
                            if (id) order.push(id);
                        });

                        $.ajax({
                            url: '{{ route("admin.product.update-image-order") }}',
                            type: 'POST',
                            data: { order: order },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                if (response.success) toastr.success(response.message || 'Image order updated');
                            },
                            error: function() {
                                toastr.error('Error updating image order');
                            }
                        });
                    }
                });

                $('#imagePreview').disableSelection();
            }
        });
    </script>
    @endpush
@endsection