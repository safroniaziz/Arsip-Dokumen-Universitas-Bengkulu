@php
    use App\Models\KlasifikasiBerkas;
@endphp
@extends('layouts.layout')
@section('title', 'Manajemen Klasifikasi Berkas')
@section('login_as', 'Operator')
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
    @include('operator/sidebar')
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
                        
                        <strong class="text-uppercase"><i class="fa fa-info-circle"></i>&nbsp;Perhatian: </strong><br> Silahkan tambahkan usulan kegiatan anda, harap melengkapi data terlebih dahulu agar proses pengajuan usulan tidak ada masalah kedepannya !!
                    </div>
                </div>
                <div class="row">
                    <form action="{{ route('operator.berkas.update') }}" enctype="multipart/form-data" method="POST">
                        {{ csrf_field() }} {{ method_field('PATCH') }}
                        <div class="col-md-12">
                            <input type="hidden" name="id" value="{{ $berkas->id }}">
                           
                            <div class="form-group col-md-6">
                                <label for="exampleInputEmail1">Nomor Berkas</label>
                                <input type="text" name="nomor_berkas" value="{{ $berkas->nomor_berkas }}" class="tags form-control @error('nomor_berkas') is-invalid @enderror" />
                                @if ($errors->has('nomor_berkas'))
                                    <small class="form-text text-danger">{{ $errors->first('nomor_berkas') }}</small>
                                @endif
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputEmail1">Jenis Berkas</label>
                                <input type="text" name="jenis_berkas" value="{{ $berkas->jenis_berkas }}" class="tags form-control @error('jenis_berkas') is-invalid @enderror" />
                                @if ($errors->has('jenis_berkas'))
                                    <small class="form-text text-danger">{{ $errors->first('jenis_berkas') }}</small>
                                @endif
                            </div>
                            
                            <div class="form-group col-md-6">
                                <label for="exampleInputEmail1">File : <a class="text-danger">Harap masukan file JPG/DOC/PDF. Max : 2MB</a></label>
                                <input type="file" name="file" id="file" class="form-control @error('file') is-invalid @enderror" style="padding-bottom:30px;">
                                @if ($errors->has('file'))
                                    <small class="form-text text-danger">{{ $errors->first('file') }}</small>
                                @endif
                            </div>
                            
                            <div class="form-group col-md-6">
                                <label for="exampleInputEmail1">Klasifikasi Arsip</label></label>
                                <select name="klasifikasi_id[]"  class="form-control tags-selector @error('klasifikasi_id') is-invalid @enderror" id="klasifikasi_id" style="font-size:13px;" multiple>
                                        @foreach ($klasifikasis as $klasifikasi)
                                            <option 
                                                @foreach ($item_klasifikasi as $item)
                                                    {{ $klasifikasi->id == $item ? 'selected' : '' }}
                                                @endforeach
                                            value="{{ $klasifikasi->id }}">{{ $klasifikasi->nm_klasifikasi }}</option>
                                        @endforeach
                                </select>
                                @if ($errors->has('klasifikasi_id'))
                                    <small class="form-text text-danger">{{ $errors->first('klasifikasi_id') }}</small>
                                @endif
                            </div>

                            <div class="form-group col-md-12">
                                <label for="exampleInputEmail1">Uraian Informasi : </label>
                                <textarea name="uraian_informasi" id="uraian_informasi" class="form-control @error('uraian_informasi') is-invalid @enderror" cols="30" rows="3">{{ $berkas->uraian_informasi }}</textarea>
                                @if ($errors->has('uraian_informasi'))
                                    <small class="form-text text-danger">{{ $errors->first('uraian_informasi') }}</small>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-12 text-center">
                            <hr style="width: 50%" class="mt-0">
                            <a href="{{ route('operator.berkas') }}" class="btn btn-warning btn-sm" style="color: white"><i class="fa fa-arrow-left"></i>&nbsp; Kembali</a>
                            <button type="reset" name="reset" class="btn btn-danger btn-sm"><i class="fa fa-refresh"></i>&nbsp;Ulangi</button>
                            <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-check-circle"></i>&nbsp;Simpan Berkas</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function(){
            $('.tags-selector').select2();
        })
    </script>
@endpush