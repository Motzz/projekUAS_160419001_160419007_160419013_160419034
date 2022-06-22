
@extends('layouts.home_master')
<style>
            p {
                font-family: 'Nunito', sans-serif;
            }
 </style>

@section('judul')
Tambah Stok Awal Barang
@endsection

@section('pathjudul')
<li class="breadcrumb-item"><a href="/home">Home</a></li>
<li class="breadcrumb-item">Master</li>
<li class="breadcrumb-item"><a href="{{route('stokAwal.index')}}">Stok Awal</a></li>
<li class="breadcrumb-item active">Tambah Stok Awal Barang</li>
@endsection

@section('content')
<div class="container-fluid">

<!-- Page Heading -->
<div class="card card-primary">
    <!-- form start -->
    <form action="{{route('stokAwal.store')}}" method="POST" enctype='multipart/form-data'>
        @csrf
        <div class="card-body">

        <div class="form-group">
                        <label for="exampleInputEmail1">Tanggal</label><br>
                        <input name="tanggalDibuat" disabled type="date" class="form-control" id="tanggalDibuat" placeholder="" required="" value="{{date('Y-m-d')}}">
                    </div>
                    <div class="form-group">
                            <label for="title">Obat</label>
                            <select class="form-control select2" style="width: 100%;" name="medicine">
                                    <option value="">--Pilih Obat--</option>
                                    @foreach($medicine as $key => $data)
                                    <option value="{{$data->id}}"{{$data->generic_name == $data->id? 'selected' :'' }}>{{$data->generic_name}}<nbsp>({{$data->form}})</option>
                                    @endforeach
                            </select>
                    </div>

                    

                     <div class="form-group">
                        <label for="exampleInputEmail1"> Jumlah</label>
                        <input type="number" class="form-control" placeholder="Masukkan Jumlah" name="jumlah" value="{{old('jumlah','')}}">
                    </div>

                     <div class="form-group">
                        <label for="exampleInputEmail1"> Deskripsi</label>
                        <input type="text" class="form-control" placeholder="Masukkan Deskripsi" name="description" value="{{old('description','')}}">
                    </div>
                    
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div>

@endsection
