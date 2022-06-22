@extends('layouts.home_master')
@if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif

@section('judul')
Products
@endsection

@section('pathjudul')
<li class="breadcrumb-item"><a href="/home">Home</a></li>
<li class="breadcrumb-item">Cart</li>
<li class="breadcrumb-item active">Products</li>
@endsection


@section('content')
@if(session("success"))
<div class="alert alert-success">
    {{session('success')}}
</div>
@endif


<div class="container products">

    <div class="row">
        @foreach($medicines as $p)
            <div class="col-xs-18 col-sm-6 col-md-3">
                <div class="thumbnail">
                    <img src="{{asset('/img/'.$p->urlGambar)}}" width="100px"alt="">
                    <div class="caption">
                        <h4>{{$p->generic_name }}
                            <nbsp>({{$p->form}})
                        </h4>
                        <p>formula: {{$p->restriction_formula}}</p>
                        <p>deskripsi: {{$p->description}}</p>

                        <!--CountTotalStol-->
                        @php
                        $totalstok = 0;
                        @endphp
                        @foreach($p->inventoryTransaction as $q)
                        @php
                        $totalstok += $q->jumlah;
                        @endphp
                        @endforeach
                        <!--/CountTotalStol-->

                        <p>total stok: <strong>{{$totalstok}}</strong></p>
                        <p><strong>Price: </strong>Rp.{{number_format($p->price,2)}}</p>

                        @if(Auth::check())
                            @if($totalstok <= 0)
                                <p class="btn-holder"><a href="{{url('add-to-cart/'.$p->id)}}" class="btn btn-warning btn-block text-center" role="button">Add to cart</a></p>
                            @endif
                        @endif

                    </div>
                </div>
            </div>
        @endforeach

    </div><!-- End row -->

</div>

<Script type="text/javascript">
$('body').on('click', '#btnAddtoCart', function() {
var totalStok = 0;
totalStok = {{$totalstok}};
alert(totalStok);
});
</Script>

@endsection




