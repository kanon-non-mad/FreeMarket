<?php

namespace App\Http\Controllers;

use Illuminate\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Models\Item;

class CommentController extends Controller
{
    public function store(CommentRequest $request, Item $item) {
        $user = auth()->user();

        Comment::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
            'content' => $request->validated()['content'],
        ]);
        return redirect()->route('item.detail',$item);
    }
}
