<?php

namespace App\Http\Controllers\Ajax;

use App\Models\AjaxHandler;
use App\Models\ClientMoney;
use App\Models\CurrentBalances;
use App\Models\Products;
use App\Models\VendingMachineMoney;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AjaxMainController extends Controller
{

    private $ajaxHandler;

    public function __construct(
        AjaxHandler $ajaxHandler
    )
    {
        //  $this->middleware('shareCommonData');
        $this->ajaxHandler = $ajaxHandler;
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $button = $this->ajaxHandler->workPlaceMainAjax($request->all());
        $msg = "This is a simple message.";
        return response()->json(array('msg'=> $msg), 200);
    }
}
