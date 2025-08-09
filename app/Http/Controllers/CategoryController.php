<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;


class CategoryController extends Controller
{
    public function index(Request  $request)
    {
        $query = Category::query();

        // Jika request dari filter event (tidak perlu pagination)
        if ($request->has('for') && $request->for === 'filter') {
            return $query->orderBy('name')->get(['category_id', 'name']);
        }

        // Default untuk halaman admin (dengan pagination)
        $query->withCount('events');

        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        $perPage = $request->per_page ?? 10;
        $categories = $query->orderBy('name')->paginate($perPage);

        return response()->json([
            'data' => $categories->items(),
            'total' => $categories->total(),
            'current_page' => $categories->currentPage(),
            'per_page' => $categories->perPage(),
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:categories',
            'is_active' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        $category = Category::create([
            'name' => $request->name,
            'is_active' => $request->is_active,
        ]);

        // Log activity
        logActivity('category', 'Kategori baru ditambahkan', $category->name . ' telah ditambahkan oleh' . Auth::user()->name);

        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil ditambahkan',
            'data' => $category
        ]);
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories')->ignore($category->category_id, 'category_id')
            ],
            'is_active' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        $category->update([
            'name' => $request->name,
            'is_active' => $request->is_active,
        ]);

        // Log activity
        logActivity('category', 'Kategori diperbarui', $category->name . ' telah diperbarui');

        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil diperbarui',
            'data' => $category
        ]);
    }

    public function destroy(Category $category)
    {
        if ($category->events()->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak dapat menghapus kategori karena memiliki event terkait'
            ], 422);
        }

        $category->delete();

        // Log activity
        logActivity('category', 'Kategori dihapus', $category->name . ' telah dihapus');

        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil dihapus'
        ]);
    }

    public function stats()
    {
        return response()->json([
            'total_categories' => Category::count(),
            'active_categories' => Category::where('is_active', true)->count(),
            'total_events' => \App\Models\Event::count()
        ]);
    }
}
