@extends('layouts.master_dashboard')
@section('style-css')
    <style>
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
        }

        /* Firefox */
        input[type=number] {
        -moz-appearance: textfield;
        }
    </style>
@endsection
@section('content-wrapper')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-line-chart"></i>
            Tambah Sales Daily Report 
            <small>...</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> E-Perform</a></li>
            <li><a href="{{ URL::previous() }}">Sales Management</a></li>
            <li><a href="{{ URL::previous() }}">Sales Daily Report</a></li>
            <li class="active">Sales Daily Report Create</li>
        </ol>
        
    </section>

    <section class="content">
        
        <!-- Default box -->
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-plus-square"></i> Tambah Sales Daily Report</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                            title="Collapse">
                    <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                    <i class="fa fa-times"></i></button>
                </div>
            </div>

            <form class="form-sample" action="#" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-8">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="" for="">Tiket Invoice <span class="text-danger">*</span></label>
                                        <input id="tiket_report" type="text" class="form-control" name="tiket_report" required autocomplete="off" placeholder="" >
                                        
                                    </div>
                                </div>
        
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="" for="">Report By <span class="text-danger">*</span></label>
                                                    
                                        @if (Auth::user()->role == "admin")
                                            <select class="form-control select2" style="width: 100%;" name="id_user_rel" required>
                                                <option value selected disabled>Choise</option>
                                                @foreach ($data_user as $item)
                                                    <option value="{{$item->id}}">
                                                        {{$item->name}}
                                                        @if ($item->role == "admin")
                                                            (Admin)
                                                        @elseif ($item->role == "sales")
                                                            (Sales)
                                                        @endif
                                                    </option>
                                                @endforeach
        
                                                @if (Auth::user()->email == "setlightcombo@gmail.com")
                                                    <option value="{{Auth::user()->id}}">{{Auth::user()->name}} (Super Admin)</option>
                                                @endif
                                            </select>   
                                        @elseif (Auth::user()->role == "sales")
                                            <input id="id_user_rel" name="" type="text" class="form-control"required autocomplete="off" placeholder="" value="{{Auth::user()->name}}" readonly>
                                            <input type="hidden" name="id_user_rel" value="{{Auth::user()->id}}" required readonly  >
                                        @endif              
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="" for="">Select Client <span class="text-danger">*</span></label>
                                        <select class="form-control select2" style="width: 100%;" name="id_client_rel" required>
                                            <option value selected disabled>Choise</option>
                                            @foreach ($data_client as $item)
                                                <option value="{{$item->id}}">
                                                    {{$item->name_client}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
        
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="" for="">Select Capacity Bandwith <span class="text-danger">*</span></label>
                                        <select class="form-control select2" style="width: 100%;" name="id_client_rel" required>
                                            <option value selected disabled>Choise</option>
                                            @foreach ($data_capacity as $item)
                                                <option value="{{$item->id}}">
                                                    {{$item->bandwith_capacity}} {{$item->type_trasfer}} || Vendor By : {{$item->jnsvendor->name_vendor}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
        
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="" for="">Price From Me </label>
                                        <input id="price_capacity_fromme" type="text" class="form-control" name="price_capacity_fromme" autocomplete="off" placeholder="" readonly>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="" for="">Price From Vendor </label>
                                        <input id="price_capacity_vendor" type="text" class="form-control" name="price_capacity_vendor" autocomplete="off" placeholder="" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="" for="">Status Progrest </label>
                                            <select class="form-control pt-0 pb-0" id="status" name="status" style="height:35px;" required>
                                                <option value selected disabled>Choise</option>
                                                <option style="background-color: #FFCA2C;color:#000;" value="ocn">&#9201;&#65039; On Process NOC</option>
                                                <option style="background-color: #157347;color:#FFF;" value="solved">&#10004; Finish</option>
                                                <option style="background-color: #BB2D3B;color:#FFF;" value="n_solved">&#10006; Fail</option>
                                            </select>
                                    </div>
                                </div>

                            </div>
        
                            
                        </div>
                    </div>

                    <div class="col-md-4">
                                
                            <ul class="list-group" style="padding: 10px;">
                                <li class="list-group-item active "></li>

                                <li class="list-group-item">
                                    <div class="form-group">
                                        <label class="font-weight-bold" for="total_harga"> Harga Bandwith Tanpa PPN ( Rp. )</label>
                                        <input type="number" name="" class="form-control" id=""  placeholder="">      
                                    </div>

                                    <div class="form-group">
                                        <label for="biaya_antar">PPN ( % )</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" name="">
                                            <span class="input-group-addon">%</span>
                                        </div>
                                    </div>
                                </li>                                                  
                                <li class="list-group-item">
                                    <div class="form-group">
                                        <label class="font-weight-bold" for="exampleInputEmail1"> Total Harga + PPN ( Rp. )</label>
                                        <input type="number" name="" class="form-control" id=""  placeholder="" readonly autocomplete="off">
                                    </div>
                                </li>
                                
                            </ul>
                        
                    </div>
                </div>
                
                <!-- /.box-body -->

                <!-- /.box-footer -->
                <div class="box-footer">
                    <a href="{{ URL::previous() }}" class="btn btn-warning" ><i class="fa  fa-arrow-circle-left"></i> Back</a>
                    <button type="submit" class="btn btn-info"><i class="fa fa-save"></i> Save</button>
                </div>
            </form>
            
        </div>
        
        <!-- /.box -->
    </section>


    
@endsection

@push('select2')
    <script>
        $('.select2').select2()
    </script>
@endpush