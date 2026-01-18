<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ $campaign->title }}</title>
    <!--[if mso]>
    <noscript>
        <xml>
            <o:OfficeDocumentSettings>
                <o:PixelsPerInch>96</o:PixelsPerInch>
            </o:OfficeDocumentSettings>
        </xml>
    </noscript>
    <![endif]-->
    <style type="text/css">
        /* RESET Y BASE */
        * {
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
            box-sizing: border-box;
        }

        body, table, td, p, h1, h2, h3, h4, h5, h6 {
            margin:0;
            padding: 0;
            border: 0;
            font-family: Arial, Helvetica, sans-serif;
        }

        body {
            width: 100% !important;
            height: 100% !important;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
            font-family: Arial, Helvetica, sans-serif;
            line-height: 1.4;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        table {
            border-collapse: collapse;
            border-spacing: 0;
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
        }

        img {
            border: 0;
            height: auto;
            line-height: 100%;
            outline: none;
            text-decoration: none;
            -ms-interpolation-mode: bicubic;
            max-width: 100%;
            display: block;
        }

        /* CONTENEDOR PRINCIPAL */
        .email-container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: {{ $campaign->background ?? '#ffffff' }};
            border: 0px solid #dddddd;
            border-radius: 0px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        /* CONTENIDO */
        .email-content {
            font-size: 15px;
            line-height: 1.5;
            color: #333333;
            padding-top: 20px;
            padding-bottom: 20px;
        }

        .email-content p {
            margin: 0 0 16px 0;
            padding: 0;
        }

        .email-content p:last-child {
            margin-bottom: 0;
        }

        /* GRID ESPECÍFICO */
        .grid-content {
            padding: 0 !important;
        }

        /* RESPONSIVE */
        @media only screen and (max-width: 620px) {
            .email-wrapper {
                padding: 10px !important;
            }
            
            .email-container {
                width: 100% !important;
                max-width: 100% !important;
                border-radius: 0 !important;
                border-left: none !important;
                border-right: none !important;
                box-shadow: none !important;
            }
            
            .email-content {
                padding: 12px 16px !important;
                font-size: 16px !important;
            }

            .grid-content {
                padding: 0 !important;
            }
        }

        /* DARK MODE SUPPORT */
        @media (prefers-color-scheme: dark) {
            .email-container {
                border-color: #444444;
            }
        }
    </style>
</head>
<body>
    <!--[if mso | IE]>
    <table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="width:600px;">
        <tr>
            <td>
    <![endif]-->

    <!-- WRAPPER EXTERNO CENTRADO -->
    <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%" style="background-color: #f5f5f5;">
        <tr>
            <td align="center" class="email-wrapper" style="padding: 20px 0;">
                <!-- CONTENEDOR PRINCIPAL -->
                <table class="email-container" role="presentation" cellpadding="0" cellspacing="0" border="0" width="600" style="margin:0 auto;">
                    
                    <!-- HEADER -->
                    @if (!empty($campaign->header_template))
                        <tr>
                            <td style="padding: 0;">
                                @include('components.headers.' . $campaign->header_template, ['campaign' => $campaign])
                            </td>
                        </tr>
                    @endif

                    <!-- BLOQUES DE CONTENIDO -->
                    @foreach ($blocks as $item)
                        @php
                            $blockType = $item['type'] ?? 'content';
                            $cssClass = $blockType === 'grid' ? 'grid-content' : 'email-content';
                        @endphp
                        <tr>
                            <td class="{{ $cssClass }}">
                                {!! $item['html'] ?? '' !!}
                            </td>
                        </tr>
                    @endforeach

                    <!-- FOOTER -->
                    @if (!empty($campaign->footer_template))
                        <tr>
                            <td style="padding: 0;">
                                @include('components.footers.' . $campaign->footer_template, ['campaign' => $campaign])
                            </td>
                        </tr>
                    @endif

                </table>
                <!-- FIN CONTENEDOR PRINCIPAL -->
            </td>
        </tr>
    </table>

    <!--[if mso | IE]>
            </td>
        </tr>
    </table>
    <![endif]-->

    <!-- TEXTO OCULTO PARA PREVIEW -->
    <div style="display: none; font-size: 1px; color: #fefefe; line-height: 1px; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden;">
        {{ $campaign->preview_text ?? 'Ver este email en tu navegador' }}
        &#847;&zwnj;&nbsp;&#847;&zwnj;&nbsp;&#847;&zwnj;&nbsp;&#847;&zwnj;&nbsp;&#847;&zwnj;&nbsp;&#847;&zwnj;&nbsp;&#847;&zwnj;&nbsp;&#847;&zwnj;&nbsp;&#847;&zwnj;&nbsp;&#847;&zwnj;&nbsp;&#847;&zwnj;&nbsp;&#847;&zwnj;&nbsp;&#847;&zwnj;&nbsp;&#847;&zwnj;&nbsp;
    </div>
</body>
</html>
