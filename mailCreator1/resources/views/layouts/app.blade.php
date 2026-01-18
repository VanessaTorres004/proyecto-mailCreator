<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'MailCreator') }}</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/core/libs.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendor/aos/dist/aos.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/hope-ui.min.css?v=2.0.0') }}" />
    <link rel="stylesheet" href="{{ asset('css/custom.min.css?v=2.0.0') }}" />
    <link rel="stylesheet" href="{{ asset('css/dark.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/customizer.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/rtl.min.css') }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    @stack('styles')
    <link href="https://unpkg.com/filepond/dist/filepond.min.css" rel="stylesheet">
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css"
        rel="stylesheet">
    <script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>
    <script
        src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.min.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.js"></script>
    <script
        src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.min.js"></script>

    <script type="text/javascript">
        function addMenu(num) {
            var newNum = num + 1;
            var html = '<div id="' + num + '" class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">' +
                '<input type="text" name="menu_url[]" class="form-control" data-rule-required="true" data-rule-url="true" placeholder="Direcci&oacute;n WEB"/>&nbsp;&nbsp;<input type="text" name="menu_nombres[]" class="form-control" data-rule-required="true" data-rule-minlength="3" placeholder="Nombre" />' +
                '<div class="mt-2"><a href="javascript:addMenu(' + newNum + ')" class="btn btn-success btn-add" ><i class="fa fa-plus"></i></a><a href="javascript:removeMenu(' + num + ')" class="btn btn-danger btn-add"><i class="fa fa-minus"></i></a></div>' +
                '</div>';
            $('#menus').append(html);
        }
        function removeMenu(num) {
            $('#' + num).remove();
        }
    </script>
</head>

