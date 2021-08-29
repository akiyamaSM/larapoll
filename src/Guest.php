<?php

namespace Inani\Larapoll;


use Inani\Larapoll\Traits\Voter;
use Illuminate\Http\Request;


class Guest
{
    use Voter;

    public $user_id;

    public function __construct(Request $request)
    {
        $this->user_id = $this->getClientIPAddress($request);
    }

    private function getClientIPAddress($request)
    {
        //For Cloudflare
        if (!empty($request->server('HTTP_CF_CONNECTING_IP')))
        {
            $ipAddress = $request->server('HTTP_CF_CONNECTING_IP');
        }
        //For share internet IP
        elseif (!empty($request->server('HTTP_CLIENT_IP')))
        {
            $ipAddress = $request->server('HTTP_CLIENT_IP');
        }
        //For Google App Engine and other proxy
        elseif (!empty($request->server('HTTP_X_FORWARDED_FOR')))
        {
            $temp      = $request->server('HTTP_X_FORWARDED_FOR');
            $ipAddress = trim(explode(',', $temp)[0]);
        }
        else
        {
            $ipAddress = $request->ip();
        }
        return $ipAddress;
    }
}
