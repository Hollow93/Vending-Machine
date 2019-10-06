<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\AjaxHandler
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AjaxHandler newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AjaxHandler newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AjaxHandler query()
 * @mixin \Eloquent
 */
class AjaxHandler extends Model
{
    /**
     * @param $request
     * @return array|mixed|string
     */
    public function definitionButton($request)
    {
        switch ($request) {
            case 'product1':
            case 'product2':
            case 'product3':
            case 'product4':
                $response = $this->initializeBuyProduct($request);
                break;
            case 'userBill1':
            case 'userBill2':
            case 'userBill3':
            case 'userBill4':
                $response = $this->initializeIntroductionMoney($request);
                break;
            case 'change':
                $response = $this->initializeReturnMoney($request);
                break;
            default:
                $response = "got incorrect button";
        }

        return $response;
    }

    /**
     * @param $request
     * @return array|mixed|string
     */
    public function workPlaceMainAjax($request)
    {
        return $this->definitionButton($request['buttonID']);
    }

    /**
     * @param $request
     * @return array|mixed
     */
    public function initializeBuyProduct($request)
    {
        $data=[];
        $recordBalancesDeposited = CurrentBalances::find(3);
        $recordProduct = Products::find($request{7});

        if($recordBalancesDeposited->summary == 0 or $recordProduct->price > $recordBalancesDeposited->summary){
            $data['action'] = 'error';
            $data['message'] = 'Внесено недостаточно средств для покупки';
        }else{
            $data = $this->editDepositSummary($recordBalancesDeposited, $recordProduct, $data);
            $data = $this->editProductAmount($request, $recordProduct, $data);

            $data['action'] = 'update';
            $data['message'] = 'Успешная покупка';

        }
        return $data;
    }

    /**
     * @param $request
     * @return array|mixed
     */
    public function initializeIntroductionMoney($request)
    {
        $data = [];

        $recordBD = ClientMoney::find($request{8});
        if($recordBD->amount == 0){
            $data['action'] = 'error';
            $data['message'] = 'У вас больше нет '.$recordBD->price;
        }else{
            $data = $this->editUserAmountMoney($request, $recordBD, $data);
            $data = $this->editVendingMachineAmountMoney($request, $data);
            $data = $this->editDepositMoney($recordBD, $data);
            $data = $this->editVendingMachineSummaryMoney($recordBD, $data);
            $data = $this->editUserSummaryMoney($recordBD, $data);

            $data['action'] = 'update';
            $data['message'] = 'Деньги успешно получены';
        }

        return $data;
    }

    /**
     * @return array
     */
    public function initializeReturnMoney()
    {

        $data = [];
        $recordBalancesDeposited = CurrentBalances::find(3);
        $recordBalancesMashine = CurrentBalances::find(2);
        $recordBalancesUser = CurrentBalances::find(1);

        if($recordBalancesDeposited->summary == 0){
            $data['action'] = 'error';
            $data['message'] = 'Текущий баланс пуст, сдача не требуется';
        }else{
            $ten = floor($recordBalancesDeposited->summary / 10);
            if($ten != 0){
                $this->takeAwayDepositTenBill($recordBalancesDeposited, $ten);
                $data = $this->returnClientTenBill($ten, $data, $recordBalancesUser);
                $data = $this->takeAwayVendingMachineTenBill($ten, $data, $recordBalancesMashine);
            }

            $five = floor($recordBalancesDeposited->summary / 5);
            if($five != 0) {
                $this->takeAwayDepositFiveBill($recordBalancesDeposited, $five);
                $data = $this->returnClientFiveBill($five, $data, $recordBalancesUser);
                $data = $this->takeAwayVendingMachineFiveBill($five, $data, $recordBalancesMashine);
            }


            $two = floor($recordBalancesDeposited->summary / 2);
            if($two != 0) {
                $this->takeAwayDepositTwoBill($recordBalancesDeposited, $two);
                $data = $this->returnClientTwoBill($two, $data, $recordBalancesUser);
                $data = $this->takeAwayVendingMachineTwoBill($two, $data, $recordBalancesMashine);
            }

            $one = floor($recordBalancesDeposited->summary / 1);
            if($one != 0) {
                $this->takeAwayDepositOneBill($recordBalancesDeposited, $one);
                $data = $this->returnClientOneBill($one, $data, $recordBalancesUser);
                $data = $this->takeAwayVendingMachineOneBill($one, $data, $recordBalancesMashine);

            }

            $data = $this->savingUpdateBalanceForClientVendingMachineAndDeposit($recordBalancesDeposited, $data, $recordBalancesUser, $recordBalancesMashine);

        }

        return $data;

    }

    /**
     * @param $request
     * @param $recordBD
     * @param $data
     * @return mixed
     */
    public function editUserAmountMoney($request, $recordBD, $data)
    {
        $recordBD->amount = $recordBD->amount - 1;
        $recordBD->save();
        $data['query'][] = 'clientMoney' . $request{8};
        $data['query'][] = 'Кол-во:' . $recordBD->amount;
        return $data;
    }

