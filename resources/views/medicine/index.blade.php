@extends('layouts.home_master')
@if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif

@section('judul')
Medicine
@endsection

@section('pathjudul')
<li class="breadcrumb-item"><a href="/home">Home</a></li>
<li class="breadcrumb-item">Master</li>
<li class="breadcrumb-item active">Medicine</li>
@endsection


@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Medicines </h3> 
                    <a href="{{route('medicines.create')}}" class="btn btn-primary btn-responsive float-right">Tambah Medicines
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle-fill" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z"/>
                        </svg>
                    </a> 
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                             <tr>
                              <th scope="col">#</th>
                              <th scope="col">Nama</th>
                              <th scope="col">Harga</th>
                              <th scope="col">restriction formula</th>
                              <th scope="col">description</th>
                              <th scope="col">Foto</th>
                              <th scope="col">Kategori</th>
                              <th scope="col">Handle</th>
                            </tr>
                          </thead>
                        <tbody>
                             @foreach($result as $key => $d)            
                             <tr>
                                <th>{{$d->id}}</th>
                                <td>{{$d->generic_name}}</td>  
                                <td>{{$d->price}}</td>
                                <td>{{$d->restriction_formula}}</td>
                                <td>{{$d->description}}</td>
                                <td><img src="{{asset('/img/'.$d->urlGambar)}}" height="50px" alt=""></td>
                                @foreach($kategori as $katego)
                                    @if($katego->id==$d->category_id)
                                    <td>{{$katego->name}}</td>
                                    @endif
                                @endforeach
                                <td>

                                <a class="btn btn-default bg-info" href="{{route('medicines.edit',[$d->id])}}">
                                        <i class="fas fa-edit"></i>
                                    </a> 

                                 

                                     <button type="button" class="btn btn-default bg-danger" data-toggle="modal" data-target="#delete_{{$d->id}}">
                                     <i class="fas fa-trash"></i> 
                                    </button>
                                </td>
                                
                                    

                                <div class="modal fade" id="delete_{{$d->id}}">
                                <div class="modal-dialog">
                                    <div class="modal-content">

                                        <div class="modal-header">
                                            <h4 class="modal-title">Konfirmasi</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button> 
                                        </div>
                                        
                                        <div class="modal-body">
                                                Apakah anda yakin mau menghapus  "{{$d->generic_name}}"
                                        </div>
                                    
                                        <div class="modal-footer justify-content-between">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Tidak</button>
                                                <form action="{{route('medicines.destroy',[$d->id])}}" method="POST" class="btn btn-responsive">
                                                @csrf
                                                @method('DELETE')
                                                <button action="{{route('medicines.destroy',[$d->id])}}" class="btn btn-default bg-danger">
                                                    Hapus
                                                </button>
                                                @csrf
                                            </form> 
                                        </div>
                                        
                                    </div>
                                <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                                </div>
                                 
                                     
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                              <th scope="col">#</th>
                              <th scope="col">Nama</th>
                              <th scope="col">Harga</th>
                              <th scope="col">restriction formula</th>
                              <th scope="col">description</th>
                              <th scope="col">Foto</th>
                              <th scope="col">Kategori</th>
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


