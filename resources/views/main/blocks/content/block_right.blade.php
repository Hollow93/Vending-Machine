<div id="block_right">
    @php($i = 1)
    <div class="sub_block_wallet">
        <div class="sub_block_inserted_coin">
            Ваши деньги:
            <span id="summaryUser">{{$currentBalance['Client money']}}</span>
        </div>
        <div id="sub_block_insert_button" class="sub_block_insert_button">
            <div id="sub_block_user_wallet">
                @foreach ($clientMoney as $money)
                    <div class="userWalletRow">{{ $money->price }} руб (<span id="clientMoney{{$i}}"
                                                                              class="count">Кол-во:{{ $money->amount }}</span>)
                        {{ Form::button('Внести',['id'=>"userBill".$i++])}}
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    @php($i = 1)
    <div class="sub_block_wallet">
        <div class="sub_block_inserted_coin">
            Деньги автомата:
            <span id="summaryVM">{{$currentBalance['Machine money']}}</span>
        </div>
        <div id="sub_block_vm_wallet" class="sub_block_vm_wallet">
            @foreach ($vendingMachineMoney as $money)
                <div class="vmWalletRow">{{ $money->price }} руб (<span id="vendingMoney{{$i++}}"
                                                                        class="count">Кол-во:{{ $money->amount }}</span>)
                    <br></div>
            @endforeach
        </div>
    </div>

    <div class="sub_block_coin">
        <div class="sub_block_inserted_coin">
            Внесенная сумма:
            <span id="summaryDeposited">{{$currentBalance['Amount deposited']}}</span>
        </div>
        <div id="sub_block_vm_wallet" class="sub_block_vm_wallet">
            <p>{{ Form::button('Сдача',['id'=>'change'])}}</p>
            <div id='msg'></div>

        </div>

    </div>
</div>