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
        if($oldCart) {
            $this->items = $oldCart->items;
            $this->totalQty = $oldCart->totalQty;
            $this->totalPrice = $oldCart->totalPrice;
        }
    }

    public function add($item, $id) 
    {
        $storedItem = [
            'qty' => 0,
            'price' => $item->products['0']['price'],
            'item' => $item,
        ];
        if($this->items) {
            if(array_key_exists($id, $this->items)) {
                $storedItem = $this->items[$id];
            }
        }
        $storedItem['qty']++;
        $storedItem['price'] = $item->products['0']['price'] * $storedItem['qty'];
        $this->totalQty++;
        $this->items[$id] = $storedItem;
        $this->totalPrice += $item->products['0']['price'];
    }

    public function update($item, $id, $size, $color) 
    {
        $storedItem = [
            'qty' => 0,
            'price' => $item->products['0']['price'],
            'item' => $item,
        ];
        if (array_key_exists($id, $this->items)) {
            $storedItem = $this->items[$id];
        }
        $storedItem['item']['products']['0']['size']['0']['name'] = $size;
        $storedItem['item']['products']['0']['color']['0']['name'] = $color;
        // $storedItem['price'] = (int)$item->products['0']['price'] * (int)$qnty;

        
        $storedItem['item']['products']['0']['size']['0']['name'] = $this->items[$id]['item']['products']['0']['size']['0']['name'];
        $storedItem['item']['products']['0']['color']['0']['name'] = $this->items[$id]['item']['products']['0']['color']['0']['name'];

    }

    public function reduce($id) 
    {        
        $this->items[$id]['qty']--;
        $this->items[$id]['price'] -= $this->items[$id]['item']['price'];
        $this->totalQty--;
        $this->totalPrice -= $this->items[$id]['item']['price'];
        if($this->items[$id]['qty'] <= 0) {
            unset($this->items[$id]);
        }
    }

    public function remove($id) 
    {        
        $this->totalQty -= (int)$this->items[$id]['qty'];
        $this->totalPrice -= (int)$this->items[$id]['price'];
        unset($this->items[$id]);
    }
}