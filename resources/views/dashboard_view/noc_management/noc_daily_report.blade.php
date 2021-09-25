@extends('layouts.master_dashboard')
@section('content-wrapper')
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                <i class="fa fa-file-text"></i>
                NOC Daily Report
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> E-Perform</a></li>
                <li><a href="#">NOC Management</a></li>
                <li class="active">NOC Daily Report</li>
            </ol>
        </section>
    
        <section class="content">
            {{-- Start Modal Create --}}
            <div class="modal fade" id="modal-create">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title"><i class="fa fa-file-text" aria-hidden="true"></i> Tambah Daily Report</h4>
                        </div>

                        <form action="{{route('noc-daily-reportstore')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">

                                        <div class="form-group row" style="margin:0px;">
                                            <label class="col-md-4 col-form-label" for="tiket_report"><h6 style="color: black; font-weight:bold;font-size:13px;">Tiket<span style="color: red;">*</span></h6></label>
                                            
                                            <div class="col-md-8">
                                                <input id="tiket_report" name="tiket_report" type="text" class="form-control" required autocomplete="off" readonly value="{{$tiket_autogenerate}}">
                                            </div>
                            
                                        </div>

                                        <div class="form-group row" style="margin:0px;">
                                            <label class="col-md-4 col-form-label" for="id_user_rel"><h6 style="color: black; font-weight:bold;font-size:13px;">PIC NOC<span style="color: red;">*</span></h6></label>
                                            
                                            @if (Auth::user()->role == "admin")
                                                <div class="col-md-8">
                                                    <select class="form-control select2" style="width: 100%;" name="id_user_rel">
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
                                            @elseif (Auth::user()->role == "noc")
                                                <div class="col-md-8">
                                                    <input id="id_user_rel" name="" type="text" class="form-control"required autocomplete="off" placeholder="" value="{{Auth::user()->name}}" readonly>
                                                    <input type="hidden" name="id_user_rel" value="{{Auth::user()->id}}" required readonly  >
                                                </div>
                                            @endif                            
                                        </div>

                                        <div class="form-group row" style="margin:0px;">
                                            <label class="col-md-4 col-form-label" for="id_link_rel"><h6 style="color: black; font-weight:bold;font-size:13px;">Select Link<span style="color: red;">*</span></h6></label>
                                            <div class="col-md-8">
                                                <select class="form-control select2"  name="id_link_rel" id="" style="width: 100%;" required>
                                                    <option value selected disabled>Choise</option>
                                                        @foreach ($data_link as $item)
                                                            <option value="{{$item->id}}">{{$item->name_link}} ({{$item->vlan}})</option>
                                                        @endforeach
                                                </select>
                                            </div>                         
                                        </div>

                                        <div class="form-group row" style="margin:0px;">
                                            <label class="col-md-4 col-form-label" for="issues"><h6 style="color: black; font-weight:bold;font-size:13px;">Issues</h6></label>
                                            
                                            <div class="col-md-8">
                                                <input id="issues" name="issues" type="text" class="form-control" autocomplete="off" placeholder="Add Issues">
                                            </div>
                                        </div>

                                        <div class="form-group row" style="margin:0px;">
                                            <label class="col-md-4 col-form-label" for="status"><h6 style="color: black; font-weight:bold;font-size:13px;">Status<span style="color: red;">*</span></h6></label>
                                            
                                            <div class="col-md-8">
                                                <select class="form-control pt-0 pb-0" id="status" name="status" style="height:35px;" required>
                                                        <option value selected disabled>Choise</option>
                                                        <option style="background-color: #FFCA2C;color:#000;" value="ocn">&#9201;&#65039; On Check NOC</option>
                                                        <option style="background-color: #157347;color:#FFF;" value="solved">&#10004; Solved</option>
                                                        <option style="background-color: #BB2D3B;color:#FFF;" value="n_solved">&#10006; Not Solved</option>
                                                </select>

                                            </div>
                                        </div>

                                        <div class="form-group row" style="margin:0px;" id="IfSolvedRange">
                                            <label class="col-md-4 col-form-label" for=""><h6 style="color: black; font-weight:bold;font-size:13px;">Range Issues</h6></label>
                                            
                                            <div class="col-md-4">
                                                <div class="form-group row">
                                                    <div class="col-md-12">
                                                        <label for="picker-1" style="color: black; font-weight:bold;font-size:13px;" >From Time</label>                                    
                                                        <input id="picker-1" type="text" class="form-control" name="dari_long" >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group row">
                                                    <div class="col-md-12">
                                                        <label for="picker-2" style="color: black; font-weight:bold;font-size:13px;" >After Time </label>
                                                        <input id="picker-2" type="text" class="form-control" name="sampai_long" >
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row" style="margin:0px;" id="IfSolvedSolution">
                                            <label class="col-md-4 col-form-label" for="solution"><h6 style="color: black; font-weight:bold;font-size:13px;">Solution</h6></label>
                                            
                                            <div class="col-md-8">
                                                <input id="solution" name="solution" type="text" class="form-control" autocomplete="off" placeholder="Add Solution">
                                            </div>
                                        </div>

                                        <div class="form-group row" style="margin:0px;">
                                            <label class="col-md-4 col-form-label" for="notes"><h6 style="color: black; font-weight:bold;font-size:13px;">*Notes*</h6></label>
                                            
                                            <div class="col-md-8">
                                                <textarea name="notes" id="" rows="5" style="width:100%;"></textarea>
                                            </div>
                                        </div>

                                    
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                            </div>
                        </form>
                    
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            {{-- End Modal Create --}}

            <!-- Default box -->
            <div class="box box-success">
                <form action="{{route('select-delete-daily-report-noc')}}" method="post" >
                    @csrf
                    <div class="box-header with-border">
                        <h3 class="box-title">Table daily Report</h3>
        
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                                    title="Collapse">
                            <i class="fa fa-minus"></i></button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                            <i class="fa fa-times"></i></button>
                        </div>
        
                        <div class="row">
                            <div class="col-md-6">
                                <button type="button" class="btn btn-info btn-sm" style="margin-top: 10px;" data-toggle="modal" data-target="#modal-create"><i class="fa fa-user-plus"></i> Tambah</button>
                                <a href="" class="btn btn-sm" style="margin-top: 10px; background-color:#ff8f9e;color:#fff;"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF</a>
                                <button type="button" class="btn btn-danger btn-sm" style="margin-top: 10px;" id="btn-co-delete" name="select_delete[]" type="submit">
                                    <i class="fa fa-trash" aria-hidden="true"></i> Hapus
                                </button>
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
                                        <th class="text-center">Range Issues</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center" style="padding:5px; min-width:80px;">&#128073; <input type="checkbox" id="cekall" style="margin-bottom: 10px;"  data-toggle="tooltip" title="Click here to Check All" data-placement="top"> &#128072;</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($data as $d)
                                        @if ($d->jnsuser->role == "admin" || $d->jnsuser->role == "noc")
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                
                                                @if (Auth::user()->role == "admin")
                                                    <td style="min-width:120px;"><a href="{{route('noc-daily-report-edit', $d->id)}}" style="color: #17a2b8;text-decoration:none;" data-toggle="tooltip" title="Click here to view or edit data" data-placement="top">{{$d->tiket_report}}</a></td>
                                                @elseif (Auth::user()->role == "noc")
                                                    @if ($d->jnsuser->id == Auth::user()->id)
                                                        <td style="min-width:120px;"><a href="{{route('noc-daily-report-edit', $d->id)}}" style="color: #17a2b8;text-decoration:none;" data-toggle="tooltip" title="Click here to view or edit data" data-placement="top">{{$d->tiket_report}}</a></td>
                                                    @elseif ($d->jnsuser->id != Auth::user()->id)
                                                        <td style="min-width:120px;"><a href="{{route('noc-daily-report-show', $d->id)}}" style="color: #17a2b8;text-decoration:none;" data-toggle="tooltip" title="Click here to view or edit data" data-placement="top">{{$d->tiket_report}}</a></td>
                                                    @endif
                                                @else
                                                    <td>-</td>
                                                @endif

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

                                                @if (Auth::user()->role == "admin")
                                                    <td class="text-center"><input type="checkbox" name="select_delete[]" value="{{$d->id}}"></td>
                                                @elseif (Auth::user()->role == "noc")
                                                    @if ($d->jnsuser->id == Auth::user()->id)
                                                        <td class="text-center"><input type="checkbox" name="select_delete[]" value="{{$d->id}}"></td>
                                                    @elseif ($d->jnsuser->id != Auth::user()->id)
                                                        <td></td>
                                                    @endif
                                                @else
                                                    <td>-</td>
                                                @endif
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                                
                            </table>
                        </div>
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

@push('checkall')
    <script>
        $(document).ready(function() {
            $('#cekall').click(function () {
                $('input[type=checkbox]').not(":disabled").prop('checked', this.checked);
            });
        } );
        
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

            if ($(this).val() == "solved") {
                $('#IfSolvedSolution').show();
                $('#solution').attr('required', '');
                $('#solution').attr('data-error', 'This field is required.');
            } else {
                $('#IfSolvedSolution').hide();
                $('#solution').removeAttr('required');
                $('#solution').removeAttr('data-error');
            }
        });
        $("#status").trigger("change");
    </script>
@endpush

