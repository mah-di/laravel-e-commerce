<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\Product;
use App\Models\ProductWish;
use Exception;
use Illuminate\Http\Request;

class ProductWishController extends Controller
{

    public function save(Request $request, string $id)
    {
        try {
            $exists = Product::where('id', $id)->exists();

            if (!$exists)
                throw new Exception("Invalid Product.");

            ProductWish::updateOrCreate(
                [
                    'user_id' => $request->user()->id,
                    'product_id' => $id
                ],
                [
                    'user_id' => $request->user()->id,
                    'product_id' => $id
                ]
            );

            return ResponseHelper::make('success', null, 'Product added to your Wishlist.');

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function get(Request $request)
    {
        try {
            $data = ProductWish::where('user_id', $request->user()->id)
                ->with(['product'])
                ->get();

            return ResponseHelper::make('success', $data);

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function delete(Request $request, string $id)
    {
        try {
            ProductWish::where([
                    'user_id' => $request->user()->id,
                    'product_id' => $id
                ])
                ->delete();

            return ResponseHelper::make('success', null, 'Wish was deleted.');

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function clear(Request $request)
    {
        try {
            ProductWish::where('user_id', $request->user()->id)->delete();

            return ResponseHelper::make('success', null, 'Wishlist cleared.');

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

}
