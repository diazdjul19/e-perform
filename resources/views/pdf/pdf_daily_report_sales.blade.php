<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
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
                        <p>Hallo {{Auth::user()->name}}, Berikut ini data Daily Report Sales. <br><br>
                            Tanggal : {{date("d M Y")}} <br>
                            Jam : {{date("H:i:s")}}
                        </p>
    
    
                    </li>
                </ul>
                <br>
                <ul class="list-group">
                    <li class="list-group-item active text-center"></li>
                    <li class="list-group-item">
                        <table class="table w-100">
                            <tr>
                                <th>No</th>
                                <th>Tiket Invoice</th>
                                <th>Report By</th>
                                <th>Name Client</th>
                                <th class="text-center">Capacity</th>
                                <th class="text-center">Site</th>
                                <th class="text-center">Margin Profit</th>
                                <th class="text-center">Status</th>
                            </tr>
                            @foreach ($data as $d)
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

                                    <td style="min-width:120px;text-align:center;">
                                        Rp. {{number_format($d->price_capacity_fromme - $d->price_capacity_vendor ,2,',','.')}}
                                    </td>

                                    <td class="text-center">
                                        @if ($d->status == "opn")
                                            <span class="label label-warning">On Process NOC</span>
                                        @elseif ($d->status == "finish")
                                            <span class="label label-primary">Finish</span>
                                        @elseif ($d->status == "fail")
                                            <span class="label label-danger">Fail</span>
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

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>    
</body>
</html>