<body>
    <style>
        .form-control {
            border-color: #00000066 !important;
        }

        .btn-add {
            padding: 0.3rem 0.3rem !important;
            font-size: 0.8rem;
        }
        
        .notification-badge {
            position: absolute;
            top: -5px;
            right: -8px;
            min-width: 20px;
            height: 20px;
            border-radius: 10px;
            font-size: 0.7rem;
            line-height: 20px;
            text-align: center;
            padding: 0 5px;
        }
    </style>
    <div id="app" class="d-flex">
        @auth
        <div id="loading">
            <div class="loader simple-loader">
                <div class="loader-body"></div>
            </div>
        </div>
        <aside class="sidebar sidebar-default sidebar-white sidebar-base navs-rounded-all ">
            <div class="sidebar-header d-flex align-items-center justify-content-start">
                <a href="{{ url('/home') }}" class="navbar-brand">
                    <div class="logo-main">
                        <div class="logo-normal">
                            <svg class=" icon-30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect x="-0.757324" y="19.2427" width="28" height="4" rx="2"
                                    transform="rotate(-45 -0.757324 19.2427)" fill="currentColor" />
                                <rect x="7.72803" y="27.728" width="28" height="4" rx="2"
                                    transform="rotate(-45 7.72803 27.728)" fill="currentColor" />
                                <rect x="10.5366" y="16.3945" width="16" height="4" rx="2"
                                    transform="rotate(45 10.5366 16.3945)" fill="currentColor" />
                                <rect x="10.5562" y="-0.556152" width="28" height="4" rx="2"
                                    transform="rotate(45 10.5562 -0.556152)" fill="currentColor" />
                            </svg>
                        </div>
                        <div class="logo-mini">
                            <svg class=" icon-30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect x="-0.757324" y="19.2427" width="28" height="4" rx="2"
                                    transform="rotate(-45 -0.757324 19.2427)" fill="currentColor" />
                                <rect x="7.72803" y="27.728" width="28" height="4" rx="2"
                                    transform="rotate(-45 7.72803 27.728)" fill="currentColor" />
                                <rect x="10.5366" y="16.3945" width="16" height="4" rx="2"
                                    transform="rotate(45 10.5366 16.3945)" fill="currentColor" />
                                <rect x="10.5562" y="-0.556152" width="28" height="4" rx="2"
                                    transform="rotate(45 10.5562 -0.556152)" fill="currentColor" />
                            </svg>
                        </div>
                    </div>
                    <h4 class="logo-title">MailCreator</h4>
                </a>
                <div class="sidebar-toggle" data-toggle="sidebar" data-active="true">
                    <i class="icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4.25 12.2744L19.25 12.2744" stroke="currentColor" stroke-width="1.5"
                                stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M10.2998 18.2988L4.2498 12.2748L10.2998 6.24976" stroke="currentColor"
                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </i>
                </div>
            </div>
            <div class="sidebar-body pt-0 data-scrollbar">
                <div class="sidebar-list">
                    <ul class="navbar-nav iq-main-menu" id="sidebar-menu">
                        <li class="nav-item static-item">
                            <a class="nav-link static-item disabled" href="#" tabindex="-1">
                                <span class="default-icon">Administración</span>
                                <span class="mini-icon">-</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('home') ? 'active' : '' }}" aria-current="page"
                                href="{{ route('home') }}">
                                <i class="icon">
                                    <svg width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                                        class="icon-20">
                                        <path opacity="0.4"
                                            d="M16.0756 2H19.4616C20.8639 2 22.0001 3.14585 22.0001 4.55996V7.97452C22.0001 9.38864 20.8639 10.5345 19.4616 10.5345H16.0756C14.6734 10.5345 13.5371 9.38864 13.5371 7.97452V4.55996C13.5371 3.14585 14.6734 2 16.0756 2Z"
                                            fill="currentColor"></path>
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M4.53852 2H7.92449C9.32676 2 10.463 3.14585 10.463 4.55996V7.97452C10.463 9.38864 9.32676 10.5345 7.92449 10.5345H4.53852C3.13626 10.5345 2 9.38864 2 7.97452V4.55996C2 3.14585 3.13626 2 4.53852 2ZM4.53852 13.4655H7.92449C9.32676 13.4655 10.463 14.6114 10.463 16.0255V19.44C10.463 20.8532 9.32676 22 7.92449 22H4.53852C3.13626 22 2 20.8532 2 19.44V16.0255C2 14.6114 3.13626 13.4655 4.53852 13.4655ZM19.4615 13.4655H16.0755C14.6732 13.4655 13.537 14.6114 13.537 16.0255V19.44C13.537 20.8532 14.6732 22 16.0755 22H19.4615C20.8637 22 22 20.8532 22 19.44V16.0255C22 14.6114 20.8637 13.4655 19.4615 13.4655Z"
                                            fill="currentColor"></path>
                                    </svg>
                                </i>
                                <span class="item-name">Dashboard</span>
                            </a>
                        </li>
                        @role('admin')
                        <li class="nav-item">
                            <a class="nav-link {{ Str::startsWith(Route::currentRouteName(), 'users') ? 'active' : '' }}"
                                data-bs-toggle="collapse" href="#sidebar-user" role="button" aria-expanded="false"
                                aria-controls="sidebar-user">
                                <i class="icon">
                                    <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M11.9488 14.54C8.49884 14.54 5.58789 15.1038 5.58789 17.2795C5.58789 19.4562 8.51765 20.0001 11.9488 20.0001C15.3988 20.0001 18.3098 19.4364 18.3098 17.2606C18.3098 15.084 15.38 14.54 11.9488 14.54Z"
                                            fill="currentColor"></path>
                                        <path opacity="0.4"
                                            d="M11.949 12.467C14.2851 12.467 16.1583 10.5831 16.1583 8.23351C16.1583 5.88306 14.2851 4 11.949 4C9.61293 4 7.73975 5.88306 7.73975 8.23351C7.73975 10.5831 9.61293 12.467 11.949 12.467Z"
                                            fill="currentColor"></path>
                                        <path opacity="0.4"
                                            d="M21.0881 9.21923C21.6925 6.84176 19.9205 4.70654 17.664 4.70654C17.4187 4.70654 17.1841 4.73356 16.9549 4.77949C16.9244 4.78669 16.8904 4.802 16.8725 4.82902C16.8519 4.86324 16.8671 4.90917 16.8895 4.93889C17.5673 5.89528 17.9568 7.0597 17.9568 8.30967C17.9568 9.50741 17.5996 10.6241 16.9728 11.5508C16.9083 11.6462 16.9656 11.775 17.0793 11.7948C17.2369 11.8227 17.3981 11.8371 17.5629 11.8416C19.2059 11.8849 20.6807 10.8213 21.0881 9.21923Z"
                                            fill="currentColor"></path>
                                        <path
                                            d="M22.8094 14.817C22.5086 14.1722 21.7824 13.73 20.6783 13.513C20.1572 13.3851 18.747 13.205 17.4352 13.2293C17.4155 13.232 17.4048 13.2455 17.403 13.2545C17.4003 13.2671 17.4057 13.2887 17.4316 13.3022C18.0378 13.6039 20.3811 14.916 20.0865 17.6834C20.074 17.8032 20.1698 17.9068 20.2888 17.8888C20.8655 17.8059 22.3492 17.4853 22.8094 16.4866C23.0637 15.9589 23.0637 15.3456 22.8094 14.817Z"
                                            fill="currentColor"></path>
                                        <path opacity="0.4"
                                            d="M7.04459 4.77973C6.81626 4.7329 6.58077 4.70679 6.33543 4.70679C4.07901 4.70679 2.30701 6.84201 2.9123 9.21947C3.31882 10.8216 4.79355 11.8851 6.43661 11.8419C6.60136 11.8374 6.76343 11.8221 6.92013 11.7951C7.03384 11.7753 7.09115 11.6465 7.02668 11.551C6.3999 10.6234 6.04263 9.50765 6.04263 8.30991C6.04263 7.05904 6.43303 5.89462 7.11085 4.93913C7.13234 4.90941 7.14845 4.86348 7.12696 4.82926C7.10906 4.80135 7.07593 4.78694 7.04459 4.77973Z"
                                            fill="currentColor"></path>
                                        <path
                                            d="M3.32156 13.5127C2.21752 13.7297 1.49225 14.1719 1.19139 14.8167C0.936203 15.3453 0.936203 15.9586 1.19139 16.4872C1.65163 17.4851 3.13531 17.8066 3.71195 17.8885C3.83104 17.9065 3.92595 17.8038 3.91342 17.6832C3.61883 14.9167 5.9621 13.6046 6.56918 13.3029C6.59425 13.2885 6.59962 13.2677 6.59694 13.2542C6.59515 13.2452 6.5853 13.2317 6.5656 13.2299C5.25294 13.2047 3.84358 13.3848 3.32156 13.5127Z"
                                            fill="currentColor"></path>
                                    </svg>
                                </i>
                                <span class="item-name">Usuarios</span>
                                <i class="right-icon">
                                    <svg class="icon-18" xmlns="http://www.w3.org/2000/svg" width="18" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </i>
                            </a>
                            <ul class="sub-nav collapse" id="sidebar-user" data-bs-parent="#sidebar-menu">
                                <li class="nav-item">
                                    <a class="nav-link {{ Route::currentRouteName() == 'users.add' ? 'active' : '' }}"
                                        href="{{ route('users.add') }}">
                                        <i class="icon">
                                            <svg class="icon-10" xmlns="http://www.w3.org/2000/svg" width="10"
                                                viewBox="0 0 24 24" fill="currentColor">
                                                <g>
                                                    <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                                </g>
                                            </svg>
                                        </i>
                                        <i class="sidenav-mini-icon"> A </i>
                                        <span class="item-name">Agregar usuario</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link " href="{{ route('users.list') }}">
                                        <i class="icon">
                                            <svg class="icon-10" xmlns="http://www.w3.org/2000/svg" width="10"
                                                viewBox="0 0 24 24" fill="currentColor">
                                                <g>
                                                    <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                                </g>
                                            </svg>
                                        </i>
                                        <i class="sidenav-mini-icon"> U </i>
                                        <span class="item-name">Listar usuarios</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @endrole
                        @role('admin')
