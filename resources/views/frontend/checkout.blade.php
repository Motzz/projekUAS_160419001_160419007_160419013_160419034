@extends('layouts.home_master')
@if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif

@section('judul')
Keranjang
@endsection

@section('pathjudul')
<li class="breadcrumb-item"><a href="/home">Home</a></li>
<li class="breadcrumb-item">Master</li>
<li class="breadcrumb-item active">User</li>
@endsection

<form action="{{route('transaction.store')}}" method="POST" >
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Hasil Keranajng</h3>                  
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                   <table id="cart" class="table table-hover table-condensed">
                        <thead>
                            <tr>
                        
                                <th style="width:50%">Product</th>
                                <th style="width:10%">Price</th>
                                <th style="width:8%">Quantity</th>
                                <th style="width:8%">Handle</th>
                                <th style="width:22%" class="text-center">Subtotal</th>
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
                                @if(isset($details['hapus']))
                                    @if($details['hapus'] == 0)
                                    @php
                                    $totalHarga += $details['price'] * $details['quantity'];
                                    $totalBarang += 1;
                                    @endphp

                                    
                                    <tr>
                                        <input type="hidden" name="medicine[]" value="{{$details['idMedicine']}}">
                                        <input type="hidden" name="price[]" value="{{$details['price']}}">
                                        <input type="hidden" name="quantity[]" value="{{$details['quantity']}}">
                                        <td data-th="Product">
                                            <div class="row">
                                                <div class="col-sm-3 hidden-xs"><img height="50px" src="{{asset('img/'.$details['photo'])}}" /></div>
                                                <div class="col-sm-9">
                                                    <h4 class="nomargin">{{$details['name']}}</h4>
                                                </div>
                                            </div>
                                        </td>
                                        <td data-th="Price">Rp.{{number_format($details['price'],2)}}</td>
                                        <td data-th="Quantity">{{$details['quantity']}}</td>
                                        <td data-th="Handle">   
                                            
                                            <p class="btn-holder"><h4><a href="{{url('add-to-cart/'.$id)}}" class="btn btn-info btn-block text-center" role="button">+</a></h4></p> 
                                            <p class="btn-holder"><h4><a href="{{url('min-to-cart/'.$id)}}" class="btn btn-warning btn-block text-center" role="button">-</a></h4></p>
                                        </td>
                                        <td data-th="Subtotal" class="text-center">Rp. {{number_format($details['price'] * $details['quantity'],2)}}</td>
                                    </tr>
                                    @endif
                                @endif
                            @endforeach
                        </tbody>
                        <tfoot>
                        <tr class="visible-xs">
                            <td colspan='4'>Total :</td>
                            <td colspan='3' class="text-center" >Rp.{{number_format($totalHarga,2)}}</td>
                        </tr>
                        <tr>
                            <td colspan='4'>
                                @isset($totalBarang)
                                @if($totalBarang > 0)
                                <!-- <a href="{{ url('/') }}" class="btn btn-warning">Continue Shopping</a>-->
                                <button type="submit" class="btn btn-warning"><i class="fa fa-angle-left"></i> CheckOut and Continue Shopping</button>
                                @endif
                                @endisset       
                            </td>
                            
                        </tr>
                        </tfoot>
                        
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</div>
</form>
@endsection







