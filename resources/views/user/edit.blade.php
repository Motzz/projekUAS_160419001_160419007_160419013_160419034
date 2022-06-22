@extends('layouts.home_master')
<style>
            p {
                font-family: 'Nunito', sans-serif;
            }
 </style>

@section('judul')
Edit User
@endsection

@section('pathjudul')
<li class="breadcrumb-item"><a href="/home">Home</a></li>
<li class="breadcrumb-item">Master</li>
<li class="breadcrumb-item"><a href="{{route('users.index')}}">Kategori Obat</a></li>
<li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<div class="container-fluid">

<!-- Page Heading -->
<div class="card card-primary">
    <!-- form start -->
    <form action="{{route('users.update', [$user->id])}}" method="POST" >
        @csrf
        @method('PUT')
        <div class="card-body">

            <div class="form-group">
                <label for="title">name</label>
                <input required type="text" name="name" maxlength="255" class="form-control" 
                value="{{old('name',$user->name)}}">
            </div>

            <div class="form-group">
                <label for="title">Email</label>
                <input required type="text" name="email" maxlength="255" class="form-control" 
                value="{{old('email',$user->email)}}">
            </div>

            <div class="form-group">
                <label for="title">Password</label>
                <input type="password" name="password" placeholder="Enter New Password (Optional)" maxlength="255" class="form-control" 
                >
                <small>Isikan untuk mengubah password</small>
            </div>
            
            <div class="form-group">
                <label>Role</label>
                <select class="form-control" name="role">
                    <option value="">-pilih role-</option>
                    @if($user->role == "admin")
                    <option selected value="admin">Admin</option>
                    <option value="buyer">Buyer</option>
                    @elseif($user->role == "buyer")
                    <option value="admin">Admin</option>
                    <option selected value="buyer">Buyer</option>
                    @else
                    <option value="admin">Admin</option>
                    <option value="buyer">Buyer</option>
                    @endif
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
