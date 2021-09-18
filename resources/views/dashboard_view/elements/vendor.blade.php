@extends('layouts.master_dashboard')
@section('content-wrapper')
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                <i class="fa fa-handshake-o"></i>
                Vendor Element

            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> E-Perform</a></li>
                <li><a href="#">Elements</a></li>
                <li class="active">Vendor Elements</li>
            </ol>
        </section>
    
        <section class="content">

            {{-- Start Modal Create --}}
            <div class="modal fade" id="modal-create">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title"><i class="fa fa-handshake-o" aria-hidden="true"></i> Tambah Vendor Baru</h4>
                        </div>

                        <form action="{{route('vendor-element.store')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group row" style="margin:0px;">
                                            <label class="col-md-4 col-form-label" for="name_vendor"><h6 style="color: black; font-weight:bold;font-size:13px;">Nama Vendor<span style="color: red;">*</span></h6></label>
                                            
                                            <div class="col-md-8">
                                                <input id="name_vendor" name="name_vendor" type="text" class="form-control" required autocomplete="off" placeholder="Example : HSP NET" autofocus>
                                            </div>
                            
                                        </div>

                                        <div class="form-group row" style="margin:0px;">
                                            <label class="col-md-4 col-form-label" for="vendor_pt"><h6 style="color: black; font-weight:bold;font-size:13px;">Perseroan Terbatas (PT)</h6></label>
                                            
                                            <div class="col-md-8">
                                                <input id="vendor_pt" name="vendor_pt" type="text" class="form-control" autocomplete="off" placeholder="Example : PT. PARSAORAN GLOBAL DATATRANS" autofocus>
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
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            {{-- End Modal Create --}}

            {{-- Start Modal Edit Bootstrap --}}
                <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Edit Vendor Elements</h4>
                        </div>
                        
                        <form action="/vendor-element" method="post" enctype="multipart/form-data" id="editForm">
                            @csrf
                            {{method_field('PUT')}}
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">

                                        <div class="form-group row" style="margin:0px;">
                                            <label class="col-md-4 col-form-label" for="name_vendor"><h6 style="color: black; font-weight:bold;font-size:13px;">Nama Vendor<span style="color: red;">*</span></h6></label>

                                            
                                            <div class="col-md-8">
                                                <input type="text" name="name_vendor" class="form-control" id="name_vendor_ed"  style="height:30px;" required >
                                            </div>
                                        </div>

                                        <div class="form-group row" style="margin:0px;">
                                            <label class="col-md-4 col-form-label" for="vendor_pt"><h6 style="color: black; font-weight:bold;font-size:13px;">Perseroan Terbatas (PT)</h6></label>

                                            
                                            <div class="col-md-8">
                                                <input type="text" name="vendor_pt" class="form-control" id="vendor_pt_ed"  style="height:30px;"  >
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
                    <h3 class="box-title">Table Vendor Elements</h3>
    
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                                title="Collapse">
                        <i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                        <i class="fa fa-times"></i></button>
                    </div>
    
                    <div class="row">
                        <div class="col-md-6">
                            <button type="button" class="btn btn-info btn-sm" style="margin-top: 10px;" data-toggle="modal" data-target="#modal-create"><i class="fa fa-plus"></i> Tambah</button>
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
                                    <th>Nama Vendor</th>
                                    <th class="text-center">Perseroan Terbatas (PT)</th>
                                    <th class="text-center">Tgl Register</th>
                                    <th class="text-center">Last Update</th>
                                    <th class="text-center">Action</th>
                                    <th style="display:none;">ID</th>

                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($data as $d)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td style="min-width:120px;">{{$d->name_vendor}}</td>
                                        <td style="min-width:120px;" class="text-center">{{$d->vendor_pt}}</td>
                                        <td style="min-width:120px;" class="text-center">{{date('d M Y', strtotime($d->created_at))}}</td>
                                        <td style="min-width:120px;" class="text-center">{{date('d M Y', strtotime($d->updated_at))}}</td>
                                        <td style="min-width:120px;" style="padding-top: 15px;" class="text-center">
                                            <a href="#" id="open-modal" class="btn btn-success btn-xs"  style="margin: 3px;"><i class="fa fa-edit"></i> Edit</a>
                                            <a href="{{route('vendor-element-delete', $d->id)}}" id="" class="delete-alert btn btn-danger btn-xs"  style="margin: 3px;"><i class="fa fa-trash"></i> Delete</a>
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

            $('#name_vendor_ed').val(data[1]);
            $('#vendor_pt_ed').val(data[2]);
        


            $('#editForm').attr('action', '/vendor-element/'+ data[6]);
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