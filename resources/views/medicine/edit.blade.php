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
<li class="breadcrumb-item"><a href="{{route('categories.index')}}">Obat</a></li>
<li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<div class="container-fluid">

<!-- Page Heading -->
<div class="card card-primary">
    <!-- form start -->
    <form action="{{route('medicines.update', [$medicines->id])}}" method="POST" >
         @csrf
        @method('PUT')
        <div class="card-body">

            <div class="form-group">
                <label for="title">name</label>
                <input required type="text" name="name" maxlength="255" class="form-control" 
                value="{{old('name',$medicines->generic_name)}}">
            </div>
            <div class="form-group">
                <label for="title">price</label>
                <input required type="text" name="description" maxlength="255" class="form-control" 
                value="{{old('price',$categories->price)}}">
            </div>
            <div class="form-group">
                <label for="title">form</label>
                <input required type="text" name="name" maxlength="255" class="form-control" 
                value="{{old('name',$medicines->form)}}">
            </div>
            <div class="form-group">
                <label for="title">restriction form</label>
                <input required type="text" name="name" maxlength="255" class="form-control" 
                value="{{old('name',$medicines->restriction_form)}}">
            </div>
            <div class="form-group">
                <label for="title">description</label>
                <input required type="text" name="name" maxlength="255" class="form-control" 
                value="{{old('description',$medicines->description)}}">
            </div>

        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div>

@endsection
