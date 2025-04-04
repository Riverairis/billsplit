<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('expenses')->get();
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255|unique:categories,name',
        'color' => 'required|string|size:7',
    ]);

    $category = Category::create([
        'name' => $request->name,
        'color' => $request->color
    ]);

    return response()->json([
        'success' => true,
        'category' => $category,
        'message' => 'Category created successfully'
    ]);
}

    public function show(Category $category)
    {
        $expenses = $category->expenses()->with('bill')->get();
        return view('categories.show', compact('category', 'expenses'));
    }
}