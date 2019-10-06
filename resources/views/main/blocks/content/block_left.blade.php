<div id="block_left">
    @php($i = 1)
    @foreach ($products as $product)
        <div class="viewblock">
            <div class="item_slot center padbottom">
                <img src="{{asset($product->image_url)}}" class="rounded" alt="...">
            </div>
            <div class="center padbottom">
                {{ $product->name }}<br/>
                <span class="item_amount" id="productAmount{{$i}}"> Кол-во:{{ $product->amount }}</span><br/>
                Цена {{ $product->price }} руб.
            </div>
            <div class="center padbottom">
                {{ Form::button('Купить',['id'=>"product".$i++])}}
            </div>
        </div>
    @endforeach

</div>