    /**
     * @param $request
     * @param $data
     * @return mixed
     */
    public function editVendingMachineAmountMoney($request, $data)
    {
        $recordVendingMachine = VendingMachineMoney::find($request{8});
        $recordVendingMachine->amount = $recordVendingMachine->amount + 1;
        $recordVendingMachine->save();
        $data['query'][] = 'vendingMoney' . $request{8};
        $data['query'][] = 'Кол-во:' . $recordVendingMachine->amount;
        return $data;
    }

    /**
     * @param $recordBD
     * @param $data
     * @return mixed
     */
    public function editDepositMoney($recordBD, $data)
    {
        $recordBalancesDeposited = CurrentBalances::find(3);
        $recordBalancesDeposited->summary = $recordBalancesDeposited->summary + $recordBD->price;
        $recordBalancesDeposited->save();
        $data['query'][] = 'summaryDeposited';
        $data['query'][] = (string)$recordBalancesDeposited->summary;
        return $data;
    }

    /**
     * @param $recordBD
     * @param $data
     * @return mixed
     */
    public function editVendingMachineSummaryMoney($recordBD, $data)
    {
        $recordBalancesMashine = CurrentBalances::find(2);
        $recordBalancesMashine->summary = $recordBalancesMashine->summary + $recordBD->price;
        $recordBalancesMashine->save();
        $data['query'][] = 'summaryVM';
        $data['query'][] = (string)$recordBalancesMashine->summary;
        return $data;
    }

    /**
     * @param $recordBD
     * @param $data
     * @return mixed
     */
    public function editUserSummaryMoney($recordBD, $data)
    {
        $recordBalancesUser = CurrentBalances::find(1);
        $recordBalancesUser->summary = $recordBalancesUser->summary - $recordBD->price;
        $recordBalancesUser->save();
        $data['query'][] = 'summaryUser';
        $data['query'][] = (string)$recordBalancesUser->summary;
        return $data;
    }

    /**
     * @param $recordBalancesDeposited
     * @param $recordProduct
     * @param $data
     * @return mixed
     */
    public function editDepositSummary($recordBalancesDeposited, $recordProduct, $data)
    {
        $recordBalancesDeposited->summary = $recordBalancesDeposited->summary - $recordProduct->price;
        $recordBalancesDeposited->save();
        $data['query'][] = 'summaryDeposited';
        $data['query'][] = (string)$recordBalancesDeposited->summary;
        return $data;
    }

    /**
     * @param $request
     * @param $recordProduct
     * @param $data
     * @return mixed
     */
    public function editProductAmount($request, $recordProduct, $data)
    {
        $recordProduct->amount = $recordProduct->amount - 1;
        $recordProduct->save();
        $data['query'][] = 'productAmount' . $request{7};
        $data['query'][] = 'Кол-во:' . (string)$recordProduct->amount;
        return $data;
    }

    /**
     * @param $recordBalancesDeposited
     * @param $ten
     */
    public function takeAwayDepositTenBill($recordBalancesDeposited, $ten): void
    {
        $recordBalancesDeposited->summary = $recordBalancesDeposited->summary - ($ten * 10);
    }

    /**
     * @param $recordBalancesDeposited
     * @param $five
     */
    public function takeAwayDepositFiveBill($recordBalancesDeposited, $five): void
    {
        $recordBalancesDeposited->summary = $recordBalancesDeposited->summary - ($five * 5);
    }

    /**
     * @param $recordBalancesDeposited
     * @param $two
     */
    public function takeAwayDepositTwoBill($recordBalancesDeposited, $two): void
    {
        $recordBalancesDeposited->summary = $recordBalancesDeposited->summary - ($two * 2);
    }

    /**
     * @param $recordBalancesDeposited
     * @param $one
     */
    public function takeAwayDepositOneBill($recordBalancesDeposited, $one): void
    {
        $recordBalancesDeposited->summary = $recordBalancesDeposited->summary - ($one * 1);
    }

    /**
     * @param $ten
     * @param $data
     * @param $recordBalancesUser
     * @return array
     */
    public function returnClientTenBill($ten, $data, $recordBalancesUser): array
    {
        $recordClientMoney = ClientMoney::find(1);
        $recordClientMoney->amount = $recordClientMoney->amount + $ten;
        $recordClientMoney->save();
        $data['query'][] = 'clientMoney1';
        $data['query'][] = 'Кол-во:' . $recordClientMoney->amount;
        $recordBalancesUser->summary = $recordBalancesUser->summary + ($ten * 10);
        return $data;
    }

