@extends('layouts.app')

@push('styles')
<style>
    body {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: 100vh;
    }
    
    .mail_preview_container {
        max-width: 700px;
        margin: auto;
        padding: 25px;
        border: none;
        border-radius: 15px;
        background: linear-gradient(145deg, #ffffff, #f8f9fa);
        box-shadow: 0 15px 35px rgba(58, 87, 232, 0.1), 0 5px 15px rgba(0, 0, 0, 0.08);
        position: relative;
        overflow: hidden;
    }
    
    .mail_preview_container::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #3a57e8, #667eea);
    }
    
    .mail_container {
        width: 600px;
        margin: auto;
        background-color: #fff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 8px 25px rgba(58, 87, 232, 0.08);
    }
    
    .card {
        border: none;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(58, 87, 232, 0.1);
        overflow: hidden;
    }
    
    .card-header {
        background: linear-gradient(135deg, #3a57e8, #667eea);
        color: white;
        border: none;
        padding: 20px 25px;
        font-weight: 600;
        font-size: 1.1rem;
    }
    
    .card-body {
        background-color: #fefefe;
    }
    
    /* Botones principales mejorados */
    .btn-primary {
        background: linear-gradient(135deg, #3a57e8, #667eea);
        border: none;
        border-radius: 10px;
        padding: 12px 24px;
        font-weight: 500;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(58, 87, 232, 0.3);
    }
    
    .btn-primary:hover {
        background: linear-gradient(135deg, #2a47d8, #5670da);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(58, 87, 232, 0.4);
    }
    
    .btn-secondary {
        background: linear-gradient(135deg, #6c757d, #868e96);
        border: none;
        border-radius: 10px;
        padding: 12px 24px;
        font-weight: 500;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(108, 117, 125, 0.3);
    }
    
    .btn-secondary:hover {
        background: linear-gradient(135deg, #5c636a, #76848c);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(108, 117, 125, 0.4);
    }
    
    .btn-warning {
        background: linear-gradient(135deg, #ffc107, #ffcd39);
        border: none;
        border-radius: 10px;
        padding: 12px 24px;
        font-weight: 500;
        color: #212529;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(255, 193, 7, 0.3);
    }
    
    .btn-warning:hover {
        background: linear-gradient(135deg, #e0a800, #edb516);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(255, 193, 7, 0.4);
        color: #212529;
    }
    
    /* Bloques mejorados con drag & drop */
    .block-item {
        background: linear-gradient(145deg, #ffffff, #f8f9fa);
        border: 2px solid transparent;
        border-radius: 15px;
        padding: 20px;
        margin-bottom: 20px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: grab;
        position: relative;
        overflow: hidden;
    }
    
    .block-item:active {
        cursor: grabbing;
    }
    
    .block-item::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(58, 87, 232, 0.03), transparent);
        transition: left 0.5s;
    }
    
    .block-item:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 35px rgba(58, 87, 232, 0.15);
        border-color: rgba(58, 87, 232, 0.2);
    }
    
    .block-item:hover::before {
        left: 100%;
    }
    
    .block-item.selected {
        border-color: #3a57e8;
        background: linear-gradient(145deg, #ffffff, #f8faff);
        box-shadow: 0 15px 35px rgba(58, 87, 232, 0.2), 0 0 0 1px rgba(58, 87, 232, 0.1);
        transform: translateY(-2px);
    }
    
    .block-item.selected::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: linear-gradient(180deg, #3a57e8, #667eea);
    }
    
    /* Estilos para drag & drop */
    .block-item.dragging {
        opacity: 0.5;
        cursor: grabbing;
        transform: rotate(2deg) scale(1.02);
    }
    
    .block-item.drag-over {
        border-color: #3a57e8;
        border-style: dashed;
        background: linear-gradient(145deg, #f8faff, #ffffff);
    }
    
    /* Indicador de arrastre */
    .drag-handle {
        position: absolute;
        top: 15px;
        left: 15px;
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(108, 117, 125, 0.9);
        color: white;
        border-radius: 8px;
        cursor: grab;
        opacity: 0;
        visibility: hidden;
        transform: translateY(10px);
        transition: all 0.3s ease;
        z-index: 10;
        box-shadow: 0 4px 15px rgba(108, 117, 125, 0.3);
        backdrop-filter: blur(10px);
    }
    
    .block-item.selected .drag-handle,
    .block-item:hover .drag-handle {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }
    
    .drag-handle:active {
        cursor: grabbing;
    }
    
    .drag-handle:hover {
        background: rgba(88, 97, 105, 1);
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(108, 117, 125, 0.4);
    }
    
    .drag-handle i {
        font-size: 16px;
    }
    
    /* Botones de acción (ocultos por defecto) */
    .block-actions {
        opacity: 0;
        visibility: hidden;
        transform: translateY(10px);
        transition: all 0.3s ease;
        position: absolute;
        top: 15px;
        right: 15px;
        z-index: 10;
    }
    
    .block-item.selected .block-actions,
    .block-item:hover .block-actions {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }
    
    /* Botones de eliminar y editar */
    .btn-action {
        border: none;
        border-radius: 8px;
        padding: 8px 12px;
        font-size: 0.85rem;
        font-weight: 500;
        transition: all 0.3s ease;
        margin-left: 5px;
        backdrop-filter: blur(10px);
    }
    
    .btn-delete {
        background: rgba(220, 53, 69, 0.9);
        color: white;
        box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);
    }
    
    .btn-delete:hover {
        background: rgba(200, 35, 51, 1);
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(220, 53, 69, 0.4);
        color: white;
    }
    
    .btn-edit {
        background: rgba(58, 87, 232, 0.9);
        color: white;
        box-shadow: 0 4px 15px rgba(58, 87, 232, 0.3);
    }
    
    .btn-edit:hover {
        background: rgba(42, 71, 216, 1);
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(58, 87, 232, 0.4);
        color: white;
    }
    
    /* Indicador visual de selección */
    .selection-indicator {
        position: absolute;
        top: 15px;
        left: 50px;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: #3a57e8;
        opacity: 0;
        transform: scale(0);
        transition: all 0.3s ease;
    }
    
    .block-item.selected .selection-indicator {
        opacity: 1;
        transform: scale(1);
    }
    
    /* Animación de carga */
    .block-item {
        animation: fadeInUp 0.6s ease forwards;
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    /* Espaciado y botones principales */
    .action-buttons {
        gap: 15px;
    }
    
    /* Mensaje de guardado */
    .save-message {
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 15px 25px;
        background: linear-gradient(135deg, #28a745, #34ce57);
        color: white;
        border-radius: 10px;
        box-shadow: 0 8px 25px rgba(40, 167, 69, 0.3);
        z-index: 1000;
        opacity: 0;
        transform: translateY(-20px);
        transition: all 0.3s ease;
    }
    
    .save-message.show {
        opacity: 1;
        transform: translateY(0);
    }
</style>
@endpush

@section('content')

@include('components.breadcrumb', array_merge(compact('breadcrumbs'), ['campaign' => $campaign]))

<div class="container-fluid p-3">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{!! $title !!}</div>

                <div class="card-body p-3">
                    <div class="mb-4 d-flex flex-wrap action-buttons">
                        <button onclick="window.location.href='{{ url('blocks/add') }}'" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Agregar Bloque
                        </button>

                        <a href="{{ url('view/' . $campaign->id) }}" target="_blank" class="btn btn-secondary">
                            <i class="fas fa-eye me-2"></i>Previsualizar
                        </a>

                        <button onclick="window.open('{{ url('campaigns/download/' . $campaign->id) }}','_blank');" class="btn btn-warning">
                            <i class="fas fa-download me-2"></i>Descargar
                        </button>
                    </div>

                    <div class="mail_preview_container">
                        <div class="mail_container">
                            <!-- HEADER -->
                            @if (!empty($campaign->header_template))
                                @include('components.headers.' . $campaign->header_template, ['campaign' => $campaign])
                            @endif

                            <!-- BLOQUES -->
                            <div id="blocks-container">
                                @foreach ($blocks as $item)
                                    <div class="block-item" 
                                         data-block-id="{{ $item['block']->id }}"
                                         draggable="true">
                                        
                                        <div class="drag-handle">
                                            <i class="fas fa-grip-vertical"></i>
                                        </div>
                                        
                                        <div class="selection-indicator"></div>
                                        
                                        <div class="block-actions">
                                            <a href="{{ url('blocks/edit/' . $item['block']->id) }}" 
                                               class="btn btn-action btn-edit"
                                               title="Editar bloque">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            
                                            <a href="{{ url('blocks/delete/' . $item['block']->id) }}"
                                               onclick="return confirm('¿Seguro que deseas eliminar este bloque?')"
                                               class="btn btn-action btn-delete"
                                               title="Eliminar bloque">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                        
                                        <div class="block-content">
                                            {!! $item['html'] !!}
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- FOOTER -->
                            @if (!empty($campaign->footer_template))
                                @include('components.footers.' . $campaign->footer_template, ['campaign' => $campaign])
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Mensaje de guardado -->
<div class="save-message" id="saveMessage">
    <i class="fas fa-check-circle me-2"></i>Orden guardado correctamente
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const blockItems = document.querySelectorAll('.block-item');
    const blocksContainer = document.getElementById('blocks-container');
    let draggedElement = null;
    
    // Selección de bloques
    blockItems.forEach(item => {
        item.addEventListener('click', function(e) {
            // Evitar que los clics en los botones de acción o el handle seleccionen el bloque
            if (e.target.closest('.block-actions') || e.target.closest('.drag-handle')) {
                return;
            }
            
            // Remover selección de otros bloques
            blockItems.forEach(otherItem => {
                otherItem.classList.remove('selected');
            });
            
            // Agregar selección al bloque actual
            this.classList.add('selected');
        });
    });
    
    // Deseleccionar al hacer clic fuera
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.block-item')) {
            blockItems.forEach(item => {
                item.classList.remove('selected');
            });
        }
    });
    
    // Drag & Drop functionality
    const draggableBlocks = document.querySelectorAll('.block-item[draggable="true"]');
    
    draggableBlocks.forEach(block => {
        // Drag start
        block.addEventListener('dragstart', function(e) {
            draggedElement = this;
            this.classList.add('dragging');
            e.dataTransfer.effectAllowed = 'move';
            e.dataTransfer.setData('text/html', this.innerHTML);
        });
        
        // Drag end
        block.addEventListener('dragend', function(e) {
            this.classList.remove('dragging');
            
            // Remover la clase drag-over de todos los bloques
            draggableBlocks.forEach(item => {
                item.classList.remove('drag-over');
            });
            
            // Guardar el nuevo orden
            saveBlockOrder();
        });
        
        // Drag over
        block.addEventListener('dragover', function(e) {
            e.preventDefault();
            e.dataTransfer.dropEffect = 'move';
            
            if (this === draggedElement) return;
            
            // Remover drag-over de todos los elementos
            draggableBlocks.forEach(item => {
                item.classList.remove('drag-over');
            });
            
            this.classList.add('drag-over');
        });
        
        // Drag enter
        block.addEventListener('dragenter', function(e) {
            e.preventDefault();
            if (this !== draggedElement) {
                this.classList.add('drag-over');
            }
        });
        
        // Drag leave
        block.addEventListener('dragleave', function(e) {
            this.classList.remove('drag-over');
        });
        
        // Drop
        block.addEventListener('drop', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            if (this === draggedElement) return;
            
            // Determinar si insertar antes o después
            const rect = this.getBoundingClientRect();
            const midpoint = rect.top + rect.height / 2;
            
            if (e.clientY < midpoint) {
                blocksContainer.insertBefore(draggedElement, this);
            } else {
                blocksContainer.insertBefore(draggedElement, this.nextSibling);
            }
            
            this.classList.remove('drag-over');
        });
    });
    
    // Función para guardar el orden de los bloques
    function saveBlockOrder() {
        const blocks = document.querySelectorAll('.block-item');
        const order = [];
        
        blocks.forEach((block, index) => {
            order.push({
                id: block.dataset.blockId,
                position: index + 1
            });
        });
        
        // Enviar el orden al servidor
        fetch('{{ url("blocks/reorder") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                campaign_id: {{ $campaign->id }},
                order: order
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showSaveMessage();
            }
        })
        .catch(error => {
            console.error('Error al guardar el orden:', error);
        });
    }
    
    // Mostrar mensaje de guardado
    function showSaveMessage() {
        const message = document.getElementById('saveMessage');
        message.classList.add('show');
        
        setTimeout(() => {
            message.classList.remove('show');
        }, 3000);
    }
});
</script>

@endsection