
@if (isset($breadcrumbs) && count($breadcrumbs) > 0)
<div class="container-fluid pt-3 px-3">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card mb-0">
                <div class="card-body py-0">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb my-0 py-2">
                        @foreach ($breadcrumbs as $index => $breadcrumb)
                            @if ($index < count($breadcrumbs) - 1) 
                                {{-- Si no es la última, tiene enlace --}}
                                <li class="breadcrumb-item"><a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['title'] }}</a></li>
                            @else
                                {{-- La última es activa sin enlace --}}
                                <li class="breadcrumb-item active" aria-current="page">{{ $breadcrumb['title'] }}</li>
                            @endif
                        @endforeach

                        </ol>
                    </nav>
                </div>    
            </div>
        </div>
    </div>
</div>
@endif
