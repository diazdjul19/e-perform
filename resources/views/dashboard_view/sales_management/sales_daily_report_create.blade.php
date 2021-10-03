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
                                        <label class="" for="id_capacity_rel">Select Capacity Bandwith <span class="text-danger">*</span></label>
                                        <select class="form-control select2" style="width: 100%;" id="id_capacity_rel" name="id_capacity_rel" required>
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
                                        <input id="capacity_fromme" type="text" class="form-control" name="price_capacity_fromme" autocomplete="off" placeholder="" readonly >
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="" for="">Price From Vendor </label>
                                        <input id="capacity_vendor" type="text" class="form-control" name="price_capacity_vendor" autocomplete="off" placeholder="" readonly >
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
                                        <input type="text" name="profit_no_ppn" class="form-control" id="id_profit_noppn" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');"  placeholder="">      
                                    </div>

                                    <div class="form-group">
                                        <label for="biaya_antar">PPN ( % )</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" name="ppn_percentage" id="id_ppn" value="0">
                                            <span class="input-group-addon">%</span>
                                        </div>
                                    </div>
                                </li>                                                  
                                <li class="list-group-item">
                                    <div class="form-group">
                                        <label class="font-weight-bold" for="exampleInputEmail1"> Total Harga + PPN ( Rp. )</label>
                                        <input type="text" name="subtotal_plus_ppn" class="form-control" id="id_profit_plusppn" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');"  placeholder="" readonly autocomplete="off">
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



@push('autocomplate-ajax')
    <script>
        $('#id_capacity_rel').on('change', function(){
            var id = $(this).children('option:selected').val();

            $.ajax({
            url: '/salesdaily-getprice-capacit',
            method : 'get',
            type : 'json',
            data: {
                id: id
            },
            success: function (response) {
                // console.log(response);
                var capacity_fromme = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(response.price_capacity_fromme);
                $('#capacity_fromme').val(capacity_fromme);
                
                var capacity_vendor = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(response.price_capacity_vendor);
                $('#capacity_vendor').val(capacity_vendor);
                
                var id_profit_noppn = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(response.price_capacity_fromme);
                $('#id_profit_noppn').val(id_profit_noppn);

                var id_profit_plusppn = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(response.price_capacity_fromme);
                $('#id_profit_plusppn').val(id_profit_plusppn);


            },
            error: function (response) {
                console.log(response);
            }

            })
        })

    </script>

    <script>
        $('#id_profit_noppn'). on('keyup', function(){
            var id_profit_noppn = $(this).val();
            var ppn_percentage = $('#id_ppn').val();
            var subtotal_plus_ppn = $('#id_profit_plusppn').val();

            var total_profit_noppn = id_profit_noppn;
            var calc_ppn = (ppn_percentage * total_profit_noppn) / 100; 
            $('#id_profit_noppn').val(total_profit_noppn);
            
            var total_profit_plusppn = parseInt(calc_ppn) + parseInt(id_profit_noppn);
            
            if (isNaN(total_profit_plusppn)) {
                total_profit_plusppn = 0;
            }
            console.log(total_profit_plusppn);
            $('#id_profit_plusppn').val(total_profit_plusppn);

        })

        $('#id_ppn'). on('keyup', function(){
            var id_profit_noppn = $('#id_profit_noppn').val();
            var ppn_percentage = $('#id_ppn').val();
            var subtotal_plus_ppn = $(this).val();

            var total_profit_noppn = id_profit_noppn;
            var calc_ppn = (ppn_percentage * total_profit_noppn) / 100; 
            $('#id_profit_noppn').val(total_profit_noppn);

            var total_profit_plusppn = parseInt(calc_ppn) + parseInt(id_profit_noppn);
            
            console.log(total_profit_plusppn);
            $('#id_profit_plusppn').val(total_profit_plusppn);

        })

        // })

    </script>
@endpush