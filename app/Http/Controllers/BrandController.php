<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\Brand;
use Exception;
use Illuminate\Http\Request;

class BrandController extends Controller
{

    public function index()
    {
        try {
            $data = Brand::all();

            return ResponseHelper::make('success', $data);
        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

}
