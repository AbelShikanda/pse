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

        if (!$this->items) {
            $this->items = [];
        }

        $uniqueKey = $id . '-' . $size . '-' . $color;

        if (array_key_exists($uniqueKey, $this->items)) {
            $this->items[$uniqueKey]['qty'] += $quantity;
            $this->items[$uniqueKey]['price'] = $item['price'] * $this->items[$uniqueKey]['qty'];
        } else {
            $this->items[$uniqueKey] = [
                'qty' => $quantity,
                'unit_price' => $item['price'],
                'thumbnail' => $item['thumbnails'],
                'product_name' => $item['product_name'],
                'product_desc' => $item['product_desc'],
                'price' => $item['price'] * $quantity,
                'product_id' => $item['product_id'],
                'image_id' => $item['id'],
                'size' => $size,
                'color' => $color,
                'color_id' => $item['color_id'],
            ];
        }

        $this->totalQty += $quantity;
        $this->totalPrice += $item['price'] * $quantity;
    }

    public function update($id, $size, $color)
    {
        $oldKey = null;
        $relatedItems = [];

        foreach ($this->items as $key => $item) {
            if ($item['image_id'] == $id) {
                $oldKey = $key;
            } else {
                $relatedItems[$key] = $item;
            }
        }

        if (!$oldKey || !isset($this->items[$oldKey])) {
            return false;
        }

        $newKey = $id . '-' . $size . '-' . $color;

        if (isset($this->items[$newKey])) {
            return back()->with('message', 'This item color and size is already in your cart.');
        } else {
            $oldItem = $this->items[$oldKey];

            $this->items[$newKey] = [
                'qty' => $this->items[$oldKey]['qty'],
                'unit_price' => $oldItem['unit_price'],
                'thumbnail' => $oldItem['thumbnail'],
                'product_name' => $oldItem['product_name'],
                'product_desc' => $oldItem['product_desc'],
                'price' => $oldItem['unit_price'] * $this->items[$oldKey]['qty'],
                'product_id' => $oldItem['product_id'],
                'image_id' => $id,
                'size' => $size,
                'color' => $color,
                'color_id' => $oldItem['color_id'],
            ];
            unset($this->items[$oldKey]);
        }

        return true;
    }

    public function reduce($key)
    {
        // Ensure the item exists in the cart
        if (!isset($this->items[$key])) {
            return;
        }

        $productPrice = $this->items[$key]['unit_price'];

        $this->items[$key]['qty']--;
        $this->items[$key]['price'] -= $productPrice;
        $this->totalQty--;
        $this->totalPrice -= $productPrice;

        // If quantity is 0 or less, remove the item
        if ($this->items[$key]['qty'] <= 0) {
            unset($this->items[$key]);
        }
    }

    public function increase($key)
    {
        // Ensure the item exists in the cart
        if (!isset($this->items[$key])) {
            return;
        }

        $productPrice = $this->items[$key]['unit_price'];

        $this->items[$key]['qty']++;
        $this->items[$key]['price'] += $productPrice;
        $this->totalQty++;
        $this->totalPrice += $productPrice;
    }

    public function remove($key)
    {
        // Ensure the item exists in the cart
        if (!isset($this->items[$key])) {
            return;
        }

        $productPrice = $this->items[$key]['unit_price'];

        // Deduct from total quantity and price
        $this->totalQty -= (int) $this->items[$key]['qty'];
        $this->totalPrice -= (int) $this->items[$key]['price'];

        // Remove the item from the cart
        unset($this->items[$key]);
    }
}
