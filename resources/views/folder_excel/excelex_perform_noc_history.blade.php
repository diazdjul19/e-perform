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
                        <th><b>Hallo {{Auth::user()->name}}, Berikut ini data Daily Report NOC : {{$getname->name}}.</b></th>
                    </tr>
                    <tr>
                        <th>Dari Tanggal : {{date('d M Y  | H:i', strtotime($data_dari_long))}}</th>
                    </tr>
                    <tr>
                        <th>Sampai Tanggal : {{date('d M Y  | H:i', strtotime($data_sampai_long))}}</th>
                    </tr>

                    <tr></tr>

                    <tr>
                        <th style="background-color:paleturquoise;">No</th>
                        <th style="width: 20px; background-color:paleturquoise;">Tiket</th>
                        <th style="width: 20px; background-color:paleturquoise;">PIC NOC</th>
                        <th style="width: 20px; background-color:paleturquoise; text-align:center;">Link</th>
                        <th style="width: 20px; background-color:paleturquoise; text-align:center;">Issues</th>
                        <th style="width: 20px; background-color:paleturquoise; text-align:center;">Range Issues</th>
                        <th style="width: 20px; background-color:paleturquoise; text-align:center;">Status</th>
                        <th style="width: 20px; background-color:paleturquoise; text-align:center;">Solution</th>
                        <th style="width: 20px; background-color:paleturquoise; text-align:center;">*Notes*</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($data_history as $d)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td style=""><a href="{{route('noc-daily-report-edit', $d->id)}}" style="color: #17a2b8;text-decoration:none;" data-toggle="tooltip" title="Click here to view or edit data" data-placement="top">{{$d->tiket_report}}</a></td>

                                    @if ($d->jnsuser != null)
                                        <td style="">
                                            {{$d->jnsuser->name}}
                                            @if ($d->jnsuser->role == "admin")
                                                (Admin)
                                            @elseif ($d->jnsuser->role == "noc")
                                                (NOC)
                                            @endif
                                        </td>
                                    @elseif ($d->jnsuser == null) 
                                        <td style="font-weight:bold;">ID Not Found !!!</td>
                                    @endif

                                    @if ($d->jnslink != null)
                                        <td style=" text-align:center;">{{$d->jnslink->name_link}} ({{$d->jnslink->vlan}})</td>
                                    @elseif ($d->jnslink == null) 
                                        <td style=" text-align:center; font-weight:bold;">ID Not Found !!!</td>
                                    @endif

                                    <td style="text-align:center;">{{$d->issues}}</td>

                                    @if ($d->dari_long != "1970-01-01 07:00:00" and $d->sampai_long != "1970-01-01 07:00:00")
                                        <td style="width:30px;text-align:center;">
                                            <span class="label label-success" style="font-size:12px; margin-left:2px; margin-right:2px;">
                                                {{date('d M Y  | H:i', strtotime($d->dari_long))}}
                                            </span>

                                            -

                                            <span class="label label-danger" style="font-size:12px; margin-left:2px; margin-right:2px;">
                                                {{date('d M Y  | H:i', strtotime($d->sampai_long))}}
                                            </span>
                                        </td>
                                    @else
                                        <td style="width:30px;text-align:center;">
                                            <span class="label label-default" style="font-size:12px; margin-left:2px; margin-right:2px;">
                                                From Time Or After Time, Not been set
                                            </span>
                                        </td>
                                    @endif
                                    
                                    <td style="text-align:center;">
                                        @if ($d->status == "ocn")
                                            <span class="label label-warning">On Check NOC</span>
                                        @elseif ($d->status == "solved")
                                            <span class="label label-primary">Solved</span>
                                        @elseif ($d->status == "n_solved")
                                            <span class="label label-danger">Not Solved</span>
                                        @endif
                                    </td>

                                    <td style="text-align:center;" class="text-center">{{$d->solution}}</td>
                                    <td style="text-align:center;" class="text-center">{{$d->notes}}</td>


                                </tr>
                            @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>