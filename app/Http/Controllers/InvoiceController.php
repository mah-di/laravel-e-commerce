<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Helpers\SSLCommerz;
use App\Models\Cart;
use App\Models\Invoice;
use App\Models\InvoiceProduct;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

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
                'delivary_status' => 'PENDING',
                'payment_status' => 'PENDING',
                'user_id' => $request->user()->id,
            ];

            $data['vat'] = ($data['total'] * 5) / 100;
            $data['payable'] = $data['total'] + $data['vat'];

            $invoice = Invoice::create($data);

            foreach ($carts as $cart)
                InvoiceProduct::create([
                    'invoice_id' => $invoice->id,
                    'cart_id' => $cart->id,
                    'user_id' => $request->user()->id,
                    'product_id' => $cart->product_id,
                    'qty' => $cart->qty,
                    'sale_price' => $cart->price
                ]);

            $frontEnd = $request->app ?? 'web';

            $result = SSLCommerz::initiate($invoice, $profile, $request->user()->email, $frontEnd);

            DB::commit();

            return ResponseHelper::make('success', [
                'payment_methods' => $result,
                'total' => $data['total'],
                'vat' => $data['vat'],
                'payable' => $data['payable']
            ]);

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function paymentSuccess(Request $request, string $transactionID, string $frontEnd)
    {
        try {
            if (!$request->hasValidSignature())
                throw new Exception("Unauthorized");

            SSLCommerz::success($transactionID);

            if ($frontEnd === 'vue')
                return Redirect::to(env('VUE_PAYMENT_SUCCESS'));

            return Redirect::route('profile.page');

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function paymentFail(Request $request, string $transactionID, string $frontEnd)
    {
        try {
            if (!$request->hasValidSignature())
                throw new Exception("Unauthorized");

            SSLCommerz::fail($transactionID);

            if ($frontEnd === 'vue')
                return Redirect::to(env('VUE_PAYMENT_UNSUCCESS'));

            return Redirect::route('profile.page');

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }

    }

    public function paymentCancel(Request $request, string $transactionID, string $frontEnd)
    {
        try {
            if (!$request->hasValidSignature())
                throw new Exception("Unauthorized");

            SSLCommerz::cancel($transactionID);

            if ($frontEnd === 'vue')
                return Redirect::to(env('VUE_PAYMENT_UNSUCCESS'));

            return Redirect::route('profile.page');

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }

    }

    public function handleIPN(Request $request)
    {
        if (!$request->hasValidSignature())
            throw new Exception("Unauthorized");

        $transactionID = $request->tran_id;
        $status = $request->status;
        $validationID = $request->val_id;

        SSLCommerz::ipn($transactionID, $status, $validationID);

        return 1;
    }

    public function get(Request $request, string $id)
    {
        try {
            $data = Invoice::where([ 'id' => $id, 'user_id' => $request->user()->id ])
                ->whereIn('payment_status', ['SUCCESS', 'VALID'])
                ->first();

            if (!$data)
                throw new Exception("Invoice not found.");

            return ResponseHelper::make('success', $data);

        } catch (Exception $error) {
            return ResponseHelper::make('fail', null, $error->getMessage());
        }
    }

    public function getAll(Request $request)
    {
        try {
            $invoices = Invoice::where([ 'user_id' => $request->user()->id ])
                ->whereIn('payment_status', ['SUCCESS', 'VALID'])
                ->get();

            return ResponseHelper::make('success', $invoices);

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

}
