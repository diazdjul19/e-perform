@extends('layouts.master_dashboard')
@section('content-wrapper')
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                <i class="fa fa-history"></i>
                NOC Perform Report
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> E-Perform</a></li>
                <li><a href="#">NOC Management</a></li>
                <li class="active">NOC Perform Report</li>
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

                <form class="form-sample" action="{{route('perform-noc-history-get')}}" method="get" >
                        @csrf
                        <!-- /.box-body -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group ">
                                        <label class="" for="id_user_rel">PIC NOC<span style="color: red;">*</span></label>  
                                        <select class="form-control select2" name="id_user_rel" placeholder="" required>
                                            <option value selected disabled>Choise</option>
                                            @foreach ($data_user as $item)
                                                <option value="{{$item->id}}">
                                                    {{$item->name}}
                                                    @if ($item->role == "admin")
                                                        (Admin)
                                                    @elseif ($item->role == "noc")
                                                        (NOC)
                                                    @endif
                                                </option>
                                            @endforeach
                                        </select>  
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group ">
                                        <label class="" for="id_link_rel">Select Link<span style="color: red;">*</span></label>  
                                        <select class="form-control select2"  name="id_link_rel" id="id_link_rel" required>
                                            <option value selected disabled>Choise</option>
                                            @foreach ($data_link as $item)
                                                <option value="{{$item->id}}">{{$item->name_link}} ({{$item->vlan}})</option>
                                            @endforeach
                                            <option value="259b0d4e5350466fad1320653c37f80e">&#127760; All Link</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group ">
                                        <label class="" for="status">Status<span style="color: red;">*</span></label>  
                                        <select class="form-control pt-0 pb-0" id="status" name="status" style="height:35px;" required>
                                            <option value selected disabled>Choise</option>
                                            <option style="background-color: #FFCA2C;color:#000;" value="ocn">&#9201;&#65039; On Check NOC</option>
                                            <option style="background-color: #157347;color:#FFF;" value="solved">&#10004; Solved</option>
                                            <option style="background-color: #BB2D3B;color:#FFF;" value="n_solved">&#10006; Not Solved</option>
                                    </select>
                                    </div>
                                </div>

                                <div class="col-md-4" id="IfSolvedRange">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group ">
                                                <label for="picker-1" style="color: black; font-weight:bold;font-size:13px;" data-toggle="tooltip" title="It is recommended to set the time to 00:00" data-placement="top">From Time<span style="color: red;">*</span></label>                                    
                                                <input id="picker-1" type="text" class="form-control" name="from_long" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group ">
                                                <label for="picker-2" style="color: black; font-weight:bold;font-size:13px;" data-toggle="tooltip" title="It is recommended to set the time to 23:59" data-placement="top">After Time<span style="color: red;">*</span></label>                                    
                                                <input id="picker-2" type="text" class="form-control" name="after_long" autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4" id="If_ocn_or_Nsolved_Range">
                                    <div class="form-group">
                                        <label class="" for="">Range Time, From Time - After Time</label>  
                                        <input id="dummy_input" type="text" class="form-control" name="" value="Range Time, From Time - After Time" disabled="disabled">
                                    </div>
                                </div>                 
                            </div>
                        </div>
                        <!-- /.box-body -->
                
                        <!-- /.box-footer -->
                        <div class="box-footer">
                            <a href="{{route('perform-noc-history')}}" class="btn btn-warning" ><i class="fa fa-refresh"></i> Refresh</a>
                            <button type="submit" class="btn btn-info"><i class="fa fa-external-link"></i> Buka Data</button>
                        </div>
                </form>
                
                <!-- /.box-body -->
            </div>

            @if (isset($data_history))
                <div class="box box-success">
                    
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-table" aria-hidden="true"></i> Table NOC Daily History</h3>
        
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                                    title="Collapse">
                            <i class="fa fa-minus"></i></button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                            <i class="fa fa-times"></i></button>
                        </div>
        
                        <div class="row">
                            <div class="col-md-6">
                                <a href="{{route('excelex-perform-noc-history')}}?{{$data_url}}" class="btn btn-sm" style="margin-top: 10px; background-color:#1be7aa;color:#fff;"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</a>
                                <a href="{{route('pdf-perform-noc-history')}}?{{$data_url}}" class="btn btn-sm" style="margin-top: 10px; background-color:#ff8f9e;color:#fff;"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF</a>
                            </div>
                            <div class="col-md-c"></div>
                        </div>   
                    </div>
                    
                    <div class="box-body">
                        <div class="table-responsive">
                            <table id="example1" class="table table-bordered table-striped" >
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tiket</th>
                                        <th>PIC NOC</th>
                                        <th class="text-center">Link</th>
                                        <th class="text-center">Issues</th>
                                        <th class="text-center">Range Issues</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Solution</th>
                                        <th class="text-center">*Notes*</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($data_history as $d)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td style="min-width:120px;"><a href="{{route('noc-daily-report-edit', $d->id)}}" style="color: #17a2b8;text-decoration:none;" data-toggle="tooltip" title="Click here to view or edit data" data-placement="top">{{$d->tiket_report}}</a></td>

                                            @if ($d->jnsuser != null)
                                                <td style="min-width:120px;">
                                                    {{$d->jnsuser->name}}
                                                    @if ($d->jnsuser->role == "admin")
                                                        (Admin)
                                                    @elseif ($d->jnsuser->role == "noc")
                                                        (NOC)
                                                    @endif
                                                </td>
                                            @elseif ($d->jnsuser == null) 
                                                <td style="min-width:120px;font-weight:bold;">ID Not Found !!!</td>
                                            @endif

                                            @if ($d->jnslink != null)
                                                <td style="min-width:120px;" class="text-center">{{$d->jnslink->name_link}} ({{$d->jnslink->vlan}})</td>
                                            @elseif ($d->jnslink == null) 
                                                <td style="min-width:120px; text-align:center; font-weight:bold;">ID Not Found !!!</td>
                                            @endif

                                            <td class="text-center">{{$d->issues}}</td>

                                            @if ($d->dari_long != "1970-01-01 00:00:00" and $d->sampai_long != "1970-01-01 00:00:00")
                                                <td style="min-width:120px;" class="text-center">
                                                    <span class="label label-success" style="font-size:12px; margin-left:2px; margin-right:2px;">
                                                        {{date('d M Y  | H:i', strtotime($d->dari_long))}}
                                                    </span>
                                                    <span class="label label-danger" style="font-size:12px; margin-left:2px; margin-right:2px;">
                                                        {{date('d M Y  | H:i', strtotime($d->sampai_long))}}
                                                    </span>
                                                </td>
                                            @else
                                                <td style="min-width:120px;" class="text-center">
                                                    <span class="label label-default" style="font-size:12px; margin-left:2px; margin-right:2px;">
                                                        From Time Or After Time, Not been set
                                                    </span>
                                                </td>
                                            @endif
                                            
                                            <td class="text-center">
                                                @if ($d->status == "ocn")
                                                    <span class="label label-warning">On Check NOC</span>
                                                @elseif ($d->status == "solved")
                                                    <span class="label label-primary">Solved</span>
                                                @elseif ($d->status == "n_solved")
                                                    <span class="label label-danger">Not Solved</span>
                                                @endif
                                            </td>

                                            <td style="min-width:120px;" class="text-center">{{$d->solution}}</td>
                                            <td style="min-width:120px;" class="text-center">{{$d->notes}}</td>


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

