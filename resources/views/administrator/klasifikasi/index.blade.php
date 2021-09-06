@extends('layouts.layout')
@section('title', 'Manajemen Klasifikasi Berkas')
@section('login_as', 'Administrator')
@section('user-login')
    @if (Auth::check())
    {{ Auth::user()->nm_user }}
    @endif
@endsection
@section('user-login2')
    @if (Auth::check())
    {{ Auth::user()->nm_user }}
    @endif
@endsection
@section('sidebar-menu')
    @include('administrator/sidebar')
@endsection
@section('content')
    <section class="panel" style="margin-bottom:20px;">
        <header class="panel-heading" style="color: #ffffff;background-color: #074071;border-color: #fff000;border-image: none;border-style: solid solid none;border-width: 4px 0px 0;border-radius: 0;font-size: 14px;font-weight: 700;padding: 15px;">
            <i class="fa fa-home"></i>&nbsp;Arsip Dokumen Universitas Bengkulu
        </header>
        <div class="panel-body" style="border-top: 1px solid #eee; padding:15px; background:white;">
            <div class="row" style="margin-right:-15px; margin-left:-15px;">
                <div class="col-md-12">
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button> 
                            <strong>Berhasil :</strong>{{ $message }}
                        </div>
                        @elseif ($message = Session::get('error'))
                            <div class="alert alert-danger alert-block">
                                <button type="button" class="close" data-dismiss="alert">×</button> 
                                <strong>Gagal :</strong>{{ $message }}
                            </div>
                            @else
                            <div class="alert alert-success alert-block" id="keterangan">
                                <strong><i class="fa fa-info-circle"></i>&nbsp;Perhatian: </strong> Berikut semua klasifikasi berkas yang tersedia, silahkan tambahkan jika diperlukan !!
                            </div>
                    @endif
                </div>
                <div class="col-md-12" id="form-klasifikasi">
                    <hr style="width:50%;">
                    <form action="{{ route('administrator.klasifikasi.post') }}" method="POST">
                        {{ csrf_field() }} {{ method_field('POST') }}
                        <div class="row">
                            <div class="form-group col-md-12 col-xs-12">
                                <label>Nama Klasifikasi :</label>
                                <input type="text" name="nm_klasifikasi" value="{{ old('nm_klasifikasi') }}" class="form-control @error('nm_klasifikasi') is-invalid @enderror" placeholder="masukan nama klasifikasi">
                                <div>
                                    @if ($errors->has('nm_klasifikasi'))
                                        <small class="form-text text-danger">{{ $errors->first('nm_klasifikasi') }}</small>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group col-md-12 col-xs-12">
                                <label>Keterangan :</label>
                                <textarea name="keterangan" class="form-control @error('keterangan') is-invalid @enderror" id="" cols="30" rows="3">{{ old('keterangan') }}</textarea>
                                <div>
                                    @if ($errors->has('keterangan'))
                                        <small class="form-text text-danger">{{ $errors->first('keterangan') }}</small>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12" style="text-align:center;">
                            <a onclick="batalkan()" class="btn btn-danger btn-sm" style="color:white; cursor:pointer;"><i class="fa fa-close"></i>&nbsp; Batalkan</a>
                            <button type="reset" class="btn btn-warning btn-sm" style="color:white; cursor:pointer;"><i class="fa fa-refresh"></i>&nbsp; Ulangi</button>
                            <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-check-circle"></i>&nbsp; Simpan Jabatan</button>
                        </div>
                    </form>
                    <hr style="width:50%;">
                </div>
                <div class="col-md-12">
                    <table class="table table-striped table-bordered" id="table" style="width:100%;">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Klasifikasi</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no=1;
                            @endphp
                            @foreach ($klasifikasis as $klasifikasi)
                                <tr>
                                    <td> {{ $no++ }} </td>
                                    <td> {{ $klasifikasi->nm_klasifikasi }} </td>
                                    <td> {{ $klasifikasi->keterangan }} </td>
                                    <td>
                                        <a onclick="editklasifikasi({{ $klasifikasi->id }})" class="btn btn-primary btn-sm" style="color:white;cursor:pointer;"><i class="fa fa-edit"></i></a>
                                        <a onclick="hapusklasifikasi({{ $klasifikasi->id }})" class="btn btn-danger btn-sm" style="color:white;cursor:pointer;"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- Modal Ubah -->
                    <div class="modal fade" id="modalubah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <form action=" {{ route('administrator.klasifikasi.update') }} " method="POST">
                                    {{ csrf_field() }} {{ method_field('PATCH') }}
                                    <div class="modal-header">
                                        <p style="font-size:15px; font-weight:bold;" class="modal-title"><i class="fa fa-suitcase"></i>&nbsp;Form Ubah Data Klasifikasi Berkas</p>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input type="hidden" name="id" id="id_ubah">
                                                <div class="form-group">
                                                    <label for="">Nama Klasifikasi :</label>
                                                    <input type="text" name="nm_klasifikasi" id="nm_klasifikasi_edit" class="form-control @error('nm_klasifikasi') is-invalid @enderror" required placeholder="masukan kelas Klasifikasi">
                                                </div>
                                            </div>

                                            <div class="form-group col-md-12 col-xs-12">
                                                <label>Keterangan :</label>
                                                <textarea name="keterangan" id="keterangan_edit" class="form-control @error('keterangan') is-invalid @enderror" id="" cols="30" rows="3" required></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-close"></i>&nbsp; Batalkan</button>
                                        <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-check-circle"></i>&nbsp; Simpan Perubahan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal Hapus-->
                <div class="modal fade modal-danger" id="modalhapus" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <form action=" {{ route('administrator.klasifikasi.delete') }} " method="POST">
                                {{ csrf_field() }} {{ method_field('DELETE') }}
                                <div class="modal-header">
                                    <p style="font-size:15px; font-weight:bold;" class="modal-title"><i class="fa fa-trash"></i>&nbsp;Form Konfirmasi Hapus Data</p>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <input type="hidden" name="id" id="id_hapus">
                                            Apakah anda yakin ingin menghapus data? klik hapus jika iya !!
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" style="border: 1px solid #fff;background: transparent;color: #fff;" class="btn btn-sm btn-outline pull-left" data-dismiss="modal"><i class="fa fa-close"></i>&nbsp; Batalkan</button>
                                    <button type="submit" style="border: 1px solid #fff;background: transparent;color: #fff;" class="btn btn-sm btn-outline"><i class="fa fa-check-circle"></i>&nbsp; Ya, Hapus</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $('#table').DataTable({
                responsive : true,
            });
        } );
        
        function editklasifikasi(id){
            $.ajax({
                url: "{{ url('administrator/manajemen_klasifikasi') }}"+'/'+ id + "/edit",
                type: "GET",
                dataType: "JSON",
                success: function(data){
                    $('#modalubah').modal('show');
                    $('#id_ubah').val(id);
                    $('#nm_klasifikasi_edit').val(data.nm_klasifikasi);
                    $('#keterangan_edit').val(data.keterangan);
                },
                error:function(){
                    alert("Nothing Data");
                }
            });
        }

        function hapusklasifikasi(id){
            $('#modalhapus').modal('show');
            $('#id_hapus').val(id);
        }

        $(document).ready(function() {
            $('#Klasifikasi_id_induk').select2({width:'100%'});
        });

    </script>
@endpush
