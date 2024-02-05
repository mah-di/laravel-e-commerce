<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\Policy;
use Exception;
use Illuminate\Http\Request;

class PolicyController extends Controller
{
    public function get(string $type)
    {
        try {
            $data = Policy::where('type', $type)->first();

            return ResponseHelper::make('fail', $data);
        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, 'Cann\'t retrieve at this moment.');
        }
    }
}