    /**
     * @param $ten
     * @param $data
     * @param $recordBalancesMashine
     * @return array
     */
    public function takeAwayVendingMachineTenBill($ten, $data, $recordBalancesMashine): array
    {
        $recordMachineMoney = VendingMachineMoney::find(1);
        $recordMachineMoney->amount = $recordMachineMoney->amount - $ten;
        $recordMachineMoney->save();
        $data['query'][] = 'vendingMoney1';
        $data['query'][] = 'Кол-во:' . $recordMachineMoney->amount;
        $recordBalancesMashine->summary = $recordBalancesMashine->summary - ($ten * 10);
        return $data;
    }

    /**
     * @param $five
     * @param $data
     * @param $recordBalancesUser
     * @return array
     */
    public function returnClientFiveBill($five, $data, $recordBalancesUser): array
    {
        $recordClientMoney = ClientMoney::find(2);
        $recordClientMoney->amount = $recordClientMoney->amount + $five;
        $recordClientMoney->save();
        $data['query'][] = 'clientMoney2';
        $data['query'][] = 'Кол-во:' . $recordClientMoney->amount;
        $recordBalancesUser->summary = $recordBalancesUser->summary + ($five * 5);
        return $data;
    }

    /**
     * @param $five
     * @param $data
     * @param $recordBalancesMashine
     * @return array
     */
    public function takeAwayVendingMachineFiveBill($five, $data, $recordBalancesMashine): array
    {
        $recordMachineMoney = VendingMachineMoney::find(2);
        $recordMachineMoney->amount = $recordMachineMoney->amount - $five;
        $recordMachineMoney->save();
        $data['query'][] = 'vendingMoney2';
        $data['query'][] = 'Кол-во:' . $recordMachineMoney->amount;
        $recordBalancesMashine->summary = $recordBalancesMashine->summary - ($five * 5);
        return $data;
    }

    /**
     * @param $two
     * @param $data
     * @param $recordBalancesUser
     * @return array
     */
    public function returnClientTwoBill($two, $data, $recordBalancesUser): array
    {
        $recordClientMoney = ClientMoney::find(3);
        $recordClientMoney->amount = $recordClientMoney->amount + $two;
        $recordClientMoney->save();
        $data['query'][] = 'clientMoney3';
        $data['query'][] = 'Кол-во:' . $recordClientMoney->amount;
        $recordBalancesUser->summary = $recordBalancesUser->summary + ($two * 2);
        return $data;
    }

    /**
     * @param $two
     * @param $data
     * @param $recordBalancesMashine
     * @return array
     */
    public function takeAwayVendingMachineTwoBill($two, $data, $recordBalancesMashine): array
    {
        $recordMachineMoney = VendingMachineMoney::find(3);
        $recordMachineMoney->amount = $recordMachineMoney->amount - $two;
        $recordMachineMoney->save();
        $data['query'][] = 'vendingMoney3';
        $data['query'][] = 'Кол-во:' . $recordMachineMoney->amount;
        $recordBalancesMashine->summary = $recordBalancesMashine->summary - ($two * 2);
        return $data;
    }

    /**
     * @param $one
     * @param $data
     * @param $recordBalancesUser
     * @return mixed
     */
    public function returnClientOneBill($one, $data, $recordBalancesUser)
    {
        $recordClientMoney = ClientMoney::find(4);
        $recordClientMoney->amount = $recordClientMoney->amount + $one;
        $recordClientMoney->save();
        $data['query'][] = 'clientMoney4';
        $data['query'][] = 'Кол-во:' . $recordClientMoney->amount;
        $recordBalancesUser->summary = $recordBalancesUser->summary + ($one * 1);
        return $data;
    }

    /**
     * @param $one
     * @param $data
     * @param $recordBalancesMashine
     * @return mixed
     */
    public function takeAwayVendingMachineOneBill($one, $data, $recordBalancesMashine)
    {
        $recordMachineMoney = VendingMachineMoney::find(4);
        $recordMachineMoney->amount = $recordMachineMoney->amount - $one;
        $recordMachineMoney->save();
        $data['query'][] = 'vendingMoney4';
        $data['query'][] = 'Кол-во:' . $recordMachineMoney->amount;
        $recordBalancesMashine->summary = $recordBalancesMashine->summary - ($one * 1);
        return $data;
    }

    /**
     * @param $recordBalancesDeposited
     * @param $data
     * @param $recordBalancesUser
     * @param $recordBalancesMashine
     * @return mixed
     */
    public function savingUpdateBalanceForClientVendingMachineAndDeposit($recordBalancesDeposited, $data, $recordBalancesUser, $recordBalancesMashine)
    {
        $recordBalancesDeposited->save();
        $data['query'][] = 'summaryDeposited';
        $data['query'][] = (string)$recordBalancesDeposited->summary;

        $recordBalancesUser->save();
        $data['query'][] = 'summaryUser';
        $data['query'][] = (string)$recordBalancesUser->summary;


        $recordBalancesMashine->save();
        $data['query'][] = 'summaryVM';
        $data['query'][] = (string)$recordBalancesMashine->summary;

        $data['action'] = 'update';
        $data['message'] = 'Возврат успешен';
        return $data;
    }


}
