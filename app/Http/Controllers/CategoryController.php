<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    public function categoryPage()
    {
        return view('pages.dashboard.category-page');
    }

    public function index(Request $request)
    {
        $user_id = $request->header('id');
        return Category::where('user_id', $user_id)->get();
    }

    public function show(Category $category)
    {

        return $category;
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50',
        ]);

        $user_id = $request->header('id');
        $validated['user_id'] = $user_id;

        $category = Category::create($validated);

        return response()->json($category, Response::HTTP_CREATED);
    }

    public function update(Request $request, Category $category)
    {

        $validated = $request->validate([
            'name' => 'required|string|max:50',
        ]);

        $user_id = $request->header('id');
        $validated['user_id'] = $user_id;

        $category->update($validated);

        return response()->json($category);
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
