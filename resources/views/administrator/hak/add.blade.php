@extends('layouts.layout')
@section('title', 'Manajemen unit Berkas')
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
                    <div class="alert alert-primary alert-block text-center" id="keterangan">
                        
                        <strong class="text-uppercase"><i class="fa fa-info-circle"></i>&nbsp;Perhatian: </strong><br> Silahkan tambahkan previlages untuk guest <b>{{ $guest->nm_user }}</b> !!
                    </div>
                </div>
                <div class="col-md-12">
                    <form action="{{ route('administrator.hak.post') }}" method="POST">
                        {{ csrf_field() }} {{ method_field('POST') }}
                        <div class="row">
                            <input type="hidden" name="guest_id" value="{{ $id }}">
                            <div class="form-group col-md-6 col-xs-12">
                                <label>Unit Akses :</label>
                                <select name="unit_id" id="unit_id" class="form-control">
                                    <option disabled selected>-- pilih unit induk --</option>
                                    @foreach ($units as $item)
                                        <option value="{{ $item->id }}">{{ $item->nm_unit }}</option>
                                    @endforeach
                                </select>
                                <div>
                                    @if ($errors->has('unit_id'))
                                        <small class="form-text text-danger">{{ $errors->first('unit_id') }}</small>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group col-md-6 col-xs-12">
                                <label>Waktu Selesai :</label>
                                <input type="date" name="waktu_selesai" value="{{ old('waktu_selesai') }}" class="form-control @error('waktu_selesai') is-invalid @enderror" placeholder=" masukan kelas unit">
                                <small class="form-text text-danger">{{ $errors->first('waktu_selesai') }}</small>
                            </div>
                        </div>
                        <div class="col-md-12" style="text-align:center;">
                            <a href="{{ route('administrator.hak.detail',[$id]) }}" class="btn btn-danger btn-sm" style="color:white; cursor:pointer;"><i class="fa fa-arrow-left"></i>&nbsp; Kembali</a>
                            <button type="reset" class="btn btn-warning btn-sm" style="color:white; cursor:pointer;"><i class="fa fa-refresh"></i>&nbsp; Ulangi</button>
                            <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-check-circle"></i>&nbsp; Simpan Jabatan</button>
                        </div>
                    </form>
                    <hr style="width:50%;">
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script>
        $('#unit_id').select2();
    </script>
@endpush