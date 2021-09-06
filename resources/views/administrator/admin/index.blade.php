@extends('layouts.layout')
@section('title', 'Manajemen Data Administrator')
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
@push('styles')
    <style>
        #detail:hover{
            text-decoration: underline !important;
            cursor: pointer !important;
            color:teal;
        }
        #selengkapnya{
            color:#5A738E;
            text-decoration:none;
            cursor:pointer;
        }
        #selengkapnya:hover{
            color:#007bff;
        }
    </style>
@endpush
@section('content')
    <section class="panel" style="margin-bottom:20px;">
        <header class="panel-heading" style="color: #ffffff;background-color: #074071;border-color: #fff000;border-image: none;border-style: solid solid none;border-width: 4px 0px 0;border-radius: 0;font-size: 14px;font-weight: 700;padding: 15px;">
            <i class="fa fa-home"></i>&nbsp;Arsip Dokumen Universitas Bengkulu
        </header>
        <div class="panel-body" style="border-top: 1px solid #eee; padding:15px; background:white;">
            <div class="row" style="margin-right:-15px; margin-left:-15px;">
                <div class="col-md-12">
                    @if ($message   = Session::get('success'))
                        <div class="alert alert-success alert-block" id="keterangan">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong><i class="fa fa-info-circle"></i>&nbsp;Berhasil: </strong> {{ $message }}
                        </div>
                        @else
                            <div class="alert alert-success alert-block" id="keterangan">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <strong><i class="fa fa-info-circle"></i>&nbsp;Perhatian: </strong> Berikut adalah data admin aplikasi arsip berkas universitas bengkulu, silahkan tambahkan admin baru jika dibutuhkan !!
                            </div>
                    @endif
                </div>
                <div class="col-md-12">
                    <a onclick="tambahAdmin()" class="btn btn-primary btn-sm" style="color:white; cursor:pointer;"><i class="fa fa-user-plus"></i>&nbsp; Tambah admin</a>
                </div>
                <div class="col-md-12">
                    <table class="table table-striped table-bordered" id="table" style="width:100%;">
                        <thead>
                            <tr>
                                <th style="text-align:center;">No</th>
                                <th style="text-align:center">Nama admin</th>
                                <th style="text-align:center">Email</th>
                                <th style="text-align:center">Password</th>
                                <th style="text-align:center">Status admin</th>
                                <th style="text-align:center">Ubah Status</th>
                                <th style="text-align:center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no=1;
                            @endphp
                            @foreach ($admins as $admin)
                                <tr>
                                    <td style="text-align:center;;"> {{ $no++ }} </td>
                                    <td style="text-align:center;"> {{ $admin->nm_user }} </td>
                                    <td style="text-align:center;"> {{ $admin->email }} </td>
                                    <td style="text-align:center;">
                                        <a onclick="ubahPassword( {{ $admin->id }} )" class="btn btn-primary btn-sm" style="color:white; cursor:pointer;"><i class="fa fa-key"></i></a>
                                    </td>
                                    <td style="text-align:center;">
                                        @if ($admin->status == "aktif")
                                            <span class="badge badge-success"><i class="fa fa-check-circle"></i>&nbsp; Aktif</span>
                                            @else
                                            <span class="badge badge-danger"><i class="fa fa-minus-circle"></i>&nbsp; Tidak Aktif</span>
                                        @endif
                                    </td>
                                    <td style="text-align:center;">
                                        @if ($admin->status == "aktif")
                                            <form action="{{ route('administrator.admin.nonaktifkan_status',[$admin->id]) }}" method="POST">
                                                {{ csrf_field() }} {{ method_field('PATCH') }}
                                                <button type="submit" class="btn btn-danger btn-sm" style="color:white; cursor:pointer;"><i class="fa fa-thumbs-down"></i></button>
                                            </form>
                                            @else
                                            <form action="{{ route('administrator.admin.aktifkan_status',[$admin->id]) }}" method="POST">
                                                {{ csrf_field() }} {{ method_field('PATCH') }}
                                                <button type="submit" class="btn btn-primary btn-sm" style="color:white; cursor:pointer;"><i class="fa fa-thumbs-up"></i></button>
                                            </form>
                                        @endif
                                    </td>
                                    <td style="text-align:center;">
                                        <a onclick="ubahData( {{ $admin->id }} )" class="btn btn-primary btn-sm" style="color:white; cursor:pointer;"><i class="fa fa-edit"></i></a>
                                        <a onclick="hapusData( {{ $admin->id }} )" class="btn btn-danger btn-sm" style="color:white; cursor:pointer;"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <!-- Modal Ubah Password-->
                        <div class="modal fade" id="formubahpassword" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <form action=" {{ route('administrator.admin.update_password') }} " method="POST">
                                    {{ csrf_field() }} {{ method_field('PATCH') }}
                                    <div class="modal-header">
                                        <p style="font-size:15px; font-weight:bold;" class="modal-title"><i class="fa fa-key"></i>&nbsp;Form Ubah Password admin</p>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input type="hidden" name="id" id="id_password">
                                                <div class="form-group">
                                                    <label for="">Masukan Password Baru :</label>
                                                    <input type="password" name="password_baru" id="password_baru" class="form-control" placeholder="password baru">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Ulangi Password Baru :</label>
                                                    <input type="password" name="password_ulangi" id="password_ulangi" class="form-control" placeholder="ulangi password baru">
                                                    <small id="konfirmasi" style="display:none;" class="form-text text-success"><i>password sama</i></small>
                                                    <small id="konfirmasi-gagal" style="display:none;" class="form-text text-danger"><i>password tidak sama</i></small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-close"></i>&nbsp; Batalkan</button>
                                        <button type="submit" class="btn btn-primary btn-sm" id="btn-submit" disabled><i class="fa fa-check-circle"></i>&nbsp; Simpan Perubahan</button>
                                    </div>
                                </form>
                            </div>
                            </div>
                        </div>
                    </table>
                    <!-- Modal Ubah -->
                    <div class="modal fade" id="modalubah" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <form action=" {{ route('administrator.admin.update') }} " method="POST">
                                {{ csrf_field() }} {{ method_field('PATCH') }}
                                <div class="modal-header">
                                    <p style="font-size:15px; font-weight:bold;" class="modal-title"><i class="fa fa-key"></i>&nbsp;Form Ubah Data admin</p>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <input type="hidden" name="id" id="id_ubah">
                                            <div class="form-group">
                                                <label for="">Nama Lengkap :</label>
                                                <input type="text" name="nm_user" id="nm_user_edit" class="form-control" placeholder="nama lengkap" required>
                                                <small class="form-text text-danger">{{ $errors->first('nm_user') }}</small>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Email :</label>
                                                <input type="email" name="email" id="email_edit" class="form-control" placeholder="email " required>
                                                <small class="form-text text-danger">{{ $errors->first('nm_user') }}</small>
                                            </div>
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
                        <form action=" {{ route('administrator.admin.delete') }} " method="POST">
                            {{ csrf_field() }} {{ method_field('DELETE') }}
                            <div class="modal-header">
                                <p style="font-size:15px; font-weight:bold;" class="modal-title"><i class="fa fa-key"></i>&nbsp;Form Konfirmasi Hapus Data</p>
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
            <!-- Modal Ubah -->
            <div class="modal fade" id="modaltambah" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action=" {{ route('administrator.admin.post') }} " method="POST">
                        {{ csrf_field() }} {{ method_field('POST') }}
                        <div class="modal-header">
                            <p style="font-size:15px; font-weight:bold;" class="modal-title"><i class="fa fa-key"></i>&nbsp;Form Tambah Data admin</p>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="hidden" name="id" id="id_ubah">
                                    <div class="form-group">
                                        <label for="">Nama Lengkap :</label>
                                        <input type="text" name="nm_user" value="{{ old('nm_user') }}" class="form-control @error('nm_user') is-invalid @enderror" placeholder="nama lengkap">
                                        <small class="form-text text-danger">{{ $errors->first('nm_user') }}</small>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Email :</label>
                                        <input type="text" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" placeholder="email ">
                                        <small class="form-text text-danger">{{ $errors->first('email') }}</small>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Password :</label>
                                        <input type="password" name="password" id="password_tambah" class="form-control @error('password') is-invalid @enderror" placeholder="**** ">
                                        <small class="form-text text-danger">{{ $errors->first('password') }}</small>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Ulangi Password :</label>
                                        <input type="password" name="password_ulangi" id="password_tambah_ulangi" class="form-control @error('password_ulangi') is-invalid @enderror" placeholder="**** ">
                                        <small id="konfirmasi-tambah" style="display:none;" class="form-text text-success"><i>password sama</i></small>
                                        <small id="konfirmasi-gagal-tambah" style="display:none;" class="form-text text-danger"><i>password tidak sama</i></small>
                                        <small class="form-text text-danger">{{ $errors->first('password_ulangi') }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-close"></i>&nbsp; Batalkan</button>
                            <button type="submit" class="btn btn-primary btn-sm" id="btn-submit-tambah"><i class="fa fa-check-circle"></i>&nbsp; Simpan Data</button>
                        </div>
                    </form>
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

        function tambahAdmin(){
            $('#modaltambah').modal('show');
        }

        @if($errors->any())
            $('#modaltambah').modal('show');
        @endif

        function ubahPassword(id){
            $('#formubahpassword').modal('show');
            $("#id_password").val(id);
        }

        $(document).ready(function(){
            $("#password_baru, #password_ulangi").keyup(function(){
                var password = $("#password_baru").val();
                var ulangi = $("#password_ulangi").val();
                if($("#password_baru").val() == $("#password_ulangi").val()){
                    $('#konfirmasi').show(100);
                    $('#konfirmasi-gagal').hide(100);
                    $('#btn-submit').attr("disabled",false);
                }
                else{
                    $('#konfirmasi').hide(100);
                    $('#konfirmasi-gagal').show(100);
                    $('#btn-submit').attr("disabled",true);
                }
            });
        });

        $(document).ready(function(){
            $("#password_tambah, #password_tambah_ulangi").keyup(function(){
                var password = $("#password_tambah").val();
                var ulangi = $("#password_tambah_ulangi").val();
                if($("#password_tambah").val() == $("#password_tambah_ulangi").val()){
                    $('#konfirmasi-tambah').show(100);
                    $('#konfirmasi-gagal-tambah').hide(100);
                    $('#btn-submit-tambah').attr("disabled",false);
                }
                else{
                    $('#konfirmasi-tambah').hide(100);
                    $('#konfirmasi-gagal-tambah').show(100);
                    $('#btn-submit-tambah').attr("disabled",true);
                }
            });
        });

        function ubahData(id){
            $.ajax({
                url: "{{ url('administrator/manajemen_administrator') }}"+'/'+ id + "/edit",
                type: "GET",
                dataType: "JSON",
                success: function(data){
                    $('#modalubah').modal('show');
                    $('#id_ubah').val(id);
                    $('#nm_user_edit').val(data.nm_user);
                    $('#email_edit').val(data.email);
                },
                error:function(){
                    alert("Nothing Data");
                }
            });
        }

        function hapusData(id){
            $('#modalhapus').modal('show');
            $('#id_hapus').val(id);
        }

    </script>
@endpush
