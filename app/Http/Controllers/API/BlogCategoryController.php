<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlogCategory;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BlogCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $categories = BlogCategory::query()
            ->get();

        return response()->json([
            'status' => 'success',
            'count' => count($categories),
            'message' => $categories,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'fail',
                'message' => $validator->errors()
            ], 400);
        }

        $data['name'] = $request->name;
        $data['slug'] = Str::slug($request->name);

        BlogCategory::query()
            ->create($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Blog category created successful'
        ], 201);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'fail',
                'message' => $validator->errors()
            ], 400);
        }

        $category = BlogCategory::query()
            ->find($id);

        if ($category) {
            $category->name = $request->name;
            $category->slug = Str::slug($request->name);
            $category->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Category edited successfully'
            ], 201);
        } else {
            return response()->json([
                'status' => 'fail',
                'message' => 'Category not found'
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $category = BlogCategory::query()
            ->find($id);

        if ($category) {
            BlogCategory::destroy($id);

            return response()->json([
                'status' => 'success',
                'message' => 'category deleted successfully'
            ], 201);
        } else {
            return response()->json([
                'status' => 'fail',
                'message' => 'Category not found'
            ], 404);
        }
    }
}
