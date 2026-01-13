<?php

namespace App\Http\Controllers\Backend;

use App\Models\Category;
use App\Models\SubCategory;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::active()->get();
        return view('backend.pages.subcategory.index', compact('categories'));
    }

    /**
     * Get subcategories data for DataTable
     */
    public function getList(Request $request)
    {
        try {
            $subcategories = SubCategory::with('category')->select('*');

            // Filter by category
            if ($request->has('category_id') && $request->category_id) {
                $subcategories->where('categoryId', $request->category_id);
            }

            return DataTables::of($subcategories)
                ->addIndexColumn()
                ->editColumn('category_name', function($subcategory) {
                    return $subcategory->category->categoryName ?? 'N/A';
                })
                ->editColumn('status', function($subcategory) {
                    $status = $subcategory->status == 'active' ? 'success' : 'danger';
                    $text = $subcategory->status == 'active' ? 'Active' : 'Inactive';
                    return '<span class="badge bg-' . $status . '">' . $text . '</span>';
                })
                ->addColumn('products_count', function($subcategory) {
                    return '<span class="badge bg-primary">' . $subcategory->products()->count() . '</span>';
                })
                ->editColumn('created_at', function($subcategory) {
                    return date('d-m-Y', strtotime($subcategory->created_at));
                })
                ->addColumn('action', function($subcategory) {
                    $actions = '<div class="btn-group">';
                    $actions .= '<a href="' . route('admin.subcategory.edit', $subcategory->id) . '" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>';
                    
                    // Status toggle button
                    if ($subcategory->status == 'active') {
                        $actions .= '<a href="' . route('admin.subcategory.status', $subcategory->id) . '" class="btn btn-sm btn-warning" title="Deactivate"><i class="fas fa-ban"></i></a>';
                    } else {
                        $actions .= '<a href="' . route('admin.subcategory.status', $subcategory->id) . '" class="btn btn-sm btn-success" title="Activate"><i class="fas fa-check"></i></a>';
                    }
                    
                    // Delete button
                    if ($subcategory->products()->count() == 0) {
                        $actions .= '<a href="' . route('admin.subcategory.delete', $subcategory->id) . '" class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure?\')"><i class="fas fa-trash"></i></a>';
                    } else {
                        $actions .= '<button class="btn btn-sm btn-danger" disabled title="Cannot delete - has products"><i class="fas fa-trash"></i></button>';
                    }
                    
                    $actions .= '</div>';
                    return $actions;
                })
                ->rawColumns(['status', 'products_count', 'action'])
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
        $subcategories = SubCategory::active()->get();  
        return view('backend.pages.subcategory.create', compact('categories', 'subcategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'categoryId' => 'required|exists:categories,id',
            'SubCategoryName' => 'required|string|max:255|unique:sub_categories,SubCategoryName',
            'status' => 'required|in:active,inactive',
        ]);

       

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Please fix the errors below.');
        }

        try {
            DB::beginTransaction();
            
            SubCategory::create([
                'categoryId' => $request->categoryId,
                'SubCategoryName' => $request->SubCategoryName,
                'status' => $request->status,
            ]);

            DB::commit();
            
            return redirect()->route('admin.subcategory.index')
                ->with('success', 'Sub Category created successfully!');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error creating sub category: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $subcategory = SubCategory::findOrFail($id);
        $categories = Category::active()->get();
        return view('backend.subcategory.edit', compact('subcategory', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $subcategory = SubCategory::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'categoryId' => 'required|exists:categories,id',
            'SubCategoryName' => 'required|string|max:255|unique:sub_categories,SubCategoryName,' . $id,
            'status' => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Please fix the errors below.');
        }

        try {
            DB::beginTransaction();
            
            $subcategory->update([
                'categoryId' => $request->categoryId,
                'SubCategoryName' => $request->SubCategoryName,
                'status' => $request->status,
            ]);

            DB::commit();
            
            return redirect()->route('admin.subcategory.index')
                ->with('success', 'Sub Category updated successfully!');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error updating sub category: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        $subcategory = SubCategory::findOrFail($id);
        
        try {
            DB::beginTransaction();
            
            // Check if subcategory has products
            if ($subcategory->products()->count() > 0) {
                return redirect()->route('admin.subcategory.index')
                    ->with('error', 'Cannot delete subcategory. It has ' . $subcategory->products()->count() . ' products.');
            }

            $subcategory->delete();
            
            DB::commit();
            
            return redirect()->route('admin.subcategory.index')
                ->with('success', 'Sub Category deleted successfully!');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.subcategory.index')
                ->with('error', 'Error deleting sub category: ' . $e->getMessage());
        }
    }

    /**
     * Toggle status of the specified resource.
     */
    public function toggleStatus($id)
    {
        $subcategory = SubCategory::findOrFail($id);
        
        try {
            DB::beginTransaction();
            
            $subcategory->status = $subcategory->status == 'active' ? 'inactive' : 'active';
            $subcategory->save();
            
            DB::commit();
            
            $status = $subcategory->status == 'active' ? 'activated' : 'deactivated';
            return redirect()->route('admin.subcategory.index')
                ->with('success', 'Sub Category ' . $status . ' successfully!');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.subcategory.index')
                ->with('error', 'Error updating status: ' . $e->getMessage());
        }
    }

    /**
     * Get subcategories by category ID (for AJAX)
     */
    public function getByCategory($categoryId)
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
}