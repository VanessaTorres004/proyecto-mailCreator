<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 30px;
        }
        .campaign-info {
            background: #f9f9f9;
            border-left: 4px solid #667eea;
            padding: 20px;
            margin: 20px 0;
            border-radius: 5px;
        }
        .info-row {
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e0e0e0;
        }
        .info-row:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        .label {
            font-weight: bold;
            color: #667eea;
            display: block;
            margin-bottom: 5px;
        }
        .value {
            color: #555;
        }
        .button {
            display: inline-block;
            padding: 15px 30px;
            background: #667eea;
            color: white !important;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
            text-align: center;
        }
        .footer {
            text-align: center;
            padding: 20px;
            color: #999;
            font-size: 12px;
            background: #f9f9f9;
        }
        .alert {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📋 Nueva Campaña Asignada</h1>
        </div>
        
        <div class="content">
            <p>Hola <strong>{{ $collaboration->user->name }}</strong>,</p>
            
            <p>Se te ha asignado una nueva campaña para trabajar. A continuación los detalles:</p>
            
            <div class="campaign-info">
                <div class="info-row">
                    <span class="label">Campaña:</span>
                    <span class="value">{{ $campaign->title }}</span>
                </div>
                
                @if($campaign->description)
                <div class="info-row">
                    <span class="label">Descripción:</span>
                    <span class="value">{{ $campaign->description }}</span>
                </div>
                @endif
                
                <div class="info-row">
                    <span class="label">Asignado por:</span>
                    <span class="value">{{ $assignedBy->name }}</span>
                </div>
                
                @if($collaboration->deadline)
                <div class="info-row">
                    <span class="label">Fecha límite:</span>
                    <span class="value">{{ \Carbon\Carbon::parse($collaboration->deadline)->format('d/m/Y') }}</span>
                </div>
                @endif
                
                @if($collaboration->notes)
                <div class="info-row">
                    <span class="label">Notas adicionales:</span>
                    <span class="value">{{ $collaboration->notes }}</span>
                </div>
                @endif
                
                <div class="info-row">
                    <span class="label">Estado:</span>
                    <span class="value">Pendiente</span>
                </div>
            </div>
            
            @if($collaboration->deadline)
            <div class="alert">
                <strong>⏰ Recordatorio:</strong> Esta campaña tiene fecha límite el 
                {{ \Carbon\Carbon::parse($collaboration->deadline)->format('d/m/Y') }}
            </div>
            @endif
            
            <p>Por favor, revisa los detalles de la campaña y comienza a trabajar en ella lo antes posible.</p>
            
            <div style="text-align: center;">
                <a href="{{ url('my-collaborations') }}" class="button">
                    Ver Mis Colaboraciones
                </a>
            </div>
        </div>
        
        <div class="footer">
            <p>Este es un correo automático de MailCreator</p>
            <p>© {{ date('Y') }} {{ config('app.name') }}</p>
        </div>
    </div>
</body>
</html>