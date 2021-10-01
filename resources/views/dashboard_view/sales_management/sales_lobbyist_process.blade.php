@extends('layouts.master_dashboard')
@section('content-wrapper')
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                <i class="fa fa-random"></i>
                Sales Lobbyits Process
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> E-Perform</a></li>
                <li><a href="#">Sales Management</a></li>
                <li class="active">Sales Lobbyits Process</li>
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
                            <h4 class="modal-title"><i class="fa fa-random" aria-hidden="true"></i> Tambah Lobbyist Client</h4>
                        </div>

                        <form action="{{route('sales-lobbyist-store')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">

                                        <div class="form-group row" style="margin:0px;">
                                            <label class="col-md-5 col-form-label" for="name_prospective_client"><h6 style="color: black; font-weight:bold;font-size:13px;">Name Prospective Client<span style="color: red;">*</span></h6></label>
                                            
                                            <div class="col-md-7">
                                                <input id="name_prospective_client" name="name_prospective_client" type="text" class="form-control" autocomplete="off" required>
                                            </div>

                                        </div>

                                        <div class="form-group row" style="margin:0px;">
                                            <label class="col-md-5 col-form-label" for="respont_prospective_client"><h6 style="color: black; font-weight:bold;font-size:13px;">Respont Prospective Client<span style="color: red;">*</span></h6></label>
                                            
                                            <div class="col-md-7">
                                                <select class="form-control pt-0 pb-0" id="respont_prospective_client" name="respont_prospective_client" style="height:35px;" required>
                                                        <option value selected disabled>Choise</option>
                                                        <option style="background-color: #157347;color:#FFF;" value="po">&#128521; Pre-Order</option>
                                                        <option style="background-color: #FFCA2C;color:#000;" value="labil">&#129300; Labil (Pikir-Pikir Dulu)</option>
                                                        <option style="background-color: #BB2D3B;color:#FFF;" value="n_po">&#128531; Not Pre-Order</option>
                                                </select>

                                            </div>
                                        </div>

                                        <div class="form-group row" style="margin:0px;">
                                            <label class="col-md-5 col-form-label" for="relation_from"><h6 style="color: black; font-weight:bold;font-size:13px;">Relation From (Include No Telp)</h6></label>
                                            
                                            <div class="col-md-7">
                                                <input id="relation_from" name="relation_from" type="text" class="form-control" autocomplete="off" >
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Tutup</button>
                                <button type="submit" id="confirm-input" class="btn btn-primary btn-sm">Simpan</button>
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
                        <h4 class="modal-title">Edit Site Elements</h4>
                    </div>
                    
                    <form action="/sales-lobbyist-update" method="post" enctype="multipart/form-data" id="editForm">
                        @csrf
                        {{method_field('PUT')}}
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">

                                    <div class="form-group row" style="margin:0px;">
                                        <label class="col-md-5 col-form-label" for="name_prospective_client_ed"><h6 style="color: black; font-weight:bold;font-size:13px;">Name Prospective Client<span style="color: red;">*</span></h6></label>
                                        
                                        <div class="col-md-7">
                                            <input id="name_prospective_client_ed" name="name_prospective_client" type="text" class="form-control" autocomplete="off" required>
                                        </div>

                                    </div>

                                    <div class="form-group row" style="margin:0px;">
                                        <label class="col-md-5 col-form-label" for="respont_prospective_client_ed"><h6 style="color: black; font-weight:bold;font-size:13px;">Respont Prospective Client<span style="color: red;">*</span></h6></label>
                                        
                                        <div class="col-md-3">
                                            <input id="respont_prospective_client_ed" name="" type="text" class="form-control" autocomplete="off" placeholder="" autofocus readonly>
                                        </div>

                                        <div class="col-md-4">
                                            <select class="form-control pt-0 pb-0" id="" name="respont_prospective_client" style="height:35px;" >
                                                    <option value selected disabled>Choise</option>
                                                    <option style="background-color: #157347;color:#FFF;" value="po">&#128521; Pre-Order</option>
                                                    <option style="background-color: #FFCA2C;color:#000;" value="labil">&#129300; Labil (Pikir-Pikir Dulu)</option>
                                                    <option style="background-color: #BB2D3B;color:#FFF;" value="n_po">&#128531; Not Pre-Order</option>
                                            </select>

                                        </div>
                                    </div>

                                    <div class="form-group row" style="margin:0px;">
                                        <label class="col-md-5 col-form-label" for="relation_from_ed"><h6 style="color: black; font-weight:bold;font-size:13px;">Relation From (Include No Telp)</h6></label>
                                        
                                        <div class="col-md-7">
                                            <input id="relation_from_ed" name="relation_from" type="text" class="form-control" autocomplete="off" >
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
                <form action="{{route('select-delete-lobbyist')}}" method="post" >
                    @csrf
                    <div class="box-header with-border">
                        <h3 class="box-title">Table Lobbyits Process</h3>
        
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                                    title="Collapse">
                            <i class="fa fa-minus"></i></button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                            <i class="fa fa-times"></i></button>
                        </div>
        
                        <div class="row">
                            <div class="col-md-6">
                                <button type="button" class="btn btn-info btn-sm" style="margin-top: 10px;" data-toggle="modal" data-target="#modal-create"><i class="fa fa-user-plus"></i> Tambah</button>
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
                                        <th>Name Prospective Client</th>
                                        <th class="text-center">Respont Prospective Client</th>
                                        <th class="text-center">Relation From</th>
                                        <th class="text-center">Action</th>
                                        <th class="text-center" style="padding:5px;">&#128073; <input type="checkbox" id="cekall" style="margin-bottom: 10px;"  data-toggle="tooltip" title="Click here to Check All" data-placement="top"> &#128072;</th>
                                        <th style="display:none;">ID</th>

                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($data as $d)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$d->name_prospective_client}}</td>
                                            @if ($d->respont_prospective_client == "po")
                                                <td class="text-center" style="min-width:120px; font-weight:bold;background-color:#22e389;color:#fff">
                                                    &#128521; Pre-Order
                                                </td>
                                            @elseif ($d->respont_prospective_client == "labil")
                                                <td class="text-center" style="min-width:120px; font-weight:bold;background-color:rgb(255, 220, 114)">
                                                    &#129300; Labil (Pikir-Pikir Dulu)
                                                </td>
                                            @elseif ($d->respont_prospective_client == "n_po")
                                                <td class="text-center" style="min-width:120px; font-weight:bold;background-color:#f55e6e;color:#fff">
                                                    &#128531; Not Pre-Order
                                                </td>
                                            @endif
                                            
                                            <td style="min-width:120px; text-align:center;">{{$d->relation_from}}</td>
                                            <td style="min-width:120px;" style="padding-top: 15px;" class="text-center">
                                                @if ($d->respont_prospective_client == "po")
                                                    <span class="label label-success" style="font-size:12px; margin-left:2px; margin-right:2px;">Opened By : {{$d->open_by}}</span>
                                                    <span class="label label-danger" style="font-size:12px; margin-left:2px; margin-right:2px;">Closed By : {{$d->close_by}}</span>
                                                @elseif ($d->respont_prospective_client == "n_po" || $d->respont_prospective_client == "labil")
                                                    <a href="#" id="open-modal" class="btn bg-purple btn-xs"  style="margin: 2px;"><i class="fa fa-edit"></i> Edit</a>
                                                @endif
                                            </td>
                                            <td class="text-center"><input type="checkbox" name="select_delete[]" value="{{$d->id}}"></td>
                                            <td style="display:none;">{{$d->id}}</td>

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

            $('#name_prospective_client_ed').val(data[1]);
            $('#respont_prospective_client_ed').val(data[2]);
            $('#relation_from_ed').val(data[3]);

            $('#editForm').attr('action', '/sales-lobbyist-update/'+ data[6]);
            $('#editModal').modal('show');
        });
        // End Edit Modal

        });
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

    <script>
        // Start Confirm Delete Using SweetAlert2
            $('#confirm-input').on('click',function(e){
                e.preventDefault();

                var form = $(this).parents('form');
                Swal.fire({
                    title: 'Confirm Alert?',
                    text: "Apa anda yakin sudah mengisi data ini dengan benar?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, I am sure !'
                }).then((result) => {
                    if (result.value) {
                        
                        form.submit();
                    }
                });
            });
        
        // End Confirm Delete Using SweetAlert2
    </script>
@endpush




