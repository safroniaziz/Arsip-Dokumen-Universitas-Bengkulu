<li>
    <a href=" {{ route('administrator.dashboard') }} "><i class="fa fa-home"></i>Dashboard</a>
</li>

<li>
    <a href=" {{ route('administrator.unit') }} "><i class="fa fa-cog"></i>Manajemen Unit</a>
</li>

<li>
    <a href=" {{ route('administrator.klasifikasi') }} "><i class="fa fa-list-alt"></i>Klasifikasi Berkas</a>
</li>

<li>
    <a href=" {{ route('administrator.berkas') }} "><i class="fa fa-file-o"></i>Manajemen Berkas</a>
</li>

<li><a><i class="fa fa-users"></i>Manajemen Pengguna <span class="fa fa-chevron-down"></span></a>
    <ul class="nav child_menu">
        <li><a href="{{ route('administrator.operator') }}">Manajemen Operator</a></li>
        <li><a href="{{ route('administrator.guest') }}">Manajemen Guest</a></li>
        <li><a href="{{ route('administrator.admin') }}">Manajemen administrator</a></li>
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