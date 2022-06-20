
<div class="row">
<div class="col-lg-12 col-sm-12 col-12 main-section">
    <div class="dropdown">
        @if(session('cart'))
            @php
            $totalHarga = 0;
            $totalBarang = 0;
            @endphp


            @foreach(session('cart') as $id=>$details)
                @php
                $totalHarga += $details['price'] * $details['quantity'];
                $totalBarang += 1;
                @endphp
            @endforeach
        @endif
        <button type="button" class="btn btn-info" data-toggle="dropdown">
        @if(Auth::user() != null)
            <i class="fa fa-shopping-cart" aria-hidden="true"></i> Cart 
        @endif
            <span class="badge badge-pill badge-danger">
                @isset($totalBarang)
                {{$totalBarang}}
                @endisset
            </span>
        </button>
        <div class="dropdown-menu">

            @if(session('cart'))
            @foreach(session('cart') as $id=>$details)

            <div class="row cart-detail">
                <div class="col-lg-4 col-sm-4 col-4 cart-detail-img">
                    <img height="50px" src="{{url('assets/images/'.$details['photo'])}}">
                </div>
                <div class="col-lg-8 col-sm-8 col-8 cart-detail-product">
                    <p>{{$details['name']}}</p>
                    <span class="price text-info"> Rp.{{number_format($details['price'],2)}}</span> <span class="count"> Quantity:{{$details['quantity']}}</span>
                </div>
            </div>
            @endforeach
            @endif
            <div class="row total-header-section">
                <div class="col-lg-6 col-sm-6 col-6">
                    <i class="fa fa-shopping-cart" aria-hidden="true"></i> <span class="badge badge-pill badge-danger">
                        @isset($totalBarang)
                        {{$totalBarang}}
                        @endisset</span>
                </div>
                <div class="col-lg-6 col-sm-6 col-6 total-section text-right">
                    <p>Total: <span class="text-info">
                            @isset($totalBarang)
                            {{$totalBarang}}Rp.{{number_format($totalHarga,2)}}
                            @endisset</span></p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-sm-12 col-12 text-center checkout">
                    <a href="{{ url('checkout') }}" class="btn btn-primary btn-block">View all</a>
                </div>
            </div>
        </div>
    </div>
</div>
</div>