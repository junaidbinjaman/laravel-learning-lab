<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreComment;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $comments = Comment::query()
            ->get();

        return response()->json([
            'status' => 'success',
            'count' => count($comments),
            'data' => $comments
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreComment $request)
    {
        //
        $data['post_id'] = $request->post_id;
        $data['user_id'] = auth()->id();
        $data['content'] = $request->message;

        Comment::query()
            ->create($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Comment created and waiting for admin\'s approval'
        ], 201);
    }

    public function changeStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'comment_id' => 'required|exists:comments,id',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'fail',
                'message' => $validator->errors()
            ], 400);
        }

        $comment = Comment::query()
            ->find($request->comment_id);

        $comment->status = $request->status;
        $comment->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Status updated'
        ], 201);
    }

    public function show(int $id)
    {
        $comment = Comment::query()
            ->where('post_id', $id)
            ->where('status', 'approved')
            ->get();

        if ($comment) {
            return response()->json([
                'status' => 'success',
                'count' => count($comment),
                'data' => $comment
            ], 200);
        }
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
