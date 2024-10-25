 <?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostCommentController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\PostTagController;
use App\Http\Controllers\UserCommentController;
use App\Http\Controllers\UserController;
use App\Mail\CommentPostedMarkdown;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
// //    return view('welcome');
// //    return "Home Page";
//     return view('home.index');
// })->name('hone.index');

// Route::get('/contact', function(){
//    return view('home.contact');
// })->name("contact");

// Call with controller
Route::get('/',[HomeController::class, 'home'])->name('home.index')->middleware('auth');
Route::get('/contact',[HomeController::class, 'contact'])->name('home.contact');

//secret
Route::get('/secret', [HomeController::class, 'secret'])
    ->name('secret')
    ->middleware('can:home.secret');

Route::get('/single', AboutController::class);

//Route::get('/', 'home.index')->name('home.index');
//Route::get('/contact','home.contact')->name('home.contact');

$posts = [
    1 => [
        'title' => 'Intro to Laravel',
        'content' => 'This is a short intro to Laravel',
        'is_new' => true,
        'has_comments' => true
    ],

    2 => [
        'title' => 'Intro to PHP',
        'content' => 'This is a short intro to PHP',
        'is_new' => false
    ],
    
    3 => [
        'title' => 'Intro to Golang',
        'content' => 'This is a short intro to Golang',
        'is_new' => false
    ],

];

Route::resource('posts', PostsController::class)
    ->only(['index', 'show', 'create','store', 'edit', 'update', 'destroy']); // The only method is used to denote which controller methods we want to allow to use.
    // ->except(['index', 'show']); // All method allow except assigned method.

// Route::get('/posts', function() use ($posts) {
//     // // compact($posts); // it means ['posts' => $posts]
//     // dump(request()->input('page',1)); // Default value "1"
//     // dump(request()->input('limit'));
//     // dd(request()->all());

//     return view('posts.index', ['posts' => $posts]);
// });

// Route::get('/post/{id}', function($id) use ($posts) {
//     // $posts = [
//     //     1 => [
//     //         'title' => 'Intro to Laravel',
//     //         'content' => 'This is a short intro to Laravel',
//     //         'is_new' => true,
//     //         'has_comments' => true
//     //     ],
//     //     2 => [
//     //         'title' => 'Intro to PHP',
//     //         'content' => 'This is a short intro to PHP',
//     //         'is_new' => false
//     //     ]
//     // ];

//     abort_if(!isset($posts[$id]), 404, 'Post not found');

//     return view('posts.show', ['post'=>$posts[$id]]);

// })
// //    ->where(['
// //        id' => '[0-9]+'
// //    ])
//     ->name('posts.show');

Route::get('/recent-posts/{days_ago?}', function($daysAgo = 20){
    return 'Post from '.$daysAgo.' days ago';
})->name('posts.recent.index');

// Grouping Routes

Route::prefix('/fun')->name('fun.')->group(function() use ($posts) {
    Route::get('/responses', function() use ($posts) {
        return response($posts, 201)
            ->header('Content-Type', 'application/json')
            ->cookie('MY_COOKIE', 'Vrushal Raut', 3600);
    })->name('responses');
    
    Route::get('redirect', function() {
        return redirect('/contact');
    })->name('redirect');
    
    Route::get('back', function() {
        return back();
    })->name('back');
    
    Route::get('named-route', function() {
        return redirect()->route('posts.show', ['id' => 1]);
    })->name('named-route');
    
    Route::get('away', function() {
        return redirect()->away('https:\\google.com');
    })->name('away');
    
    Route::get('json', function() use ($posts) {
        return response ()->json($posts);
    })->name('json'); 
    
    Route::get('download', function() use ($posts) {
        return response ()->download(public_path('files\Sample PDF Doc.pdf'), 'sample.pdf');
    })->name('download');
});

// E-301
Route::get('/posts/tag/{tag}', [PostTagController::class, 'index'])->name('posts.tags.index');

// E-307 Route Model Binding
Route::resource('posts.comments', PostCommentController::class)->only(['store']);

// E-330 OneToMany Polymorphic associating
Route::resource('users.comments', UserCommentController::class)->only(['store']);

// E-321: User Cotrol and Policy
Route::resource('users',UserController::class)->only(['show','edit','update']);

Route::get('mailable', function() {
    $comment = Comment::find(451);
    return new CommentPostedMarkdown($comment);
});

// Auth::routes();
Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
