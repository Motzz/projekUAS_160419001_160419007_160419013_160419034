
@extends('layouts.home_master')
<style>
            p {
                font-family: 'Nunito', sans-serif;
            }
 </style>

@section('judul')
Edit Adjustment Stock
@endsection

@section('pathjudul')
<li class="breadcrumb-item"><a href="/home">Home</a></li>
<li class="breadcrumb-item">Master</li>
<li class="breadcrumb-item"><a href="{{route('adjustmentStok.index')}}">Adjustment Stock</a></li>
<li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<div class="container-fluid">

<!-- Page Heading -->
<div class="card card-primary">
    <!-- form start -->
    <form action="{{route('adjustmentStok.store')}}" method="POST" enctype='multipart/form-data'>
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="form-group">
                <label for="lastName">Tanggal Pembuatan</label>
                <input required name="tanggalDibuat" type="date" class="form-control" id="tanggalDibuat" placeholder="" required="" value="{{$AdjustmentStok->tanggalPembuatan}}">
                <!--<div class="invalid-feedback"> Valid last name is required. </div>-->
            </div>

            <div class="form-group">
                <label for="title">Medicines</label>
                <select required class="form-control select2" style="width: 100%;" name="medicine">
                    <option value="">--Pilih Medicine--</option>
                    @foreach($medicine as $key => $data)
                    @if($AdjustmentStok->medicines_id)
                        <option selected value="{{$data->id}}"{{$data->generic_name == $data->id? 'selected' :'' }}>{{$data->generic_name}}<nbsp>({{$data->form}})</option>
                    @else
                        <option value="{{$data->id}}"{{$data->generic_name == $data->id? 'selected' :'' }}>{{$data->generic_name}}<nbsp>({{$data->form}})</option>
                    @endif
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="title">Jumlah Stok Barang Awal</label>
                <input readonly type="number"  min="0" id="stokAwalBarang" name="QuantityAwal" class="form-control" value="{{old('QuantityAwal',$AdjustmentStok->QuantityAwal)}}">
            </div>

            <div class="form-group">
                <label for="title">Jumlah Stok Barang Baru</label>
                <input required type="number"  min="0" name="QuantityBaru" class="form-control" value="{{old('QuantityBaru',$AdjustmentStok->QuantityBaru)}}">
            </div>

            <div class="form-group">
                <label for="title">Deskripsi</label>
                <input required type="text" name="description" class="form-control" value="{{old('description',$AdjustmentStok->description)}}" maxlength="500">
            </div>
                    
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div>


<script>
    $(document).ready(function() {
        $("#medicine").on("change", function() {
            var id = this.value;
            if (id == "pilih" || id == "") {
                $("#stokAwalBarang").val("");

            } else {
                var total = 0;

                var dataReport = <?php echo json_encode($medicine); ?>;            

                $.each(dataReport, function(key, value) {
                    if (value.id.toString() == id.toString()) {
                        $.each(value.inventoryTransaction, function(k, v) {
                            total = total + parseFloat(value.jumlah);
                        });
                    }
                });
                $("#stokAwalBarang").val(total);
            }

        });
    });
</script>
@endsection
