@extends('layouts.master_dashboard')
@section('content-wrapper')
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                <i class="fa fa-users"></i>
                User Management
                @if (request()->is('user-registration'))
                    <span style="font-size: 13px;">| User Registration</span>
                @elseif(request()->is('user-approved'))
                    <span style="font-size: 13px;">| User Approved</span>
                @elseif(request()->is('user-rejected'))
                    <span style="font-size: 13px;">| User Rejected</span>
                @endif
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> E-Perform</a></li>
                <li><a href="#">User Management</a></li>

                @if (request()->is('user-registration'))
                    <li class="active">User Registration</li>
                @elseif(request()->is('user-approved'))
                    <li class="active">User Approved</li>
                @elseif(request()->is('user-rejected'))
                    <li class="active">User Rejected</li>
                @endif

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
                            <h4 class="modal-title"><i class="fa fa-user-plus" aria-hidden="true"></i> Tambah User Baru</h4>
                        </div>

                        <form action="{{route('user-store')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group row" style="margin:0px;">
                                            <label class="col-md-2 col-form-label" for="name"><h6 style="color: black; font-weight:bold;font-size:13px;">Nama <span style="color: red;">*</span></h6></label>
                                            
                                            <div class="col-md-10">
                                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" placeholder="Name" autofocus>
                                                @error('name')
                                                    <span class="invalid-feedback" role="alert" style="color: red;">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            
                                        </div>
                                        <div class="form-group row" style="margin:0px;">
                                            <label class="col-md-2 col-form-label" for="email"><h6 style="color: black; font-weight:bold;font-size:13px;">Email <span style="color: red;">*</span></h6></label>
                                            
                                            <div class="col-md-10">
                                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email">
                                                @error('email')
                                                    <span class="invalid-feedback" role="alert" style="color: red;">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row" style="margin:0px;">
                                            <label class="col-md-2 col-form-label" for="no_telp"><h6 style="color: black; font-weight:bold;font-size:13px;">No Telp</h6></label>
                                            
                                            <div class="col-md-10">
                                                <input type="text" name="no_telp" class="form-control input-sm" id="no_telp" placeholder=""  >
                                            </div>
                                        </div>
                                        <div class="form-group row" style="margin:0px;">
                                            <label class="col-md-2 col-form-label" for="foto_user"><h6 style="color: black; font-weight:bold;font-size:13px;">Foto User</h6></label>
                                            
                                            <div class="col-md-10">
                                                <input type="file" name="foto_user" class="form-control input-sm" id="foto_user" placeholder="">
                                                <span class="text-danger" style="font-size: 10px;">*Max Upload : 10MB</span> <br>

                                                @error('foto_user')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row" style="margin:0px;">
                                            <label class="col-md-2 col-form-label" for="foto_ktp"><h6 style="color: black; font-weight:bold;font-size:13px;">Foto KTP</h6></label>
                                            
                                            <div class="col-md-10">
                                                <input type="file" name="foto_ktp" class="form-control input-sm" id="foto_ktp" placeholder="">
                                                <span class="text-danger" style="font-size: 10px;">*Max Upload : 10MB</span> <br>

                                                @error('foto_ktp')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row" style="margin:0px;">
                                            <label class="col-md-2 col-form-label" for=""><h6 style="color: black; font-weight:bold;font-size:13px;">Security <span style="color: red;">*</span></h6></label>
                                            
                                            <div class="col-md-5">
                                                <div class="input-group">
                                                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror input-sm" id="password" placeholder="Password"  required >
                                                    <div class="input-group-addon"><i class="glyphicon glyphicon-eye-open" arial-hidden="true" id="eye1" onclick="toggle1()"></i></div>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="input-group">
                                                    <input type="password" name="password_confirmation" class="form-control input-sm" id="password-confirm" placeholder="Confirm Password"  required >
                                                    <div class="input-group-addon"><i class="glyphicon glyphicon-eye-open" arial-hidden="true" id="eye2" onclick="toggle2()"></i></div>
                                                </div>
                                            </div>
                                            @error('password')
                                                <span class="invalid-feedback" role="alert" style="color: red; margin-left:15px;">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group row" style="margin:0px;">
                                            <label class="col-md-2 col-form-label" for="role"><h6 style="color: black; font-weight:bold;font-size:13px;">Role <span style="color: red;">*</span></h6></label>
                                            
                                            <div class="col-md-10">
                                                <select class="form-control" name="role" id="role" >
                                                    <optgroup label="Pilih Role" >
                                                        <option value selected disabled>Pilih Role</option>
                                                        <option value="noc">NOC</option>
                                                        <option value="sales">Sales</option>
                                                    </optgroup>
                                                </select>
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
                <form action="{{route('select-delete-user')}}" method="post" >
                    @csrf
                    <div class="box-header with-border">
                        <h3 class="box-title">Table User Management</h3>
        
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                                    title="Collapse">
                            <i class="fa fa-minus"></i></button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                            <i class="fa fa-times"></i></button>
                        </div>
        
                        <div class="row">
                            <div class="col-md-6">
                                @if (request()->is('user-registration'))
                                    <button type="button" class="btn btn-info btn-sm" style="margin-top: 10px;" data-toggle="modal" data-target="#modal-create"><i class="fa fa-user-plus"></i> Tambah</button>
                                    <button type="button" class="btn btn-danger btn-sm" style="margin-top: 10px;" id="btn-co-delete" name="select_delete[]" type="submit">
                                        <i class="fa fa-trash" aria-hidden="true"></i> Hapus
                                    </button>
                                @elseif(request()->is('user-approved'))
                                    <button type="button" class="btn btn-info btn-sm" style="margin-top: 10px;"><i class="fa fa-print"></i> Print</button>
                                    <button type="button" class="btn btn-danger btn-sm" style="margin-top: 10px;" id="btn-co-delete" name="select_delete[]" type="submit">
                                        <i class="fa fa-trash" aria-hidden="true"></i> Hapus
                                    </button>
                                @elseif(request()->is('user-rejected'))
                                    <button type="button" class="btn btn-info btn-sm" style="margin-top: 10px;"><i class="fa fa-print"></i> Print</button>
                                    <button type="button" class="btn btn-danger btn-sm" style="margin-top: 10px;" id="btn-co-delete" name="select_delete[]" type="submit">
                                        <i class="fa fa-trash" aria-hidden="true"></i> Hapus
                                    </button>
                                @endif
                                
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
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th class="text-center">Role</th>
                                        <th class="text-center">Status </th>
                                        <th class="text-center" style="padding:5px; min-width:80px;">&#128073; <input type="checkbox" id="cekall" style="margin-bottom: 10px;"  data-toggle="tooltip" title="Click here to Check All" data-placement="top"> &#128072;</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($data as $d)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            @if (request()->is('user-registration'))
                                                <td style="min-width:120px;"><a href="{{route('user-editregistration', $d->id)}}" style="color: #17a2b8;text-decoration:none;" data-toggle="tooltip" title="Click here to view or edit data" data-placement="top">{{$d->name}}</a></td>
                                            @elseif(request()->is('user-approved'))
                                                <td style="min-width:120px;"><a href="{{route('user-editapproved', $d->id)}}" style="color: #17a2b8;text-decoration:none;" data-toggle="tooltip" title="Click here to view or edit data" data-placement="top">{{$d->name}}</a></td>
                                            @elseif(request()->is('user-rejected'))
                                                <td style="min-width:120px;"><a href="{{route('user-editrejected', $d->id)}}" style="color: #17a2b8;text-decoration:none;" data-toggle="tooltip" title="Click here to view or edit data" data-placement="top">{{$d->name}}</a></td>
                                            @endif
                                            
                                            <td>{{$d->email}}</td>
                                            <td class="text-center">
                                                @if ($d->role == "admin")
                                                    <span class="label label-default">Admin</span>
                                                @elseif ($d->role == "noc")
                                                    <span class="label label-primary">NOC</span>
                                                @elseif ($d->role == "sales")
                                                    <span class="label label-info">Sales</span>
                                                @endif
                                            </td>
                                        
                                            <td class="text-center">                   
                                                @if ($d->role == 'admin')
                                                    @if ($d->status == 'P')
                                                        <a href="{{route('user.active', $d->id)}}" id="" class="label label-warning" style="font-size: 12px;" data-toggle="tooltip" title="Click here to Activate" data-placement="top"><i class="fa fa-clock-o"></i> Belum Aktif</a>
                                                    @elseif ($d->status == 'NA')
                                                        <a href="{{route('user.active', $d->id)}}" id="" class="label label-danger" style="font-size: 12px;" data-toggle="tooltip" title="Click here to Activate" data-placement="top"><i class="fa fa-times"></i> User Not Active</a>
                                                    @elseif($d->status == 'A')
                                                        <span class="label label-primary" style="font-size: 12px;"><i class="fa fa-check-square-o"></i> Admin Aktif</span>
                                                    @endif
                                                @elseif ($d->role != 'admin')
                                                    @if ($d->status == 'P')
                                                        <a href="{{route('user.active', $d->id)}}" id="" class="label label-warning" style="font-size: 12px;" data-toggle="tooltip" title="Click here to Activate" data-placement="top"><i class="fa fa-clock-o"></i> Belum Aktif</a>
                                                    @elseif ($d->status == 'NA')
                                                        <a href="{{route('user.active', $d->id)}}" id="" class="label label-danger" style="font-size: 12px;" data-toggle="tooltip" title="Click here to Activate" data-placement="top"><i class="fa fa-times"></i> User Not Active</a>
                                                    @elseif($d->status == 'A')
                                                        <a  href="{{route('user.not-active', $d->id)}}" id="" class="label label-info" style="font-size: 12px;"  data-toggle="tooltip" title="Click here to Turn Off" data-placement="top"><i class="fa fa-check-square-o"></i> User Aktif</a>
                                                    @endif 
                                                @endif
                                            </td>
                                            <td class="text-center"><input type="checkbox" name="select_delete[]" value="{{$d->id}}"></td>
                                        </tr>
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

