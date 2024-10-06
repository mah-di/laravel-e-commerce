<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function indexByCategory(Request $request, string $id)
    {
        try {
            $limit = $request->limit ?? 4;
            $data = Product::where('category_id', $id)->paginate($limit);

            return ResponseHelper::make('success', $data);

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function indexByBrand(Request $request, string $id)
    {
        try {
            $limit = $request->limit ?? 4;
            $data = Product::where('brand_id', $id)->paginate($limit);

            return ResponseHelper::make('success', $data);

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function indexByRemark(Request $request, string $remark)
    {
        try {
            $limit = $request->limit ?? 4;
            $data = Product::where('remark', $remark)->paginate($limit);

            return ResponseHelper::make('success', $data);

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function search(Request $request)
    {
        try {
            $limit = $request->limit ?? 4;

            $hasParams = false;

            $query = Product::whereNotNull('id');

            if ($request->related_id) {
                $hasParams = true;

                $query = $query->whereNot('id', $request->related_id);
            }

            if ($request->brand_id) {
                $hasParams = true;

                $query = $query->where('brand_id', $request->brand_id);
            }

            if ($request->category_id) {
                $hasParams = true;

                $query = $query->where('category_id', $request->category_id);
            }

            if ($request->q) {
                $hasParams = true;

                $query = $query->where('title', 'LIKE', "%{$request->q}%");
            }

            if ($request->remark) {
                $hasParams = true;

                $query = $query->where('remark', $request->remark);
            }

            if ($request->max_price) {
                $hasParams = true;

                $query = $query->where('price', '<=', $request->max_price);
            }

            if ($request->min_price) {
                $hasParams = true;

                $query = $query->where('price', '>=', $request->min_price);
            }

            if ($request->max_rating) {
                $hasParams = true;

                $query = $query->where('star', '<=', $request->max_rating);
            }

            if ($request->min_rating) {
                $hasParams = true;

                $query = $query->where('star', '>=', $request->min_rating);
            }

            if ($request->stock and $request->stock === 'in') {
                $hasParams = true;

                $query = $query->where('stock', '>', 0);
            }

            if ($request->stock and $request->stock === 'out') {
                $hasParams = true;

                $query = $query->where('stock', '=', 0);
            }

            if ($hasParams)
                $data = $query->paginate($limit)->withQueryString();

            return ResponseHelper::make('success', $data);

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function getQuery(Request $request) {

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
