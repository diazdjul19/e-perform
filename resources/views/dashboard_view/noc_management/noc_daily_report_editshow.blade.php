@extends('layouts.master_dashboard')
@section('content-wrapper')
    <!-- Content Header (Page header) -->
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-file-text"></i>
            NOC Daily Report
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> E-Perform</a></li>
            <li><a href="#">NOC Management</a></li>
            <li><a href="#">NOC Daily Report</a></li>
            @if (request()->is('noc-daily-report-edit/*'))
                <li class="active">Edit Daily Report</li>
            @elseif(request()->is('noc-daily-report-show/*'))
                <li class="active">Show Daily Report</li>
            @endif
        </ol>
    </section>

    <section class="content">

        <!-- Default box -->
        <div class="box box-success">
            <div class="box-header with-border">
                @if (request()->is('noc-daily-report-edit/*'))
                    <h3 class="box-title"><a href="{{ URL::previous() }}"><i class="fa fa-pencil-square-o"></i></a> Form Edit Profil</h3>
                @elseif(request()->is('noc-daily-report-show/*'))
                    <h3 class="box-title"><a href="{{ URL::previous() }}"><i class="fa fa-arrow-left"></i></a> Form Show Profil</h3>
                @endif

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                            title="Collapse">
                    <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                    <i class="fa fa-times"></i></button>
                </div>
            </div>


            @if (request()->is('noc-daily-report-edit/*'))
                <form class="form-sample" action="{{route('noc-daily-report-update', $data->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        {{method_field('put')}}

                        <!-- /.box-body -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label class="" for="tiket_report">Tiker Report<span style="color: red;">*</span></label>  
                                        <input type="text" name="tiket_report" class="form-control" id="tiket_report"  placeholder="Tiket Report" value="{{$data->tiket_report}}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label class="" for="id_user_rel">PIC NOC<span style="color: red;">*</span></label>  
                                        @if (Auth::user()->role == "admin")             
                                            <select class="form-control select2" name="id_user_rel" placeholder="" required>
                                                <optgroup label="PIC NOC Saat Ini">
                                                    @if ($data->jnsuser == null)
                                                        <option  value="">ID Not Found !!!</option>
                                                    @elseif ($data->jnsuser != null)
                                                        <option  value="{{$data->jnsuser->id}}">{{$data->jnsuser->name}}</option>
                                                    @endif
                                                </optgroup>  
                                                <optgroup label="PIC NOC Baru">  
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

                                                    @if (Auth::user()->email == "setlightcombo@gmail.com")
                                                        <option value="{{Auth::user()->id}}">{{Auth::user()->name}} (Super Admin)</option>
                                                    @endif
                                                </optgroup>
                                            </select>  
                                        @elseif (Auth::user()->role == "noc")
                                            <input id="id_user_rel" name="" type="text" class="form-control" required autocomplete="off" value="{{Auth::user()->name}}" disabled="disabled">
                                            <input type="hidden" name="id_user_rel" value="{{Auth::user()->id}}" required readonly  >
                                        @endif   
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label class="" for="id_link_rel">Select Link<span style="color: red;">*</span></label>  
                                        <select class="form-control select2" name="id_link_rel" placeholder="" required>
                                            <optgroup label="PIC NOC Saat Ini">
                                                @if ($data->jnslink == null)
                                                    <option  value="">ID Not Found !!!</option>
                                                @elseif ($data->jnslink != null) 
                                                    <option  value="{{$data->jnslink->id}}">{{$data->jnslink->name_link}} ({{$data->jnslink->vlan}})</option>
                                                @endif
                                            </optgroup>  
                                            <optgroup label="PIC NOC Baru">  
                                                @foreach ($data_link as $item)
                                                    <option value="{{$item->id}}">
                                                        {{$item->name_link}} ({{$item->vlan}})
                                                    </option>
                                                @endforeach
                                            </optgroup>
                                        </select>  
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label class="" for="issues">Issues</label>  
                                        <input type="text" name="issues" class="form-control" id="issues"  placeholder="Issues" value="{{$data->issues}}">
                                    </div>
                                </div>
                                
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label class="" for="status">Status<span style="color: red;">*</span></label>  
                                        <select class="form-control" name="status" id="status" placeholder="" required>
                                            <optgroup label="Status Saat Ini">
                                                @if ($data->status == "ocn")
                                                    <option style="background-color: #FFCA2C;color:#000;" value="{{$data->status}}">&#9201;&#65039; On Check NOC</option>
                                                @elseif ($data->status == "solved")
                                                    <option style="background-color: #157347;color:#FFF;" value="{{$data->status}}">&#10004; Solved</option>
                                                @elseif ($data->status == "n_solved")
                                                    <option style="background-color: #BB2D3B;color:#FFF;" value="{{$data->status}}">&#10006; Not Solved</option>
                                                @endif
                                            </optgroup>  
                                            <optgroup label="Status Baru">  
                                                <option style="background-color: #FFCA2C;color:#000;" value="ocn">&#9201;&#65039; On Check NOC</option>
                                                <option style="background-color: #157347;color:#FFF;" value="solved">&#10004; Solved</option>
                                                <option style="background-color: #BB2D3B;color:#FFF;" value="n_solved">&#10006; Not Solved</option>
                                            </optgroup>
                                        </select>  
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group" id="IfSolvedRange">
                                        <div class="row">
                                            @if ($data->dari_long != "1970-01-01 00:00:00" and $data->sampai_long != "1970-01-01 00:00:00")
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <div class="col-md-12">
                                                            <label for="picker-1" style="color: black; font-weight:bold;font-size:13px;" >Range Issues - From Time</label>                                    
                                                            <input id="picker-1" type="text" class="form-control" name="dari_long" value="{{date('Y/m/d H:i', strtotime($data->dari_long))}}" autocomplete="off">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <div class="col-md-12">
                                                            <label for="picker-2" style="color: black; font-weight:bold;font-size:13px;" >Range Issues - After Time </label>
                                                            <input id="picker-2" type="text" class="form-control" name="sampai_long" value="{{date('Y/m/d H:i', strtotime($data->sampai_long))}}" autocomplete="off">
                                                        </div>
                                                    </div>
                                                </div>
                                            @elseif ($data->dari_long == "1970-01-01 00:00:00" and $data->sampai_long != "1970-01-01 00:00:00")
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <div class="col-md-12">
                                                            <label for="picker-1" style="color: black; font-weight:bold;font-size:13px;" >Range Issues - From Time</label>                                    
                                                            <input id="picker-1" type="text" class="form-control" name="dari_long" value="" autocomplete="off">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <div class="col-md-12">
                                                            <label for="picker-2" style="color: black; font-weight:bold;font-size:13px;" >Range Issues - After Time </label>
                                                            <input id="picker-2" type="text" class="form-control" name="sampai_long" value="{{date('Y/m/d H:i', strtotime($data->sampai_long))}}" autocomplete="off">
                                                        </div>
                                                    </div>
                                                </div>
                                            @elseif ($data->dari_long != "1970-01-01 00:00:00" and $data->sampai_long == "1970-01-01 00:00:00")
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <div class="col-md-12">
                                                            <label for="picker-1" style="color: black; font-weight:bold;font-size:13px;" >Range Issues - From Time</label>                                    
                                                            <input id="picker-1" type="text" class="form-control" name="dari_long" value="{{date('Y/m/d H:i', strtotime($data->dari_long))}}" autocomplete="off">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <div class="col-md-12">
                                                            <label for="picker-2" style="color: black; font-weight:bold;font-size:13px;" >Range Issues - After Time </label>
                                                            <input id="picker-2" type="text" class="form-control" name="sampai_long" value="" autocomplete="off">
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <div class="col-md-12">
                                                            <label for="picker-1" style="color: black; font-weight:bold;font-size:13px;" >Range Issues - From Time</label>                                    
                                                            <input id="picker-1" type="text" class="form-control" name="dari_long" value="" autocomplete="off">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <div class="col-md-12">
                                                            <label for="picker-2" style="color: black; font-weight:bold;font-size:13px;" >Range Issues - After Time </label>
                                                            <input id="picker-2" type="text" class="form-control" name="sampai_long" value="" autocomplete="off">
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group" id="If_ocn_or_Nsolved_Range">
                                        <label class="" for="">Range Time, From Time - After Time</label>  
                                        <input id="dummy_input" type="text" class="form-control" name="" value="Range Time, From Time - After Time" disabled="disabled">
                                    </div>
                                </div>
                                
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group" id="IfSolvedSolution">
                                        <label class="" for="solution">Solution</label>  
                                        <input type="text" name="solution" class="form-control" id="solution"  placeholder="solution" value="{{$data->solution}}">
                                    </div>

                                    <div class="form-group" id="If_ocn_or_Nsolved_Solution">
                                        <label class="" for=""> Solution</label>  
                                        <input id="dummy_input" type="text" class="form-control" name="" value="If the status has been solved, then you can edit this form." disabled="disabled">
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group" >
                                        <label class="" for="">*Notes*</label>
                                        <textarea name="notes" id="" rows="5" style="width:100%;">{{$data->notes}}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                
                        <!-- /.box-footer -->
                        <div class="box-footer">
                            <a href="{{ URL::previous() }}" class="btn btn-warning" ><i class="fa  fa-arrow-circle-left"></i> Back</a>
                            <button type="submit" class="btn btn-info"><i class="fa fa-save"></i> Update</button>
                        </div>
                </form>
            @elseif(request()->is('noc-daily-report-show/*'))
                <!-- /.box-body -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group ">
                                <label class="" for="tiket_report">Nama User</label>  
                                <input type="text" name="tiket_report" class="form-control" id="tiket_report"  placeholder="Tiket Report" value="{{$data->tiket_report}}" disabled="disabled">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group ">
                                <label class="" for="id_user_rel">PIC NOC</label>  
                                @if (Auth::user()->role == "admin")
                                    
                                    <select class="form-control select2" name="id_user_rel" placeholder="" required disabled="disabled">
                                        <optgroup label="PIC NOC Saat Ini">
                                            <option  value="{{$data->jnsuser->id}}">{{$data->jnsuser->name}}</option>
                                        </optgroup>  
                                        <optgroup label="PIC NOC Baru">  
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
                                        </optgroup>
                                    </select>  
                                @elseif (Auth::user()->role == "noc")
                                    <input id="id_user_rel" name="" type="text" class="form-control"required autocomplete="off" placeholder="" value="{{Auth::user()->name}}" readonly>
                                    <input type="hidden" name="id_user_rel" value="{{Auth::user()->id}}" required readonly  >
                                @endif   
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group ">
                                <label class="" for="id_link_rel">Select Link</label>  
                                <select class="form-control select2" name="id_link_rel" placeholder="" required disabled="disabled">
                                    <optgroup label="PIC NOC Saat Ini">
                                        <option  value="{{$data->jnslink->id}}">{{$data->jnslink->name_link}} ({{$data->jnslink->vlan}})</option>
                                    </optgroup>  
                                    <optgroup label="PIC NOC Baru">  
                                        @foreach ($data_link as $item)
                                            <option value="{{$item->id}}">
                                                {{$item->name_link}} ({{$item->vlan}})
                                            </option>
                                        @endforeach
                                    </optgroup>
                                </select>  
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group ">
                                <label class="" for="issues">Issues</label>  
                                <input type="text" name="issues" class="form-control" id="issues"  placeholder="Issues" value="{{$data->issues}}" disabled="disabled">
                            </div>
                        </div>
                        
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group ">
                                <label class="" for="status">Status</label>  
                                <select class="form-control" name="status" placeholder="" required disabled="disabled">
                                    <optgroup label="Status Saat Ini">
                                        @if ($data->status == "ocn")
                                            <option style="background-color: #FFCA2C;color:#000;" value="{{$data->status}}">&#9201;&#65039; On Check NOC</option>
                                        @elseif ($data->status == "solved")
                                            <option style="background-color: #157347;color:#FFF;" value="{{$data->status}}">&#10004; Solved</option>
                                        @elseif ($data->status == "n_solved")
                                            <option style="background-color: #BB2D3B;color:#FFF;" value="{{$data->status}}">&#10006; Not Solved</option>
                                        @endif
                                    </optgroup>  
                                    <optgroup label="Status Baru">  
                                        <option style="background-color: #FFCA2C;color:#000;" value="ocn">&#9201;&#65039; On Check NOC</option>
                                        <option style="background-color: #157347;color:#FFF;" value="solved">&#10004; Solved</option>
                                        <option style="background-color: #BB2D3B;color:#FFF;" value="n_solved">&#10006; Not Solved</option>
                                    </optgroup>
                                </select>  
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group ">
                                <div class="row">
                                    @if ($data->dari_long != "1970-01-01 00:00:00" and $data->sampai_long != "1970-01-01 00:00:00")
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <div class="col-md-12">
                                                    <label for="picker-1" style="color: black; font-weight:bold;font-size:13px;" >Range Issues - From Time</label>                                    
                                                    <input id="picker-1" type="text" class="form-control" name="dari_long" value="{{date('Y/m/d H:i', strtotime($data->dari_long))}}" autocomplete="off" disabled="disabled">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <div class="col-md-12">
                                                    <label for="picker-2" style="color: black; font-weight:bold;font-size:13px;" >Range Issues - After Time </label>
                                                    <input id="picker-2" type="text" class="form-control" name="sampai_long" value="{{date('Y/m/d H:i', strtotime($data->sampai_long))}}" autocomplete="off" disabled="disabled">
                                                </div>
                                            </div>
                                        </div>
                                    @elseif ($data->dari_long == "1970-01-01 00:00:00" and $data->sampai_long != "1970-01-01 00:00:00")
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <div class="col-md-12">
                                                    <label for="picker-1" style="color: black; font-weight:bold;font-size:13px;" >Range Issues - From Time</label>                                    
                                                    <input id="picker-1" type="text" class="form-control" name="dari_long" value="" autocomplete="off" disabled="disabled">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <div class="col-md-12">
                                                    <label for="picker-2" style="color: black; font-weight:bold;font-size:13px;" >Range Issues - After Time </label>
                                                    <input id="picker-2" type="text" class="form-control" name="sampai_long" value="{{date('Y/m/d H:i', strtotime($data->sampai_long))}}" autocomplete="off" disabled="disabled">
                                                </div>
                                            </div>
                                        </div>
                                    @elseif ($data->dari_long != "1970-01-01 00:00:00" and $data->sampai_long == "1970-01-01 00:00:00")
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <div class="col-md-12">
                                                    <label for="picker-1" style="color: black; font-weight:bold;font-size:13px;" >Range Issues - From Time</label>                                    
                                                    <input id="picker-1" type="text" class="form-control" name="dari_long" value="{{date('Y/m/d H:i', strtotime($data->dari_long))}}" autocomplete="off" disabled="disabled">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <div class="col-md-12">
                                                    <label for="picker-2" style="color: black; font-weight:bold;font-size:13px;" >Range Issues - After Time </label>
                                                    <input id="picker-2" type="text" class="form-control" name="sampai_long" value="" autocomplete="off" disabled="disabled">
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <div class="col-md-12">
                                                    <label for="picker-1" style="color: black; font-weight:bold;font-size:13px;" >Range Issues - From Time</label>                                    
                                                    <input id="picker-1" type="text" class="form-control" name="dari_long" value="" autocomplete="off" disabled="disabled">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <div class="col-md-12">
                                                    <label for="picker-2" style="color: black; font-weight:bold;font-size:13px;" >Range Issues - After Time </label>
                                                    <input id="picker-2" type="text" class="form-control" name="sampai_long" value="" autocomplete="off" disabled="disabled">
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group ">
                                <label class="" for="solution">Solution</label>  
                                <input type="text" name="solution" class="form-control" id="solution"  placeholder="solution" value="{{$data->solution}}" disabled="disabled">
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group ">
                                <label class="" for="">*Notes*</label>
                                <textarea name="notes" id="" rows="5" style="width:100%;" disabled="disabled">{{$data->notes}}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
            @endif


            <!-- /.box-footer -->
        </div>
        <!-- /.box -->

    </section>    
@endsection

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
                timepicker: true,
                datepicker: true,
                format: 'Y/m/d H:i',
                // mask: true,
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


            if ($(this).val() != "solved") {
                $('#If_ocn_or_Nsolved_Range').show();
                $('#If_ocn_or_Nsolved_Solution').show();
            } else {
                $('#If_ocn_or_Nsolved_Range').hide();
                $('#If_ocn_or_Nsolved_Solution').hide();
            }
            
        });
        $("#status").trigger("change");
    </script>
@endpush
