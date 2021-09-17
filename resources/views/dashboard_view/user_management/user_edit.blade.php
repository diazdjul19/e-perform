@extends('layouts.master_dashboard')
@section('content-wrapper')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-user"></i>
            Edit Data User
            <small>...</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> E-Perform</a></li>
            <li><a href="{{route('home')}}">User Management</a></li>
            @if (request()->is('user-editregistration/*'))
                <li><a href="{{route('user-registration')}}">User Registration </a></li>
            @elseif(request()->is('user-editapproved/*'))
                <li><a href="{{route('user-approved')}}">User Approved </a></li>
            @elseif(request()->is('user-editrejected/*'))
                <li><a href="{{route('user-rejected')}}">User Rejected </a></li>
            @endif
            <li class="active">User Edit</li>
        </ol>
    </section>

    <section class="content">

        {{--Start Alert --}}
            @if ($message = Session::get('success_edit_profil'))
                <div class="box box-info box-solid">
                    <div class="box-header with-border">
                        <h4 class="box-title"><i class="fa fa-info-circle"></i>  Success Edit Profil</h4>

                        <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                        <!-- /.box-tools -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        {{ $message }}
                    </div>
                    <!-- /.box-body -->
                </div>
            @endif

            @if ($message = Session::get('error_edit_profil'))
                <div class="box box-danger box-solid">
                    <div class="box-header with-border">
                        <h4 class="box-title"><i class="fa fa-info-circle"></i>  Error Edit Profil</h4>

                        <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                        <!-- /.box-tools -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        {{ $message }}
                    </div>
                    <!-- /.box-body -->
                </div>
            @endif
            

            @if ($message = Session::get('success_edit_password'))
                <div class="box box-success box-solid">
                    <div class="box-header with-border">
                        <h4 class="box-title"><i class="fa fa-info-circle"></i>  Success Edit Password</h4>

                        <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                        <!-- /.box-tools -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        {{ $message }}
                    </div>
                    <!-- /.box-body -->
                </div>
            @endif

            @if ($message = Session::get('pass_copass_tidak_sama'))
                <div class="box box-danger box-solid">
                    <div class="box-header with-border">
                        <h4 class="box-title"><i class="fa fa-info-circle"></i>  Error Edit Password</h4>

                        <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                        <!-- /.box-tools -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        {{ $message }}
                    </div>
                    <!-- /.box-body -->
                </div>
            @endif

            @if ($message = Session::get('error_old_password'))
                <div class="box box-danger box-solid">
                    <div class="box-header with-border">
                        <h4 class="box-title"><i class="fa fa-info-circle"></i>  Error Edit Password</h4>

                        <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                        <!-- /.box-tools -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        {{ $message }}
                    </div>
                    <!-- /.box-body -->
                </div>
            @endif

            
        {{-- End Alert --}}

        <!-- Default box -->
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-user"></i> Form Edit Profil</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                            title="Collapse">
                    <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                    <i class="fa fa-times"></i></button>
                </div>
            </div>

            <form class="form-sample" action="{{route('user-update', $data->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    {{method_field('put')}}

                    <!-- /.box-body -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label class="" for="exampleInputEmail1">Nama User</label>  
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }} {{$data->name}}" required autocomplete="name" placeholder="Name">
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror                                 
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="l" for="exampleInputEmail1">Email User </label>
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}  {{$data->email}}" required autocomplete="email" placeholder="Email">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="" for="exampleInputEmail1">Nomer Telpon</label>
                                    <input type="text" name="no_telp" class="form-control" id="exampleInputEmail1"  placeholder="Nomer Telpon" value="{{$data->no_telp}}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                @if (Auth::user()->role == 'admin')
                                    <div class="form-group">                      
                                        <label class="" for="exampleInputEmail1">Role User</label>
                                        <select class="form-control" name="role" placeholder="role" required>
                                            <optgroup label="Role Saat Ini">
                                                <option  value="{{$data->role}}">
                                                    @if ($data->role == 'admin')
                                                        <span>Admin</span>
                                                    @elseif($data->role == 'noc')
                                                        <span>NOC</span>
                                                    @elseif($data->role == 'sales')
                                                        <span>Sales</span>      
                                                    @endif
                                                </option>
                                            </optgroup>  
                                            <optgroup label="Role Baru">  
                                                <option value="admin">Admin</option>
                                                <option value="noc">NOC</option>
                                                <option value="sales">Sales</option>
                                            </optgroup>
                                        </select>                                    
                                    </div>
                                @elseif(Auth::user()->role != 'admin')
                                    <div class="form-group">                      
                                        <label class="" for="exampleInputEmail1">Role User</label>
                                        <select class="form-control" name="role" placeholder="role" required>
                                            <optgroup label="Role Saat Ini">
                                                <option  value="{{$data->role}}">
                                                    @if ($data->role == 'admin')
                                                        <span>Admin</span>
                                                    @elseif($data->role == 'noc')
                                                        <span>NOC</span>
                                                    @elseif($data->role == 'sales')
                                                        <span>Sales</span>      
                                                    @endif
                                                </option>
                                            </optgroup>  
                                        </select>                                    
                                    </div>
                                @endif
                            </div>
                        </div>

                        
                        <div class="row">
                            <div class="col-md-6">
                                @if (Auth::user()->role == 'admin')
                                    <div class="form-group">                      
                                        <label class="" for="exampleInputEmail1">Status User</label>
                                        <select class="form-control" name="status" placeholder="status" required>
                                            <optgroup label="Status Saat Ini">
                                                <option  value="{{$data->level}}">
                                                    @if ($data->status == 'A')
                                                        <span>Active</span>
                                                    @elseif($data->status == 'NA')
                                                        <span>Not Active</span>
                                                    @elseif($data->status == 'P')
                                                        <span>Pending</span>        
                                                    @endif
                                                </option>
                                            </optgroup>  
                                            <optgroup label="Status Baru">  
                                                <option value="A">Active</option>
                                                <option value="NA">Not Active</option>
                                                <option value="P">Pending</option>
                                            </optgroup>
                                        </select>                                    
                                    </div>
                                @elseif(Auth::user()->role != 'admin')
                                    <div class="form-group">                      
                                        <label class="" for="exampleInputEmail1">Status User</label>
                                        <select class="form-control" name="status" placeholder="status" required>
                                            <optgroup label="Status Saat Ini">
                                                <option  value="{{$data->level}}">
                                                    @if ($data->status == 'A')
                                                        <span>Active</span>
                                                    @elseif($data->status == 'NA')
                                                        <span>Not Active</span>
                                                    @elseif($data->status == 'P')
                                                        <span>Pending</span>        
                                                    @endif
                                                </option>
                                            </optgroup>  
                                        </select>                                    
                                    </div>
                                @endif
                                
                            </div>

                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="" for="exampleInputEmail1">Foto KTP</label>
                                        <div class="form-group">                      
                                            @if($data->foto_ktp)
                                                <a href="{{url('/storage/foto_ktp/'.$data->foto_ktp)}}" data-toggle="lightbox" data-type="image" data-footer="Foto KTP Milik : {{$data->name}}">
                                                    <img src="{{url('/storage/foto_ktp/'.$data->foto_ktp)}}" style="width: 97px; max-height:60px; border-radius:5px;">
                                                </a>
                                            @endif
                                            <input type="file" name="foto_ktp" class="form-control" id="exampleInputEmail1"  placeholder="User Photo" value="{{$data->foto_ktp}}">
                                        </div>
                                    </div>
    
                                    <div class="col-md-6">
                                        <label class="" for="exampleInputEmail1">Foto Profil</label>
                                        <div class="form-group">                      
                                            @if($data->foto_user)
                                                <a href="{{url('/storage/user/'.$data->foto_user)}}" data-toggle="lightbox" data-type="image" data-footer="Foto Profil Milik : {{$data->name}}">
                                                    <img src="{{url('/storage/user/'.$data->foto_user)}}" style="width: 97px; max-height:60px; border-radius:5px;">
                                                </a>
                                            @endif
                                            <input type="file" name="foto_user" class="form-control" id="exampleInputEmail1"  placeholder="User Photo" value="{{$data->foto_user}}">
                                        </div>
                                    </div>
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

            <!-- /.box-footer -->
        </div>
        <!-- /.box -->


        
        <!-- Default box -->
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-expeditedssl"></i> Form Edit Password</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                            title="Collapse">
                    <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                    <i class="fa fa-times"></i></button>
                </div>
            </div>

            <form class="form-sample" action="{{route('user-update-password', $data->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                {{method_field('put')}}

                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="l" for="exampleInputEmail1">Email User </label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}  {{$data->email}}" required autocomplete="email" placeholder="Email" readonly>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                                <div class="form-group ">
                                    <label class="" for="exampleInputEmail1">Password Lama</label> 
                                    <div class="input-group">
                                        <input type="password" name="old_password" class="form-control" id="oldpassword" placeholder="Password Lama"  >
                                        <div class="input-group-addon"><i class="glyphicon glyphicon-lock" arial-hidden="true" id="eye_old_pass" onclick="toggle_old_pass()"></i></div>
                                    </div>
                                    @if ($message = Session::get('error_old_password'))
                                        <strong style="color:red;">{{ $message }}</strong>
                                    @endif                               
                                </div>
                            </div>
                    </div>
                    

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group ">
                                <label class="" for="exampleInputEmail1">Password</label>
                                <div class="input-group">
                                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Password"  >
                                    <div class="input-group-addon"><i class="glyphicon glyphicon-lock" arial-hidden="true" id="eye1" onclick="toggle1()"></i></div>
                                </div>
                                @if ($message = Session::get('non_new_pass'))
                                    <strong style="color:red;">{{ $message }}</strong>
                                @endif
                                @if ($message = Session::get('pass_copass_tidak_sama'))
                                    <strong style="color:red;">{{ $message }}</strong>
                                @endif  
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group ">
                                <label class="" for="exampleInputEmail1">Password Confirmation</label> 
                                <div class="input-group">
                                    <input type="password" name="password_confirmation" class="form-control" id="password-confirm" placeholder="Confirm Password"  >
                                    <div class="input-group-addon"><i class="glyphicon glyphicon-lock" arial-hidden="true" id="eye2" onclick="toggle2()"></i></div>
                                </div>
                                @if ($message = Session::get('pass_copass_tidak_sama'))
                                    <strong style="color:red;">{{ $message }}</strong>
                                @endif                               
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
            
        </div>
        
        <!-- /.box -->
    </section>


    
@endsection

@push('show-hide-password')
    <script>
        var state= false;

        function toggle_old_pass() {
            if (state) {
                document.getElementById(
                    "oldpassword").
                    setAttribute("type", "password");
                document.getElementById(
                    "eye_old_pass").style.color='#7a797e';
                state = false;
            }else{
                document.getElementById(
                    "oldpassword").
                    setAttribute("type", "text");
                document.getElementById(
                    "eye_old_pass").style.color='#5887ef';
                state = true;
            }
        }

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

@push('lightbox')
    <script type="text/javascript">
        $(document).ready(function() {
            // $.noConflict();
            $(document).on('click', '[data-toggle="lightbox"]', function(event) {
                // alert("clicked"); //to test this function ran
                event.preventDefault();
                $(this).ekkoLightbox();
            });
        } );
        
    </script>
@endpush
