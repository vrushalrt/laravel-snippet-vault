<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePost;
use App\Models\BlogPost;
use App\Models\Image;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
// use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
USE Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;

class PostsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', [
            'only' => [
                'create', 'store', 'edit', 'update', 'destroy', 'index'
                ]
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // DB::enableQueryLog();

        // $posts = BlogPost::all();
        // $posts = BlogPost::with('comments')->get();

        // foreach($posts as $post) {
        //     // dump($post->comments()->get());
        //     foreach($post->comments()->get() as $comment) {
        //         dump($comment->content);
        //     }
        // }
        // dd(DB::getQueryLog());
        // return view('posts.index',['posts' => BlogPost::orderBy('created_at', 'desc')->take(5)->get()]);

        // $posts = Cache::remember('blog-posts', now()->addSeconds(10), function(){
        //     return BlogPost::latest()->withCount('comments')->with('user')->get();        
        // });  
        
        // $mostCommentedPost = Cache::remember('blog-post-most-commented', 60, function(){
        //     return BlogPost::mostCommented()->take(5)->get();        
        // });  

        // $mostActiveUsers = Cache::remember('user-most-active', 60, function(){
        //     return User::withMostBlogPosts()->take(5)->get();        
        // });  

        // $mostActiveUserLastMonth = Cache::remember('user-most-active-last-month', 60, function(){
        //     return User::withMostBlogPostsLastMonth()->take(5)->get();        
        // });  

        // E-294 - Cache tags
        // $posts = Cache::tags(['blog-post'])->remember('blog-posts', now()->addSeconds(10), function(){
        //     return BlogPost::latest()
        //         ->withCount('comments')
        //         ->with('user')
        //         ->with('tags')
        //         ->get();        
        // });
        
        // $posts = BlogPost::latest()
        // ->withCount('comments')
        // ->with('user')
        // ->with('tags')
        //         ->get();          
        
        // $mostCommentedPost = Cache::tags(['blog-post'])->remember('blog-post-most-commented', 60, function(){
        //     return BlogPost::mostCommented()->take(5)->get();        
        // });  

        // $mostActiveUsers = Cache::tags(['blog-post'])->remember('user-most-active', 60, function(){
        //     return User::withMostBlogPosts()->take(5)->get();        
        // });  

        // $mostActiveUserLastMonth = Cache::tags(['blog-post'])->remember('user-most-active-last-month', 60, function(){
        //     return User::withMostBlogPostsLastMonth()->take(5)->get();        
        // });

        // E-309 - Converting repeating queries to query scopes
        $posts = BlogPost::latestWithRelations()->get();   
  
        return view('posts.index',
            [
                // 'posts' => BlogPost::all(),
                'posts' => $posts,
                // 'mostCommented' => $mostCommentedPost,
                // 'mostActive' => $mostActiveUsers,
                // 'mostActiveUserLastMonth' => $mostActiveUserLastMonth
            ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $this->authorize('posts.create');
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    public function store(StorePost $request)
    {
        // $request->validate([
        //     'title' => 'bail|required|min:5|max:100',
        //     'content' => 'required|min:10',
        // ]);

        $validated =$request->validated();
        $validated['user_id'] = $request->user()->id;

        // $post = new BlogPost();
        //logic 1
        // $post->title = $request->input('title');
        // $post->content = $request->input('content');

        // logic 2
        // $post->title = $validated['title'];
        // $post->content = $validated['content'];
        // $post->save();

        // logic 3
        $post = BlogPost::create($validated);

         // E-312 : Thumbnail image upload
         if ($request->hasFile('thumbnail')) {
            // $file = $request->file('thumbnail');
            // dump($file);
            // dump($file->getClientMimeType());
            // dump($file->getClientOriginalExtension());

            // dump($file->store('thumbnails'));

            // Alternate file upload
            // dump(Storage::disk('public')->put('thumbnails', $file));

            // E-312 : Handling Image Uploads
            // $fileName = $file->storeAs('thumbnails', $post->id . '.' . $file->guessExtension());
            // dump(Storage::putFileAs('thumbnails', $file, $post->id . '.' . $file->guessExtension()));

            // dump(Storage::url($fileName)); // Recommended for production

            // E-313 : Image Model
            $path = $request->file('thumbnail')->store('thumbnails');
         
            $post->image()->save(
                Image::make(['path' => $path])
            );
        }

        // dd($request->hasFile('thumbnail'));

        session()->flash('status', 'Post created!');

        return redirect()->route('posts.show',['post' => $post->id]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // abort_if(!isset($this->posts[$id]), 404, 'Post not found');

        // Local scope
        // return view('posts.show', [
        //     // 'post' => BlogPost::findOrFail($id)
        //     'post' => BlogPost::with(['comments' => function ($query){
        //         return $query->latest();
        //     }])->findOrFail($id)
        // ]);

        // $blogPost = Cache::remember("blog-post-{id}", 60, function() use($id) {
        //     return BlogPost::with('comments')->findOrFail($id);
        // });
        
        // E-294 - Cache tags
        $blogPost = Cache::tags(['blog-post'])->remember("blog-post-{$id}", 60, function() use($id) {
            return BlogPost::with('comments', 'tags', 'user', 'comments.user')  
                ->findOrFail($id); // E-308 Eager Loading
        });

        $sessionId = session()->getId();
        $counterKey = "blog-post-{$id}-counter";
        $usersKey = "blog-post-{$id}-users";

        $users = Cache::get($usersKey, []);
        $usersUpdate = [];
        $difference = 0;
        $now = now();

        foreach ($users as $session => $lastVisit) {
            if ($now->diffInMinutes($lastVisit) >= 1){
                $difference--;
            } else {
                $usersUpdate[$session] = $lastVisit;
            }
        }

        if (
            !array_key_exists($sessionId, $users) 
            || $now->diffInMinutes($users[$sessionId]) >=1
            ) {
                $difference++;
        }

        $usersUpdate[$sessionId] = $now;

        Cache::forever($usersKey, $usersUpdate);

        // if (!Cache::has($counterKey)) {
        //     Cache::forever($counterKey, 1);
        // } else {
        //     Cache::increment($counterKey, $difference);
        // }
        
        // E-294 - Cache tags
        if (!Cache::tags(['blog-post'])->has($counterKey)) {
            Cache::tags(['blog-post'])->forever($counterKey, 1);
        } else {
            Cache::tags(['blog-post'])->increment($counterKey, $difference);
        }

        $counter = Cache::tags(['blog-post'])->get($counterKey);

        return view('posts.show', [
            // 'post' => BlogPost::findOrFail($id)
            'post' => $blogPost,
            'counter' => $counter
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BlogPost $post)
    {
        // if (Gate::denies('update-post', $post)) 
        // {
        //     abort(403, "You can't edit this post");
        // }

        // $this->authorize('posts.update', $post); // Short hand method works same like Gate
        $this->authorize($post); // Short hand method works same like Gate
        
        return view('posts.edit', ['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StorePost $request,  $id)
    {
        $post = BlogPost::findOrFail($id);

        // if (Gate::denies('update-post', $post)) {
        //     abort(403, "You can't edit this post");
        // }

        // $this->authorize('posts.update', $post); // Short hand method works same like Gate
        $this->authorize($post);

        $validated = $request->validated();

        $post->fill($validated);
        
        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('thumbnails');

            if ($post->image) {
                Storage::delete($post->image->path);
                $post->image->path = $path;
                $post->image->save();
            } else {
                $post->image()->save(
                    Image::make(['path' => $path])
                );
            }
        }

        $post->save();

        session()->flash('status', 'Post updated!'); 

        return redirect()->route('posts.show', ['post' => $post->id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BlogPost $post)
    {
        // if (Gate::denies('delete-post', $post)) 
        // {
        //     abort(403, "You can't delete this post");
        // }

        // $this->authorize('posts.delete', $post); // Short hand method works same like Gate
        $this->authorize($post);

        $post->delete();

        session()->flash('status', 'Post deleted!');
        
        return redirect()->route('posts.index');
    }
}
