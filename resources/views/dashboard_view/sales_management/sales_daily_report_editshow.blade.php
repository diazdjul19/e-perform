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
            @if (request()->is('sales-daily-report-edit/*'))
                Sales Edit Daily Report
            @elseif(request()->is('sales-daily-report-show/*'))
                Sales Show Daily Report
            @endif 
            <small>...</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> E-Perform</a></li>
            <li><a href="{{ URL::previous() }}">Sales Management</a></li>
            <li><a href="{{ URL::previous() }}">Sales Daily Report</a></li>
            @if (request()->is('sales-daily-report-edit/*'))
                <li class="active">Sales Edit Daily Report</li>
            @elseif(request()->is('sales-daily-report-show/*'))
                <li class="active">Sales Show Daily Report</li>
            @endif
        </ol>
        
    </section>

    <section class="content">
        
        <!-- Default box -->
        <div class="box box-success">
            <div class="box-header with-border">
                @if (request()->is('sales-daily-report-edit/*'))
                    <h3 class="box-title"><i class="fa fa-pencil-square"></i> Sales Edit Daily Report</h3>
                @elseif(request()->is('sales-daily-report-show/*'))
                    <h3 class="box-title"><i class="fa fa-info-circle"></i> Sales Show Daily Report</h3>
                    
                @endif 

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                            title="Collapse">
                    <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                    <i class="fa fa-times"></i></button>
                </div>
            </div>

            <form class="form-sample" action="{{route('sales-daily-report-update', $data->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                {{method_field('put')}}

                <div class="row">
                    <div class="col-md-8">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="" for="">Tiket Invoice <span class="text-danger">*</span></label>
                                        <input id="tiket_report" type="text" class="form-control" name="tiket_report" autocomplete="off" required readonly value="{{$data->tiket_report}}">
                                        
                                    </div>
                                </div>
        
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="" for="">Report By <span class="text-danger">*</span></label>
                                        @if (Auth::user()->role == "admin")
                                            <select class="form-control select2" name="id_user_rel" placeholder="" required>
                                                <optgroup label="ReportBy Saat Ini">
                                                    @if ($data->jnsuser == null)
                                                        <option  value="">ID Not Found !!!</option>
                                                    @elseif ($data->jnsuser != null)
                                                        <option  value="{{$data->jnsuser->id}}">{{$data->jnsuser->name}}</option>
                                                    @endif
                                                </optgroup>  
                                                <optgroup label="ReportBy Baru">  
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
                                                </optgroup>
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
                                                <optgroup label="Data Client Saat Ini">
                                                    @if ($data->jnsclient == null)
                                                        <option  value="">ID Not Found !!!</option>
                                                    @elseif ($data->jnsclient != null) 
                                                        <option  value="{{$data->jnsclient->id}}">{{$data->jnsclient->name_client}} || ({{$data->jnsclient->email_client}})</option>
                                                    @endif
                                                </optgroup>  
                                                <optgroup label="Data Client Baru">  
                                                    @foreach ($data_client as $item)
                                                        <option value="{{$item->id}}">
                                                            {{$item->name_client}} || {{$item->email_client}}
                                                        </option>
                                                    @endforeach
                                                </optgroup>

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
                                            {{-- {<optgroup label="Data Capacity Saat Ini"> --}}
                                                @if ($data->jnscapacity == null)
                                                    <option  value="">ID Not Found !!!</option>
                                                @elseif ($data->jnscapacity != null) 
                                                    
                                                    <option value="{{$data->jnscapacity->id}}">
                                                        {{$data->jnscapacity->bandwith_capacity}} {{$data->jnscapacity->type_trasfer}} ||
                                                        @inject('vendor', 'App\Models\MsVendor')
                                                        {{substr($vendor->where('id', $data->jnscapacity->id_vendor_rel)->first('name_vendor'), 16, -2)}} ||
                                                        &#10004; Active Saat Ini
                                                    </option>
                                                @endif
                                            {{-- </optgroup>   --}}
                                            {{-- <optgroup label="Data Capacity Baru"> --}}
                                                @foreach ($data_capacity as $item)
                                                    <option value="{{$item->id}}">
                                                        {{$item->bandwith_capacity}} {{$item->type_trasfer}} || Vendor By : {{$item->jnsvendor->name_vendor}}
                                                    </option>
                                                @endforeach
                                            {{-- </optgroup> --}}
                                            
                                        </select>
                                    </div>
                                </div>
        
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="" for="">Price From Me </label>
                                        <input id="capacity_fromme" type="text" class="form-control" name="" autocomplete="off" placeholder="" readonly value="Rp. {{number_format($price_origin_capacity->price_capacity_fromme , 0, ".", ".")}}">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="" for="">Price From Vendor </label>
                                        <input id="capacity_vendor" type="text" class="form-control" name="price_capacity_vendor" autocomplete="off" placeholder="" readonly value="Rp. {{number_format($price_origin_capacity->price_capacity_vendor , 0, ".", ".")}}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="" for="">Select Site <span class="text-danger">*</span></label>
                                        <select class="form-control select2" style="width: 100%;" name="id_site_rel" required>
                                            <optgroup label="Data Site Saat Ini">
                                                @if ($data->jnssite == null)
                                                    <option  value="">ID Not Found !!!</option>
                                                @elseif ($data->jnssite != null) 
                                                    <option  value="{{$data->jnssite->id}}">{{$data->jnssite->name_site}}</option>
                                                @endif
                                            </optgroup>  
                                            <optgroup label="Data Site Baru">  
                                                @foreach ($data_site as $item)
                                                    <option value="{{$item->id}}">
                                                        {{$item->name_site}}
                                                    </option>
                                                @endforeach
                                            </optgroup>

                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="" for="">Status Progrest </label>
                                            <select class="form-control pt-0 pb-0" id="status" name="status" style="height:35px;" required>
                                                <optgroup label="Status Saat Ini">
                                                    @if ($data->status == "opn")
                                                        <option style="background-color: #FFCA2C;color:#000;" value="{{$data->status}}">&#9201;&#65039; On Progress NOC</option>
                                                    @elseif ($data->status == "finish")
                                                        <option style="background-color: #157347;color:#FFF;" value="{{$data->status}}">&#10004; Finish</option>
                                                    @elseif ($data->status == "fail")
                                                        <option style="background-color: #BB2D3B;color:#FFF;" value="{{$data->status}}">&#10006; Fail</option>
                                                    @endif
                                                </optgroup>

                                                <optgroup label="Status Baru">
                                                    <option style="background-color: #FFCA2C;color:#000;" value="opn">&#9201;&#65039; On Process NOC</option>
                                                    <option style="background-color: #157347;color:#FFF;" value="finish">&#10004; Finish</option>
                                                    <option style="background-color: #BB2D3B;color:#FFF;" value="fail">&#10006; Fail</option>
                                                </optgroup>
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
                                        <input type="text" name="profit_no_ppn" class="form-control" id="id_profit_noppn" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');"  placeholder="" value="Rp. {{number_format($profit_noppn , 0, ".", ".")}}" >      
                                    </div>

                                    <div class="form-group">
                                        <label for="biaya_antar">PPN ( % )</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" name="ppn_percentage" id="id_ppn" value="{{$ppn_percentage}}" >
                                            <span class="input-group-addon">%</span>
                                        </div>
                                    </div>
                                </li>                                                  
                                <li class="list-group-item">
                                    <div class="form-group">
                                        <label class="font-weight-bold" for="exampleInputEmail1"> Total Harga + PPN ( Rp. )</label>
                                        <input type="text" name="subtotal_plus_ppn" class="form-control" id="id_profit_plusppn" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');"  placeholder="" readonly autocomplete="off" value="Rp. {{number_format($profit_subtotal_plusppn , 0, ".", ".")}}">
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

                    {{-- <a href="#" target="_blank" class="btn btn-sm btn-default" style="float: right; margin-left:2px; margin-right:2px;"><i class="fa fa-print"></i> Print</a> --}}
                    <a href="#"  class="btn btn-sm btn-danger" style="float: right; margin-left:2px; margin-right:2px;"><i class="fa fa-file-pdf-o"></i> Download PDF</a>
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

    </script>
@endpush

{{-- @push('show-hide-input')
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
@endpush --}}
