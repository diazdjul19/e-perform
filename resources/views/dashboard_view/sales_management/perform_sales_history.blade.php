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
                    <h3 class="box-title"><i class="fa fa-search" aria-hidden="true"></i> Select NOC Daily History</h3>
    
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
                                        <label class="" for="status">Status<span style="color: red;">*</span></label>  
                                        <select class="form-control pt-0 pb-0" id="status" name="status" style="height:35px;" required>
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
                                                <label for="picker-1" style="color: black; font-weight:bold;font-size:13px;" data-toggle="tooltip" title="It is recommended to set the time to 00:00" data-placement="top">From Time<span style="color: red;">*</span></label>                                    
                                                <input id="picker-1" type="text" class="form-control" name="from_long" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group ">
                                                <label for="picker-2" style="color: black; font-weight:bold;font-size:13px;" data-toggle="tooltip" title="It is recommended to set the time to 00:00" data-placement="top">After Time<span style="color: red;">*</span></label>                                    
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
                format: 'Y/m/d 00:00',
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

