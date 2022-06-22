@extends('layouts.home_master')
@if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif

@section('judul')
Medicine Terlaris
@endsection

@section('pathjudul')
<li class="breadcrumb-item"><a href="/home">Home</a></li>
<li class="breadcrumb-item">Report</li>
<li class="breadcrumb-item active">Medicine Terlaris</li>
@endsection


@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Medicine Terlaris</h3> 
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                             <tr>
                              <th scope="col">#</th>
                              <th scope="col">Nama</th>
                              <th scope="col">Harga</th>
                              <th scope="col">Formula</th>
                              <th scope="col">Restriction Formula</th>
                              <th scope="col">Description</th>
                              <th scope="col">Faskes 1</th>
                              <th scope="col">Faskes 2</th>
                              <th scope="col">Faskes 3</th>
                              <th scope="col">Foto </th>
                              <th scope="col">Kategori</th>
                              <th scope="col">Quantity</th>
                            </tr>
                          </thead>
                        <tbody>
                             @foreach($result as $key => $d)            
                             <tr>
                                <th>{{$d->id}}</th>
                                <td>{{$d->generic_name}}</td>  
                                <td>{{$d->price}}</td>
                                <td>{{$d->form}}</td>
                                <td>{{$d->restriction_formula}}</td>
                                <td>{{$d->description}}</td>
                                @if($d->faskes1==0)
                                <td>Tidak</td>
                                @elseif($d->faskes1==1)
                                <td>Ya</td>
                                @endif
                                
                                @if($d->faskes2==0)
                                <td>Tidak</td>
                                @elseif($d->faskes2==1)
                                <td>Ya</td>
                                @endif
                                
                                
                                @if($d->faskes3==0)
                                <td>Tidak</td>
                                @elseif($d->faskes3==1)
                                <td>Ya</td>
                                @endif

                                <td><img src="{{asset('/img/'.$d->urlGambar)}}" height="30px" alt=""></td>
                                @foreach($category as $katego)
                                    @if($katego->id==$d->category_id)
                                    <td>{{$katego->name}}</td>
                                    @endif
                                @endforeach
                                <td>{{$d->Quantity * -1}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                              <th scope="col">#</th>
                              <th scope="col">Nama</th>
                              <th scope="col">Harga</th>
                              <th scope="col">Formula</th>
                              <th scope="col">Restriction Formula</th>
                              <th scope="col">Description</th>
                              <th scope="col">Faskes 1</th>
                              <th scope="col">Faskes 2</th>
                              <th scope="col">Faskes 3</th>
                              <th scope="col">Foto </th>
                              <th scope="col">Kategori</th>
                              <th scope="col">Quantity</th>
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


