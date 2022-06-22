
@extends('layouts.home_master')
<style>
            p {
                font-family: 'Nunito', sans-serif;
            }
 </style>

@section('judul')
Edit Medicine
@endsection

@section('pathjudul')
<li class="breadcrumb-item"><a href="/home">Home</a></li>
<li class="breadcrumb-item">Master</li>
<li class="breadcrumb-item"><a href="{{route('medicines.index')}}">Medicine</a></li>
<li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<div class="container-fluid">

<!-- Page Heading -->
<div class="card card-primary">
    <!-- form start -->
    <form action="{{route('medicines.update',[$medicines->id])}}" method="POST" enctype='multipart/form-data'>
        @csrf
        @method('PUT')
        <div class="card-body">

                   <div class="form-group">
                        <label for="exampleInputEmail1"> Nama Obat</label>
                        <input type="text" class="form-control" placeholder="Masukkan nama obat" name="generic_name" value="{{old('name',$medicines->generic_name)}}">
                    </div>

                    <div class="form-group">
                            <label for="title">Kategori</label>
                            <select class="form-control select2" style="width: 100%;" name="kategori">
                                    <option value="">--Pilih kategori--</option>
                                    @foreach($kategori as $key => $data)
                                        @if($medicines->category_id == $data ->id )
                                         <option selected value="{{$data->id}}"{{$data->name == $data->id? 'selected' :'' }}>{{$data->name}}</option>
                                        @else
                                         <option value="{{$data->id}}"{{$data->name == $data->id? 'selected' :'' }}>{{$data->name}}</option>
                                        @endif
                                    @endforeach
                            </select>
                    </div>

                     <div class="form-group">
                        <label for="exampleInputEmail1"> Harga</label>
                        <input type="number" class="form-control" placeholder="Masukkan harga" name="price" value="{{old('price',$medicines->price)}}">
                    </div>

                     <div class="form-group">
                        <label for="exampleInputEmail1"> Form</label>
                        <input type="text" class="form-control" placeholder="Masukkan Form" name="form" value="{{old('form',$medicines->form)}}">
                    </div>

                     <div class="form-group">
                        <label for="exampleInputEmail1"> Restriction Formula</label>
                        <input type="text" class="form-control" placeholder="Masukkan Formula" name="restriction_formula" value="{{old('restriction_formula',$medicines->restriction_formula)}}">
                    </div>

                     <div class="form-group">
                        <label for="exampleInputEmail1"> Deskripsi</label>
                        <input type="text" class="form-control" placeholder="Masukkan Deskripsi" name="description" value="{{old('description',$medicines->description)}}">
                    </div>
               
                    <div class="form-group">
                        <label for="title">Faskes 1</label><br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="faskes1" value="1"{{'1' == old('faskes1',$medicines->faskes1)? 'checked' :'' }}>
                            <label class="form-check-label" for="inlineRadio1">Ya</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="faskes1" value="0"{{'0'== old('faskes1',$medicines->faskes1)? 'checked' :'' }}>
                            <label class="form-check-label" for="inlineRadio2">Tidak</label>
                        </div><br>
                    </div>

                    <div class="form-group">
                        <label for="title">Faskes 2</label><br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="faskes2" value="1"{{'1' == old('faskes2',$medicines->faskes2)? 'checked' :'' }}>
                            <label class="form-check-label" for="inlineRadio1">Ya</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="faskes2" value="0"{{'0'== old('faskes2',$medicines->faskes2)? 'checked' :'' }}>
                            <label class="form-check-label" for="inlineRadio2">Tidak</label>
                        </div><br>
                    </div>

                    <div class="form-group">
                        <label for="title">Faskes 3</label><br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="faskes3" value="1"{{'1' == old('faskes3',$medicines->faskes3)? 'checked' :'' }}>
                            <label class="form-check-label" for="inlineRadio1">Ya</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="faskes3" value="0"{{'0'== old('faskes3',$medicines->faskes3)? 'checked' :'' }}>
                            <label class="form-check-label" for="inlineRadio2">Tidak</label>
                        </div><br>
                    </div>

                    <div class="form-group">
                        <label for="logo">Gambar Obat</label>
                        <input type="file" class="form-control" id="exampleInputEmail1" placeholder="Enter text" name="gambarObat" id="gambarObat"
                         accept="image/png, image/jpeg,image/jpg">
                         <br>
                        <img src="{{asset('/img/'.$medicines->urlGambar)}}" alt='' width='100'>
                        @error('image')
                            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                    
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div>

@endsection
