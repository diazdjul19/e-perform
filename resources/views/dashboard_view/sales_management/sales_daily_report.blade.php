@extends('layouts.master_dashboard')
@section('content-wrapper')
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                <i class="fa fa-sliders"></i>
                Sales Daily Report
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> E-Perform</a></li>
                <li><a href="#">Sales Management</a></li>
                <li class="active">Sales Daily Report</li>
            </ol>
        </section>
    
        <section class="content">

            <!-- Default box -->
            <div class="box box-success">
                <form action="#" method="post" >
                    @csrf
                    <div class="box-header with-border">
                        <h3 class="box-title">Table Daily Report</h3>
        
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                                    title="Collapse">
                            <i class="fa fa-minus"></i></button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                            <i class="fa fa-times"></i></button>
                        </div>
        
                        <div class="row">
                            <div class="col-md-6">
                                <a href="{{route('sales-daily-report-create-nemail')}}" class="btn btn-info btn-sm" style="margin-top: 10px;"><i class="fa fa-plus"></i> Tambah</a>
                                <a href="#" class="btn btn-sm" style="margin-top: 10px; background-color:#ff8f9e;color:#fff;"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF</a>
                                <button type="button" class="btn btn-danger btn-sm" style="margin-top: 10px;" id="btn-co-delete" name="select_delete[]" type="submit">
                                    <i class="fa fa-trash" aria-hidden="true"></i> Hapus
                                </button>
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
                                        <th>Tiket Invoice</th>
                                        <th>Report By</th>
                                        <th>Name Client</th>
                                        <th class="text-center">Capacity</th>
                                        <th class="text-center">Site</th>
                                        <th class="text-center">Margin Profit</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center" style="padding:5px;">&#128073; <input type="checkbox" id="cekall" style="margin-bottom: 10px;"  data-toggle="tooltip" title="Click here to Check All" data-placement="top"> &#128072;</th>
                                    </tr>
                                </thead>

                                <tbody>
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

                                            @if (Auth::user()->role == "admin")
                                                <td class="text-center"><input type="checkbox" name="select_delete[]" value="{{$d->id}}"></td>
                                            @elseif (Auth::user()->role == "sales")
                                                @if ($d->jnsuser == null)
                                                    <td class="text-center"><input type="checkbox" name="select_delete[]" value="{{$d->id}}"></td>
                                                @elseif ($d->jnsuser->id == Auth::user()->id)
                                                    <td class="text-center"><input type="checkbox" name="select_delete[]" value="{{$d->id}}"></td>
                                                @elseif ($d->jnsuser->id != Auth::user()->id)
                                                    <td></td>
                                                @endif
                                            @else
                                                <td>-</td>
                                            @endif

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




