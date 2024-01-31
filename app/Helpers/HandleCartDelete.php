<?php

namespace App\Helpers;
use App\Models\Cart;
use App\Models\Product;
use Exception;
use Illuminate\Support\Facades\DB;

class HandleCartDelete
{

    public static function handle(?Cart $cart)
    {
        if (!$cart)
            throw new Exception("Invalid action.");

        $productID = $cart->product_id;
        $qty = $cart->qty;

        $cart->delete();

        Product::where('id', $productID)
            ->update([
                'stock' => DB::raw("products.stock + {$qty}")
            ]);
    }

}
