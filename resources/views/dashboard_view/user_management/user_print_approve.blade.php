<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>E-Perfotm | Print User</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="/assets-admin/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/assets-admin/bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="/assets-admin/bower_components/Ionicons/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/assets-admin/dist/css/AdminLTE.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body onload="window.print();">
    <div class="wrapper">
    <!-- Main content -->
    <section class="invoice">
        <table width="100%">
            <tr>
                <td width="10%" align="center">
                    <img src="{{asset('image-inject/logo-imedianet-kecil.png')}}" alt="" width="100px" height="75px">
                </td>
                <td width="80%" align="center">
                        <font size="4">PT IKHLAS CIPTA TEKNOLOGI (ISP)</font> <br>
                        <font size="2">Jl. Masjid Al Mochtar Jl. Malaka No.4, RT.3/RW.8, Munjul, Kec. Cipayung, Kota Jakarta Timur, </font><br>
                        <font size="2">Daerah Khusus Ibukota Jakarta 13850</font><br>
                </td>
                <td width="10%" align="center">
                    <img src="{{asset('image-inject/diazgithub.png')}}" alt="" width="100px" height="75px">
                </td>
            </tr>
        </table>
        <br>
        <div class="row">
            <div class="col-md-12">
                <ul class="list-group">
                    <li class="list-group-item active">
                        <br>
                        <p>Hallo {{Auth::user()->name}}, Berikut ini data user yang telah anda setujui. <br><br>
                            Tanggal : {{date("d M Y")}} <br>
                            Jam : {{date("H:i:s")}}
                        </p>
    
    
                    </li>
                </ul>
                <br>
                <ul class="list-group">
                    <li class="list-group-item active text-center">Data User Approved.</li>
                    <li class="list-group-item">
                        <table class="table w-100">
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>No Telp</th>
                                <th>Role</th>
                                <th>Status</th>
                            </tr>
                            @foreach ($data as $d)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$d->name}}</td>
                                    <td>{{$d->email}}</td>
                                    <td>{{$d->no_telp}}</td>
                                    <td>
                                        @if ($d->role == "admin")
                                            Admin                                  
                                        @elseif($d->role == "noc")
                                            NOC
                                        @elseif($d->role == "sales")
                                            Sales
                                        @endif
                                    </td>
                                    <td>
                                        @if ($d->status == "P")
                                            Pending                                  
                                        @elseif($d->status == "A")
                                            Active
                                        @elseif($d->status == "NA")
                                            Not Active
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
    
                        </table>
                    </li>
                </ul> 
            </div>
        </div>
    </section>
    <!-- /.content -->
    </div>
<!-- ./wrapper -->
</body>
</html>
