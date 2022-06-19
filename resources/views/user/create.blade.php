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
<li class="breadcrumb-item"><a href="{{route('users.index')}}">User</a></li>
<li class="breadcrumb-item active">Tambah</li>
@endsection

@section('content')
<div class="container-fluid">

<!-- Page Heading -->
<div class="card card-primary">
    <!-- form start -->
    <form action="{{route('users.store')}}" method="POST" >
        @csrf
        <div class="card-body">

            <div class="form-group">
                <label for="title">name</label>
                <input required type="text" name="name" maxlength="255" class="form-control" 
                value="{{old('name','')}}">
            </div>

            <div class="form-group">
                <label for="title">email</label>
                <input required type="email" name="email" maxlength="255" class="form-control" 
                value="{{old('email','')}}" >
            </div>

            <div class="form-group">
                <label for="title">password</label>
                <input required type="password" name="password" maxlength="255" class="form-control" 
                value="{{old('password','')}}" >
            </div>
            
            <div class="form-group">
                        <label>Role</label>
                        <select class="form-control" name="id_role">
                            <option>-pilih role-</option>
                            <option>Admin</option>
                            <option>Buyer</option>
                        </select>
            </div>

        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div>

@endsection
