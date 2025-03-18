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

    public function update($id, $newSize, $newColor, $oldSize, $oldColor, $quantity)
    {
        $selectedKey = null;

        foreach ($this->items as $key => $item) {
            if ($item['image_id'] == $id) {
                // Check if this item matches exactly by size & color
                if ($item['size'] == $oldSize && $item['color'] == $oldColor) {
                    $selectedKey = $key;  // Exact match found
                }
            }
        }

        if (!$selectedKey || !isset($this->items[$selectedKey])) {
            return false;
        }

        $newKey = $id . '-' . $newSize . '-' . $newColor;

        if (isset($this->items[$newKey])) {
            if ($newKey !== $selectedKey) {
                $this->items[$newKey]['qty'] += $quantity;
                $this->items[$newKey]['price'] = $this->items[$newKey]['unit_price'] * $this->items[$newKey]['qty'];
                unset($this->items[$selectedKey]);

                return true;
            } else {
                return back()->with('message', 'This item color and size is already in your cart.');
            }
        }

        if ($this->items[$selectedKey]['size'] !== $newSize || $this->items[$selectedKey]['color'] !== $newColor) {
            $oldItem = $this->items[$selectedKey];
            $this->items[$newKey] = [
                'qty' => $oldItem['qty'],
                'unit_price' => $oldItem['unit_price'],
                'thumbnail' => $oldItem['thumbnail'],
                'product_name' => $oldItem['product_name'],
                'product_desc' => $oldItem['product_desc'],
                'price' => $oldItem['unit_price'] * $oldItem['qty'],
                'product_id' => $oldItem['product_id'],
                'image_id' => $id,
                'size' => $newSize,
                'color' => $newColor,
                'color_id' => $oldItem['color_id'],
            ];
            unset($this->items[$selectedKey]);
        } else {
            $oldItem = $this->items[$selectedKey];
            $this->items[$newKey] = [
                'qty' => $oldItem['qty'],
                'unit_price' => $oldItem['unit_price'],
                'thumbnail' => $oldItem['thumbnail'],
                'product_name' => $oldItem['product_name'],
                'product_desc' => $oldItem['product_desc'],
                'price' => $oldItem['unit_price'] * $oldItem['qty'],
                'product_id' => $oldItem['product_id'],
                'image_id' => $id,
                'size' => $newSize,
                'color' => $newColor,
                'color_id' => $oldItem['color_id'],
            ];
            unset($this->items[$selectedKey]);
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

        // Deduct from total quantity and price
        $this->totalQty -= (int) $this->items[$key]['qty'];
        $this->totalPrice -= (int) $this->items[$key]['price'];

        // Remove the item from the cart
        unset($this->items[$key]);
    }
}