@push('confirm-alert')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

    <script>
        // Start Confirm Select Delete Using SweetAlert2
            $('#btn-co-delete').on('click',function(e){
                e.preventDefault();

                var form = $(this).parents('form');
                Swal.fire({
                    title: 'Apakah Anda Yakin?',
                    text: "Anda tidak akan bisa mengembalikan data ini!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        // Swal.fire(
                        // 'Success!',
                        // 'Data Berhasil Di Hapus.',
                        // 'success'
                        // )
                        form.submit();
                    } else {
                        Swal.fire(
                            'Cancelled!',
                            'Our imaginary file is safe :).',
                            'error'
                        )
                    } 
                });
            });
        // End Confirm Select Delete Using SweetAlert2
    </script>
@endpush

@push('datetime-picker')
    <script>
        jQuery.datetimepicker.setLocale('id')
        jQuery(document).ready(function () {
            'use strict';
            jQuery('#picker-1, #picker-2').datetimepicker({
                timepicker: true,
                datepicker: true,
                format: 'Y/m/d H:i',
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

@push('show-hide-input')
    <script>
        $("#status").change(function() {
            if ($(this).val() == "solved") {
                $('#IfSolvedRange').show();
                // $('#picker-1').attr('required', '');
                // $('#picker-1').attr('data-error', 'This field is required.');
                // $('#picker-2').attr('required', '');
                // $('#picker-2').attr('data-error', 'This field is required.');
            } else {
                $('#IfSolvedRange').hide();
                $('#picker-1').removeAttr('required');
                $('#picker-1').removeAttr('data-error');
                $('#picker-2').removeAttr('required');
                $('#picker-2').removeAttr('data-error');
            }

            if ($(this).val() != "solved") {
                $('#If_ocn_or_Nsolved_Range').show();
            } else {
                $('#If_ocn_or_Nsolved_Range').hide();
            }
        });
        $("#status").trigger("change");
    </script>
@endpush


