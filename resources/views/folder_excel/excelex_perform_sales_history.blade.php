<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Excel</title>
</head>

<body>
    <div class="row">
        <div class="col-md-12 table-responsive">
            <table >
                <thead style="background-color: black;">
                    <tr>
                        <th><b>Tanggal Download : {{date('l, d F Y')}}</b></th>
                    </tr>
                    <tr></tr>
                    <tr>
                        <th><b>Hallo {{Auth::user()->name}}, Berikut ini data Daily Report Sales : {{$getname->name}}.</b></th>
                    </tr>
                    <tr>
                        <th>Dari Tanggal : {{date('d M Y  | H:i', strtotime($data_dari_long))}}</th>
                    </tr>
                    <tr>
                        <th>Sampai Tanggal : {{date('d M Y  | H:i', strtotime($data_sampai_long))}}</th>
                    </tr>

                    <tr></tr>

                    <tr>
                        <th >No</th>
                        <th style="width:20px;">Tiket</th>
                        <th style="width:20px;">Report By</th>
                        <th style="width:20px;">Nama Client</th>
                        <th style="width:20px;text-align:center">Capacity</th>
                        <th style="width:20px;text-align:center">Site</th>
                        <th style="width:20px;text-align:center">Status</th>
                        <th style="width:40px;text-align:center">Harga Dari Vendor</th>
                        <th style="width:40px;text-align:center">Harga Bandwith Tanpa PPN</th>
                        <th style="width:20px;text-align:center">PPN ( % )</th>
                        <th style="width:40px; background-color:#1bb1e7;text-align:center">Total Harga + PPN ( Rp. )</th>
                        <th style="width:40px; background-color:#1be7aa;text-align:center">Margin Profit</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($data_history as $d)
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

                            <td  style="min-width:120px;text-align:center;">
                                @if ($d->status == "opn")
                                    <span class="label label-warning">On Process NOC</span>
                                @elseif ($d->status == "finish")
                                    <span class="label label-primary">Finish</span>
                                @elseif ($d->status == "fail")
                                    <span class="label label-danger">Fail</span>
                                @endif
                            </td>
                            <td style="min-width:200px;text-align:center;">Rp. {{number_format($d->price_capacity_vendor,2,',','.')}}</td>
                            <td style="min-width:200px;text-align:center;">Rp. {{number_format($d->price_capacity_fromme,2,',','.')}}</td>
                            <td style="min-width:100px;text-align:center;">{{$d->ppn_percentage}} %</td>
                            <td style="min-width:200px;text-align:center; background-color:#95daf3;"> Rp. {{number_format($d->subtotal_plus_ppn,2,',','.')}} </td>
                            <td style="min-width:120px;text-align:center; background-color:#9cffe1;">
                                Rp. {{number_format($d->price_capacity_fromme - $d->price_capacity_vendor ,2,',','.')}}
                            </td>

                            

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>