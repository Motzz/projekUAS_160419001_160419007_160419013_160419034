@extends('layout.conquere')

@section('content')

<div class="container">

<div class="portlet">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-reorder"></i> Tambah Data Medicine
        </div>
   
    </div>
    <div class="portlet-body form">
        <form method="POST" action="{{url('medicines')}}">
            @csrf
            <div class="form-body">
                  <div class="form-group">
                        <label for="exampleInputEmail1"> nama Obat</label>
                        <input type="text" class="form-control" placeholder="Masukkan nama obat" name="name" value="{{old('name','')}}">
                    </div>

                     <div class="form-group">
                        <label for="exampleInputEmail1"> Harga</label>
                        <input type="number" class="form-control" placeholder="Masukkan harga" name="price" value="{{old('price','')}}">
                    </div>

                     <div class="form-group">
                        <label for="exampleInputEmail1"> Form</label>
                        <input type="number" class="form-control" placeholder="Masukkan harga" name="form" value="{{old('form','')}}">
                    </div>
               
                        <div class="form-group">
                            <label for="title">Kategori</label>
                            <select class="form-control select2" style="width: 100%;" name="mKotaID">
                                    <option value="">--Pilih kategori--</option>
                                    @foreach($dataKategori as $key => $data)
                                    <option value="{{$data->id}}"{{$data->name == $data->id? 'selected' :'' }}>{{$data->name}}</option>
                                    @endforeach
                            </select>
                        </div>

                         <div class="form-group">
                            <label for="title">Supplier</label>
                            <select class="form-control select2" style="width: 100%;" name="mKotaID">
                                    <option value="">--Pilih Supplier--</option>
                                    @foreach($dataSupplier as $key => $data)
                                    <option value="{{$data->id}}"{{$data->name == $data->id? 'selected' :'' }}>{{$data->name}}</option>
                                    @endforeach
                            </select>
                        </div>

                       <div class="form-group">
                            <label for="title">Khusus</label><br>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="Khusus" value="1"{{'1' == old('Khusus','')? 'checked' :'' }}>
                                <label class="form-check-label" for="inlineRadio1">Ya</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="Khusus" value="0"{{'0'== old('Khusus','')? 'checked' :'' }}>
                                <label class="form-check-label" for="inlineRadio2">Tidak</label>
                            </div><br>
                        </div>
            <div class="form-actions">
                <input type="submit" class="btn btn-info">Submit</input>
            </div>
        </form>
    </div>
</div>
</div>
   

@endsection