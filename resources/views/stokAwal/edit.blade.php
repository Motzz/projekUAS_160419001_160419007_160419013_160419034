
@extends('layouts.home_master')
<style>
            p {
                font-family: 'Nunito', sans-serif;
            }
 </style>

@section('judul')
Edit Stok Obat
@endsection

@section('pathjudul')
<li class="breadcrumb-item"><a href="/home">Home</a></li>
<li class="breadcrumb-item">Master</li>
<li class="breadcrumb-item"><a href="{{route('stokAwal.index')}}">Stok Awal</a></li>
<li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<div class="container-fluid">

<!-- Page Heading -->
<div class="card card-primary">
    <!-- form start -->
    <form action="{{route('stokAwal.update',[$stokAwal->id])}}" method="POST" enctype='multipart/form-data'>
        @csrf
        @method('PUT')
        <div class="card-body">

        <div class="form-group">
                <label for="exampleInputEmail1"> Nama</label>
                <input readonly type="text" class="form-control" value="{{$stokAwal->name}}">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Tanggal</label><br>
                <input name="tanggalDibuat" readonly type="date" class="form-control" id="tanggalDibuat" placeholder="" required="" value="{{date('Y-m-d')}}">
            </div>

            <div class="form-group">
                <label for="title">Obat</label>
                <select class="form-control select2" style="width: 100%;" name="medicine">
                        <option value="">--Pilih Obat--</option>
                        <option selected value="{{$stokAwal->medicine->id}}"{{$stokAwal->medicine->generic_name == $stokAwal->medicine->id? 'selected' :'' }}>{{$stokAwal->medicine->generic_name}}<nbsp>({{$stokAwal->medicine->form}})</option>
                        @foreach($medicine as $key => $data)
                         <option value="{{$data->id}}"{{$data->generic_name == $data->id? 'selected' :'' }}>{{$data->generic_name}}<nbsp>({{$data->form}})</option>
                        @endforeach   
                </select>
            </div>

            
                <div class="form-group">
                <label for="exampleInputEmail1"> Jumlah</label>
                <input type="number" class="form-control" placeholder="Masukkan Jumlah" name="jumlah" value="{{old('jumlah',$stokAwal->jumlah)}}">
            </div>

                <div class="form-group">
                <label for="exampleInputEmail1"> Deskripsi</label>
                <input type="text" class="form-control" placeholder="Masukkan Deskripsi" name="description" value="{{old('description',$stokAwal->description)}}">
            </div>
                    
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div>

@endsection
