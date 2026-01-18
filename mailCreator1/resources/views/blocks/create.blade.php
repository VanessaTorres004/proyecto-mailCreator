@extends('layouts.app')

@section('content')
@include('components.breadcrumb', compact('breadcrumbs'))

@push('styles')
<style>
  body {
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    min-height: 100vh;
  }

  .card {
    border: none;
    border-radius: 20px;
    box-shadow: 0 15px 35px rgba(58, 87, 232, 0.15);
    overflow: hidden;
    backdrop-filter: blur(10px);
  }

  .card-header {
    background: linear-gradient(135deg, #3a57e8, #667eea);
    border: none;
    padding: 25px;
    position: relative;
    overflow: hidden;
  }

  .card-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
    animation: shine 3s infinite;
  }

  @keyframes shine {
    0% { left: -100%; }
    50% { left: 100%; }
    100% { left: -100%; }
  }

  .card-header h4 {
    margin: 0;
    font-weight: 600;
    font-size: 1.5rem;
    text-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  }

  .card-body {
    padding: 30px;
    background: linear-gradient(145deg, #ffffff, #f8f9fa);
  }

  .block-container {
    position: relative;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    cursor: pointer;
    border-radius: 15px;
    padding: 25px;
    background: linear-gradient(145deg, #ffffff, #f8faff);
    box-shadow: 0 8px 25px rgba(58, 87, 232, 0.08);
    border: 2px solid transparent;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
  }

  .block-container::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(58, 87, 232, 0.03), transparent);
    transition: left 0.6s;
  }

  .block-container:hover {
    transform: translateY(-8px) scale(1.02);
    box-shadow: 0 20px 40px rgba(58, 87, 232, 0.2);
    border-color: rgba(58, 87, 232, 0.3);
  }

  .block-container:hover::before {
    left: 100%;
  }

  .block-container.selected {
    transform: translateY(-5px) scale(1.02);
    border-color: #3a57e8;
    background: linear-gradient(145deg, #ffffff, #f0f3ff);
    box-shadow: 
      0 20px 40px rgba(58, 87, 232, 0.25),
      0 0 0 3px rgba(58, 87, 232, 0.1),
      inset 0 1px 0 rgba(255, 255, 255, 0.6);
  }

  .block-container.selected::after {
    content: '';
    position: absolute;
    top: -2px;
    left: -2px;
    right: -2px;
    bottom: -2px;
    background: linear-gradient(45deg, #3a57e8, #667eea, #3a57e8);
    border-radius: 17px;
    z-index: -1;
    animation: borderGlow 2s linear infinite;
  }

  @keyframes borderGlow {
    0%, 100% { opacity: 0.6; }
    50% { opacity: 1; }
  }

  .preview-img {
    width: 100%;
    max-width: 100%;
    height: auto;
    border-radius: 12px;
    transition: all 0.4s ease;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
  }

  .block-container:hover .preview-img {
    transform: scale(1.05);
    box-shadow: 0 15px 30px rgba(58, 87, 232, 0.2);
  }

  .block-container.selected .preview-img {
    transform: scale(1.03);
    box-shadow: 0 15px 30px rgba(58, 87, 232, 0.3);
  }

  .block-label {
    margin-top: 15px;
    font-weight: 600;
    font-size: 0.95rem;
    color: #4a5568;
    transition: all 0.3s ease;
    text-align: center;
  }

  .block-container:hover .block-label {
    color: #3a57e8;
    transform: translateY(-2px);
  }

  .block-container.selected .block-label {
    color: #3a57e8;
    font-weight: 700;
  }

  .selection-indicator {
    position: absolute;
    top: 15px;
    right: 15px;
    width: 24px;
    height: 24px;
    border-radius: 50%;
    background: linear-gradient(135deg, #3a57e8, #667eea);
    opacity: 0;
    transform: scale(0);
    transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 12px;
    box-shadow: 0 4px 15px rgba(58, 87, 232, 0.4);
  }

  .block-container.selected .selection-indicator {
    opacity: 1;
    transform: scale(1);
  }

  .selection-indicator::after {
    content: '✓';
    font-weight: bold;
  }

  /* Botones mejorados */
  .btn {
    border-radius: 12px;
    padding: 12px 30px;
    font-weight: 600;
    transition: all 0.3s ease;
    border: none;
    position: relative;
    overflow: hidden;
  }

  .btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.5s;
  }

  .btn:hover::before {
    left: 100%;
  }

  .btn-primary {
    background: linear-gradient(135deg, #3a57e8, #667eea);
    box-shadow: 0 8px 20px rgba(58, 87, 232, 0.3);
  }

  .btn-primary:hover {
    background: linear-gradient(135deg, #2a47d8, #5670da);
    transform: translateY(-2px);
    box-shadow: 0 12px 25px rgba(58, 87, 232, 0.4);
  }

  .btn-outline-secondary {
    background: transparent;
    border: 2px solid #6c757d;
    color: #6c757d;
    box-shadow: 0 4px 15px rgba(108, 117, 125, 0.2);
  }

  .btn-outline-secondary:hover {
    background: #6c757d;
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(108, 117, 125, 0.3);
  }

  /* Animación de entrada */
  .block-container {
    opacity: 0;
    transform: translateY(30px);
    animation: fadeInUp 0.6s ease forwards;
  }

  .block-container:nth-child(1) { animation-delay: 0.1s; }
  .block-container:nth-child(2) { animation-delay: 0.2s; }
  .block-container:nth-child(3) { animation-delay: 0.3s; }
  .block-container:nth-child(4) { animation-delay: 0.4s; }
  .block-container:nth-child(5) { animation-delay: 0.5s; }
  .block-container:nth-child(6) { animation-delay: 0.6s; }
  .block-container:nth-child(7) { animation-delay: 0.7s; }
  .block-container:nth-child(8) { animation-delay: 0.8s; }
  .block-container:nth-child(9) { animation-delay: 0.9s; }

  @keyframes fadeInUp {
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  /* Grid responsive mejorado */
  .blocks-grid {
    gap: 25px;
  }

  @media (max-width: 768px) {
    .block-container {
      padding: 20px;
    }
    
    .preview-img {
      max-width: 100%;
    }
    
    .card-body {
      padding: 20px;
    }
  }

  /* Efecto de focus para accesibilidad */
  .block-container:focus {
    outline: none;
    box-shadow: 0 0 0 3px rgba(58, 87, 232, 0.3);
  }
</style>
@endpush

<div class="container py-4">
  <div class="row justify-content-center">
    <div class="col-lg-10">
      <div class="card">
        <div class="card-header text-center">
          <h4 class="text-white">
            <i class="fas fa-cube me-3"></i>Selecciona un bloque
          </h4>
        </div>

        <div class="card-body">
          <form action="{{ url('blocks/add') }}" method="POST">
            @csrf
            <input type="hidden" name="block_type" id="block_type" required>

            <div class="row blocks-grid text-center">
              {{-- Título --}}
              <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="block-container" data-type="title_1" tabindex="0">
                  <div class="selection-indicator"></div>
                  <img src="{{ asset('img/bodies/title.png') }}" class="preview-img" alt="Bloque Título">
                  <p class="block-label">
                    <i class="fas fa-heading me-2"></i>Título
                  </p>
                </div>
              </div>

              {{-- Subtítulo --}}
              <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="block-container" data-type="subtitle_1" tabindex="0">
                  <div class="selection-indicator"></div>
                  <img src="{{ asset('img/bodies/subtitle.png') }}" class="preview-img" alt="Bloque Subtítulo">
                  <p class="block-label">
                    <i class="fas fa-text-height me-2"></i>Subtítulo
                  </p>
                </div>
              </div>

              {{-- Logo --}}
              <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="block-container" data-type="logo_1" tabindex="0">
                  <div class="selection-indicator"></div>
                  <img src="{{ asset('img/bodies/logo.png') }}" class="preview-img" alt="Bloque Logo">
                  <p class="block-label">
                    <i class="fas fa-image me-2"></i>Logo
                  </p>
                </div>
              </div>

              {{-- Imagen --}}
              <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="block-container" data-type="image_1" tabindex="0">
                  <div class="selection-indicator"></div>
                  <img src="{{ asset('img/bodies/image.png') }}" class="preview-img" alt="Bloque Imagen">
                  <p class="block-label">
                    <i class="fas fa-photo-video me-2"></i>Imagen
                  </p>
                </div>
              </div>

              {{-- Grid --}}
              <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="block-container" data-type="grid_1" tabindex="0">
                  <div class="selection-indicator"></div>
                  <img src="{{ asset('img/bodies/grid.png') }}" class="preview-img" alt="Bloque Grid">
                  <p class="block-label">
                    <i class="fas fa-th me-2"></i>Grid
                  </p>
                </div>
              </div>

              {{-- Mensaje --}}
              <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="block-container" data-type="message_1" tabindex="0">
                  <div class="selection-indicator"></div>
                  <img src="{{ asset('img/bodies/message.png') }}" class="preview-img" alt="Bloque Mensaje">
                  <p class="block-label">
                    <i class="fas fa-comment me-2"></i>Mensaje
                  </p>
                </div>
              </div>

              {{-- Botón --}}
              <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="block-container" data-type="button_1" tabindex="0">
                  <div class="selection-indicator"></div>
                  <img src="{{ asset('img/bodies/button.png') }}" class="preview-img" alt="Bloque Botón">
                  <p class="block-label">
                    <i class="fas fa-hand-pointer me-2"></i>Botón
                  </p>
                </div>
              </div>

              {{-- Banner --}}
              <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="block-container" data-type="banner_1" tabindex="0">
                  <div class="selection-indicator"></div>
                  <img src="{{ asset('img/bodies/banner.png') }}" class="preview-img" alt="Bloque Banner">
                  <p class="block-label">
                    <i class="fas fa-flag me-2"></i>Banner
                  </p>
                </div>
              </div>

              {{-- Icono-texto --}}
              <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="block-container" data-type="icono_1" tabindex="0">
                  <div class="selection-indicator"></div>
                  <img src="{{ asset('img/bodies/icono.png') }}" class="preview-img" alt="Bloque Icono">
                  <p class="block-label">
                    <i class="fas fa-icons me-2"></i>Icono
                  </p>
                </div>
              </div>

              {{-- Social --}}
              <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="block-container" data-type="social_1" tabindex="0">
                  <div class="selection-indicator"></div>
                  <img src="{{ asset('img/bodies/social.png') }}" class="preview-img" alt="Bloque social">
                  <p class="block-label">
                    <i class="fas fa-share-alt me-2"></i>Social
                  </p>
                </div>
              </div>

              {{-- Instructivo --}}
              <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="block-container" data-type="instructivo_1" tabindex="0">
                  <div class="selection-indicator"></div>
                  <img src="{{ asset('img/bodies/instu.png') }}" class="preview-img" alt="Bloque instructivo">
                  <p class="block-label">
                    <i class="fas fa-list-ol me-2"></i>Instructivo
                  </p>
                </div>
              </div>
            </div>

            <div class="mt-5 d-flex justify-content-between align-items-center">
              <a href="{{ url('blocks/list/' . session('campaign_id')) }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Cancelar
              </a>
              <button type="submit" class="btn btn-primary" id="submitBtn">
                <i class="fas fa-plus me-2"></i>Agregar bloque
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
  $(document).ready(function () {
    // Función para seleccionar bloque
    function selectBlock($container) {
      $('.block-container').removeClass('selected');
      $container.addClass('selected');
      const type = $container.data('type');
      $('#block_type').val(type);
      
      // Animación del botón de enviar
      $('#submitBtn').addClass('btn-success').removeClass('btn-primary');
      setTimeout(() => {
        $('#submitBtn').removeClass('btn-success').addClass('btn-primary');
      }, 300);
    }

    // Click en contenedor
    $('.block-container').click(function () {
      selectBlock($(this));
    });

    // Soporte para teclado (accesibilidad)
    $('.block-container').keypress(function(e) {
      if (e.which === 13 || e.which === 32) { // Enter o Space
        e.preventDefault();
        selectBlock($(this));
      }
    });

    // Validación del formulario con mejor UX
    $('form').on('submit', function(e) {
      if (!$('#block_type').val()) {
        e.preventDefault();
        
        // Animación de error
        $('.block-container').addClass('animate__animated animate__pulse animate__faster');
        setTimeout(() => {
          $('.block-container').removeClass('animate__animated animate__pulse animate__faster');
        }, 1000);
        
        // Alerta mejorada
        Swal.fire({
          title: '¡Atención!',
          text: 'Por favor selecciona un bloque antes de continuar.',
          icon: 'warning',
          confirmButtonText: 'Entendido',
          confirmButtonColor: '#3a57e8',
          showClass: {
            popup: 'animate__animated animate__fadeInDown'
          },
          hideClass: {
            popup: 'animate__animated animate__fadeOutUp'
          }
        });
        
        return false;
      }
      
      // Animación de carga en el botón
      const $btn = $('#submitBtn');
      const originalText = $btn.html();
      $btn.html('<i class="fas fa-spinner fa-spin me-2"></i>Agregando...')
          .prop('disabled', true);
    });

    // Preselección si hay un tipo en la URL (para mejorar UX)
    const urlParams = new URLSearchParams(window.location.search);
    const preselected = urlParams.get('type');
    if (preselected) {
      const $preselectedBlock = $(`.block-container[data-type="${preselected}"]`);
      if ($preselectedBlock.length) {
        selectBlock($preselectedBlock);
      }
    }
  });
</script>

{{-- SweetAlert2 para alertas mejoradas --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
{{-- Animate.css para animaciones --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
@endsection