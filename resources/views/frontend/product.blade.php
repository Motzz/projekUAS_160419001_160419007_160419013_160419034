@extends('layouts.home_master')
@if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif

@section('judul')
Products
@endsection

@section('pathjudul')
<li class="breadcrumb-item"><a href="/home">Home</a></li>
<li class="breadcrumb-item">Cart</li>
<li class="breadcrumb-item active">Products</li>
@endsection


@section('content')
@if(session("success"))
<div class="alert alert-success">
    {{session('success')}}
</div>
@endif


<div class="container products">

    <div class="row">
        @foreach($medicines as $p)
            <div class="col-xs-18 col-sm-6 col-md-3">
                <div class="thumbnail">
                    <img src="{{asset('/img/'.$p->urlGambar)}}" width="100px"alt="">
                    
                    <div class="caption">
                        <h4>{{$p->generic_name }}
                            <nbsp>({{$p->form}})
                        </h4>
                        <p>formula: {{$p->restriction_formula}}</p>
                        <p>deskripsi: {{$p->description}}</p>

                        <!--CountTotalStol-->
                        @php
                        $totalstok = 0;
                        @endphp
                            @foreach($dataReport as $q)
                                @if($q->medicines_id == $p->id)
                                    @php
                                    $totalstok += $q->jumlah;
                                    @endphp
                                @endif
                            @endforeach
                        <!--/CountTotalStol-->

                        <p>total stok: <strong>{{$totalstok}}</strong></p>
                        <p><strong>Price: </strong>Rp.{{number_format($p->price,2)}}</p>
                         <button type="button" class="btn btn-default bg-info" data-toggle="modal" data-target="#detail_{{$p->id}}">
                            <i class="fas fa-eye"></i> 
                        </button>

                        @if(Auth::check())
                            @if($totalstok < 1)
                                <p class="btn-holder"><button disabled class="btn btn-danger btn-block text-center" role="button">Out Of Stock!</button></p>
                            @else
                                <p class="btn-holder"><a href="{{url('add-to-cart/'.$p->id)}}" class="btn btn-warning btn-block text-center" role="button">Add to cart</a></p>
                            @endif
                        @endif

                    </div>
                       
                        <div class="modal fade" id="detail_{{$p->id}}">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Detail Product</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button> 
                                    </div>
                                    <div class="modal-body">
                                           <img src="{{asset('/img/'.$p->urlGambar)}}" width="100px"alt="">
                                            <h4>{{$p->generic_name }}
                                                <nbsp>({{$p->form}})
                                            </h4>
                                            <p>formula: {{$p->restriction_formula}}</p>
                                            <p>deskripsi: {{$p->description}}</p>
                                             @php
                                            $totalstok = 0;
                                            @endphp
                                                @foreach($dataReport as $q)
                                                    @if($q->medicines_id == $p->id)
                                                        @php
                                                        $totalstok += $q->jumlah;
                                                        @endphp
                                                    @endif
                                                @endforeach
                                            <!--/CountTotalStol-->

                                            <p>total stok: <strong>{{$totalstok}}</strong></p>
                                            <p><strong>Price: </strong>Rp.{{number_format($p->price,2)}}</p>
                                            <p>Kategori Obat :
                                                 @foreach($kategor as $k)
                                                    @if($k->id == $p->category_id)
                                                       {{$k->name}}
                                                    @endif
                                                @endforeach
                                            </p>
                                            <p>Faskes 1 :
                                            
                                                @if( $p->faskes1 == 1)
                                                    ya
                                                @else
                                                    Tidak
                                                @endif
                                              
                                            </p>
                                             <p>Faskes 2 :
                                            
                                                @if( $p->faskes2 == 1)
                                                    ya
                                                @else
                                                    Tidak
                                                @endif
                                              
                                            </p>
                                             <p>Faskes 3 :
                                            
                                                @if( $p->faskes3 == 1)
                                                    ya
                                                @else
                                                    Tidak
                                                @endif
                                              
                                            </p>

                                    </div>
                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>

                </div>
            </div>
        @endforeach

    </div><!-- End row -->

</div>

<Script type="text/javascript">

</Script>

@endsection




