@extends('backend.layout.app')
@section('title', 'Sub Categories | '.Helper::getSettings('application_name') ?? 'Machine Tool Solution')
@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mt-2">Sub Categories Management</h4>
            <a href="{{ route('admin.subcategory.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add New Sub Category
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
                    <div class="col-md-6">
                        <i class="fas fa-table me-1"></i>
                        Sub Categories List
                    </div>
                    <div class="col-md-6 text-end">
                        <div class="row">
                            <div class="col-md-8">
                                <select class="form-select form-select-sm" id="categoryFilter">
                                    <option value="">All Categories</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->categoryName }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <button type="button" id="resetFilter" class="btn btn-sm btn-secondary">Reset</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="subcategoriesTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Sub Category Name</th>
                                <th>Category</th>
                                <th>Products</th>
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
            var table = $('#subcategoriesTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.subcategory.getList') }}",
                    type: "POST",
                    data: function (d) {
                        d.category_id = $('#categoryFilter').val();
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'SubCategoryName', name: 'SubCategoryName' },
                    { data: 'category_name', name: 'category.categoryName' },
                    { data: 'products_count', name: 'products_count', orderable: false, searchable: false },
                    { data: 'status', name: 'status' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ],
                order: [[1, 'asc']],
                pageLength: 25,
                responsive: true,
                language: {
                    emptyTable: "No sub categories found",
                    info: "Showing _START_ to _END_ of _TOTAL_ sub categories",
                    infoEmpty: "Showing 0 to 0 of 0 sub categories",
                    infoFiltered: "(filtered from _MAX_ total sub categories)",
                    lengthMenu: "Show _MENU_ sub categories",
                    loadingRecords: "Loading...",
                    processing: "Processing...",
                    search: "Search:",
                    zeroRecords: "No matching sub categories found"
                }
            });

            // Category filter change
            $('#categoryFilter').change(function() {
                table.draw();
            });

            // Reset filter
            $('#resetFilter').click(function() {
                $('#categoryFilter').val('');
                table.draw();
            });
        });
    </script>
    @endpush
@endsection