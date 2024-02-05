<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function index()
    {
        try {
            $data = Category::all();

            return ResponseHelper::make('success', $data);
        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function single(string $id)
    {
        try {
            $data = Category::find($id);

            if (!$data)
                throw new Exception("Unknown Category");

            return ResponseHelper::make('success', $data);
        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

}
