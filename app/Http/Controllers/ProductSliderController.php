<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\ProductSlider;
use Exception;
use Illuminate\Http\Request;

class ProductSliderController extends Controller
{

    public function get()
    {
        try {
            $data = ProductSlider::all();

            return ResponseHelper::make('success', $data);

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

}
