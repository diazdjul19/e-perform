@extends('layouts.master_dashboard')
@section('content-wrapper')
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                <i class="fa fa-street-view"></i>
                Client Element

            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> E-Perform</a></li>
                <li><a href="#">Elements</a></li>
                <li class="active">Client Elements</li>
            </ol>
        </section>
    
        <section class="content">

            @if ($message = Session::get('success_confirm'))
                <div class="box box-info box-solid">
                    <div class="box-header with-border">
                        <h4 class="box-title"><i class="fa fa-info-circle"></i>  Success Add Data</h4>
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
                    <div class="box-footer">
                        @if ($message = Session::get('session_data'))
                            <a href="{{route('client-element.index')}}" class="btn bg-olive margin" ><i class="fa fa-refresh"></i> Tetap Di Halaman Ini</a>
                            <a href="{{route('sales-daily-report-create', $message)}}" class="btn bg-purple margin" ><i class="fa fa-paper-plane"></i> Buat Laporan Penjualan (Klient ini)</a>
                        @endif

                    </div>
                </div>
            @endif


            {{-- Start Modal Edit Bootstrap --}}
                <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Edit Client Elements</h4>
                        </div>
                        
                        <form action="/client-element" method="post" enctype="multipart/form-data" id="editForm">
                            @csrf
                            {{method_field('PUT')}}
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">

                                        <div class="form-group row" style="margin:0px;">
                                            <label class="col-md-4 col-form-label" for="name_client"><h6 style="color: black; font-weight:bold;font-size:13px;">Nama Client<span style="color: red;">*</span></h6></label>
                                            
                                            <div class="col-md-8">
                                                <input type="text" name="name_client" class="form-control" id="name_client_ed"  style="height:30px;" required >
                                            </div>
                                        </div>

                                        <div class="form-group row" style="margin:0px;">
                                            <label class="col-md-4 col-form-label" for="no_telp"><h6 style="color: black; font-weight:bold;font-size:13px;">No Telp<span style="color: red;">*</span></h6></label>
                                            
                                            <div class="col-md-8">
                                                <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" name="no_telp_client" class="form-control" id="no_telp_ed"  style="height:30px;" required >
                                            </div>
                                        </div>

                                        <div class="form-group row" style="margin:0px;">
                                            <label class="col-md-4 col-form-label" for="email_client"><h6 style="color: black; font-weight:bold;font-size:13px;">Email<span style="color: red;">*</span></h6></label>
                                            
                                            <div class="col-md-8">
                                                <input type="text" name="email_client" class="form-control @error('email_client') is-invalid @enderror" value="{{ old('email_client') }}" id="email_client_ed"  style="height:30px;" required >
                                                @error('email_client')
                                                    <span class="invalid-feedback" role="alert" style="color: red;">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group row" style="margin:0px;">
                                            <label class="col-md-4 col-form-label" for="company_client"><h6 style="color: black; font-weight:bold;font-size:13px;">Nama Perusahaan</h6></label>
                                            
                                            <div class="col-md-8">
                                                <input type="text" name="company_client" class="form-control" id="company_client_ed"  style="height:30px;" >
                                            </div>
                                        </div>

                                        <div class="form-group row" style="margin:0px;">
                                            <label class="col-md-4 col-form-label" for="address_client"><h6 style="color: black; font-weight:bold;font-size:13px;">Alamat Client<span style="color: red;">*</span></h6></label>
                                            
                                            <div class="col-md-8">
                                                <input type="text" name="address_client" class="form-control" id="address_client_ed"  style="height:30px;" required >
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
                    </div>
                </div>
            {{-- End Modal Edit Bootstrap --}}

            <!-- Default box -->
            <div class="box box-success">
                
                <div class="box-header with-border">
                    <h3 class="box-title">Table Client Elements</h3>
    
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                                title="Collapse">
                        <i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                        <i class="fa fa-times"></i></button>
                    </div>
    
                    <div class="row">
                        <div class="col-md-6">
                            <a href="{{route('client-element.create')}}" class="btn btn-info btn-sm" style="margin-top: 10px;"><i class="fa fa-plus"></i> Tambah</a>
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
                                    <th>Nama Client</th>
                                    <th class="text-center">Nama Perusahaan</th>
                                    <th class="text-center">No Telp</th>
                                    <th class="text-center">Email</th>
                                    <th class="text-center">Alamat</th>
                                    <th class="text-center">Action</th>
                                    <th style="display:none;">ID</th>

                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($data as $d)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td style="min-width:120px;">{{$d->name_client}}</td>
                                        <td style="min-width:120px;" class="text-center">{{$d->company_client}}</td>
                                        <td style="min-width:120px;" class="text-center">{{$d->no_telp_client}}</td>
                                        <td style="min-width:120px;" class="text-center">{{$d->email_client}}</td>
                                        <td style="min-width:120px;" class="text-center">{{$d->address_client}}</td>

                                        <td style="min-width:120px;" style="padding-top: 15px;" class="text-center">
                                            <a href="#" id="open-modal" class="btn btn-success btn-xs"  style="margin: 3px;"><i class="fa fa-edit"></i> Edit</a>
                                            <a href="{{route('client-element-delete', $d->id)}}" id="" class="delete-alert btn btn-danger btn-xs"  style="margin: 3px;"><i class="fa fa-trash"></i> Delete</a>
                                        </td>
                                        <td style="display:none;">{{$d->id}}</td>

                                    </tr>
                                @endforeach
                            </tbody>
                            
                        </table>
                    </div>
                    
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </section>
@endsection

@push('datatable')
    {{-- <script>
        $(function () {
            $('#example1').DataTable()
        })
    </script> --}}

    <script>
        $(document).ready( function () {

        // var table = $(function () {
        //     $('#example1').DataTable()
        // });

        // Start DataTable Biasa
        var table = $('#example1').DataTable({
                        responsive: true,
                        language: {
                            searchPlaceholder: 'Search...',
                            sSearch: '',
                            lengthMenu: '_MENU_ items/page',
                        }
                    });
        // End DataTable Biasa

        // Start Edit Modal
        table.on('click', '#open-modal', function (){
                    
            $tr = $(this).closest('tr');
            if ($($tr).hasClass('child')) {
                $tr = $tr.prev('.parent');
            }

            var data = table.row($tr).data();
            console.log(data);

            $('#name_client_ed').val(data[1]);
            $('#company_client_ed').val(data[2]);
            $('#no_telp_ed').val(data[3]);
            $('#email_client_ed').val(data[4]);
            $('#address_client_ed').val(data[5]);
        


            $('#editForm').attr('action', '/client-element/'+ data[7]);
            $('#editModal').modal('show');
        });
        // End Edit Modal

        });
    </script>
@endpush

@push('confirm-alert')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

    <script>
        // Start Confirm Delete Using SweetAlert2
            $('.delete-alert').on('click',function(e){
                e.preventDefault();
                const url = $(this).attr('href');
                // var id = $(this).data('id');
                Swal.fire({
                    title: 'Apakah Anda Yakin?',
                    text: "Anda akan menghapus data ini!",
                    icon: 'error',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        Swal.fire(
                        'Success!',
                        'Data berhasil di hapus.',
                        'success'
                        )
                        window.location.href = url;
                    }
                });
                
            });
        // End Confirm Delete Using SweetAlert2
    </script>
@endpush