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
                        <p>Hallo {{Auth::user()->name}}, Berikut ini data detail Daily Report Sales {{$data->tiket_report}}. <br><br>
                            Tanggal : {{date("d M Y")}} <br>
                            Jam : {{date("H:i:s")}}
                        </p>
    
    
                    </li>
                </ul>
                <br>
                <div class="row">
                    <div class="row justify-content-center" style="padding: 0px 15px 0px 15px;">                
                        <div class="col-sm-6">
                            <table class="table w-100">
                                <tr>
                                    <th>Report By</th>
                                    <td>{{$data->jnsuser->name}}</td>
                                </tr>
                                <tr>
                                    <th>Name Client</th>
                                    <td>{{$data->jnsclient->name_client}}</td>
                                </tr>
                                <tr>
                                    <th>Capacity Bandwith</th>
                                    <td>
                                        {{$data->jnscapacity->bandwith_capacity}} {{$data->jnscapacity->type_trasfer}} ||
                                        @inject('vendor', 'App\Models\MsVendor')
                                        {{substr($vendor->where('id', $data->jnscapacity->id_vendor_rel)->first('name_vendor'), 16, -2)}}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Site</th>
                                    <td>{{$data->jnssite->name_site}}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        @if ($data->status == "opn")
                                            <span class="label label-warning">On Process NOC</span>
                                        @elseif ($data->status == "finish")
                                            <span class="label label-primary">Finish</span>
                                        @elseif ($data->status == "fail")
                                            <span class="label label-danger">Fail</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Tgl Report</th>
                                    <td>{{date('d M Y', strtotime($data->created_at))}}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-sm-6">
                            <table class="table w-100">
                                
                                <tr>
                                    <th>Price Ori Fromme</th>
                                    <td>
                                        Rp. {{number_format($price_origin_capacity->price_capacity_fromme ,2,',','.')}}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Price Ori Vendor</th>
                                    <td>Rp. {{number_format($price_origin_capacity->price_capacity_vendor ,2,',','.')}}</td>
                                </tr>
                                <tr style="background-color: rgb(255, 255, 123)">
                                    <th>Harga Bandwith Tanpa PPN ( Rp. )</th>
                                    <td>
                                        Rp. {{number_format($profit_noppn ,2,',','.')}}
                                    </td>
                                </tr>
                                <tr style="background-color: rgb(255, 73, 73); color:#fff">
                                    <th>PPN Percentage</th>
                                    <td>
                                        {{$ppn_percentage}} %
                                    </td>
                                </tr>
                                <tr style="background-color: greenyellow">
                                    <th>Total Harga + PPN ( Rp. )</th>
                                    <td style="font-weight: bold;">
                                        Rp. {{number_format($profit_subtotal_plusppn ,2,',','.')}}
                                    </td>
                                </tr>
                                <tr style="background-color: greenyellow">
                                    <th>Margin Profit ( Rp. )</th>
                                    <td style="font-weight: bold;">
                                        Rp. {{number_format($profit_noppn - $price_origin_capacity->price_capacity_vendor ,2,',','.')}}
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
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