<li>
    <hr class="hr-horizontal">
</li>
<li class="nav-item static-item">
    <a class="nav-link static-item disabled" href="#" tabindex="-1">
        <span class="default-icon">Configuración</span>
        <span class="mini-icon">-</span>
    </a>
</li>
<li class="nav-item">
    <a class="nav-link {{ Request::is('admin/roles') ? 'active' : '' }}" 
       href="{{ route('admin.roles.index') }}">
        <i class="icon">
            <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z" fill="currentColor"/>
            </svg>
        </i>
        <span class="item-name">Gestión de Roles</span>
    </a>
</li>
@endrole
                        <li>
                            <hr class="hr-horizontal">
                        </li>
                        <li class="nav-item static-item">
                            <a class="nav-link static-item disabled" href="#" tabindex="-1">
                                <span class="default-icon">Gestión</span>
                                <span class="mini-icon">-</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="collapse" href="#sidebar-special" role="button"
                                aria-expanded="false" aria-controls="sidebar-special">
                                <i class="icon">
                                    <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path opacity="0.4"
                                            d="M22 15.94C22 18.73 19.76 20.99 16.97 21H16.96H7.05C4.27 21 2 18.75 2 15.96V15.95C2 15.95 2.006 11.524 2.014 9.298C2.015 8.88 2.495 8.646 2.822 8.906C5.198 10.791 9.447 14.228 9.5 14.273C10.21 14.842 11.11 15.163 12.03 15.163C12.95 15.163 13.85 14.842 14.56 14.262C14.613 14.227 18.767 10.893 21.179 8.977C21.507 8.716 21.989 8.95 21.99 9.367C22 11.576 22 15.94 22 15.94Z"
                                            fill="currentColor"></path>
                                        <path
                                            d="M21.4759 5.67351C20.6099 4.04151 18.9059 2.99951 17.0299 2.99951H7.04988C5.17388 2.99951 3.46988 4.04151 2.60388 5.67351C2.40988 6.03851 2.50188 6.49351 2.82488 6.75151L10.2499 12.6905C10.7699 13.1105 11.3999 13.3195 12.0299 13.3195C12.0339 13.3195 12.0369 13.3195 12.0399 13.3195C12.0429 13.3195 12.0469 13.3195 12.0499 13.3195C12.6799 13.3195 13.3099 13.1105 13.8299 12.6905L21.2549 6.75151C21.5779 6.49351 21.6699 6.03851 21.4759 5.67351Z"
                                            fill="currentColor"></path>
                                    </svg>
                                </i>
                                <span class="item-name">Campañas</span>
                                <i class="right-icon">
                                    <svg class="icon-18" xmlns="http://www.w3.org/2000/svg" width="18" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </i>
                            </a>
                            <ul class="sub-nav collapse" id="sidebar-special" data-bs-parent="#sidebar-menu">
                                <li class="nav-item">
                                    <a class="nav-link " href="{{ route('campaigns.add') }}">
                                        <i class="icon">
                                            <svg class="icon-10" xmlns="http://www.w3.org/2000/svg" width="10"
                                                viewBox="0 0 24 24" fill="currentColor">
                                                <g>
                                                    <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                                </g>
                                            </svg>
                                        </i>
                                        <i class="sidenav-mini-icon"> B </i>
                                        <span class="item-name">Agregar Campañas</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link " href="{{route('campaigns.list')}}">
                                        <i class="icon">
                                            <svg class="icon-10" xmlns="http://www.w3.org/2000/svg" width="10"
                                                viewBox="0 0 24 24" fill="currentColor">
                                                <g>
                                                    <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                                </g>
                                            </svg>
                                        </i>
                                        <i class="sidenav-mini-icon"> C </i>
                                        <span class="item-name">Listar Campañas</span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- My Collaborations menu item for marketing users -->
                        @hasanyrole('marketing|facultades')
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('my-collaborations') ? 'active' : '' }}" 
                               href="{{ route('campaigns.my-collaborations') }}">
                                <i class="icon">
                                    <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M9 11.5C9 12.3284 8.32843 13 7.5 13C6.67157 13 6 12.3284 6 11.5C6 10.6716 6.67157 10 7.5 10C8.32843 10 9 10.6716 9 11.5Z" fill="currentColor"/>
                                        <path d="M13 11.5C13 12.3284 12.3284 13 11.5 13C10.6716 13 10 12.3284 10 11.5C10 10.6716 10.6716 10 11.5 10C12.3284 10 13 10.6716 13 11.5Z" fill="currentColor"/>
                                        <path d="M17 11.5C17 12.3284 16.3284 13 15.5 13C14.6716 13 14 12.3284 14 11.5C14 10.6716 14.6716 10 15.5 10C16.3284 10 17 10.6716 17 11.5Z" fill="currentColor"/>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12ZM20 12C20 16.4183 16.4183 20 12 20C7.58172 20 4 16.4183 4 12C4 7.58172 7.58172 4 12 4C16.4183 4 20 7.58172 20 12Z" fill="currentColor"/>
                                    </svg>
                                </i>
                                <span class="item-name">Mis Colaboraciones</span>
                            </a>
                        </li>
                        @endhasanyrole
                    </ul>
                </div>
            </div>
            <div class="sidebar-footer"></div>
        </aside>
        @endauth
        <div class="flex-fill main-content">
            <main>
                @auth
                <nav class="nav navbar navbar-expand-lg navbar-light iq-navbar">
                    <div class="container-fluid navbar-inner">
                        <a href="{{ route('home') }}" class="navbar-brand">
                            <div class="logo-main">
                                <div class="logo-normal">
                                    <svg class="text-primary icon-30" viewBox="0 0 30 30" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <rect x="-0.757324" y="19.2427" width="28" height="4" rx="2"
                                            transform="rotate(-45 -0.757324 19.2427)" fill="currentColor" />
                                        <rect x="7.72803" y="27.728" width="28" height="4" rx="2"
                                            transform="rotate(-45 7.72803 27.728)" fill="currentColor" />
                                        <rect x="10.5366" y="16.3945" width="16" height="4" rx="2"
                                            transform="rotate(45 10.5366 16.3945)" fill="currentColor" />
                                        <rect x="10.5562" y="-0.556152" width="28" height="4" rx="2"
                                            transform="rotate(45 10.5562 -0.556152)" fill="currentColor" />
                                    </svg>
                                </div>
                                <div class="logo-mini">
                                    <svg class="text-primary icon-30" viewBox="0 0 30 30" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <rect x="-0.757324" y="19.2427" width="28" height="4" rx="2"
                                            transform="rotate(-45 -0.757324 19.2427)" fill="currentColor" />
                                        <rect x="7.72803" y="27.728" width="28" height="4" rx="2"
                                            transform="rotate(-45 7.72803 27.728)" fill="currentColor" />
                                        <rect x="10.5366" y="16.3945" width="16" height="4" rx="2"
                                            transform="rotate(45 10.5366 16.3945)" fill="currentColor" />
                                        <rect x="10.5562" y="-0.556152" width="28" height="4" rx="2"
                                            transform="rotate(45 10.5562 -0.556152)" fill="currentColor" />
                                    </svg>
                                </div>
                            </div>
                            <h4 class="logo-title">Hope UI</h4>
                        </a>
                        <div class="sidebar-toggle" data-toggle="sidebar" data-active="true">
                            <i class="icon">
                                <svg width="20px" class="icon-20" viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M4,11V13H16L10.5,18.5L11.92,19.92L19.84,12L11.92,4.08L10.5,5.5L16,11H4Z" />
                                </svg>
                            </i>
                        </div>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon">
                                <span class="mt-2 navbar-toggler-bar bar1"></span>
                                <span class="navbar-toggler-bar bar2"></span>
                                <span class="navbar-toggler-bar bar3"></span>
                            </span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="mb-2 navbar-nav ms-auto align-items-center navbar-list mb-lg-0">
                                
                                <!-- Icono de Notificaciones en Navbar -->
                                <li class="nav-item dropdown me-3">
                                    <a class="nav-link position-relative" href="{{ route('notifications.index') }}" id="notificationLink">
                                        <i class="fas fa-bell fa-lg"style="font-size: 22px! important;"></i>
                                        @php
                                            $unreadCount = \App\Models\Notification::where('user_id', Auth::id())->where('read', false)->count();
                                        @endphp
                                        @if($unreadCount > 0)
                                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger notification-badge">
                                                {{ $unreadCount > 99 ? '99+' : $unreadCount }}
                                                <span class="visually-hidden">notificaciones sin leer</span>
                                            </span>
                                        @endif
                                    </a>
                                </li>
                                
                                <!-- Dropdown del Usuario -->
                                <li class="nav-item dropdown">
                                    <a class="py-0 nav-link d-flex align-items-center" href="#" id="navbarDropdown"
                                        role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <img src="{{ asset('images/avatars/01.png') }}" alt="User-Profile"
                                            class="theme-color-default-img img-fluid avatar avatar-50 avatar-rounded">
                                        <div class="caption ms-3 d-none d-md-block">
                                            <h6 class="mb-0 caption-title">{{ Auth::user()->name }}</h6>
                                        </div>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                        <li>
                                            <form action="{{ route('logout') }}" method="POST">
                                                @csrf
                                                <button type="submit" class="dropdown-item">Cerrar sesión</button>
                                            </form>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
                @endauth
                @yield('content')
                @yield('scripts')
            </main>
        </div>
    </div>

    <script
        src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.min.js"></script>

    <script>
        var filesData = {!! json_encode(!empty($campaign->logo ?? null) ? [
            [
                'source' => in_array($campaign->logo, ['rojo.png', 'blanco.png'])
                    ? asset('img/'.$campaign->logo)
                    : asset('uploads/'.$campaign->logo),
                'options' => ['type' => 'local']
            ]
        ] : [])!!};

        FilePond.registerPlugin(FilePondPluginImagePreview, FilePondPluginFileValidateType, FilePondPluginFileValidateSize);

        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        const pond = FilePond.create(document.querySelector('.filepond'), {
            acceptedFileTypes: ['image/*'],
            labelIdle: 'Arrastra y suelta tu imagen o <span class="filepond--label-action">Examinar</span>',
            labelInvalidField: 'El campo contiene archivos inválidos',
            labelFileWaitingForSize: 'Esperando tamaño...',
            labelFileSizeNotAvailable: 'Tamaño no disponible',
            labelFileLoading: 'Cargando',
            labelFileLoadError: 'Error al cargar',
            labelFileProcessing: 'Subiendo',
            labelFileProcessingComplete: 'Subido',
            labelFileProcessingAborted: 'Subida cancelada',
            labelFileProcessingError: 'Error al subir',
            labelTapToCancel: 'Toca para cancelar',
            labelTapToRetry: 'Toca para reintentar',
            labelTapToUndo: 'Toca para deshacer',
            imagePreviewHeight: 150,
            imageCropAspectRatio: '4:3',
            imageResizeTargetWidth: 200,
            imageResizeTargetHeight: 150,
            maxFiles: 1,
            maxFileSize: '1MB',
            allowMultiple: false,
            allowProcess: false,
            storeAsFile: true,
            server: {
                load: (source, load, error, progress, abort, headers) => {
                    fetch(source)
                        .then(res => res.blob())
                        .then(load)
                        .catch(err => {
                            console.error(err);
                            error('Error al cargar la imagen');
                        });
                }
            },
            files: filesData
        });
    </script>
    <script>
        document.getElementById('envio')?.addEventListener('change', function () {
            var label = document.getElementById('envioStatusLabel');
            var campos = document.getElementById('correoCampos');

            if (this.checked) {
                label.innerText = 'SI';
campos.style.display = 'block';
            } else {
                label.innerText = 'NO';
                campos.style.display = 'none';
            }
        });

        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('collapsed');
        }
    </script>
    <script src="{{ asset('js/core/libs.min.js') }}"></script>
    <script src="{{ asset('js/core/external.min.js') }}"></script>
    <script src="{{ asset('js/charts/widgetcharts.js') }}"></script>
    <script src="{{ asset('js/charts/vectore-chart.js') }}"></script>
    <script src="{{ asset('js/charts/dashboard.js') }}"></script>
    <script src="{{ asset('js/plugins/fslightbox.js') }}"></script>
    <script src="{{ asset('js/plugins/setting.js') }}"></script>
    <script src="{{ asset('js/plugins/slider-tabs.js') }}"></script>
    <script src="{{ asset('js/plugins/form-wizard.js') }}"></script>
    <script src="{{ asset('vendor/aos/dist/aos.js') }}"></script>
    <script src="{{ asset('js/hope-ui.js') }}" defer></script>
</body>

</html>