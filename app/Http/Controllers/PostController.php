<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use \Illuminate\Http\JsonResponse;
use \Illuminate\Http\Request;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return ResourceCollection
     */
    public function index()
    {
        $posts = Post::query()->get();
        return PostResource::collection($posts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return PostResource
     */
    public function store(Request $request)
    {
        $createdPost = DB::transaction(function () use($request){
            $createdPost = Post::query()->create([
                'title' => $request->title,
                'body' => $request->body,
            ]);
            $createdPost->users()->sync($request->user_ids);

            return $createdPost;
        });
        return new PostResource($createdPost);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return PostResource
     */
    public function show(Post $post)
    {
        return new PostResource($post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return PostResource | JsonResponse
     */
    public function update(Request $request, Post $post)
    {
//        $post->update($request->only(['title', 'body']));

        $updatedPost = $post->update([
           'title' => $request->title ?? $post->title,
           'body' => $request->body ?? $post->body,
        ]);

        if (!$updatedPost) {
            return new JsonResponse([
                'errors' => ['Failed to update post.'],
            ], 400);
        }
        return new PostResource($updatedPost);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Post $post)
    {
        $deletedPost = $post->forceDelete();
        if (!$deletedPost) {
            return new JsonResponse([
                'errors' => ['Failed to delete post.'],
            ], 400);
        }
        return new JsonResponse([
            'data'=> 'Post deleted successfully',
        ]);
    }
}
