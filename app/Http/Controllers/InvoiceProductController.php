<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\InvoiceProduct;
use Exception;
use Illuminate\Http\Request;

class InvoiceProductController extends Controller
{

    public function get(Request $request, string $id)
    {
        try {
            $invoice = InvoiceProduct::where([
                    'invoice_id' => $id,
                    'user_id' => $request->user()->id,
                ])
                ->with([
                    'product' => fn ($q) => $q->select(['id', 'title'])
                ])
                ->get();

            return ResponseHelper::make('success', $invoice);

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

}
