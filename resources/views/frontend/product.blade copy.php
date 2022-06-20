@extends('layouts.frontend')

@section('title', 'Products')

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
                    <img src="{{asset($p->urlGambar)}}" alt="">
                    <div class="caption">
                        <h4>{{$p->generic_name }}
                            <nbsp>({{$p->form}})
                        </h4>
                        <p>formula: {{$p->restriction_formula}}</p>
                        <p>deskripsi: {{$p->description}}</p>
                        <p><strong>Price: </strong>Rp.{{number_format($p->price,2)}}</p>
                        @if(Auth::user() != null)
                            <p class="btn-holder"><a href="{{url('add-to-cart/'.$p->id)}}" class="btn btn-warning btn-block text-center" role="button">Add to cart</a> </p>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach

    </div><!-- End row -->

</div>

@endsection