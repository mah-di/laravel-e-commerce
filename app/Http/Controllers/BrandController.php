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

    public function single(string $id)
    {
        try {
            $data = Brand::find($id);

            if (!$data)
                throw new Exception("Unknown Brand");

            return ResponseHelper::make('success', $data);
        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

}
