@extends('layouts.master_dashboard')
@section('content-wrapper')
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                <i class="fa fa-external-link"></i>
                Link Element

            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> E-Perform</a></li>
                <li><a href="#">Elements</a></li>
                <li class="active">Link Elements</li>
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
                            <h4 class="modal-title"><i class="fa fa-external-link" aria-hidden="true"></i> Tambah Link Baru</h4>
                        </div>

                        <form action="{{route('link-element.store')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group row" style="margin:0px;">
                                            <label class="col-md-4 col-form-label" for="name_link"><h6 style="color: black; font-weight:bold;font-size:13px;">Nama Link<span style="color: red;">*</span></h6></label>
                                            
                                            <div class="col-md-8">
                                                <input id="name_link" name="name_link" type="text" class="form-control" required autocomplete="off" placeholder="Add Name Link" autofocus>
                                            </div>
                                        </div>

                                        <div class="form-group row" style="margin:0px;">
                                            <label class="col-md-4 col-form-label" for="penanggung_jawab_link"><h6 style="color: black; font-weight:bold;font-size:13px;">Nama Penanggung Jawab<span style="color: red;">*</span></h6></label>
                                            
                                            <div class="col-md-8">
                                                <input id="penanggung_jawab_link" name="penanggung_jawab_link" type="text" class="form-control" required autocomplete="off" placeholder="Add Person Pesponsible">
                                            </div>
                                        </div>

                                        <div class="form-group row" style="margin:0px;">
                                            <label class="col-md-4 col-form-label" for="vlan"><h6 style="color: black; font-weight:bold;font-size:13px;">Vlan</h6></label>
                                            
                                            <div class="col-md-8">
                                            <input type="text" name="vlan" id="vlan" class="form-control" placeholder="Add Vlan" aria-label="" aria-describedby="basic-addon2"  style="height:30px;"  oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');">
                                            </div>
                                        </div>

                                        <div class="form-group row" style="margin:0px;">
                                            <label class="col-md-4 col-form-label" for="id_capacity_rel"><h6 style="color: black; font-weight:bold;font-size:13px;">Capacity Bandwith</h6></label>
                                            
                                            <div class="col-md-8">
                                                <select class="form-control pt-0 pb-0" id="id_capacity_rel" name="id_capacity_rel" style="height:30px;" >
                                                        <option value selected disabled>Choise</option>
                                                        @foreach ($data_capacity as $item)
                                                            <option value="{{$item->id}}">{{$item->bandwith_capacity}} {{$item->type_trasfer}}</option>
                                                        @endforeach
                                                </select>

                                            </div>
                                        </div>

                                        <div class="form-group row" style="margin:0px;">
                                            <label class="col-md-4 col-form-label" for="id_site_rel"><h6 style="color: black; font-weight:bold;font-size:13px;">Site</h6></label>
                                            
                                            <div class="col-md-8">
                                                <select class="form-control pt-0 pb-0" id="id_site_rel" name="id_site_rel" style="height:30px;" >
                                                        <option value selected disabled>Choise</option>
                                                        @foreach ($data_site as $item)
                                                            <option value="{{$item->id}}">{{$item->name_site}}</option>
                                                        @endforeach
                                                </select>

                                            </div>
                                        </div>

                                        <div class="form-group row" style="margin:0px;">
                                            <label class="col-md-4 col-form-label" for="id_vendor_rel"><h6 style="color: black; font-weight:bold;font-size:13px;">Vendor</h6></label>
                                            
                                            <div class="col-md-8">
                                                <select class="form-control pt-0 pb-0" id="id_vendor_rel" name="id_vendor_rel" style="height:30px;" >
                                                        <option value selected disabled>Choise</option>
                                                        @foreach ($data_vendor as $item)
                                                            <option value="{{$item->id}}">{{$item->name_vendor}}</option>
                                                        @endforeach
                                                </select>

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
                            <h4 class="modal-title">Edit Link Elements</h4>
                        </div>
                        
                        <form action="/link-element" method="post" enctype="multipart/form-data" id="editForm">
                            @csrf
                            {{method_field('PUT')}}
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group row" style="margin:0px;">
                                            <label class="col-md-4 col-form-label" for="name_link_ed"><h6 style="color: black; font-weight:bold;font-size:13px;">Nama Link<span style="color: red;">*</span></h6></label>
                                            
                                            <div class="col-md-8">
                                                <input id="name_link_ed" name="name_link" type="text" class="form-control" required autocomplete="off" placeholder="Add Name Link" autofocus>
                                            </div>
                                        </div>

                                        <div class="form-group row" style="margin:0px;">
                                            <label class="col-md-4 col-form-label" for="penanggung_jawab_link_ed"><h6 style="color: black; font-weight:bold;font-size:13px;">Nama Penanggung Jawab<span style="color: red;">*</span></h6></label>
                                            
                                            <div class="col-md-8">
                                                <input id="penanggung_jawab_link_ed" name="penanggung_jawab_link" type="text" class="form-control" required autocomplete="off" placeholder="Add Person Pesponsible">
                                            </div>
                                        </div>

                                        <div class="form-group row" style="margin:0px;">
                                            <label class="col-md-4 col-form-label" for="vlan_ed"><h6 style="color: black; font-weight:bold;font-size:13px;">Vlan</h6></label>
                                            
                                            <div class="col-md-8">
                                            <input type="text" name="vlan" id="vlan_ed" class="form-control" placeholder="Add Vlan" aria-label="" aria-describedby="basic-addon2"  style="height:30px;"  oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');">
                                            </div>
                                        </div>

                                        <div class="form-group row" style="margin:0px;">
                                            <label class="col-md-4 col-form-label" for="id_capacity_rel_ed"><h6 style="color: black; font-weight:bold;font-size:13px;">Capacity Bandwith</h6></label>
                                            
                                            <div class="col-md-4">
                                                <input id="id_capacity_rel_ed" name="" type="text" class="form-control" autocomplete="off" placeholder="" autofocus readonly>
                                            </div>

                                            <div class="col-md-4">
                                                <select class="form-control pt-0 pb-0" id="" name="id_capacity_rel" style="height:30px;" >
                                                        <option value selected disabled>Choise</option>
                                                        @foreach ($data_capacity as $item)
                                                            <option value="{{$item->id}}">{{$item->bandwith_capacity}} {{$item->type_trasfer}}</option>
                                                        @endforeach
                                                </select>

                                            </div>
                                        </div>

                                        <div class="form-group row" style="margin:0px;">
                                            <label class="col-md-4 col-form-label" for="id_site_rel_ed"><h6 style="color: black; font-weight:bold;font-size:13px;">Site</h6></label>
                                            
                                            <div class="col-md-4">
                                                <input id="id_site_rel_ed" name="" type="text" class="form-control" autocomplete="off" placeholder="" autofocus readonly>
                                            </div>

                                            <div class="col-md-4">
                                                <select class="form-control pt-0 pb-0" id="" name="id_site_rel" style="height:30px;" >
                                                        <option value selected disabled>Choise</option>
                                                        @foreach ($data_site as $item)
                                                            <option value="{{$item->id}}">{{$item->name_site}}</option>
                                                        @endforeach
                                                </select>

                                            </div>
                                        </div>

                                        <div class="form-group row" style="margin:0px;">
                                            <label class="col-md-4 col-form-label" for="id_vendor_rel_ed"><h6 style="color: black; font-weight:bold;font-size:13px;">Vendor</h6></label>
                                           
                                            <div class="col-md-4">
                                                <input id="id_vendor_rel_ed" name="" type="text" class="form-control" autocomplete="off" placeholder="" autofocus readonly>
                                            </div>

                                            <div class="col-md-4">
                                                <select class="form-control pt-0 pb-0" id="" name="id_vendor_rel" style="height:30px;" >
                                                        <option value selected disabled>Choise</option>
                                                        @foreach ($data_vendor as $item)
                                                            <option value="{{$item->id}}">{{$item->name_vendor}}</option>
                                                        @endforeach
                                                </select>

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
                    <h3 class="box-title">Table Link Elements</h3>
    
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
                                    <th>Nama Link</th>
                                    <th class="text-center">PJ Link</th>
                                    <th class="text-center">Capacity Bandwith</th>
                                    <th class="text-center">Vlan</th>
                                    <th class="text-center">Site</th>
                                    <th class="text-center">Vendor</th>
                                    <th class="text-center">Action</th>
                                    <th style="display:none;">ID</th>

                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($data as $d)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td style="min-width:120px;">{{$d->name_link}}</td>
                                        <td style="min-width:120px;" class="text-center">{{$d->penanggung_jawab_link}}</td>

                                        @if ($d->jnscapacity != null)
                                            <td style="min-width:120px;" class="text-center">{{$d->jnscapacity->bandwith_capacity}} {{$d->jnscapacity->type_trasfer}}</td>
                                        @elseif ($d->jnscapacity == null) 
                                            <td style="min-width:120px; text-align:center; font-weight:bold;">ID Not Found !!!</td>
                                        @endif

                                        <td style="min-width:120px;" class="text-center">{{$d->vlan}}</td>

                                        @if ($d->jnssite != null)
                                            <td style="min-width:120px;" class="text-center">{{$d->jnssite->name_site}}</td>
                                        @elseif ($d->jnssite == null) 
                                            <td style="min-width:120px; text-align:center; font-weight:bold;">ID Not Found !!!</td>
                                        @endif

                                        @if ($d->jnsvendor != null)
                                            <td style="min-width:120px;" class="text-center">{{$d->jnsvendor->name_vendor}}</td>
                                        @elseif ($d->jnsvendor == null) 
                                            <td style="min-width:120px; text-align:center; font-weight:bold;">ID Not Found !!!</td>
                                        @endif

                                        
                                        <td style="min-width:120px;" style="padding-top: 15px;" class="text-center">
                                            <a href="#" id="open-modal" class="btn btn-success btn-xs"  style="margin: 3px;"><i class="fa fa-edit"></i> Edit</a>
                                            <a href="{{route('link-element-delete', $d->id)}}" id="" class="delete-alert btn btn-danger btn-xs"  style="margin: 3px;"><i class="fa fa-trash"></i> Delete</a>
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

            $('#name_link_ed').val(data[1]);
            $('#penanggung_jawab_link_ed').val(data[2]);
            $('#id_capacity_rel_ed').val(data[3]);
            $('#vlan_ed').val(data[4]);
            $('#id_site_rel_ed').val(data[5]);
            $('#id_vendor_rel_ed').val(data[6]);
           

        


            $('#editForm').attr('action', '/link-element/'+ data[8]);
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