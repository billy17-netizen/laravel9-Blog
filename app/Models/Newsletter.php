<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Newsletter extends Model
{
    protected $table = 'newsletters';
    protected $fillable = ['email'];

    public static function store($request)
    {
        self::create($request->all());

        $mailchimp = new \MailchimpMarketing\ApiClient();

        $mailchimp->setConfig([
            'apiKey' => env('MAILCHIMP_API_KEY'),
            'server' => env('MAILCHIMP_PREFIX'),
        ]);
        $list_id = 'd9ffea0afa';
        try {
            $response = $mailchimp->lists->addListMember($list_id, [
                "email_address" => $request->input('email'),
                "status" => "subscribed",
            ]);
            return response()->json(['message' => 'Thank-you for your subscription.'],200);
        } catch (\MailchimpMarketing\ApiException $e) {
            return response()->json(['message' => 'Invalid Email Address'],500);
        }
//        $response = $mailchimp->ping->get();
//        return response()->json($response);

    }
}
