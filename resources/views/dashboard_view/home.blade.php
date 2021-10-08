@extends('layouts.master_dashboard')
@section('content-wrapper')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-dashboard"></i>
            Dashboard
            <small>...</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> E-Perform</a></li>
            <li><a href="#">Dashboard</a></li>
            <li class="active">Dashboard</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-aqua">
                <span class="info-box-icon"><i class="fa fa-users"></i></span>

                <div class="info-box-content">
                <span class="info-box-text">Total User Active</span>
                <span class="info-box-number">{{$data_user}} User</span>

                <div class="progress">
                    <div class="progress-bar" style="width: 100%"></div>
                </div>
                    <span class="progress-description">
                        Lorem ipsum, dolor sit amet consectetur adipisicing elit.
                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-green">
                <span class="info-box-icon"><i class="fa fa-street-view"></i></span>

                <div class="info-box-content">
                <span class="info-box-text">Total Client</span>
                <span class="info-box-number">{{$data_client}} Client</span>

                <div class="progress">
                    <div class="progress-bar" style="width: 100%"></div>
                </div>
                    <span class="progress-description">
                        Lorem ipsum, dolor sit amet consectetur adipisicing elit.
                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-yellow">
                <span class="info-box-icon"><i class="fa fa-file-text"></i></span>

                <div class="info-box-content">
                <span class="info-box-text">Total Report Sales</span>
                <span class="info-box-number">{{$data_sales_report}}</span>

                <div class="progress">
                    <div class="progress-bar" style="width: 100%"></div>
                </div>
                    <span class="progress-description">
                        Lorem ipsum, dolor sit amet consectetur adipisicing elit.
                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-red">
                <span class="info-box-icon"><i class="fa fa-file-text"></i></span>

                <div class="info-box-content">
                <span class="info-box-text">Total Report NOC</span>
                <span class="info-box-number">{{$data_noc_report}}</span>

                <div class="progress">
                    <div class="progress-bar" style="width: 100%"></div>
                </div>
                    <span class="progress-description">
                        Lorem ipsum, dolor sit amet consectetur adipisicing elit.
                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            </div>
            <!-- /.col -->
        </div>

        <br>

        <div class="row">
            <div class="col-md-3">
                <!-- Profile Image -->
                <div class="box box-primary">
                    <div class="box-body box-profile">
                    @if (Auth::user()->foto_user == true)
                        <img class="profile-user-img img-responsive img-circle" src="{{url('/storage/user/'.Auth::user()->foto_user)}}" alt="User profile picture">
                    @else
                        <img src="/assets-eperform/nopicture2.png" class="profile-user-img img-responsive img-circle" alt="User profile picture">
                    @endif

                    <h3 class="profile-username text-center">{{ Auth::user()->name }}</h3>

                    <p class="text-muted text-center">{{ Auth::user()->email }}</p>

                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">
                        <b>Hak Akses</b> <a class="pull-right">
                            @if (Auth::user()->role == "admin")
                                <span class="label label-primary" style="">Admin</span>                                  
                            @elseif(Auth::user()->role == "noc")
                                <span class="label label-info" style="">NOC</span>
                            @elseif(Auth::user()->role == "sales")
                                <span class="label label-info" style="">Sales</span>
                            @endif
                        </a>
                        </li>
                    </ul>

                    @if (Auth::user()->role == "admin")
                        @if ($data_mngr == null)
                            <form action="{{route('mngr-store')}}" method="post">
                                @csrf
                                <ul class="list-group list-group-unbordered">
                                    <li class="list-group-item">
                                        <label for=""><b>Mngr login</b></label>
                                        <select class="form-control" name="mngr_login" id="" required>
                                            <option value selected disabled>Pilih Status</option>
                                            <option value="true">True</option>
                                            <option value="false">False</option>
                                        </select>
                                    </li>
                                    <li class="list-group-item">
                                        <label for=""><b>Mngr Register <span style="color: red;">*</span></b></label>
                                        <select class="form-control" name="mngr_register" id="" required>
                                            <option value selected disabled>Pilih Status</option>
                                            <option value="true">True</option>
                                            <option value="false">False</option>
                                        </select>
                                    </li>
                                    <li class="list-group-item">
                                        <label for=""><b>Mngr FgPasword</b></label>
                                        <select class="form-control" name="mngr_fgpassword" id="" required>
                                            <option value selected disabled>Pilih Status</option>
                                            <option value="true">True</option>
                                            <option value="false">False</option>
                                        </select>
                                    </li>
                                </ul>
                                <button type="submit" class="btn btn-primary btn-block">Save</button>
                            </form>
                        @elseif ($data_mngr != null)
                            <form action="{{route('mngr-update', $data_mngr->id)}}" method="post">
                                @csrf
                                {{method_field('put')}}

                                <ul class="list-group list-group-unbordered">
                                    <li class="list-group-item">
                                        <label for=""><b>Mngr login</b></label>
                                        <select class="form-control" name="mngr_login" id="" required>
                                            <optgroup label="Mngr Login Saat Ini">
                                                <option value="{{$data_mngr->mngr_login}}">
                                                    @if ($data_mngr->mngr_login == "true")
                                                        True
                                                    @elseif ($data_mngr->mngr_login == "false")
                                                        False
                                                    @endif
                                                </option>
                                            </optgroup>
                                            <optgroup label="Mngr Login Baru">
                                                <option value="true">True</option>
                                                <option value="false">False</option>
                                            </optgroup>
                                        </select>
                                    </li>
                                    <li class="list-group-item">
                                        <label for=""><b>Mngr Register <span style="color: red;">*</span></b></label>
                                        <select class="form-control" name="mngr_register" id="" required>
                                            <optgroup label="Mngr Register Saat Ini">
                                                <option value="{{$data_mngr->mngr_register}}">
                                                    @if ($data_mngr->mngr_register == "true")
                                                        True
                                                    @elseif ($data_mngr->mngr_register == "false")
                                                        False
                                                    @endif
                                                </option>
                                            </optgroup>
                                            <optgroup label="Mngr Register Baru">
                                                <option value="true">True</option>
                                                <option value="false">False</option>
                                            </optgroup>
                                        </select>
                                    </li>
                                    <li class="list-group-item">
                                        <label for=""><b>Mngr FgPasword</b></label>
                                        <select class="form-control" name="mngr_fgpassword" id="" required>
                                            <optgroup label="Mngr FgPassword Saat Ini">
                                                <option value="{{$data_mngr->mngr_fgpassword}}">
                                                    @if ($data_mngr->mngr_fgpassword == "true")
                                                        True
                                                    @elseif ($data_mngr->mngr_fgpassword == "false")
                                                        False
                                                    @endif
                                                </option>
                                            </optgroup>
                                            <optgroup label="Mngr FgPassword Baru">
                                                <option value="true">True</option>
                                                <option value="false">False</option>
                                            </optgroup>
                                        </select>
                                    </li>
                                </ul>
                                <button type="submit" class="btn btn-primary btn-block">Save</button>
                            </form>
                        @endif
                    @endif

                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <div class="col-md-9">
                <!-- MAP & BOX PANE -->
                <div class="box box-success">
                    <div class="box-header with-border">
                    <h3 class="box-title">Google Maps (INET Media)</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body no-padding">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card bd-0 shadow-base" style="padding: 15px;">
                                        <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15861.648558208131!2d106.896133!3d-6.340633!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x5f4e9b9d813ead75!2sInet%20Media!5e0!3m2!1sen!2sid!4v1631713713271!5m2!1sen!2sid" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                                    </div><!-- card -->

                                    <div class="input-group input-group-sm" style="padding:15px;">
                                        <input type="text" class="form-control" placeholder='Size recommendation : width="100%" height="450"'>
                                            <span class="input-group-btn">
                                            <button type="button" class="btn btn-info btn-flat">Start Iframe!</button>
                                            </span>
                                    </div>
                                </div>
                            </div>

                        </div>
                        
                    </div>
                    <!-- /.row -->
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection

