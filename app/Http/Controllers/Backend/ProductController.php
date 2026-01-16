<?php

namespace App\Http\Controllers\Backend;

use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::active()->get();
        return view('backend.pages.product.index', compact('categories'));
    }

    /**
     * Get products data for DataTable
     */
    public function getList(Request $request)
    {
        try {
            $products = Product::with(['category', 'subCategory', 'primaryImage'])->select('*');

            // Filter by category
            if ($request->has('category_id') && $request->category_id) {
                $products->where('CategoryId', $request->category_id);
            }

            // Filter by subcategory
            if ($request->has('subcategory_id') && $request->subcategory_id) {
                $products->where('SubCategoryId', $request->subcategory_id);
            }

            // Search functionality
            if ($request->has('search') && !empty($request->search['value'])) {
                $search = $request->search['value'];
                $products->where(function ($query) use ($search) {
                    $query->where('ProductName', 'like', '%' . $search . '%')
                        ->orWhere('ProductDetails', 'like', '%' . $search . '%')
                        ->orWhereHas('category', function ($q) use ($search) {
                            $q->where('categoryName', 'like', '%' . $search . '%');
                        })
                        ->orWhereHas('subCategory', function ($q) use ($search) {
                            $q->where('SubCategoryName', 'like', '%' . $search . '%');
                        });
                });
            }

            return DataTables::of($products)
                ->addIndexColumn()
                ->editColumn('category_name', function ($product) {
                    return $product->category->categoryName ?? 'N/A';
                })
                ->editColumn('subcategory_name', function ($product) {
                    return $product->subCategory->SubCategoryName ?? 'N/A';
                })
                ->editColumn('Price', function ($product) {
                    return '' . number_format($product->Price, 2);
                })
                ->editColumn('OfferPrice', function ($product) {
                    return $product->OfferPrice ? '' . number_format($product->OfferPrice, 2) : '-';
                })
                ->addColumn('discount', function ($product) {
                    if ($product->OfferPrice && $product->Price > 0) {
                        $discount = round((($product->Price - $product->OfferPrice) / $product->Price) * 100, 2);
                        return '<span class="badge bg-danger">' . $discount . '% OFF</span>';
                    }
                    return '-';
                })
                ->addColumn('thumbnail', function ($product) {
                    // Use model accessor which returns full URL or fallback
                    $url = $product->primaryImage->image_url ?? asset('images/default-product.png');
                    return '<img src="' . $url . '" style="height:40px;width:40px;object-fit:cover;border-radius:6px;" />';
                })
                ->editColumn('status', function ($product) {
                    $status = $product->status == 'active' ? 'success' : 'danger';
                    $text = $product->status == 'active' ? 'Active' : 'Inactive';
                    return '<span class="badge bg-' . $status . '">' . $text . '</span>';
                })
                ->editColumn('created_at', function ($product) {
                    return date('d-m-Y', strtotime($product->created_at));
                })
                ->addColumn('action', function ($product) {
                    $actions = '<div class="btn-group">';
                    $actions .= '<a href="' . route('admin.product.view', $product->id) . '" class="btn btn-sm btn-info" title="View"><i class="fas fa-eye"></i></a>';
                    $actions .= '<a href="' . route('admin.product.edit', $product->id) . '" class="btn btn-sm btn-primary" title="Edit"><i class="fas fa-edit"></i></a>';

                    // Status toggle button
                    if ($product->status == 'active') {
                        $actions .= '<a href="' . route('admin.product.status', $product->id) . '" class="btn btn-sm btn-warning" title="Deactivate"><i class="fas fa-ban"></i></a>';
                    } else {
                        $actions .= '<a href="' . route('admin.product.status', $product->id) . '" class="btn btn-sm btn-success" title="Activate"><i class="fas fa-check"></i></a>';
                    }

                    // Delete button
                    $actions .= '<a href="' . route('admin.product.delete', $product->id) . '" class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure?\')" title="Delete"><i class="fas fa-trash"></i></a>';

                    $actions .= '</div>';
                    return $actions;
                })
                ->rawColumns(['discount', 'status', 'action', 'thumbnail'])
                ->make(true);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::active()->get();
        // $subcategories = SubCategory::where('categoryId', $categories->first()->id)->active()->get();
        $subcategories = SubCategory::active()->get();


        // dd($subcategories);

        return view('backend.pages.product.create', compact('categories', 'subcategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'CategoryId' => 'required|exists:categories,id',
            'SubCategoryId' => 'required|exists:sub_categories,id',
            'ProductName' => 'required|string|max:255',
            'ProductDetails' => 'nullable|string',
            'Price' => 'required|numeric|min:0',
            'OfferPrice' => 'nullable|numeric|min:0|lt:Price',
            'ProductSize' => 'nullable|string|max:100',
            'status' => 'required|in:active,inactive',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ], [
            'OfferPrice.lt' => 'Offer price must be less than regular price.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Please fix the errors below.');
        }

        try {
            DB::beginTransaction();

            $product = Product::create([
                'CategoryId' => $request->CategoryId,
                'SubCategoryId' => $request->SubCategoryId,
                'ProductName' => $request->ProductName,
                'ProductDetails' => $request->ProductDetails,
                'Price' => $request->Price,
                'OfferPrice' => $request->OfferPrice,
                'ProductSize' => $request->ProductSize,
                'status' => $request->status,
            ]);

            // 2️⃣ Then save images
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $index => $image) {
                    $path = $image->store('products', 'public');

                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $path,
                        'is_primary' => $index === 0,
                        'sort_order' => $index
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('admin.product.index')
                ->with('success', 'Product created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error creating product: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function view($id)
    {
        $product = Product::with(['category', 'subCategory'])->findOrFail($id);
        return view('backend.pages.product.view', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $product = Product::with(['category', 'subCategory'])->findOrFail($id);
        $categories = Category::active()->get();
        $subcategories = SubCategory::where('categoryId', $product->CategoryId)->active()->get();

        return view('backend.pages.product.edit', compact('product', 'categories', 'subcategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'CategoryId' => 'required|exists:categories,id',
            'SubCategoryId' => 'required|exists:sub_categories,id',
            'ProductName' => 'required|string|max:255',
            'ProductDetails' => 'nullable|string',
            'Price' => 'required|numeric|min:0',
            'OfferPrice' => 'nullable|numeric|min:0|lt:Price',
            'ProductSize' => 'nullable|string|max:100',
            'status' => 'required|in:active,inactive',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ], [
            'OfferPrice.lt' => 'Offer price must be less than regular price.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Please fix the errors below.');
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('products', 'public');

                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                    'sort_order' => $product->images()->count() + $index
                ]);
            }
        }

        try {
            DB::beginTransaction();

            $product->update([
                'CategoryId' => $request->CategoryId,
                'SubCategoryId' => $request->SubCategoryId,
                'ProductName' => $request->ProductName,
                'ProductDetails' => $request->ProductDetails,
                'Price' => $request->Price,
                'OfferPrice' => $request->OfferPrice,
                'ProductSize' => $request->ProductSize,
                'status' => $request->status,
            ]);

            DB::commit();

            return redirect()->route('admin.product.index')
                ->with('success', 'Product updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error updating product: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        $product = Product::findOrFail($id);

        try {
            DB::beginTransaction();

            $product->delete();

            DB::commit();

            return redirect()->route('admin.product.index')
                ->with('success', 'Product deleted successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.product.index')
                ->with('error', 'Error deleting product: ' . $e->getMessage());
        }
    }

    /**
     * Toggle status of the specified resource.
     */
    public function toggleStatus($id)
    {
        $product = Product::findOrFail($id);

        try {
            DB::beginTransaction();

            $product->status = $product->status == 'active' ? 'inactive' : 'active';
            $product->save();

            DB::commit();

            $status = $product->status == 'active' ? 'activated' : 'deactivated';
            return redirect()->route('admin.product.index')
                ->with('success', 'Product ' . $status . ' successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.product.index')
                ->with('error', 'Error updating status: ' . $e->getMessage());
        }
    }

    /**
     * Get subcategories by category ID (for AJAX)
     */
    public function getSubcategories($categoryId)
    {
        try {
            $subcategories = SubCategory::where('categoryId', $categoryId)
                ->where('status', 'active')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $subcategories
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete product image
     */
    public function deleteImage($id)
    {
        try {
            $image = ProductImage::findOrFail($id);

            // Delete file from storage
            Storage::disk('public')->delete($image->image_path);

            $image->delete();

            return response()->json([
                'success' => true,
                'message' => 'Image deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Set image as primary
     */
    public function setPrimaryImage($id)
    {
        try {
            $image = ProductImage::findOrFail($id);

            // Remove primary from all images of this product
            ProductImage::where('product_id', $image->product_id)
                ->update(['is_primary' => false]);

            // Set this image as primary
            $image->is_primary = true;
            $image->save();

            return response()->json([
                'success' => true,
                'message' => 'Primary image set successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update image order
     */
    public function updateImageOrder(Request $request)
    {
        try {
            foreach ($request->order as $order => $id) {
                ProductImage::where('id', $id)->update(['sort_order' => $order]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Image order updated'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}