@extends('layouts.frontend')

@section('title', 'Cart')

@section('content')

<table id="cart" class="table table-hover table-condensed">
    <thead>
        <tr>
            <th style="width:50%">Product</th>
            <th style="width:10%">Price</th>
            <th style="width:8%">Quantity</th>
            <th style="width:22%" class="text-center">Subtotal</th>
            <th style="width:10%"></th>
        </tr>
    </thead>
    <tbody>

        @if(session('cart'))
        @php
        $totalHarga = 0;
        $totalBarang = 0;
        @endphp
        @endif

        @foreach(session('cart') as $id=>$details)
        @php
        $totalHarga += $details['price'] * $details['quantity'];
        $totalBarang += 1;
        @endphp


        <tr>
            <td data-th="Product">
                <div class="row">
                    <div class="col-sm-3 hidden-xs"><img height="50px" src="{{url('assets/images/'.$details['photo'])}}" /></div>
                    <div class="col-sm-9">
                        <h4 class="nomargin">{{$details['name']}}</h4>
                    </div>
                </div>
            </td>
            <td data-th="Price">Rp.{{number_format($details['price'],2)}}</td>
            <td data-th="Quantity">
                {{$details['quantity']}}
            </td>
            <td data-th="Subtotal" class="text-center">Rp. {{number_format($details['price'] * $details['quantity'],2)}}</td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr class="visible-xs">
            <td colspan="3"></td>
            <td style="text-align:right" ><strong>Rp.{{number_format($totalHarga,2)}}</strong></td>
        </tr>
    </tfoot>
</table>

@endsection