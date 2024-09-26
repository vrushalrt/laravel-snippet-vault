<?php
// E-330 OneToMany Polymorphic associating
namespace App\Http\Controllers;

use App\Http\Requests\StoreComment;
use App\Models\User;
use Illuminate\Http\Request;

class UserCommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['store']);
    }
    public function store(User $user, StoreComment $request)
    {
        $user->commentsOn()->create([
            'content' => $request->input('content'),
            'user_id' => $request->user()->id
        ]);

        // session()->flash('status', 'Comment Added.');

        return redirect()->back()
            ->with('status', 'Comment Added.');
    }
}
