@extends('main.layout')

@section('favicon')
    {{ Html::favicon( '/images/favicon.png' ) }}
@endsection

@section('title', __('mainMessage.VM'))

@section('style')
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
@endsection

@section('js')
    <script src= "{{ mix('js/app.js') }}"></script>
@endsection

@section('content')

    @include('main.blocks.content.block_left', ['products' => $products])
    @include('main.blocks.content.block_right', ['currentBalance' => $currentBalance, 'clientMoney' => $clientMoney, 'vendingMachineMoney' => $vendingMachineMoney])

@endsection