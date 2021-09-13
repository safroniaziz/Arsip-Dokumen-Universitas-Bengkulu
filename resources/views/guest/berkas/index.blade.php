@php
    use App\Models\KlasifikasiBerkas;
@endphp
@extends('layouts.layout')
@section('title', 'Lihat Berkas')
@section('login_as', 'Guest')
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
    @include('guest/sidebar')
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
                                <strong><i class="fa fa-info-circle"></i>&nbsp;Perhatian: </strong> Berikut semua berkas berkas yang sudah diupload oleh operator !!
                            </div>
                    @endif
                </div>

                <div class="form-group col-md-12">
                    <label for="">Filter Per Unit</label>
                    <select id="unit" class="form-control">
                        <option disabled selected>-- pilih unit --</option>
                        @foreach ($units as $item)
                            <option value="{{ $item->nm_unit }}">{{ $item->nm_unit }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-12 table-responsive">
                    <table class="table table-striped table-bordered" id="table" style="width:100%;">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nomor Berkas</th>
                                <th>Jenis Berkas</th>
                                <th>Nama Klasifikasi</th>
                                <th>Download File</th>
                                <th>Pengunggah</th>
                                <th>Unit Pengunggah</th>
                                <th>Uraian Informasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no=1;
                            @endphp
                            @foreach ($berkas as $berkas)
                                <tr>
                                    <td> {{ $no++ }} </td>
                                    <td style="width: 20%">
                                        {{ $berkas->nomor_berkas }} 
                                        <hr style="margin: 5px 0px !important">
                                        Diinput {{ $berkas->created_at ? $berkas->created_at->diffForHumans() : '-' }} ({{ $berkas->created_at ? \Carbon\Carbon::parse($berkas->created_at)->format('j F Y H:i') : '' }})
                                    </td>
                                    <td> {{ $berkas->jenis_berkas }} </td>
                                    <td>
                                        <?php
                                            $klasifikasi = explode(',',$berkas->klasifikasi_id);
                                            foreach ($klasifikasi as $item) {
                                                $data = KlasifikasiBerkas::where('id',$item)->select('nm_klasifikasi')->first();
                                                if (!empty($data['nm_klasifikasi'])) {
                                                    ?>
                                                        <label class="badge badge-info">{{ $data->nm_klasifikasi }}</label>
                                                    <?php
                                                }
                                            }
                                        ?>
                                    </td>
                                    <td style="text-align: center">
                                        <a class="btn btn-primary btn-sm" href="{{ asset('upload_file/'.\Illuminate\Support\Str::slug($berkas->nm_unit).'/'.$berkas->file) }}" download="{{ $berkas->file }}"><i class="fa fa-download"></i></a>
                                    </td>
                                    <td> {{ $berkas->nm_operator }} </td>
                                    <td> {{ $berkas->nm_unit }} </td>
                                    <td> {{ $berkas->uraian_informasi }} </td>
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
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.colVis.min.js"></script>
    <script>
        $(document).ready(function() {
            var table = $('#table').DataTable({
                responsive : true,
            });

            $('#unit').change(function() {
            table.columns(6)
            .search(this.value)
            .draw();
        });
        } );
    </script>
@endpush
