<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function indexByCategory(string $id)
    {
        try {
            $data = Product::where('category_id', $id)->get();

            return ResponseHelper::make('success', $data);

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function indexByBrand(string $id)
    {
        try {
            $data = Product::where('brand_id', $id)->get();

            return ResponseHelper::make('success', $data);

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function indexByRemark(string $remark)
    {
        try {
            $data = Product::where('remark', $remark)->get();

            return ResponseHelper::make('success', $data);

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function search(Request $request)
    {
        try {
            $hasParams = false;

            $data = Product::whereNotNull('id');

            if ($request->brand_id) {
                $hasParams = true;

                $data = $data->where('brand_id', $request->brand_id);
            }

            if ($request->category_id) {
                $hasParams = true;

                $data = $data->where('category_id', $request->category_id);
            }

            if ($request->q) {
                $hasParams = true;

                $data = $data->where('title', 'LIKE', "%{$request->q}%");
            }

            if ($request->remark) {
                $hasParams = true;

                $data = $data->where('remark', $request->remark);
            }

            if ($request->max_price) {
                $hasParams = true;

                $data = $data->where('price', '<=', $request->max_price);
            }

            if ($request->min_price) {
                $hasParams = true;

                $data = $data->where('price', '>=', $request->min_price);
            }

            if ($request->max_rating) {
                $hasParams = true;

                $data = $data->where('star', '<=', $request->max_rating);
            }

            if ($request->min_rating) {
                $hasParams = true;

                $data = $data->where('star', '>=', $request->min_rating);
            }

            if ($request->stock and $request->stock === 'in') {
                $hasParams = true;

                $data = $data->where('stock', '>', 0);
            }

            if ($request->stock and $request->stock === 'out') {
                $hasParams = true;

                $data = $data->where('stock', '=', 0);
            }

            if ($hasParams)
                $data = $data->with(['brand', 'category'])->get();

            return ResponseHelper::make('success', $data);

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function single(string $id)
    {
        try {
            $data = Product::with(['brand', 'category'])->find($id);

            return ResponseHelper::make('success', $data);

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

}
