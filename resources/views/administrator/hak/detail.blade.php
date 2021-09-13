@extends('layouts.layout')
@section('title', 'Previlages Guest')
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
                                <strong><i class="fa fa-info-circle"></i>&nbsp;Perhatian: </strong> Berikut adalah detail akses guest <b>{{ $guest->nm_user }}</b> !!
                            </div>
                    @endif
                </div>
                <div class="col-md-12">
                    <a href="{{ route('administrator.hak') }}" class="btn btn-danger btn-sm" style="color:white; cursor:pointer;"><i class="fa fa-arrow-left"></i>&nbsp; Kembali</a>
                    <a href="{{ route('administrator.hak.add',[$id]) }}" class="btn btn-primary btn-sm" style="color:white; cursor:pointer;"><i class="fa fa-plus"></i>&nbsp; Tambah Previlages</a>
                </div>
                <div class="col-md-12">
                    <table class="table table-striped table-bordered" id="table" style="width:100%;">
                        <thead>
                            <tr>
                                <th style="text-align:center;">No</th>
                                <th style="text-align:center">Nama Guest</th>
                                <th style="text-align:center">Unit Diakses</th>
                                <th style="text-align:center">Status Previlages</th>
                                <th style="text-align:center">Nonaktifkan Status</th>
                                <th style="text-align:center">Waktu Selesai</th>
                                <th style="text-align:center">Hapus</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no=1;
                            @endphp
                            @foreach ($details as $detail)
                                <tr>
                                    <td style="text-align:center;;"> {{ $no++ }} </td>
                                    <td style="text-align:center;"> {{ $detail->nm_user }} </td>
                                    <td style="text-align:center;"> {{ $detail->nm_unit }} </td>
                                    <td style="text-align:center;">
                                        @if ($detail->status == "aktif")
                                            <?php
                                                $tgl=date('Y-m-d');
                                                if ($tgl > $detail->waktu_selesai) {
                                                    ?>
                                                        <span class="badge badge-danger"><i class="fa fa-minus-circle"></i>&nbsp; Tidak Aktif</span>
                                                    <?php
                                                } else {
                                                    ?>
                                                        <span class="badge badge-success"><i class="fa fa-check-circle"></i>&nbsp; Aktif</span>
                                                    <?php
                                                }
                                            ?>
                                            @else
                                            <span class="badge badge-danger"><i class="fa fa-minus-circle"></i>&nbsp; Tidak Aktif</span>
                                        @endif
                                    </td>
                                    <td style="text-align:center;">
                                        @if ($detail->status == "aktif")
                                            <?php
                                                $tgl=date('Y-m-d');
                                                if ($tgl > $detail->waktu_selesai) {
                                                    ?>
                                                        <a style="color: red">previlages sudah tidak aktif</a>
                                                    <?php
                                                } else {
                                                    ?>
                                                        <form action="{{ route('administrator.hak.nonaktifkan_status',[$detail->id,$id]) }}" method="POST">
                                                            {{ csrf_field() }} {{ method_field('PATCH') }}
                                                            <button type="submit" class="btn btn-danger btn-sm" style="color:white; cursor:pointer;"><i class="fa fa-thumbs-down"></i></button>
                                                        </form>
                                                    <?php
                                                }
                                            ?>
                                            
                                            @else
                                            <a style="color: red">previlages sudah tidak aktif</a>
                                        @endif
                                    </td>
                                    
                                    <td style="text-align:center;">
                                        @if ($detail->status == "aktif")
                                            <?php
                                                $tgl=date('Y-m-d');
                                                if ($tgl > $detail->waktu_selesai) {
                                                    ?>
                                                        <a style="color: red">waktu sudah habis</a>
                                                    <?php
                                                } else {
                                                    ?>
                                                        {{ $detail->waktu_selesai }}
                                                    <?php
                                                }
                                            ?>
                                            @else
                                            <a style="color: red">waktu sudah habis</a>
                                        @endif
                                    </td>
                                    <td>
                                        <form action="{{ route('administrator.hak.delete',[$detail->id,$id]) }}" method="POST">
                                            {{ csrf_field() }} {{ method_field('DELETE') }}
                                            <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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
    </script>
@endpush
