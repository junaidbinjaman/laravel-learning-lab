<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreBlogPostRequest;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\Seo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BlogPostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $post = BlogPost::with('seo_data')
            ->get();

        return response()->json([
            'status' => 'success',
            'count' => count($post),
            'data' => $post
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBlogPostRequest $request)
    {
        //
        $request->validated();

        $loggedIn_user = Auth::user();

        if ($loggedIn_user->id != $request->user_id) {
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
        if (Auth::user()->role === 'admin') {
            $data['status'] = 'publish';
        }
        if (Auth::user()->role === 'admin' || Auth::user()->role === 'author') {
            $data['published_at'] = date('Y-m-d H:i:s');
        }

        $blogPost = BlogPost::query()
            ->create($data);

        $postId = $blogPost->id;
        $seoData['post_id'] = $postId;
        $seoData['meta_title'] = $request->meta_title;
        $seoData['meta_description'] = $request->meta_description;
        $seoData['meta_keywords'] = $request->meta_keywords;

        Seo::query()
            ->create($seoData);

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
        $blogPost = BlogPost::query()
            ->find($id);

        if (!$blogPost) {
            return response()->json([
                'status' => 'fail',
                'message' => 'No blog post found'
            ], 404);
        }

        $loggedIn_user = Auth::user();

//        if ($loggedIn_user->id != $request->user_id) {
//            return response()->json([
//                'status' => 'fail',
//                'message' => 'Unauthorized access'
//            ], 400);
//        }

        $category = BlogCategory::query()
            ->find($request->category_id);

        if (!$category) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Category not found'
            ], 404);
        }

        // Chek additional condition to restrict authorized edit
        if ($loggedIn_user->id == $blogPost->user_id || Auth::user()->role == 'admin') {
            $blogPost->category_id = $request->category_id;
            $blogPost->user_id = $request->user_id;
            $blogPost->title = $request->title;
            $blogPost->slug = Str::slug($request->title);
            $blogPost->content = $request->content;
            $blogPost->excerpt = $request->excerpt;
            $blogPost->status = $request->status;
            $blogPost->save();

            $seo_data = Seo::query()
                ->where('post_id', $blogPost->id)->first();

            $seo_data->meta_title = $request->meta_title;
            $seo_data->meta_description = $request->meta_description;
            $seo_data->meta_keywords = $request->meta_keywords;
            $seo_data->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Blog Post edited successfully'
            ], 201);
        } else {
            return response()->json([
                'status' => 'fail',
                'id' => $blogPost->user_id,
                'message' => 'You are not allowed to perform this task'
            ], 403);
        }
    }

    public function blogPostImage(Request $request, int $id)
    {
        //
        $blogPost = BlogPost::query()
            ->find($id);

        if (!$blogPost) {
            return response()->json([
                'status' => 'fail',
                'message' => 'No blog post found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'thumbnail' => 'nullable|image|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'fail',
                'message' => $validator->errors()
            ], 404);
        }

        $loggedIn_user = Auth::user();

        if ($loggedIn_user->id == $blogPost->user_id || Auth::user()->role == 'admin') {
            $imagePath = null;

            if ($request->hasFile('thumbnail') && $request->file('thumbnail')->isValid()) {
                $file = $request->file('thumbnail');

                $fileName = time() . '_' . $file->getClientOriginalName();

                $file->move(public_path('storage/posts'), $fileName);

                $imagePath = 'storage/posts/' . $fileName;
            }

            $blogPost->thumbnail = $imagePath ?? $blogPost->thumbnail;
            $blogPost->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Blog image updated successfully'
            ], 201);
        } else {
            return response()->json([
                'status' => 'fail',
                'id' => $blogPost->user_id,
                'message' => 'You are not allowed to perform this task'
            ], 403);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $blogPost = BlogPost::query()
            ->find($id);
        $loggedIn_user = Auth::user();

        if (!$blogPost) {
            return response()->json([
                'status' => 'fail',
                'message' => 'No Blog Post Found'
            ], 404);
        }

        if ($loggedIn_user->id == $blogPost->user_id || Auth::user()->role == 'admin') {
            $blogPost->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Post deleted successfully'
            ], 201);
        } else {
            return response()->json([
                'status' => 'fail',
                'id' => $blogPost->user_id,
                'message' => 'You are not allowed to perform this task'
            ], 403);
        }
    }
}
