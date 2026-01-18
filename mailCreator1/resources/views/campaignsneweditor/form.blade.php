@extends('layouts.app')

@section('styles')
  <style>
    #editor-container {
      height: 600px;
      width: 100%;
    }
  </style>

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
  <div class="row">
    <div class="col-lg-12 mx-auto">
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h4 class="mb-0">Crear campaña</h4>
        </div>
        <div class="card-body">
          <div id="editor-container"></div>
          <button class="btn btn-primary mt-3" id="btn-save">Guardar plantilla</button>
        </div>
      </div>
    </div>
  </div>
</div>
@stop

@section('scripts')
  <script src="https://editor.unlayer.com/embed.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      unlayer.init({
        id: 'editor-container',
        displayMode: 'email',
        features: {
          undoRedo: true,
          imageEditor: true,
        },
        tools: {
          // Aquí puedes ocultar o personalizar herramientas
        }
      });

      document.getElementById('btn-save').addEventListener('click', function () {
        unlayer.exportHtml(function (data) {
          const html = data.html;
          console.log("HTML exportado:", html);

          // Aquí puedes hacer un POST a tu backend
          // Ejemplo:
          // fetch('/guardar-html', {
          //   method: 'POST',
          //   headers: {
          //     'Content-Type': 'application/json',
          //     'X-CSRF-TOKEN': '{{ csrf_token() }}'
          //   },
          //   body: JSON.stringify({ html })
          // });
        });
      });
    });
  </script>
@endsection
