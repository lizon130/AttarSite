<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('backend.pages.category.index');
    }

    /**
     * Get categories data for DataTable
     */
    public function getList(Request $request)
    {
        try {
            $categories = Category::select('*');

            return DataTables::of($categories)
                ->addIndexColumn()
                ->editColumn('status', function($category) {
                    $status = $category->status == 'active' ? 'success' : 'danger';
                    $text = $category->status == 'active' ? 'Active' : 'Inactive';
                    return '<span class="badge bg-' . $status . '">' . $text . '</span>';
                })
                ->addColumn('subcategories_count', function($category) {
                    return '<span class="badge bg-info">' . $category->subCategories()->count() . '</span>';
                })
                ->addColumn('products_count', function($category) {
                    return '<span class="badge bg-primary">' . $category->products()->count() . '</span>';
                })
                ->editColumn('created_at', function($category) {
                    return date('d-m-Y', strtotime($category->created_at));
                })
                ->addColumn('action', function($category) {
                    $actions = '<div class="btn-group">';
                    $actions .= '<a href="' . route('admin.category.edit', $category->id) . '" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>';
                    
                    // Status toggle button
                    if ($category->status == 'active') {
                        $actions .= '<a href="' . route('admin.category.status', $category->id) . '" class="btn btn-sm btn-warning" title="Deactivate"><i class="fas fa-ban"></i></a>';
                    } else {
                        $actions .= '<a href="' . route('admin.category.status', $category->id) . '" class="btn btn-sm btn-success" title="Activate"><i class="fas fa-check"></i></a>';
                    }
                    
                    // Delete button
                    if ($category->subCategories()->count() == 0 && $category->products()->count() == 0) {
                        $actions .= '<a href="' . route('admin.category.delete', $category->id) . '" class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure?\')"><i class="fas fa-trash"></i></a>';
                    } else {
                        $actions .= '<button class="btn btn-sm btn-danger" disabled title="Cannot delete - has related data"><i class="fas fa-trash"></i></button>';
                    }
                    
                    $actions .= '</div>';
                    return $actions;
                })
                ->rawColumns(['status', 'subcategories_count', 'products_count', 'action'])
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
        return view('backend.pages.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'categoryName' => 'required|string|max:255|unique:categories,categoryName',
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
            
            Category::create([
                'categoryName' => $request->categoryName,
                'status' => $request->status,
            ]);

            DB::commit();
            
            return redirect()->route('admin.category.index')
                ->with('success', 'Category created successfully!');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error creating category: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('backend.pages.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'categoryName' => 'required|string|max:255|unique:categories,categoryName,' . $id,
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
            
            $category->update([
                'categoryName' => $request->categoryName,
                'status' => $request->status,
            ]);

            DB::commit();
            
            return redirect()->route('admin.category.index')
                ->with('success', 'Category updated successfully!');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error updating category: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        $category = Category::findOrFail($id);
        
        try {
            DB::beginTransaction();
            
            // Check if category has subcategories or products
            if ($category->subCategories()->count() > 0) {
                return redirect()->route('admin.category.index')
                    ->with('error', 'Cannot delete category. It has ' . $category->subCategories()->count() . ' subcategories.');
            }
            
            if ($category->products()->count() > 0) {
                return redirect()->route('admin.category.index')
                    ->with('error', 'Cannot delete category. It has ' . $category->products()->count() . ' products.');
            }

            $category->delete();
            
            DB::commit();
            
            return redirect()->route('admin.category.index')
                ->with('success', 'Category deleted successfully!');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.category.index')
                ->with('error', 'Error deleting category: ' . $e->getMessage());
        }
    }

    /**
     * Toggle status of the specified resource.
     */
    public function toggleStatus($id)
    {
        $category = Category::findOrFail($id);
        
        try {
            DB::beginTransaction();
            
            $category->status = $category->status == 'active' ? 'inactive' : 'active';
            $category->save();
            
            DB::commit();
            
            $status = $category->status == 'active' ? 'activated' : 'deactivated';
            return redirect()->route('admin.category.index')
                ->with('success', 'Category ' . $status . ' successfully!');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.category.index')
                ->with('error', 'Error updating status: ' . $e->getMessage());
        }
    }
}