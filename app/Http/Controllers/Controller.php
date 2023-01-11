<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\View;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function __construct() {
        $appName="Alex Paints";
    $bizcontact="+256-755386247";
    $bizlocation="Ntinda Kampala";
    $bizname="ACB Paints Ug Ltd";
    $email="info@acbpaintsug.com";

       View::share('appName',$appName);
       View::share('bizcontact',$bizcontact);
       View::share('bizname',$bizname);
       View::share('bizlocation',$bizlocation);
       View::share('bizemail',$email);

  }
}