@push('max-img')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            
            var uploadFieldUsr = document.getElementById("foto_user");
            var uploadFieldKtp = document.getElementById("foto_ktp");


            uploadFieldUsr.onchange = function() {
                if(this.files[0].size > 1e+7){
                // alert("Maximum Image Upload Size 10MB!");
                Swal.fire({
                    icon: 'error',
                    title: 'Sorry...',
                    text: 'Maximum Image Upload Size 10MB!',
                    
                });
                this.value = "";
                };
            };

            uploadFieldKtp.onchange = function() {
                if(this.files[0].size > 1e+7){
                // alert("Maximum Image Upload Size 10MB!");
                Swal.fire({
                    icon: 'error',
                    title: 'Sorry...',
                    text: 'Maximum Image Upload Size 10MB!',
                    
                });
                this.value = "";
                };
            };
        } );
    </script>

@endpush

@push('show-hide-password')
    <script>
        var state= false;
        function toggle1() {
            if (state) {
                document.getElementById(
                    "password").
                    setAttribute("type", "password");
                document.getElementById(
                    "eye1").style.color='#7a797e';
                state = false;
            }else{
                document.getElementById(
                    "password").
                    setAttribute("type", "text");
                document.getElementById(
                    "eye1").style.color='#5887ef';
                state = true;
            }
        }

        function toggle2() {
            if (state) {
                document.getElementById(
                    "password-confirm").
                    setAttribute("type", "password");
                document.getElementById(
                    "eye2").style.color='#7a797e';
                state = false;
            }else{
                document.getElementById(
                    "password-confirm").
                    setAttribute("type", "text");
                document.getElementById(
                    "eye2").style.color='#5887ef';
                state = true;
            }
        }
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