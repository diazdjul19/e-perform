@extends('layouts.master_dashboard')
@section('content-wrapper')
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                <i class="fa fa-tint"></i>
                Capacity Element

            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> E-Perform</a></li>
                <li><a href="#">Elements</a></li>
                <li class="active">Capacity Elements</li>
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
                                <h4 class="modal-title"><i class="fa fa-tint" aria-hidden="true"></i> Tambah Capacity Baru</h4>
                            </div>

                            <form action="{{route('capacity-element.store')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group row" style="margin:0px;">
                                                <label class="col-md-4 col-form-label" for="bandwith_capacity"><h6 style="color: black; font-weight:bold;font-size:13px;">Capacity Bandwith<span style="color: red;">*</span></h6></label>
                                                
                                                <div class="col-md-4">
                                                    <input type="text" name="bandwith_capacity" id="bandwith_capacity" class="form-control" placeholder="Add Capacity Bandwith" aria-label="" aria-describedby="basic-addon2"  style="height:30px;"  oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" required autofocus>
                                                </div>

                                                <div class="col-md-4">
                                                    <select class="form-control pt-0 pb-0" id="type_trasfer" name="type_trasfer" style="height:30px;" required>
                                                        <option value selected disabled>Choise</option>
                                                        <option value="B">Byte (B)</option>
                                                        <option value="KB">Kilobyte (KB)</option>
                                                        <option value="MB">Megabyte (MB)</option>
                                                        <option value="GB">Gigabyte (GB)</option>
                                                        <option value="TB">Terabyte (TB)</option>
                                                        <option value="PB">Petabyte (PB)</option>
                                                    </select>
                                                </div>
                                
                                            </div>

                                            <div class="form-group row" style="margin:0px;">
                                                <label class="col-md-4 col-form-label" for="price_capacity_fromme"><h6 style="color: black; font-weight:bold;font-size:13px;">Price From Me <span style="color: red;">*</span></h6></label>
                                                
                                                <div class="col-md-8">
                                                    <input id="price_capacity_fromme" name="price_capacity_fromme" type="text" class="form-control" autocomplete="off" placeholder="Add Price" autofocus>
                                                </div>
                                
                                            </div>

                                            <div class="form-group row" style="margin:0px;">
                                                <label class="col-md-4 col-form-label" for="price_capacity_vendor"><h6 style="color: black; font-weight:bold;font-size:13px;">Price From Vendor</h6></label>
                                                
                                                <div class="col-md-8">
                                                    <input id="price_capacity_vendor" name="price_capacity_vendor" type="text" class="form-control" autocomplete="off" placeholder="Add Price" autofocus>
                                                </div>
                                
                                            </div>

                                            <div class="form-group row" style="margin:0px;">
                                                <label class="col-md-4 col-form-label" for="id_vendor_rel"><h6 style="color: black; font-weight:bold;font-size:13px;">From Vendor</h6></label>
                                                
                                                <div class="col-md-8">
                                                    <select class="form-control pt-0 pb-0" id="id_vendor_rel" name="id_vendor_rel" style="height:30px;" required>
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
                            <h4 class="modal-title">Edit Capacity Elements</h4>
                        </div>
                        
                        <form action="/capacity-element" method="post" enctype="multipart/form-data" id="editForm">
                            @csrf
                            {{method_field('PUT')}}
                            
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">

                                        <div class="form-group row" style="margin:0px;">
                                            <label class="col-md-4 col-form-label" for="bandwith_capacity"><h6 style="color: black; font-weight:bold;font-size:13px;">(Bandwith Saat ini)</h6></label>
                                            
                                            <div class="col-md-8">
                                                <input id="bandwith_capacity_ed" name="" type="text" class="form-control" autocomplete="off" placeholder="" autofocus readonly>
                                            </div>
                            
                                        </div>

                                        <div class="form-group row" style="margin:0px;">
                                            <label class="col-md-4 col-form-label" for="bandwith_capacity"><h6 style="color: black; font-weight:bold;font-size:13px;">Capacity Bandwith Baru<span style="color: red;">*</span></h6></label>
                                            
                                            <div class="col-md-4">
                                                <input type="text" name="bandwith_capacity" id="bandwith_capacity" class="form-control" placeholder="Add New Capacity Bandwith" aria-label="" aria-describedby="basic-addon2"  style="height:30px;"  oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" autofocus>
                                            </div>

                                            <div class="col-md-4">
                                                <select class="form-control pt-0 pb-0" id="type_trasfer" name="type_trasfer" style="height:30px;" >
                                                    <option value selected disabled>Choise</option>
                                                    <option value="B">Byte (B)</option>
                                                    <option value="KB">Kilobyte (KB)</option>
                                                    <option value="MB">Megabyte (MB)</option>
                                                    <option value="GB">Gigabyte (GB)</option>
                                                    <option value="TB">Terabyte (TB)</option>
                                                    <option value="PB">Petabyte (PB)</option>
                                                </select>
                                            </div>
                            
                                        </div>

                                        <div class="form-group row" style="margin:0px;">
                                            <label class="col-md-4 col-form-label" for="price_capacity_fromme_ed"><h6 style="color: black; font-weight:bold;font-size:13px;">Price From Me <span style="color: red;">*</span></h6></label>
                                            
                                            <div class="col-md-8">
                                                <input id="price_capacity_fromme_ed" name="price_capacity_fromme" type="text" class="form-control" autocomplete="off" placeholder="Add Price" autofocus>
                                            </div>
                            
                                        </div>

                                        <div class="form-group row" style="margin:0px;">
                                            <label class="col-md-4 col-form-label" for="price_capacity_vendor_ed"><h6 style="color: black; font-weight:bold;font-size:13px;">Price From Vendor</h6></label>
                                            
                                            <div class="col-md-8">
                                                <input id="price_capacity_vendor_ed" name="price_capacity_vendor" type="text" class="form-control" autocomplete="off" placeholder="Add Price" autofocus>
                                            </div>
                            
                                        </div>

                                        <div class="form-group row" style="margin:0px;">
                                            <label class="col-md-4 col-form-label" for="id_vendor_rel"><h6 style="color: black; font-weight:bold;font-size:13px;">From Vendor</h6></label>
                                            
                                            <div class="col-md-4">
                                                <input id="id_vendor_rel_ed" name="" type="text" class="form-control" autocomplete="off" placeholder="" autofocus readonly>
                                            </div>

                                            <div class="col-md-4">
                                                <select class="form-control pt-0 pb-0" id="" name="id_vendor_rel" style="height:30px;">
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
                    <h3 class="box-title">Table Capacity Elements</h3>
    
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
                                <tr >
                                    <th>No</th>
                                    <th class="text-center">Capacity Bandwith</th>
                                    <th class="text-center">Price From Me</th>
                                    <th class="text-center">Price From Vendor</th>
                                    <th class="text-center">From Vendor</th>
                                    <th class="text-center">Action</th>
                                    <th style="display:none;">ID</th>

                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($data as $d)
                                    <tr >
                                        <td>{{$loop->iteration}}</td>
                                        <td style="min-width:120px; text-align:center;">{{$d->bandwith_capacity}} {{$d->type_trasfer}}</td>
                                        <td style="min-width:120px; text-align:center;">Rp. {{number_format($d->price_capacity_fromme,0, ".", ".")}}</td>
                                        <td style="min-width:120px; text-align:center;">Rp. {{number_format($d->price_capacity_vendor,0, ".", ".")}}</td>
                                        <td style="min-width:120px; text-align:center;">{{$d->jnsvendor->name_vendor}}</td>
                                        <td style="min-width:120px; text-align:center;" style="padding-top: 15px;" class="text-center">
                                            <a href="#" id="open-modal" class="btn btn-success btn-xs"  style="margin: 3px;"><i class="fa fa-edit"></i> Edit</a>
                                            <a href="{{route('capacity-element-delete', $d->id)}}" id="" class="delete-alert btn btn-danger btn-xs"  style="margin: 3px;"><i class="fa fa-trash"></i> Delete</a>
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

            $('#bandwith_capacity_ed').val(data[1]);
            $('#price_capacity_fromme_ed').val(data[2]);
            $('#price_capacity_vendor_ed').val(data[3]);
            $('#id_vendor_rel_ed').val(data[4]);


            $('#editForm').attr('action', '/capacity-element/'+ data[6]);
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

