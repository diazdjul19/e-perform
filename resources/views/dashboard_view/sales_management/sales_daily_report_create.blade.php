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

            <form class="form-sample" action="{{route('sales-daily-report-store')}}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-8">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="" for="">Tiket Invoice <span class="text-danger">*</span></label>
                                        <input id="tiket_report" type="text" class="form-control" name="tiket_report" autocomplete="off" required readonly value="{{$tiket_autogenerate}}">
                                        
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
                                        @if (!isset($data_client_byemail))
                                            <label class="" for="">Select Client <span class="text-danger">*</span></label>
                                            <select class="form-control select2" style="width: 100%;" name="id_client_rel" required>
                                                <option value selected disabled>Choise</option>
                                                @foreach ($data_client as $item)
                                                    <option value="{{$item->id}}">
                                                        {{$item->name_client}} || {{$item->email_client}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        @elseif (isset($data_client_byemail))
                                            <label class="" for="">Name || Email Client <span class="text-danger">*</span></label>

                                            <input id="id_client_rel" name="" type="text" class="form-control"required autocomplete="off" placeholder="" value="{{$data_client_byemail->name_client}} || {{$data_client_byemail->email_client}}" readonly>
                                            <input type="hidden" name="id_client_rel" value="{{$data_client_byemail->id}}" required readonly  >
                                        @endif
                                        
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
                                        <label class="" for="">Select Site <span class="text-danger">*</span></label>
                                        <select class="form-control select2" style="width: 100%;" name="id_site_rel" required>
                                            <option value selected disabled>Choise</option>
                                            @foreach ($data_site as $item)
                                                <option value="{{$item->id}}">
                                                    {{$item->name_site}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="" for="">Status Progrest </label>
                                            <select class="form-control pt-0 pb-0" id="status" name="status" style="height:35px;" required>
                                                <option value selected disabled>Choise</option>
                                                <option style="background-color: #FFCA2C;color:#000;" value="opn">&#9201;&#65039; On Process NOC</option>
                                                <option style="background-color: #157347;color:#FFF;" value="finish">&#10004; Finish</option>
                                                <option style="background-color: #BB2D3B;color:#FFF;" value="fail">&#10006; Fail</option>
                                            </select>
                                    </div>
                                </div>

                            </div>
        
                            
                        </div>
                    </div>

                    <div class="col-md-4">
                                
                            <ul class="list-group" style="padding: 10px;">
                                <li class="list-group-item active "></li>

                                <li class="list-group-item" id="IfSelected">
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

@push('input-rupiah')
    <script>
    
        var dengan_rupiah = document.getElementById('id_profit_noppn');
        dengan_rupiah.addEventListener('keyup', function(e)
        {
            dengan_rupiah.value = formatRupiah(this.value, 'Rp. ');
        });
        
        /* Fungsi */
        function formatRupiah(angka, prefix)
        {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split	= number_string.split(','),
                sisa 	= split[0].length % 3,
                rupiah 	= split[0].substr(0, sisa),
                ribuan 	= split[0].substr(sisa).match(/\d{3}/gi);
                
            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }
            
            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
        }

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
                var capacity_fromme = new Intl.NumberFormat('id-ID', { style: 'decimal', currency: 'IDR' }).format(response.price_capacity_fromme);
                $('#capacity_fromme').val('Rp. ' + capacity_fromme);
                
                var capacity_vendor = new Intl.NumberFormat('id-ID', { style: 'decimal', currency: 'IDR' }).format(response.price_capacity_vendor);
                $('#capacity_vendor').val('Rp. ' + capacity_vendor);
                
                var id_profit_noppn = new Intl.NumberFormat('id-ID', { style: 'decimal', currency: 'IDR' }).format(response.price_capacity_fromme);
                $('#id_profit_noppn').val('Rp. ' + id_profit_noppn);

                var id_profit_plusppn = new Intl.NumberFormat('id-ID', { style: 'decimal', currency: 'IDR' }).format(response.price_capacity_fromme);
                $('#id_profit_plusppn').val('Rp. ' + id_profit_plusppn);

                // $('#id_profit_noppn').val(response.price_capacity_fromme);
                // $('#id_profit_plusppn').val(response.price_capacity_fromme);    


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
            var replace_rp = id_profit_noppn.replace('Rp', '');
            var replace_dot = replace_rp.replace(/\./g, '');
            var replace_coma00 = replace_dot.replace(',00', '');
            

            var ppn_percentage = $('#id_ppn').val();
            var subtotal_plus_ppn = $('#id_profit_plusppn').val();

            var total_profit_noppn = replace_coma00;


            var calc_ppn = (ppn_percentage * total_profit_noppn) / 100; 
            $('#id_profit_noppn').val(id_profit_noppn);
            
            var total_profit_plusppn = parseInt(calc_ppn) + parseInt(total_profit_noppn);
            
            if (isNaN(total_profit_plusppn)) {
                total_profit_plusppn = 0;
            }
            console.log(total_profit_plusppn);
            var id_profit_plusppn = new Intl.NumberFormat('id-ID', { style: 'decimal', currency: 'IDR' }).format(total_profit_plusppn);
            $('#id_profit_plusppn').val('Rp. ' + id_profit_plusppn);


        })

        $('#id_capacity_rel'). on('change', function(){
            var goto_zero = parseInt("0")
            $('#id_ppn').val(goto_zero);


        })

        $('#id_ppn'). on('keyup', function(){
            var get_id_profit_noppn = $('#id_profit_noppn').val();
            var replace_rp = get_id_profit_noppn.replace('Rp', '');
            var replace_dot = replace_rp.replace(/\./g, '');
            var replace_coma00 = replace_dot.replace(',00', '');
            var id_profit_noppn = replace_coma00;

            var ppn_percentage = $('#id_ppn').val();
            var subtotal_plus_ppn = $(this).val();

            var total_profit_noppn = id_profit_noppn;
            var calc_ppn = (ppn_percentage * total_profit_noppn) / 100; 
            $('#id_profit_noppn').val(get_id_profit_noppn);

            var total_profit_plusppn = parseInt(calc_ppn) + parseInt(id_profit_noppn);
            
            console.log(total_profit_plusppn);
            var id_profit_plusppn = new Intl.NumberFormat('id-ID', { style: 'decimal', currency: 'IDR' }).format(total_profit_plusppn);
            $('#id_profit_plusppn').val('Rp. ' + id_profit_plusppn);


        })

        // })

    </script>
@endpush

@push('show-hide-input')
    <script>
        $("#id_capacity_rel").change(function() {
            if ($(this).children('option:selected').val()) {
                $('#IfSelected').show();
                $('#id_profit_noppn').attr('required', '');
                $('#id_profit_noppn').attr('data-error', 'This field is required.');
                $('#id_ppn').attr('required', '');
                $('#id_ppn').attr('data-error', 'This field is required.');
            } else {
                $('#IfSelected').hide();
                $('#id_profit_noppn').removeAttr('required');
                $('#id_profit_noppn').removeAttr('data-error');
                $('#id_ppn').removeAttr('required');
                $('#id_ppn').removeAttr('data-error');
            }

        });
        $("#id_capacity_rel").trigger("change");
    </script>
@endpush
