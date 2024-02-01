<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\Cart;
use App\Models\Invoice;
use App\Models\InvoiceProduct;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{

    public function create(Request $request)
    {
        DB::beginTransaction();

        try {
            $carts = Cart::where('user_id', $request->user()->id)
                ->select([
                    'id',
                    'price',
                    'qty',
                    'product_id'
                ])
                ->selectRaw('price * qty as sub_total')
                ->get();

            if (count($carts) === 0)
                throw new Exception("Empty Cart.");

            $profile = $request->user()->profile;

            if (!$profile)
                throw new Exception("Please set-up your profile first.");

            $data = [
                'total' => $carts->sum('sub_total'),
                'transaction_id' => uniqid(),
                'cus_detail' => "Name:{$profile->cus_name},Address:{$profile->cus_address},City:{$profile->cus_city},Phone:{$profile->cus_phone}",
                'ship_detail' => "Name:{$profile->ship_name},Address:{$profile->ship_address},City:{$profile->ship_city},Phone:{$profile->ship_phone}",
                'delivary_status' => 'Pending',
                'payment_status' => 'Pending',
                'user_id' => $request->user()->id,
            ];

            $data['vat'] = ($data['total'] * 5) / 100;
            $data['payable'] = $data['total'] + $data['vat'];

            $invoice = Invoice::create($data);

            foreach ($carts as $cart) {
                InvoiceProduct::create([
                    'invoice_id' => $invoice->id,
                    'user_id' => $request->user()->id,
                    'product_id' => $cart->product_id,
                    'qty' => $cart->qty,
                    'sale_price' => $cart->price,
                ]);

                Cart::where('id', $cart->id)->delete();
            }

            DB::commit();

            return ResponseHelper::make('success', null);
        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function getAll(Request $request)
    {
        try {
            $invoices = Invoice::where('user_id', $request->user()->id)->get();

            return ResponseHelper::make('success', $invoices);

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function get(Request $request, string $id)
    {
        try {
            $invoice = Invoice::where([
                    'id' => $id,
                    'user_id' => $request->user()->id,
                ])
                ->with('invoiceProducts')
                ->first();

            return ResponseHelper::make('success', $invoice);

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

}
