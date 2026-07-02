<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Like;

class LikeController extends Controller
{
    /** いいね */
    public function store(Item $item)
    {
        $user = auth()->user();

        if(! Like::where('user_id',$user->id)
            ->where('item_id',$item->id)
            ->exists()){

        Like::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
            ]);

        }

        return redirect()->route('item.detail',$item);
    }

    /** いいね解除 */
    public function destroy(Item $item)
    {
        $user = auth()->user();

        Like::where('user_id',$user->id)
            ->where('item_id',$item->id)
            ->delete();

        return redirect()->route('item.detail',$item);
    }
}
