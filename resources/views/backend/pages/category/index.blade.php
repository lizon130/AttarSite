@extends('backend.layout.app')
@section('title', 'Categories | '.Helper::getSettings('application_name') ?? 'Machine Tool Solution')
@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mt-2">Categories Management</h4>
            <a href="{{ route('admin.category.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add New Category
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
                <i class="fas fa-table me-1"></i>
                Categories List
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="categoriesTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Category Name</th>
                                <th>Sub Categories</th>
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
            $('#categoriesTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.category.getList') }}",
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'categoryName', name: 'categoryName' },
                    { data: 'subcategories_count', name: 'subcategories_count', orderable: false, searchable: false },
                    { data: 'products_count', name: 'products_count', orderable: false, searchable: false },
                    { data: 'status', name: 'status' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ],
                order: [[1, 'asc']],
                pageLength: 25,
                responsive: true,
                language: {
                    emptyTable: "No categories found",
                    info: "Showing _START_ to _END_ of _TOTAL_ categories",
                    infoEmpty: "Showing 0 to 0 of 0 categories",
                    infoFiltered: "(filtered from _MAX_ total categories)",
                    lengthMenu: "Show _MENU_ categories",
                    loadingRecords: "Loading...",
                    processing: "Processing...",
                    search: "Search:",
                    zeroRecords: "No matching categories found"
                }
            });
        });
    </script>
    @endpush
@endsection