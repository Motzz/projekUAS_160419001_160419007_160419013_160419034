
@extends('layouts.home_master')
<style>
            p {
                font-family: 'Nunito', sans-serif;
            }
 </style>

@section('judul')
Tambah Pulau
@endsection

@section('pathjudul')
<li class="breadcrumb-item"><a href="/home">Home</a></li>
<li class="breadcrumb-item">Master</li>
<li class="breadcrumb-item"><a href="{{route('medicines.index')}}">medicine</a></li>
<li class="breadcrumb-item active">Tambah</li>
@endsection

@section('content')
<div class="container-fluid">

<!-- Page Heading -->
<div class="card card-primary">
    <!-- form start -->
    <form action="{{route('medicines.store')}}" method="POST" enctype='multipart/form-data'>
        @csrf
        <div class="card-body">

                   <div class="form-group">
                        <label for="exampleInputEmail1"> Nama Obat</label>
                        <input type="text" class="form-control" placeholder="Masukkan nama obat" name="name" value="{{old('name','')}}">
                    </div>

                    <div class="form-group">
                            <label for="title">Kategori</label>
                            <select class="form-control select2" style="width: 100%;" name="kategori">
                                    <option value="">--Pilih kategori--</option>
                                    @foreach($kategori as $key => $data)
                                    <option value="{{$data->id}}"{{$data->name == $data->id? 'selected' :'' }}>{{$data->name}}</option>
                                    @endforeach
                            </select>
                    </div>

                     <div class="form-group">
                        <label for="exampleInputEmail1"> Harga</label>
                        <input type="number" class="form-control" placeholder="Masukkan harga" name="price" value="{{old('price','')}}">
                    </div>

                     <div class="form-group">
                        <label for="exampleInputEmail1"> Form</label>
                        <input type="text" class="form-control" placeholder="Masukkan Form" name="form" value="{{old('form','')}}">
                    </div>

                     <div class="form-group">
                        <label for="exampleInputEmail1"> Restriction Formula</label>
                        <input type="text" class="form-control" placeholder="Masukkan Formula" name="restriction_formula" value="{{old('restriction_formula','')}}">
                    </div>

                     <div class="form-group">
                        <label for="exampleInputEmail1"> Deskripsi</label>
                        <input type="text" class="form-control" placeholder="Masukkan Deskripsi" name="description" value="{{old('description','')}}">
                    </div>
               
                    <div class="form-group">
                        <label for="title">Faskes 1</label><br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="faskes1" value="1"{{'1' == old('faskes1','')? 'checked' :'' }}>
                            <label class="form-check-label" for="inlineRadio1">Ya</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="faskes1" value="0"{{'0'== old('faskes1','')? 'checked' :'' }}>
                            <label class="form-check-label" for="inlineRadio2">Tidak</label>
                        </div><br>
                    </div>

                    <div class="form-group">
                        <label for="title">Faskes 2</label><br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="faskes2" value="1"{{'1' == old('faskes2','')? 'checked' :'' }}>
                            <label class="form-check-label" for="inlineRadio1">Ya</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="faskes2" value="0"{{'0'== old('faskes2','')? 'checked' :'' }}>
                            <label class="form-check-label" for="inlineRadio2">Tidak</label>
                        </div><br>
                    </div>

                    <div class="form-group">
                        <label for="title">Faskes 3</label><br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="faskes3" value="1"{{'1' == old('faskes3','')? 'checked' :'' }}>
                            <label class="form-check-label" for="inlineRadio1">Ya</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="faskes3" value="0"{{'0'== old('faskes3','')? 'checked' :'' }}>
                            <label class="form-check-label" for="inlineRadio2">Tidak</label>
                        </div><br>
                    </div>

                    <div class="form-group">
                        <label for="logo">Gambar Obat</label>
                        <input type="file" class="form-control" id="exampleInputEmail1" placeholder="Enter text" name="gambarObat" id="gambarObat" >
                        
                    </div>
                    
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div>

@endsection
