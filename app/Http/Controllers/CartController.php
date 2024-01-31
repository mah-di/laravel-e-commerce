<?php

namespace App\Http\Controllers;

use App\Helpers\HandleCartDelete;
use App\Helpers\ResponseHelper;
use App\Models\Cart;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{

    public function save(Request $request)
    {
        DB::beginTransaction();

        try {
            $validData = $request->validate([
                'product_id' => ['required'],
                'color' => ['required'],
                'size' => ['required'],
                'qty' => ['required', 'numeric', 'gt:0'],
            ]);

            $product = Product::where('id', $request->product_id)->select(['stock', 'price', 'discount_price'])->first();

            if (!$product)
                throw new Exception("Invalid Product.");

            if ($request->qty > $product->stock)
                throw new Exception("Quantity exceeds available stock.");

            $price = ($product->discount_price > 0) ? $product->discount_price : $product->price;

            $cart = Cart::where([
                    'user_id' => $request->user()->id,
                    'product_id' => $request->product_id
                ])
                ->select(['qty'])
                ->first();

            if (!$cart) {
                Cart::create([
                    'user_id' => $request->user()->id,
                    ...$validData,
                    'price' => $price
                ]);

                $product->stock -= $request->qty;

            } else {
                $qtyDiff = $request->qty - $cart->qty;

                Cart::where([
                        'user_id' => $request->user()->id,
                        'product_id' => $request->product_id
                    ])
                    ->update([
                        'user_id' => $request->user()->id,
                        ...$validData,
                        'price' => $price
                    ]);

                $product->stock -= $qtyDiff;
            }

            $product->save();

            DB::commit();

            return ResponseHelper::make('success', null, 'Product added to your Cart.');

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function get(Request $request)
    {
        try {
            $data = Cart::where('user_id', $request->user()->id)
                ->with(['product'])
                ->get();

            return ResponseHelper::make('success', $data);

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function delete(Request $request, string $id)
    {
        DB::beginTransaction();

        try {
            $cart = Cart::where([
                    'id' => $id,
                    'user_id' => $request->user()->id
                ])
                ->first();

            HandleCartDelete::handle($cart);

            DB::commit();

            return ResponseHelper::make('success', null, 'Cart Item was deleted.');

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function clear(Request $request)
    {
        DB::beginTransaction();

        try {
            $carts = Cart::where('user_id', $request->user()->id)->get();

            foreach ($carts as $cart) {
                HandleCartDelete::handle($cart);
            }

            DB::commit();

            return ResponseHelper::make('success', null, 'Cart cleared.');

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

}
