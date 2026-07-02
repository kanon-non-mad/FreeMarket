<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Purchase;
use App\Http\Requests\PurchaseRequest;
use App\Http\Requests\AddressRequest;

class PurchaseController extends Controller
{
    public function create(Item $item)
    {
    $user = auth()->user();

    return view('purchase', compact('item', 'user'));
    }

    public function store(PurchaseRequest $request,Item $item)
    {
        $user = auth()->user();

        Purchase::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
            'address' => $user->address,
            'building' => $user->building,
            'postal_code' => $user->postal_code,
            'payment_method' => $request->validated()['payment_method'],
            'price' => $item->price,
        ]);

        return redirect()->route('profile.index');
    }

    public function editAddress(Item $item)
    {
        $user = auth()->user();
        return view('address',compact('item','user'));
    }

    public function updateAddress(AddressRequest $request, Item $item) {
        $user = auth()->user();

        $data = $request->validated();

        $user->update([
            'postal_code' => $data['postal_code'],
            'address' => $data['address'],
            'building' => $data['building'],
        ]);

        return redirect()->route('purchase.create',$item);
    }
}
