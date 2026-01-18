@extends('layouts.app')

@section('content')

    @include('components.breadcrumb', compact('breadcrumbs'))

    @if (session('message'))
        <div class="container-fluid p-3">
            <div class="alert alert-{{ session('code') === '200' ? 'success' : 'danger' }}">
                {{ session('message') }}
            </div>
        </div>
    @endif

    <div class="container-fluid p-3">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ $title }}</div>

                    <div class="card-body p-0">
                        <form method="GET" action="{{ route('campaigns.list') }}" class="mb-3 px-4 pt-1 col-md-6 col-12">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" placeholder="Buscar campaña..."
                                    value="{{ request('search') }}">
                                <button type="submit" class="btn btn-primary">Buscar</button>
                            </div>
                        </form>

                        <div class="clearfix"></div>

                        <div class="table-responsive" style="border:0">

                            <table class="table">
                                <thead>
                                    <tr>
                                        <th style="width:18px">#</th>
                                        <th>Campa&ntilde;a</th>
                                        <th>Link</th>
                                        <th>Fecha de Creaci&oacute;n</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($campaigns->count() > 0)
                                        @foreach ($campaigns as $campaign)
                                            <tr class="table-flag-blue">
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $campaign->title }}</td>
                                                <td>{{ $campaign->link }}</td>
                                                <td>{{ $campaign->created_at }}</td>
                                                <td>
                                                    <a class="btn btn-success show-tooltip px-2 py-1" title="Previsualización"
                                                        href="{{ url('view/' . $campaign->id) }}" target="_blank">
                                                        <i class="fa fa-eye"></i>
                                                    </a>&nbsp;
                                                    <a class="btn btn-success show-tooltip px-2 py-1" title="Editar"
                                                        href="{{ url('campaigns/edit/' . $campaign->id) }}">
                                                        <i class="fa fa-pencil"></i>
                                                    </a>&nbsp;
                                                    <a class="btn btn-info show-tooltip px-2 py-1" title="Bloques del Mail"
                                                        href="{{ url('blocks/list/' . $campaign->id) }}">
                                                        <i class="fa fa-folder-tree"></i>
                                                    </a>&nbsp;
                                                    <a href="{{ url('campaigns/delete/' . $campaign->id) }}"
                                                        class="btn btn-danger show-tooltip px-2 py-1" title="Eliminar"
                                                        onclick="return confirm('Desea eliminar este registro?')">
                                                        <i class="fa fa-trash"></i>
                                                    </a>&nbsp;
                                                    <a href="{{ url('campaigns/download/' . $campaign->id) }}"
                                                        class="btn btn-lime show-tooltip px-2 py-1" title="Descargar"
                                                        onclick="return confirm('Desea descargar este correo?')">
                                                        <i class="fa fa-download"></i>
                                                    </a>&nbsp;
                                                    <a class="btn btn-info show-tooltip px-2 py-1" title="Copiar Campaña"
                                                        href="{{ url('campaigns/copy/' . $campaign->id) }}"
                                                        onclick="return confirm('Desea copiar este registro?');">
                                                        <i class="fa fa-clone"></i>
                                                    </a>&nbsp;
                                                    @if ($campaign->envio == 1)
                                                        <a class="btn btn-success show-tooltip px-2 py-1" title="Enviar Mail"
                                                            href="{{ url('send/' . $campaign->id) }}"
                                                            onclick="return confirm('Desea Enviar este correo?')">
                                                            <i class="fa fa-paper-plane-o"></i>
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5">No existen registros</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>

                        </div>
                        <!-- Agregar paginación -->
                        <div class="d-flex justify-content-center mt-3">
                            {{ $campaigns->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
