<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Http\Requests\ExhibitionRequest;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::all();
        return view('item.index',compact('items'));
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        $items = Item::where('item_name', 'like',"%{$keyword}%")->get();

        return view('item.index',compact('items','keyword'));
    }

    public function show(Item $item)
    {
        $item->load([
            'likes',
            'comments.user',
            'categories',
        ]);

        return view('item.detail',compact('item'));
    }

    public function create()
    {
        return view('item.create');
    }

    public function store(ExhibitionRequest $request)
    {
        $data = $request->validated();

        $imagePath = $request->file('item_image')->store('items', 'public');

        $item = Item::create([
            'user_id' => auth()->id(),
            'item_name' => $data['item_name'],
            'brand' => $data['brand'] ?? null,
            'price' => $data['price'],
            'description' => $data['description'],
            'condition' => $data['condition'],
            'item_image' => $imagePath,
        ]);
        $item->categories()->attach($data['category_id']);

        return redirect()->route('item.index');
    }

    public function mylist()
    {
        $user = auth()->user();

        $items = Item::whereIn(
            'id',
            $user->likes()->pluck('item_id')
        )->get();

        return view('item.mylist', compact('items'));
    }
}