@extends('layouts.home_master')
@if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif

@section('judul')
Data Transaction
@endsection

@section('pathjudul')
<li class="breadcrumb-item"><a href="/home">Home</a></li>
<li class="breadcrumb-item">Transaction</li>
<li class="breadcrumb-item active">Data Transaction </li>
@endsection


@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Transaction</h3> 
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                             <tr>
                              <th scope="col">#</th>
                              <th scope="col">Name</th>
                              <th scope="col">Transaction Date</th>
                              <th scope="col">Total Price</th>
                              <th scope="col">Pembeli</th>
                              <th scope="col">Handle</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($result as $key => $d)            
                            <tr>             
                                <td>{{$d->id}}</td>
                                <td>{{$d->name}}</td>
                                <td>{{$d->transaction_date}}</td>
                                <td>{{$d->total}}</td>
                                <td>{{$d->user->name}}</td>
                                <td>
                                    <!--Buat tombol show atau lihat notanya ke detail-->

                                </td>

                            </tr>
                            @endforeach
                        </tbody>

                        <tfoot>
                            <tr>
                            <th scope="col">#</th>
                              <th scope="col">Name</th>
                              <th scope="col">Transaction Date</th>
                              <th scope="col">Total Price</th>
                              <th scope="col">Pembeli</th>
                              <th scope="col">Handle</th>
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
@endsection


