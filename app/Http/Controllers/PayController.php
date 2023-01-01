<?php

namespace App\Http\Controllers;

use App\Models\Buyer;
use App\Models\Payment;
use App\Services\FatooorahServices;
use App\Models\User;
use bookeey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PayController extends Controller
{
    //

    private $fatoorahServices;

    public function __construct(FatooorahServices $fatoorahServices)
    {
        $this->fatoorahServices = $fatoorahServices;
    }


    public function payOrder($total_amount,$order_id = 0)
    {

        if ($total_amount == 0)
            return response()->json(['status' => 'error', 'message' => 'Error Validation'], 406);


        $rand = rand(100000000000, 999999999999);

        $auth_data_user_credit = Auth::user();

        $data_user_credit = User::where('id', $auth_data_user_credit->id)->first();

        $companyname = $data_user_credit->name;
        $phonenumber = $data_user_credit->phone;
        $email = $data_user_credit->email;


        $money = $total_amount;
        $paymentCase = $money + 0.250;

        $user_id = $data_user_credit->id;
        $setSecretKey = '0123930';
        $MerchUID = 'mer21000381';
        $SubMerchUID = 'subm21000592';

        $data = [
            "DBRqst" => "PY_ECom",
            "Do_Appinfo" => [
                "APIVer" => "1.6",
                "APPTyp" => "WEB",
                "AppVer" => "1"
            ],
            "Do_MerchDtl" => [
                "BKY_PRDENUM" => "ECom",
                "FURL" => 'https://mashawir.easymedia.agency/payment/error',
                "MerchUID" => "$MerchUID",
                "SURL" => 'https://mashawir.easymedia.agency/payment/call_back',
                'setSecretKey' => "$setSecretKey",
            ],
            "Do_PyrDtl" => [
                "Pyr_MPhone" => $phonenumber,
                "Pyr_Name" => $companyname,
                "ISDNCD" => "965"
            ],
            "Do_TxnDtl" => [
                [
                    "SubMerchUID" => "$SubMerchUID",
                    "Txn_AMT" => "$paymentCase"
                ]
            ],
            "Do_TxnHdr" => [
                'Merch_Txn_UID' => "$rand",
                "PayFor" => "ECom",
                "PayMethod" => "KNET",
                "Txn_HDR" => "2987228884280325",
                "hashMac" => "8B95BEED1BDAAA0B0672D28BFA7F0C08408EFD7AAACA6C78582242A1348ABAB0542C0CD43BC9AD9DD906B001C1B220557011D8E0770DDFB45CE70C8D7D069C7F",
                "emailAddress" => "$email",
                "phoneAddress" => "+965" . "$phonenumber",
                "address" => "Kwite",
                "ISDNCode" => "123",
                "merchantIBanNo" => "1234123412341234",
                "accountTitleName" => "test",
                "swiftCode" => "ABC",
                "merchantName" => "$companyname",
            ]
        ];

        session()->regenerate();
        session(['MIR' => "$MerchUID"]);

        $ldate = date('m-d-Y');
        $response = $this->fatoorahServices->sendPayment($data);

        if ($response['PayUrl'] != null) {
            $MerchantTxnRefNo = "$rand";
            $rand2 = rand(10000000, 99999999);

            $num = "B$rand2";

            /*$payment = new Payment();
            $payment->order_id = $order_id;
            $payment->amount = $money;
            $payment->currency = 'KWD';
            $payment->method = 'KNET';
            $payment->status = 'completed';
            $payment->transaction_id = '';
            $issave = $payment->save();*/
            if ($response['PayUrl']) {
                return $response['PayUrl'];
            } else {
                return back()->withErrors([
                    'error' => $response['ErrorMessage'],
                ]);
            }
        } else {
            return back()->withErrors([
                'email' => $response['ErrorMessage'],
            ]);
        }
    }
}
