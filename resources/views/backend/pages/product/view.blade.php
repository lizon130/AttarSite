@extends('backend.layout.app')
@section('title', 'View Product | '.Helper::getSettings('application_name') ?? 'Machine Tool Solution')
@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mt-2">Product Details</h4>
            <div>
                <a href="{{ route('admin.product.edit', $product->id) }}" class="btn btn-primary">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <a href="{{ route('admin.product.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to List
                </a>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-eye me-1"></i>
                Product Information
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <table class="table table-bordered">
                            <tr>
                                <th width="30%">Product Name</th>
                                <td>{{ $product->ProductName }}</td>
                            </tr>
                            <tr>
                                <th>Category</th>
                                <td>{{ $product->category->categoryName ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Sub Category</th>
                                <td>{{ $product->subCategory->SubCategoryName ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Product Details</th>
                                <td>{{ $product->ProductDetails ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Price</th>
                                <td>{{ number_format($product->Price, 2) }}</td>
                            </tr>
                            <tr>
                                <th>Offer Price</th>
                                <td>
                                    @if($product->OfferPrice)
                                        {{ number_format($product->OfferPrice, 2) }}
                                        @if($product->Price > 0)
                                            @php
                                                $discount = round((($product->Price - $product->OfferPrice) / $product->Price) * 100, 2);
                                            @endphp
                                            <span class="badge bg-danger ms-2">{{ $discount }}% OFF</span>
                                        @endif
                                    @else
                                        <span class="text-muted">No offer</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Product Size/Variant</th>
                                <td>{{ $product->ProductSize ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    @if($product->status == 'active')
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Created Date</th>
                                <td>{{ date('d-m-Y h:i A', strtotime($product->created_at)) }}</td>
                            </tr>
                            <tr>
                                <th>Last Updated</th>
                                <td>{{ date('d-m-Y h:i A', strtotime($product->updated_at)) }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <i class="fas fa-chart-bar me-1"></i>
                                Quick Stats
                            </div>
                            <div class="card-body">
                                <div class="text-center mb-4">
                                    <div class="display-6 text-primary">{{ number_format($product->OfferPrice ?: $product->Price, 2) }}</div>
                                    <small class="text-muted">Current Selling Price</small>
                                </div>
                                
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span>Regular Price</span>
                                        <span>{{ number_format($product->Price, 2) }}</span>
                                    </div>
                                    <div class="progress" style="height: 8px;">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 100%"></div>
                                    </div>
                                </div>
                                
                                @if($product->OfferPrice)
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span>Offer Price</span>
                                        <span>{{ number_format($product->OfferPrice, 2) }}</span>
                                    </div>
                                    <div class="progress" style="height: 8px;">
                                        @php
                                            $percentage = ($product->OfferPrice / $product->Price) * 100;
                                        @endphp
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: {{ $percentage }}%"></div>
                                    </div>
                                </div>
                                
                                <div class="alert alert-warning">
                                    <div class="d-flex justify-content-between">
                                        <strong>You Save:</strong>
                                        <strong>{{ number_format($product->Price - $product->OfferPrice, 2) }}</strong>
                                    </div>
                                </div>
                                @endif
                                
                                <div class="d-grid gap-2">
                                    @if($product->status == 'active')
                                        <a href="{{ route('admin.product.status', $product->id) }}" class="btn btn-warning">
                                            <i class="fas fa-ban"></i> Deactivate Product
                                        </a>
                                    @else
                                        <a href="{{ route('admin.product.status', $product->id) }}" class="btn btn-success">
                                            <i class="fas fa-check"></i> Activate Product
                                        </a>
                                    @endif
                                    
                                    <a href="{{ route('admin.product.delete', $product->id) }}" 
                                       class="btn btn-danger" 
                                       onclick="return confirm('Are you sure you want to delete this product?')">
                                        <i class="fas fa-trash"></i> Delete Product
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-info text-white">
                                <i class="fas fa-history me-1"></i>
                                Product Management Actions
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <a href="{{ route('admin.product.edit', $product->id) }}" class="btn btn-outline-primary w-100 mb-2">
                                            <i class="fas fa-edit"></i> Edit Details
                                        </a>
                                    </div>
                                    <div class="col-md-3">
                                        <a href="{{ route('admin.subcategory.edit', $product->SubCategoryId) }}" class="btn btn-outline-info w-100 mb-2">
                                            <i class="fas fa-layer-group"></i> View Sub Category
                                        </a>
                                    </div>
                                    <div class="col-md-3">
                                        <a href="{{ route('admin.category.edit', $product->CategoryId) }}" class="btn btn-outline-success w-100 mb-2">
                                            <i class="fas fa-folder"></i> View Category
                                        </a>
                                    </div>
                                    <div class="col-md-3">
                                        <button onclick="window.history.back()" class="btn btn-outline-secondary w-100 mb-2">
                                            <i class="fas fa-arrow-left"></i> Go Back
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-images me-1"></i>
                Product Images
            </div>
            <div class="card-body">
                @if($product->images->count() > 0)
                    <div class="row">
                        @foreach($product->images as $image)
                            <div class="col-md-3 mb-3">
                                <div class="card">
                                    <img src="{{ asset('storage/' . $image->image_path) }}" 
                                         class="card-img-top" 
                                         alt="Product Image"
                                         style="height: 200px; object-fit: cover;">
                                    <div class="card-body text-center">
                                        @if($image->is_primary)
                                            <span class="badge bg-success">Primary Image</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted text-center">No images uploaded for this product.</p>
                @endif
            </div>
        </div>
    </div>
</div>
            </div>
        </div>
    </div>
@endsection