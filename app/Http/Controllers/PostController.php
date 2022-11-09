<?php

namespace App\Http\Controllers;


use App\Http\Requests\PostsRequest;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class PostController extends Controller
{

    public function index()
    {
        if (Gate::denies('Read-Posts')) {
            abort(403);
        }
        $posts = Post::with('author')->get();
        return response()->view('cms.posts.index', compact('posts'));
    }


    public function create()
    {
        if (Gate::denies('Create-Post')) {
            abort(403);
        }
        return response()->view('cms.posts.create');
    }


    public function store(PostsRequest $request)
    {
        $data= $request->only(['title', 'date']);
        $data['author_id'] = Auth::user()->id;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = $file->getClientOriginalName();
            $request->file('image')->storeAs('/posts', $fileName, ['disk' => 'public']);

            $data['image'] ='posts/' . $fileName;
        }
        $post = Post::create($data);

        return response()->json([
            'message' => $post ? 'Create successful' : 'Create failed',
        ],$post ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);

    }


    public function show(Post $post)
    {
        //
    }


    public function edit(Post $post)
    {
        if (Gate::denies('Update-Post')) {
            abort(403);
        }
        return response()->view('cms.posts.edit',compact('post'));
    }


    public function update(PostsRequest $request, Post $post)
    {
        $data= $request->only(['title', 'date']);
        $data['author_id'] = Auth::user()->id;

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($post->image);
            $file = $request->file('image');
            $fileName = $file->getClientOriginalName();
            $request->file('image')->storeAs('/posts', $fileName, ['disk' => 'public']);

            $data['image'] ='posts/' . $fileName;
        }
        $post->update($data);

        return response()->json([
            'message' => $post ? 'Create successful' : 'Create failed',
        ],$post ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
    }


    public function destroy(Post $post)
    {
        if (Gate::denies('Delete-Post')) {
            abort(403);
        }
        $url_image = $post->image;
        $isDeleted = $post->delete();
        if ($isDeleted) Storage::disk('public')->delete($url_image);
        return response()->json([
            'icon'=>$isDeleted ? 'success':'error',
            'title'=>$isDeleted ? 'Deleted successfully':'Delete failed'
        ], $isDeleted ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }
}
