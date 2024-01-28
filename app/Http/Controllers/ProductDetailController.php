<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\ProductDetail;
use Exception;
use Illuminate\Http\Request;

class ProductDetailController extends Controller
{

    public function get(string $id)
    {
        try {
            $data = ProductDetail::where('product_id', $id)->first();

            return ResponseHelper::make('success', $data);

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

}
