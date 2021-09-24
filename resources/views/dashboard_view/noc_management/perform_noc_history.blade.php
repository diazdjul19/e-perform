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

                <form class="form-sample" action="#" method="POST" enctype="multipart/form-data">
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
                                            <option value="#">&#127760; All Link</option>
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

                                <div class="col-md-2">
                                    <div class="form-group ">
                                        <label for="picker-1" style="color: black; font-weight:bold;font-size:13px;" >From Time<span style="color: red;">*</span></label>                                    
                                        <input id="picker-1" type="text" class="form-control" name="dari_long" >
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group ">
                                        <label for="picker-2" style="color: black; font-weight:bold;font-size:13px;" >After Time<span style="color: red;">*</span></label>                                    
                                        <input id="picker-2" type="text" class="form-control" name="after_long" >
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


