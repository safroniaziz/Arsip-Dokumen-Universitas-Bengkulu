<li>
    <a href=" {{ route('operator.dashboard') }} "><i class="fa fa-home"></i>Dashboard</a>
</li>

<li><a><i class="fa fa-list-alt"></i>Klasifikasi Berkas <span class="fa fa-chevron-down"></span></a>
    <ul class="nav child_menu">
        <li><a href="{{ route('operator.klasifikasi_saya') }}">Klasifikasi Saya</a></li>
        <li><a href="{{ route('operator.all_klasifikasi') }}">Semua Klasifikasi</a></li>
    </ul>
</li>

<li
    @if (Route::current()->getName() == "operator.berkas.add" || Route::current()->getName() == "operator.berkas.edit")
        class="set_active active"
    @endif
><a><i class="fa fa-list-alt"></i>Manajemen Berkas <span class="fa fa-chevron-down"></span></a>
    <ul class="nav child_menu"
        @if (Route::current()->getName() == "operator.berkas.add" || Route::current()->getName() == "operator.berkas.edit")
            style="display:block !important;"
        @endif
    >
        <li
            @if (Route::current()->getName() == "operator.berkas.add" || Route::current()->getName() == "operator.berkas.edit")
                class="current-page"
            @endif
        ><a href="{{ route('operator.berkas') }}">Berkas Saya</a></li>

        <li><a href="{{ route('operator.berkas_anak') }}">Berkas Bawah Unit</a></li>
    </ul>
</li>

<li style="padding-left:2px;">
    <a class="dropdown-item" href="{{ route('logout') }}"
        onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
        <i class="fa fa-power-off text-danger"></i>{{__('Logout') }}
    </a>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

</li>

@push('styles')
    <style>
        .noclick       {
            pointer-events: none;
            cursor: context-menu;
            background-color: #ed5249;
        }

        .default{
            cursor: default;
        }

        .set_active{
            border-right: 5px solid #1ABB9C;
        }

    </style>
@endpush