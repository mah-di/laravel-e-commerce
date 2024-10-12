<?php

namespace App\Helpers;

use App\Models\Cart;
use App\Models\CustomerProfile;
use App\Models\Invoice;
use App\Models\SSLCommerzAccount;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\URL;

class SSLCommerz
{

    public static function initiate(Invoice $invoice, CustomerProfile $profile, string $email, string $frontEnd)
    {
        $sslAccount = SSLCommerzAccount::first();

        $successURL = URL::signedRoute('paymentSuccess', ['transactionID' => $invoice->transaction_id, 'frontEnd' => $frontEnd]);
        $failURL = URL::signedRoute('paymentFail', ['transactionID' => $invoice->transaction_id, 'frontEnd' => $frontEnd]);
        $cancelURL = URL::signedRoute('paymentCancel', ['transactionID' => $invoice->transaction_id, 'frontEnd' => $frontEnd]);
        $ipnURL = URL::signedRoute('ipn');

        $response = Http::asForm()->post($sslAccount->init_url, [
            'store_id' => $sslAccount->store_id,
            'store_passwd' => $sslAccount->store_password,
            'total_amount' => $invoice->payable,
            'currency' => $sslAccount->currency,
            'tran_id' => $invoice->transaction_id,
            'success_url' => $successURL,
            'fail_url' => $failURL,
            'cancel_url' => $cancelURL,
            'ipn_url' => $ipnURL,
            'cus_name' => $profile->cus_name,
            'cus_email' => $email,
            'cus_add1' => $profile->cus_address,
            'cus_city' => $profile->cus_city,
            'cus_state' => $profile->cus_state,
            'cus_postcode' => $profile->cus_postcode,
            'cus_country' => $profile->cus_country,
            'cus_phone' => $profile->cus_phone,
            'shipping_method' => 'YES',
            'ship_name' => $profile->ship_name,
            'ship_add1' => $profile->ship_address,
            'ship_city' => $profile->ship_city,
            'ship_state' => $profile->ship_state,
            'ship_postcode' => $profile->ship_postcode,
            'ship_country' => $profile->ship_country,
            'product_name' => 'Any',
            'product_category' => 'Any',
            'product_profile' => 'general',
        ]);

        return $response->json('desc');
    }

    public static function success(string $transactionID)
    {
        $invoice = Invoice::where('transaction_id', $transactionID)
            ->where(fn ($query) =>
                $query->where('validation_id', 0)
                    ->orWhere('payment_status', 'VALID')
            )
            ->first();

        $invoice->payment_status === 'PENDING' && ($invoice->payment_status = 'SUCCESS');
        $invoice->save();

        $cartIds = [];

        foreach ($invoice->invoiceProducts as $invoiceProduct) {
            $cartIds[] = $invoiceProduct->cart_id;
        }

        Cart::whereIn('id', $cartIds)->delete();
    }

    public static function fail(string $transactionID)
    {
        Invoice::where(['transaction_id' => $transactionID, 'validation_id' => 0])->update(['payment_status' => 'FAIL']);
    }

    public static function cancel(string $transactionID)
    {
        Invoice::where(['transaction_id' => $transactionID, 'validation_id' => 0])->update(['payment_status' => 'CANCEL']);
    }

    public static function ipn(string $transactionID, string $status, string $validationID)
    {
        Invoice::where(['transaction_id' => $transactionID, 'validation_id' => 0])->update(['payment_status' => $status, 'validation_id' => $validationID]);
    }

}
