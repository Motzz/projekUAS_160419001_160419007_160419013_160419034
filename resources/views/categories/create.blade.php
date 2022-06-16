@extends('layouts.home_master')
<style>
            p {
                font-family: 'Nunito', sans-serif;
            }
 </style>

@section('judul')
Tambah Menu
@endsection

@section('pathjudul')
<li class="breadcrumb-item"><a href="/home">Home</a></li>
<li class="breadcrumb-item">Master</li>
<li class="breadcrumb-item"><a href="{{route('categories.index')}}">Kategori Obat</a></li>
<li class="breadcrumb-item active">Tambah</li>
@endsection

@section('content')
<div class="container-fluid">

<!-- Page Heading -->
<div class="card card-primary">
    <!-- form start -->
    <form action="{{route('categories.store')}}" method="POST" >
        @csrf
        <div class="card-body">

            <div class="form-group">
                <label for="title">name</label>
                <input required type="text" name="name" maxlength="255" class="form-control" 
                value="{{old('name','')}}">
            </div>
            <div class="form-group">
                <label for="title">description</label>
                <input required type="text" name="description" maxlength="255" class="form-control" 
                value="{{old('description','')}}" >
            </div>

        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div>

@endsection
