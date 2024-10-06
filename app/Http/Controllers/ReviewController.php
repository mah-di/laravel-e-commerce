<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\InvoiceProduct;
use App\Models\Product;
use App\Models\Review;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{

    public function save(Request $request)
    {
        DB::beginTransaction();

        try {
            $validData = $request->validate([
                'review' => ['nullable'],
                'rating' => ['required', 'in:5,4,3,2,1'],
                'product_id' => ['required', 'exists:products,id'],
            ]);

            $profileID = $request->user()->profile->id;

            $data = Review::updateOrCreate(
                [
                    'customer_profile_id' => $profileID,
                    'product_id' => $request->product_id
                ],
                [
                    ...$validData,
                    'customer_profile_id' => $profileID
                ]
            );

            $rating = Review::where('product_id', $request->product_id)->avg('rating');

            Product::where('id', $request->product_id)->update(['star' => $rating]);

            DB::commit();

            return ResponseHelper::make('success', $data);

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function getReviewByCustomer(Request $request, string $productId)
    {
        try {
            $data = Review::where(['product_id' => $productId, 'customer_profile_id' => $request->user()->profile->id])->with(['product'])->first();

            return ResponseHelper::make('success', $data);

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function getAllReviewsByCustomer(Request $request)
    {
        try {
            $data = Review::where('customer_profile_id', $request->user()->profile->id)->with(['product'])->get();

            return ResponseHelper::make('success', $data);

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function getToReviewProducts(Request $request)
    {
        try {$reviewedProductIds = Review::where('customer_profile_id', $request->user()->profile->id)->distinct()->pluck('product_id');

            $data = InvoiceProduct::whereIn('id',
                    fn($q) => $q
                        ->where('user_id', $request->user()->id)
                        ->select(DB::raw('MAX(id)'))
                        ->from('invoice_products')
                        ->groupBy('product_id')
                    )
                ->whereNotIn('product_id', $reviewedProductIds)
                ->with(['product'])
                ->get();

            return ResponseHelper::make('success', $data);

        } catch (Exception $exception) {
            return ResponseHelper::make('success', null, $exception->getMessage());
        }
    }

    public function getProductReviews(string $productID)
    {
        try {
            $data = Review::where('product_id', $productID)->with([
                    'customer' => fn ($q) => $q->select(['id', 'cus_name'])
                ])
                ->get();

            return ResponseHelper::make('success', $data);

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

}
