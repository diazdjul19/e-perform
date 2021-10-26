@extends('layouts.master_dashboard')
@section('content-wrapper')
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                <i class="fa fa-history"></i>
                Sales Perform Report
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> E-Perform</a></li>
                <li><a href="#">Sales Management</a></li>
                <li class="active">Sales Perform Report</li>
            </ol>
        </section>
    
        <section class="content">

            <!-- Default box -->
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-search" aria-hidden="true"></i> Select Sales Daily History</h3>
    
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                                title="Collapse">
                        <i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                        <i class="fa fa-times"></i></button>
                    </div>
                </div>

                <form class="form-sample" action="{{route('perform-sales-history-get')}}" method="get" >
                        @csrf
                        <!-- /.box-body -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group ">
                                        <label class="" for="id_user_rel">Report By<span style="color: red;">*</span></label>  
                                        <select class="form-control select2" name="id_user_rel" id="id_user_rel" placeholder="" required>
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
                                        </select>  
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group ">
                                        <label class="" for="id_client_rel">Select Client<span style="color: red;">*</span></label>  
                                        <select class="form-control select2"  name="id_client_rel" id="id_client_rel" required>
                                            <option value selected disabled>Choise</option>
                                            @foreach ($data_client as $item)
                                                <option value="{{$item->id}}">{{$item->name_client}}</option>
                                            @endforeach
                                            <option value="34e4e14c9085f747c60aeb339fde1f84">&#127760; All Client</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group ">
                                        <label class="" for="status">Status</label>  
                                        <select class="form-control pt-0 pb-0" id="status" name="status" style="height:35px;">
                                            <option value selected disabled>Choise</option>
                                            <option style="background-color: #FFCA2C;color:#000;" value="opn">&#9201;&#65039; On Process NOC</option>
                                            <option style="background-color: #157347;color:#FFF;" value="finish">&#10004; Finish</option>
                                            <option style="background-color: #BB2D3B;color:#FFF;" value="fail">&#10006; Fail</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4" id="">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group ">
                                                <label for="picker-1" style="color: black; font-weight:bold;font-size:13px;" data-toggle="tooltip" title="It is recommended to set the time to 00:00" data-placement="top">From Time</label>                                    
                                                <input id="picker-1" type="text" class="form-control" name="from_long" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group ">
                                                <label for="picker-2" style="color: black; font-weight:bold;font-size:13px;" data-toggle="tooltip" title="It is recommended to set the time to 23:59" data-placement="top">After Time</label>                                    
                                                <input id="picker-2" type="text" class="form-control" name="after_long" autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- /.box-body -->
                
                        <!-- /.box-footer -->
                        <div class="box-footer">
                            <a href="#" class="btn btn-warning" ><i class="fa fa-refresh"></i> Refresh</a>
                            <button type="submit" class="btn btn-info"><i class="fa fa-external-link"></i> Buka Data</button>
                        </div>
                </form>
                
                <!-- /.box-body -->
            </div>

            @if (isset($data_history))
                <div class="box box-success">
                    
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-table" aria-hidden="true"></i> Table Sales Daily History</h3>
        
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                                    title="Collapse">
                            <i class="fa fa-minus"></i></button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                            <i class="fa fa-times"></i></button>
                        </div>
        
                        <div class="row">
                            <div class="col-md-6">
                                <a href="{{route('excelex-perform-sales-history')}}?{{$data_url}}" class="btn btn-sm" style="margin-top: 10px; background-color:#1be7aa;color:#fff;"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</a>
                                <a href="{{route('pdf-perform-sales-history')}}?{{$data_url}}" class="btn btn-sm" style="margin-top: 10px; background-color:#ff8f9e;color:#fff;"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF</a>
                            </div>
                            <div class="col-md-c"></div>
                        </div>   
                    </div>
                    
                    <div class="box-body">
                        <div class="table-responsive">
                            <table id="example1" class="table table-bordered table-striped" >
                                <thead>
                                    <tr >
                                        <th>No</th>
                                        <th>Tiket</th>
                                        <th style="min-width:80px;">Report By</th>
                                        <th style="min-width:80px;">Nama Client</th>
                                        <th style="min-width:80px;" class="text-center">Capacity</th>
                                        <th style="min-width:80px;" class="text-center">Site</th>
                                        <th style="min-width:80px;" class="text-center">Status</th>
                                        <th style="min-width:120px;" class="text-center">Harga Dari Vendor</th>
                                        <th style="min-width:200px;" class="text-center">Harga Bandwith Tanpa PPN</th>
                                        <th style="min-width:80px;" class="text-center">PPN ( % )</th>
                                        <th style="min-width:200px; background-color:#1bb1e7;color:#fff;" class="text-center">Total Harga + PPN ( Rp. )</th>
                                        <th style="min-width:200px; background-color:#1be7aa;color:#fff;" class="text-center">Margin Profit</th>
                                    </tr>
                                
                                </thead>

                                <tbody>
                                    @foreach ($data_history as $d)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>

                                            @if (Auth::user()->role == "admin")
                                                <td style="min-width:120px;"><a href="{{route('sales-daily-report-edit', $d->id)}}" style="color: #17a2b8;text-decoration:none;" data-toggle="tooltip" title="Click here to view or edit data" data-placement="top">{{$d->tiket_report}}</a></td>
                                            @elseif (Auth::user()->role == "sales")
                                                @if ($d->jnsuser == null)
                                                    <td style="min-width:120px;"><a href="{{route('sales-daily-report-edit', $d->id)}}" style="color: #17a2b8;text-decoration:none;" data-toggle="tooltip" title="Click here to view or edit data" data-placement="top">{{$d->tiket_report}}</a></td>
                                                @elseif ($d->jnsuser->id == Auth::user()->id)
                                                    <td style="min-width:120px;"><a href="{{route('sales-daily-report-edit', $d->id)}}" style="color: #17a2b8;text-decoration:none;" data-toggle="tooltip" title="Click here to view or edit data" data-placement="top">{{$d->tiket_report}}</a></td>
                                                @elseif ($d->jnsuser->id != Auth::user()->id)
                                                    <td style="min-width:120px;"><a href="{{route('sales-daily-report-show', $d->id)}}" style="color: #17a2b8;text-decoration:none;" data-toggle="tooltip" title="Click here to view or edit data" data-placement="top">{{$d->tiket_report}}</a></td>
                                                @endif
                                            @else
                                                <td>-</td>
                                            @endif

                                            @if ($d->jnsuser != null)
                                                <td style="min-width:120px;">
                                                    {{$d->jnsuser->name}}
                                                    @if ($d->jnsuser->role == "admin")
                                                        (Admin)
                                                    @elseif ($d->jnsuser->role == "sales")
                                                        (Sales)
                                                    @endif
                                                </td>
                                            @elseif ($d->jnsuser == null) 
                                                <td style="min-width:120px;font-weight:bold;">ID Not Found !!!</td>
                                            @endif

                                            @if ($d->jnsclient != null)
                                                <td style="min-width:120px;">
                                                    {{$d->jnsclient->name_client}}
                                                </td>
                                            @elseif ($d->jnsclient == null) 
                                                <td style="min-width:120px;font-weight:bold;">ID Not Found !!!</td>
                                            @endif

                                            @if ($d->jnscapacity != null)
                                                <td style="min-width:120px;text-align:center;">
                                                    {{$d->jnscapacity->bandwith_capacity}}
                                                    {{$d->jnscapacity->type_trasfer}}  ||
                                                    
                                                    @inject('vendor', 'App\Models\MsVendor')
                                                    {{substr($vendor->where('id', $d->jnscapacity->id_vendor_rel)->first('name_vendor'), 16, -2)}}
                                                </td>
                                            @elseif ($d->jnscapacity == null) 
                                                <td style="min-width:120px;text-align:center;font-weight:bold;">ID Not Found !!!</td>
                                            @endif

                                            @if ($d->jnssite != null)
                                                <td style="min-width:120px;text-align:center;">
                                                    {{$d->jnssite->name_site}}
                                                </td>
                                            @elseif ($d->jnssite == null) 
                                                <td style="min-width:120px;text-align:center;font-weight:bold;">ID Not Found !!!</td>
                                            @endif

                                            <td class="text-center">
                                                @if ($d->status == "opn")
                                                    <span class="label label-warning">On Process NOC</span>
                                                @elseif ($d->status == "finish")
                                                    <span class="label label-primary">Finish</span>
                                                @elseif ($d->status == "fail")
                                                    <span class="label label-danger">Fail</span>
                                                @endif
                                            </td>
                                            <td style="min-width:200px;text-align:center;">Rp. {{number_format($d->price_capacity_vendor,2,',','.')}}</td>
                                            <td style="min-width:200px;text-align:center;">Rp. {{number_format($d->price_capacity_fromme,2,',','.')}}</td>
                                            <td style="min-width:100px;text-align:center;">{{$d->ppn_percentage}} %</td>
                                            <td style="min-width:200px;text-align:center; background-color:#95daf3;color:#000;"> Rp. {{number_format($d->subtotal_plus_ppn,2,',','.')}} </td>
                                            <td style="min-width:120px;text-align:center; background-color:#9cffe1;color:#000;">
                                                Rp. {{number_format($d->price_capacity_fromme - $d->price_capacity_vendor ,2,',','.')}}
                                            </td>

                                            

                                        </tr>
                                    @endforeach
                                </tbody>
                                
                            </table>
                        </div>
                    </div>
                    
                    <!-- /.box-body -->
                </div>
            @endif
            <!-- /.box -->
        </section>
@endsection

@push('datatable')
    <script>
        $(function () {
            $('#example1').DataTable()
        })
    </script>
@endpush

@push('select2')
    <script>
        $('.select2').select2()
    </script>
@endpush

@push('datetime-picker')
    <script>
        jQuery.datetimepicker.setLocale('id')
        jQuery(document).ready(function () {
            'use strict';
            jQuery('#picker-1, #picker-2').datetimepicker({
                timepicker: false,
                datepicker: true,
                format: 'Y/m/d',
                mask: true,
                lang: 'id',
                i18n:{
                    month: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
                    dayOfWeek: ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu']
                },
                step: 1,
                
            });
        });

    </script>
@endpush

