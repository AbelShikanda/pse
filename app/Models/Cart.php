<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart
{
    public $items = null;
    public $totalQty = 0;
    public $totalPrice = 0;

    public function __construct($oldCart)
    {
        if ($oldCart) {
            $this->items = $oldCart->items;
            $this->totalQty = $oldCart->totalQty;
            $this->totalPrice = $oldCart->totalPrice;
        }
    }

    public function add($item, $id, $quantity, $size, $color)
    {
        $quantity = $quantity ?? 1;

        if ($this->items && array_key_exists($id, $this->items)) {
            return back()->with('error', 'This product is already in your cart.');
        }

        $storedItem = [
            'qty' => $quantity,
            'price' => $item->products['0']['price'],
            'item' => $item,
            'size' => $size,
            'color' => $color,
        ];

        if ($this->items && array_key_exists($id, $this->items)) {
            $storedItem = $this->items[$id];
            $storedItem['qty'] += $quantity;
        }

        $storedItem['price'] = $item->products['0']['price'] * $storedItem['qty'];

        $this->totalQty += $quantity;
        $this->items[$id] = $storedItem;
        $this->totalPrice += $item->products['0']['price'] * $quantity;
    }

    public function update($item, $id, $size, $color)
    {
        $storedItem = $this->items[$id];

        if (!empty($storedItem['size']) || !empty($storedItem['color'])) {
            $storedItem['size'] = $size;
            $storedItem['color'] = $color;
        } else {
            $storedItem = [
                'qty' => $storedItem['qty'],
                'price' => $item->products[0]['price'],
                'item' => $item,
                'size' => $size,
                'color' => $color,
            ];
        }

        if (array_key_exists($id, $this->items)) {
            $this->items[$id] = $storedItem;
        }

        $sizeName = ProductSizes::find($size);
        $storedItem['item']['products']['0']['size']['0']['name'] = $sizeName;
        $storedItem['item']['products']['0']['color']['0']['name'] = $color;
        // $storedItem['price'] = (int)$item->products['0']['price'] * (int)$qnty;

        $storedItem['item']['products']['0']['size']['0']['name'] = $this->items[$id]['item']['products']['0']['size']['0']['name'];
        $storedItem['item']['products']['0']['color']['0']['name'] = $this->items[$id]['item']['products']['0']['color']['0']['name'];
        // dd($size, $storedItem);
    }

    public function reduce($id)
    {
        if (!isset($this->items[$id])) {
            return;
        }

        $productPrice = $this->items[$id]['item']['products'][0]['price'];

        $this->items[$id]['qty']--;
        $this->items[$id]['price'] -= $productPrice;
        $this->totalQty--;
        $this->totalPrice -= $productPrice;

        if ($this->items[$id]['qty'] <= 0) {
            unset($this->items[$id]);
        }
    }

    public function increase($id)
    {
        if (!isset($this->items[$id])) {
            return;
        }

        $productPrice = $this->items[$id]['item']['products'][0]['price'];

        $this->items[$id]['qty']++;
        $this->items[$id]['price'] += $productPrice;
        $this->totalQty++;
        $this->totalPrice += $productPrice;
    }

    public function remove($id)
    {
        $this->totalQty -= (int) $this->items[$id]['qty'];
        $this->totalPrice -= (int) $this->items[$id]['price'];
        unset($this->items[$id]);
    }
}
