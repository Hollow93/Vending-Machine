<?php

namespace App\Http\Controllers\MainPage;

use App\Models\ClientMoney;
use App\Models\CurrentBalances;
use App\Models\Products;
use App\Models\VendingMachineMoney;
use App\Http\Controllers\Controller;

class MainPageController extends Controller
{
    /**
     * @var Products
     */
    private $products;
    /**
     * @var ClientMoney
     */
    private $clientMoney;
    /**
     * @var VendingMachineMoney
     */
    private $vendingMachineMoney;
    /**
     * @var CurrentBalances
     */
    private $currentBalance;

    /**
     * MainPageController constructor.
     * @param Products $products
     * @param ClientMoney $clientMoney
     * @param VendingMachineMoney $vendingMachineMoney
     * @param CurrentBalances $currentBalance
     */
    public function __construct(
        Products $products,
        ClientMoney $clientMoney,
        VendingMachineMoney $vendingMachineMoney,
        CurrentBalances $currentBalance
    )
    {
        //  $this->middleware('shareCommonData');
        $this->products = $products;
        $this->clientMoney = $clientMoney;
        $this->vendingMachineMoney = $vendingMachineMoney;
        $this->currentBalance = $currentBalance;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __invoke()
    {
        return view('main.index', [
            'products' => $this->products->getAllRecords(),
            'clientMoney' => $this->clientMoney->getAllRecords(),
            'vendingMachineMoney' => $this->vendingMachineMoney->getAllRecords(),
            'currentBalance' => $this->currentBalance->getAllSummary(),
        ]);
    }
}
