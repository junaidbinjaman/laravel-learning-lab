<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreBlogPostRequest;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BlogPostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBlogPostRequest $request)
    {
        //
        $request->validated();

        $loggedIn_user = Auth::user();

        if($loggedIn_user->id != $request->user_id) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Unauthorized access'
            ], 400);
        }

        $category = BlogCategory::query()
            ->find($request->category_id);

        if (!$category) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Category not found'
            ], 404);
        }

        $imagePath = null;

        if ($request->hasFile('thumbnail') && $request->file('thumbnail')->isValid()) {
            $file = $request->file('thumbnail');

            $fileName = time() . '_' . $file->getClientOriginalName();

            $file->move(public_path('storage/posts'), $fileName);

            $imagePath = 'storage/posts/' . $fileName;
        }

        $data['title'] = $request->title;
        $data['slug'] = Str::slug($request->title);
        $data['user_id'] = $request->user_id;
        $data['category_id'] = $request->category_id;
        $data['content'] = $request->content;
        $data['excerpt'] = $request->excerpt;
        $data['thumbnail'] = $imagePath ? $imagePath : null;
        $data['status'] = 'publish';
        $data['published_at'] = date('Y-m-d H:i:s');

        BlogPost::query()
            ->create($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Blog post created successfully'
        ], 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
