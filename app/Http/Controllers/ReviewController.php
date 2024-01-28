<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\Review;
use Exception;
use Illuminate\Http\Request;

class ReviewController extends Controller
{

    public function get(string $id)
    {
        try {
            $data = Review::where('product_id', $id)->with([
                    'customer' => fn ($q) => $q->select(['cus_name'])
                ])
                ->get();

            return ResponseHelper::make('success', $data);

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

}
