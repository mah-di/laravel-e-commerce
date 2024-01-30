<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\CustomerProfile;
use Exception;
use Illuminate\Http\Request;

class CustomerProfileController extends Controller
{

    public function save(Request $request)
    {
        try {
            $validData = $request->validate([
                'cus_name' => ['required'],
                'cus_address' => ['required'],
                'cus_city' => ['required'],
                'cus_state' => ['required'],
                'cus_postcode' => ['required'],
                'cus_country' => ['required'],
                'cus_phone' => ['required'],
                'ship_name' => ['required'],
                'ship_address' => ['required'],
                'ship_city' => ['required'],
                'ship_state' => ['required'],
                'ship_postcode' => ['required'],
                'ship_country' => ['required'],
                'ship_phone' => ['required'],
            ]);

            $data = CustomerProfile::updateOrCreate(
                [
                    'user_id' => $request->user()->id
                ],
                [
                    ...$validData,
                    'user_id' => $request->user()->id
                ]
            );

            return ResponseHelper::make('success', $data, 'Profile Information Saved.');

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function getProfile(Request $request)
    {
        try {
            $data = $request->user()->profile;

            return ResponseHelper::make('success', $data);

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

}