@push('input-rupiah')
    <script>
        var rupiah1 = document.getElementById("price_capacity_fromme");
        rupiah1.addEventListener("keyup", function(e) {
            // tambahkan 'Rp.' pada saat form di ketik
            // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
            rupiah1.value = formatRupiah(this.value, "Rp. ");
        });

        var rupiah2 = document.getElementById("price_capacity_fromme_ed");
        rupiah2.addEventListener("keyup", function(e) {
            // tambahkan 'Rp.' pada saat form di ketik
            // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
            rupiah2.value = formatRupiah(this.value, "Rp. ");
        });

        var rupiah3 = document.getElementById("price_capacity_vendor");
        rupiah3.addEventListener("keyup", function(e) {
            // tambahkan 'Rp.' pada saat form di ketik
            // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
            rupiah3.value = formatRupiah(this.value, "Rp. ");
        });

        var rupiah4 = document.getElementById("price_capacity_vendor_ed");
        rupiah4.addEventListener("keyup", function(e) {
            // tambahkan 'Rp.' pada saat form di ketik
            // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
            rupiah4.value = formatRupiah(this.value, "Rp. ");
        });

        /* Fungsi formatRupiah */
        function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, "").toString(),
                split = number_string.split(","),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            // tambahkan titik jika yang di input sudah menjadi angka ribuan
            if (ribuan) {
                separator = sisa ? "." : "";
                rupiah += separator + ribuan.join(".");
            }

            rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
            return prefix == undefined ? rupiah : rupiah ? "Rp. " + rupiah : "";
        }

    </script>

@endpush