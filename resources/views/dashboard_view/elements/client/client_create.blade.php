@extends('layouts.master_dashboard')
@section('content-wrapper')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-street-view"></i>
            Tambah Client Element
            <small>...</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> E-Perform</a></li>
            <li><a href="{{ URL::previous() }}">Elements</a></li>
            
            <li class="active">Client Edit</li>
        </ol>
    </section>

    <section class="content">
        
        <!-- Default box -->
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-plus-square"></i> Tambah Client Element</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                            title="Collapse">
                    <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                    <i class="fa fa-times"></i></button>
                </div>
            </div>

            <form class="form-sample" action="{{route('client-element.store')}}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="box-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="name_client" for="">Nama Client <span class="text-danger">*</span></label>
                                @if (empty($data))
                                    <input id="name_client" type="text" class="form-control" name="name_client" required autocomplete="off" placeholder="Sample : Diaz Djuliansyah" >
                                @else
                                    <input id="name_client" type="text" class="form-control" name="name_client" required autocomplete="off" placeholder="Sample : Diaz Djuliansyah" value="{{$data->name_prospective_client}}" readonly>
                                    <input type="hidden" name="uuid_lobbyists" value="{{$data->uuid_lobbyists }}">
                                @endif
                                
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="no_telp_client" for="">No Telpon <span class="text-danger">*</span></label>
                                <input id="no_telp_client" type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" class="form-control" name="no_telp_client" required autocomplete="off" placeholder="Sample : 0896****2668">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="email_client" for="">Email <span class="text-danger">*</span></label>
                                <input id="email_client" type="email" class="form-control  @error('email_client') is-invalid @enderror" name="email_client" value="{{ old('email_client') }}" required autocomplete="off" placeholder="Sample : sample@imedianet.id">
                                @error('email_client')
                                    <span class="invalid-feedback" role="alert" style="color: red;">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="company_client" for="">Nama Perusahaan </label>
                                <input id="company_client" type="text" class="form-control" name="company_client" autocomplete="off" placeholder="Sample : PT IKHLAS CIPTA TEKNOLOGI (ISP)">
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="form-group">
                                <label class="address_client" for="">Alamat Client <span class="text-danger">*</span></label>
                                <input id="address_client" type="text" class="form-control" name="address_client" required autocomplete="off" placeholder="Sample : Jl. Masjid Al Mochtar Jl. Malaka No.4, RT.3/RW.8, Munjul, Kec. Cipayung, Kota Jakarta Timur, Daerah Khusus Ibukota Jakarta 13850">
                            </div>
                        </div>
                    </div>

                    
                </div>
                <!-- /.box-body -->

                <!-- /.box-footer -->
                <div class="box-footer">
                    <a href="{{ URL::previous() }}" class="btn btn-warning" ><i class="fa  fa-arrow-circle-left"></i> Back</a>
                    <button type="submit" class="btn btn-info"><i class="fa fa-save"></i> Save</button>
                </div>
            </form>
            
        </div>
        
        <!-- /.box -->
    </section>


    
@endsection