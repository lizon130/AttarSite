@extends('backend.layout.app')
@section('title', 'Products | '.Helper::getSettings('application_name') ?? 'Machine Tool Solution')
@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mt-2">Products Management</h4>
            <a href="{{ route('admin.product.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add New Product
            </a>
        </div>

        <!-- Flash Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card mb-4">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-8">
                        <i class="fas fa-table me-1"></i>
                        Products List
                    </div>
                    <div class="col-md-4 text-end">
                        <div class="row g-2">
                            <div class="col-md-6">
                                <select class="form-select form-select-sm" id="categoryFilter">
                                    <option value="">All Categories</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->categoryName }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <button type="button" id="resetFilter" class="btn btn-sm btn-secondary w-100">Reset</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="productsTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Product Name</th>
                                <th>Category</th>
                                <th>Sub Category</th>
                                <th>Price</th>
                                <th>Offer Price</th>
                                <th>Discount</th>
                                <th>Status</th>
                                <th>Created Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- DataTable will load data here -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    @push('footer')
    <script>
        $(document).ready(function() {
            // Initialize DataTable
            var table = $('#productsTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.product.getList') }}",
                    type: "POST",
                    data: function (d) {
                        d.category_id = $('#categoryFilter').val();
                        d.subcategory_id = $('#subcategoryFilter').val();
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'thumbnail', name: 'thumbnail', orderable: false, searchable: false },
                    { data: 'ProductName', name: 'ProductName' },
                    { data: 'category_name', name: 'category.categoryName' },
                    { data: 'subcategory_name', name: 'subCategory.SubCategoryName' },
                    { data: 'Price', name: 'Price' },
                    { data: 'OfferPrice', name: 'OfferPrice' },
                    { data: 'discount', name: 'discount', orderable: false, searchable: false },
                    { data: 'status', name: 'status' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ],
                order: [[1, 'asc']],
                pageLength: 25,
                responsive: true,
                language: {
                    emptyTable: "No products found",
                    info: "Showing _START_ to _END_ of _TOTAL_ products",
                    infoEmpty: "Showing 0 to 0 of 0 products",
                    infoFiltered: "(filtered from _MAX_ total products)",
                    lengthMenu: "Show _MENU_ products",
                    loadingRecords: "Loading...",
                    processing: "Processing...",
                    search: "Search:",
                    zeroRecords: "No matching products found"
                }
            });

            // Category filter change
            $('#categoryFilter').change(function() {
                // Load subcategories for this category
                var categoryId = $(this).val();
                loadSubcategories(categoryId);
                table.draw();
            });

            // Reset filter
            $('#resetFilter').click(function() {
                $('#categoryFilter').val('');
                $('#subcategoryFilter').remove();
                table.draw();
            });

            // Load subcategories function
            function loadSubcategories(categoryId) {
                if (categoryId) {
                    $.ajax({
                        url: '{{ url("admin/product/get-subcategories") }}/' + categoryId,
                        type: 'GET',
                        success: function(response) {
                            if (response.success) {
                                // Remove existing subcategory filter if exists
                                $('#subcategoryFilter').remove();
                                
                                // Create subcategory filter
                                var html = '<select class="form-select form-select-sm" id="subcategoryFilter">';
                                html += '<option value="">All Sub Categories</option>';
                                $.each(response.data, function(key, value) {
                                    html += '<option value="' + value.id + '">' + value.SubCategoryName + '</option>';
                                });
                                html += '</select>';
                                
                                // Add after category filter
                                $('#categoryFilter').closest('.col-md-6').after('<div class="col-md-6" id="subcategoryContainer">' + html + '</div>');
                                
                                // Add change event for subcategory filter
                                $('#subcategoryFilter').change(function() {
                                    table.draw();
                                });
                            }
                        }
                    });
                } else {
                    $('#subcategoryFilter').remove();
                }
            }
        });

        // Image preview for new images
$('#images').change(function() {
    var preview = $('#imagePreview');
    preview.empty();
    
    if (this.files) {
        $.each(this.files, function(i, file) {
            var reader = new FileReader();
            
            reader.onload = function(e) {
                var html = '<div class="col-md-2">' +
                           '<div class="card">' +
                           '<img src="' + e.target.result + '" ' +
                           'class="card-img-top" ' +
                           'style="height: 100px; object-fit: cover;">' +
                           '<div class="card-body p-2 text-center">' +
                           '<span class="badge bg-secondary">New</span>' +
                           '</div></div></div>';
                
                preview.append(html);
            }
            
            reader.readAsDataURL(file);
        });
    }
});

// Delete existing image
$(document).on('click', '.delete-image', function() {
    var imageId = $(this).data('id');
    var imageItem = $(this).closest('.image-item');
    
    if (confirm('Are you sure you want to delete this image?')) {
        $.ajax({
            url: '{{ url("admin/product/delete-image") }}/' + imageId,
            type: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    imageItem.remove();
                    toastr.success(response.message);
                }
            }
        });
    }
});

// Set image as primary
$(document).on('click', '.set-primary', function() {
    var imageId = $(this).data('id');
    var button = $(this);
    
    $.ajax({
        url: '{{ url("admin/product/set-primary-image") }}/' + imageId,
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success) {
                // Update UI
                $('.badge.bg-success').removeClass('bg-success').addClass('bg-secondary');
                $('.badge.bg-secondary').text('Set Primary').removeClass('badge').addClass('btn btn-sm btn-outline-primary set-primary');
                
                button.replaceWith('<span class="badge bg-success mb-1">Primary</span>');
                toastr.success(response.message);
            }
        }
    });
});

// Make images sortable (for edit page only)
@if(isset($product) && $product->images->count() > 0)
$('#imagePreview').sortable({
    update: function(event, ui) {
        var order = [];
        $('#imagePreview .image-item').each(function(index) {
            order.push($(this).data('id'));
        });
        
        $.ajax({
            url: '{{ route("admin.product.update-image-order") }}',
            type: 'POST',
            data: { order: order },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    }
});
$('#imagePreview').disableSelection();
@endif
    </script>
    @endpush
@endsection