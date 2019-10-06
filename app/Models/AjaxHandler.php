<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AjaxHandler extends Model
{
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

    public function workPlaceMainAjax($request)
    {
        return $this->definitionButton($request['buttonID']);
    }

    public function initializeBuyProduct($request)
    {
        $recordBalancesDeposited = CurrentBalances::find(3);
        $recordProduct = Products::find($request{7});

        if($recordBalancesDeposited->summary == 0 or $recordProduct->price > $recordBalancesDeposited->summary){
            $data['action'] = 'error';
            $data['message'] = 'Внесено недостаточно средств для покупки';
        }else{
            $recordBalancesDeposited->summary = $recordBalancesDeposited->summary - $recordProduct->price;
            $q =$recordBalancesDeposited->summary;
            $recordBalancesDeposited->save();
            $data['query'][] = 'summaryDeposited';
            $data['query'][] = (string)$recordBalancesDeposited->summary;

            $recordProduct->amount = $recordProduct->amount - 1;
            $recordProduct->save();

            $data['query'][] = 'productAmount'.$request{7};
            $data['query'][] = 'Кол-во:'.(string)$recordProduct->amount;

            $data['action'] = 'update';
            $data['message'] = 'Успешная покупка';

        }
        return $data;
    }

    public function initializeIntroductionMoney($request)
    {
        $data = [];

        $recordBD = ClientMoney::find($request{8});
        if($recordBD->amount == 0){
            $data['action'] = 'error';
            $data['message'] = 'У вас больше нет '.$recordBD->price;
        }else{

            $recordBD->amount = $recordBD->amount -1;
            $recordBD->save();
            $data['query'][] = 'clientMoney'.$request{8};
            $data['query'][] = 'Кол-во:'.$recordBD->amount;


            $recordVendingMachine = VendingMachineMoney::find($request{8});
            $recordVendingMachine->amount = $recordVendingMachine->amount + 1;
            $recordVendingMachine->save();
            $data['query'][] = 'vendingMoney'.$request{8};
            $data['query'][] = 'Кол-во:'.$recordVendingMachine->amount;


            $recordBalancesDeposited = CurrentBalances::find(3);
            $recordBalancesDeposited->summary = $recordBalancesDeposited->summary + $recordBD->price;
            $recordBalancesDeposited->save();
            $data['query'][] = 'summaryDeposited';
            $data['query'][] = (string)$recordBalancesDeposited->summary;


            $recordBalancesMashine = CurrentBalances::find(2);
            $recordBalancesMashine->summary = $recordBalancesMashine->summary + $recordBD->price;
            $recordBalancesMashine->save();
            $data['query'][] = 'summaryVM';
            $data['query'][] = (string)$recordBalancesMashine->summary;

            $recordBalancesUser = CurrentBalances::find(1);
            $recordBalancesUser->summary = $recordBalancesUser->summary - $recordBD->price;
            $recordBalancesUser->save();
            $data['query'][] = 'summaryUser';
            $data['query'][] = (string)$recordBalancesUser->summary;


            $data['action'] = 'update';
            $data['message'] = 'Деньги успешно получены';
        }

        return $data;
    }

    public function initializeReturnMoney($request)
    {

        $data = [];

        $recordBalancesDeposited = CurrentBalances::find(3);
        $recordBalancesMashine = CurrentBalances::find(2);
        $recordBalancesUser = CurrentBalances::find(1);
        if($recordBalancesDeposited->summary == 0){
            $data['action'] = 'error';
            $data['message'] = 'Текущий баланс пуст, сдача не требуется';
        }else{
            // 39
            $ten = floor($recordBalancesDeposited->summary / 10);
            if($ten != 0){
                $recordBalancesDeposited->summary = $recordBalancesDeposited->summary - ($ten*10);

                $recordClientMoney = ClientMoney::find(1);
                $recordClientMoney->amount = $recordClientMoney->amount + $ten;
                $recordClientMoney->save();
                $data['query'][] = 'clientMoney1';
                $data['query'][] = 'Кол-во:'.$recordClientMoney->amount;
                $recordBalancesUser->summary = $recordBalancesUser->summary + ($ten*10);

                $recordMachineMoney = VendingMachineMoney::find(1);
                $recordMachineMoney->amount = $recordMachineMoney->amount - $ten;
                $recordMachineMoney->save();
                $data['query'][] = 'vendingMoney1';
                $data['query'][] = 'Кол-во:'.$recordMachineMoney->amount;
                $recordBalancesMashine->summary = $recordBalancesMashine->summary - ($ten*10);




            }


            $five = floor($recordBalancesDeposited->summary / 5);
            if($five != 0) {
                $recordBalancesDeposited->summary = $recordBalancesDeposited->summary - ($five * 5);
                $recordClientMoney = ClientMoney::find(2);
                $recordClientMoney->amount = $recordClientMoney->amount + $five;
                $recordClientMoney->save();
                $data['query'][] = 'clientMoney2';
                $data['query'][] = 'Кол-во:'.$recordClientMoney->amount;
                $recordBalancesUser->summary = $recordBalancesUser->summary + ($five * 5);

                $recordMachineMoney = VendingMachineMoney::find(2);
                $recordMachineMoney->amount = $recordMachineMoney->amount - $five;
                $recordMachineMoney->save();
                $data['query'][] = 'vendingMoney2';
                $data['query'][] = 'Кол-во:'.$recordMachineMoney->amount;
                $recordBalancesMashine->summary = $recordBalancesMashine->summary - ($five * 5);




            }


            $two = floor($recordBalancesDeposited->summary / 2);
            if($two != 0) {
                $recordBalancesDeposited->summary = $recordBalancesDeposited->summary - ($two * 2);
                $recordClientMoney = ClientMoney::find(3);
                $recordClientMoney->amount = $recordClientMoney->amount + $two;
                $recordClientMoney->save();
                $data['query'][] = 'clientMoney3';
                $data['query'][] = 'Кол-во:'.$recordClientMoney->amount;
                $recordBalancesUser->summary = $recordBalancesUser->summary + ($two * 2);

                $recordMachineMoney = VendingMachineMoney::find(3);
                $recordMachineMoney->amount = $recordMachineMoney->amount - $two;
                $recordMachineMoney->save();
                $data['query'][] = 'vendingMoney3';
                $data['query'][] = 'Кол-во:'.$recordMachineMoney->amount;
                $recordBalancesMashine->summary = $recordBalancesMashine->summary - ($two * 2);





            }

            $one = floor($recordBalancesDeposited->summary / 1);
            if($one != 0) {
                $recordBalancesDeposited->summary = $recordBalancesDeposited->summary - ($one * 1);
                $recordClientMoney = ClientMoney::find(4);
                $recordClientMoney->amount = $recordClientMoney->amount + $one;
                $recordClientMoney->save();
                $data['query'][] = 'clientMoney4';
                $data['query'][] = 'Кол-во:'.$recordClientMoney->amount;
                $recordBalancesUser->summary = $recordBalancesUser->summary + ($one * 1);


                $recordMachineMoney = VendingMachineMoney::find(4);
                $recordMachineMoney->amount = $recordMachineMoney->amount - $one;
                $recordMachineMoney->save();
                $data['query'][] = 'vendingMoney4';
                $data['query'][] = 'Кол-во:'.$recordMachineMoney->amount;
                $recordBalancesMashine->summary = $recordBalancesMashine->summary - ($one * 1);

            }

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

        }

        return $data;

    }


}
