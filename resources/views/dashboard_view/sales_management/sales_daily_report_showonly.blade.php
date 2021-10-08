@extends('layouts.master_dashboard')
@section('content-wrapper')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-line-chart"></i>
            @if (request()->is('sales-daily-report-edit/*'))
                Sales Edit Daily Report
            @elseif(request()->is('sales-daily-report-show/*'))
                Sales Show Daily Report
            @endif 
            <small>...</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> E-Perform</a></li>
            <li><a href="{{ URL::previous() }}">Sales Management</a></li>
            <li><a href="{{ URL::previous() }}">Sales Daily Report</a></li>
            @if (request()->is('sales-daily-report-edit/*'))
                <li class="active">Sales Edit Daily Report</li>
            @elseif(request()->is('sales-daily-report-show/*'))
                <li class="active">Sales Show Daily Report</li>
            @endif
        </ol>
        
    </section>

    <div class="row">
        <section class="invoice">
            <!-- title row -->
            <div class="row">
                <div class="col-xs-12">
                <h2 class="page-header">
                    <a href="{{ URL::previous() }}" data-toggle="tooltip" title="Back" data-placement="top"><i class="fa fa-arrow-circle-left"></i></a> Tiket "{{$data->tiket_report}}"
                    <small class="pull-right">Last update: {{date('d M Y', strtotime($data->updated_at))}}</small>
                </h2>
                </div>
                <!-- /.col -->
            </div>
            <!-- info row -->
            
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

            <div class="row no-print">
                <div class="col-xs-12">
                    {{-- <a href="#" target="_blank" class="btn btn-sm btn-default"><i class="fa fa-print"></i> Print</a> --}}
                    <a href="{{route('pdf-daily-report-sales-detail', $data->id)}}"  class="btn btn-sm btn-danger"><i class="fa fa-file-pdf-o"></i> Download PDF</a>
                    
                </div>
            </div>
        </section>
    </div>


    
@endsection

