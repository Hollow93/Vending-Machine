<?php

namespace App\Http\Controllers\Ajax;

use App\Models\AjaxHandler;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AjaxMainController extends Controller
{

    /**
     * @var AjaxHandler
     */
    private $ajaxHandler;

    /**
     * AjaxMainController constructor.
     * @param AjaxHandler $ajaxHandler
     */
    public function __construct(AjaxHandler $ajaxHandler)
    {
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
        return response()->json($button, 200);
    }


}
