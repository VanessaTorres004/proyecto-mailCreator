<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>{{ $campaign->title }}</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <style>
    body {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      margin: 0;
      padding: 20px;
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
      min-height: 100vh;
    }

    .preview-container {
      max-width: 1200px;
      margin: 0 auto;
      background: rgba(255,255,255,0.95);
      border-radius: 16px;
      border: 1px solid rgba(255,255,255,0.3);
      box-shadow: 0 20px 40px rgba(0,0,0,0.1), 0 10px 20px rgba(0,0,0,0.05), inset 0 1px 0 rgba(255,255,255,0.9);
      overflow: hidden;
      animation: fadeInUp 0.6s ease-out;
    }

    /* Sistema de pestañas */
    .tabs-container {
      background: rgba(255,255,255,0.9);
      border-bottom: 1px solid rgba(0,0,0,0.1);
      backdrop-filter: blur(10px);
    }

    .tabs-nav {
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 0 20px;
      gap: 8px;
    }

    .tab-button {
      background: transparent;
      border: none;
      padding: 16px 24px;
      font-size: 15px;
      font-weight: 500;
      color: #666;
      cursor: pointer;
      border-radius: 8px 8px 0 0;
      transition: all 0.3s ease;
      position: relative;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .tab-button:hover {
      background: rgba(102, 126, 234, 0.1);
      color: #667eea;
    }

    .tab-button.active {
      background: white;
      color: #667eea;
      box-shadow: 0 -2px 8px rgba(0,0,0,0.1);
    }

    .tab-button.active::after {
      content: '';
      position: absolute;
      bottom: -1px;
      left: 0;
      right: 0;
      height: 2px;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .tab-icon {
      width: 18px;
      height: 18px;
      opacity: 0.7;
      transition: opacity 0.3s ease;
    }

    .tab-button.active .tab-icon {
      opacity: 1;
    }

    /* Contenido de pestañas */
    .tab-content {
      display: none;
      padding: 0;
    }

    .tab-content.active {
      display: block;
      animation: fadeIn 0.4s ease-out;
    }

    /* Vista comparación */
    .comparison-view {
      display: flex;
      gap: 20px;
      padding: 20px;
      justify-content: center;
      flex-wrap: wrap;
    }

    .single-view {
      display: flex;
      justify-content: center;
      padding: 20px;
    }

    .email-preview {
      background: white;
      border-radius: 12px;
      border: 1px solid rgba(0,0,0,0.1);
      box-shadow: 0 8px 25px rgba(0,0,0,0.1);
      overflow: hidden;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .email-preview:hover {
      transform: translateY(-2px);
      box-shadow: 0 12px 35px rgba(0,0,0,0.15);
    }

    .desktop-preview { 
      width: 680px; 
      
    }
    
    .mobile-preview { 
      width: 400px; 
      
    }

    .single-desktop { 
      width: 700px; 
      min-height:max-content;
    }

    .single-mobile { 
      width: 400px; 
      min-height:500px ;
    }

    .preview-label {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      text-align: center;
      font-size: 14px;
      font-weight: 600;
      padding: 12px;
      margin: 0;
      letter-spacing: 0.5px;
      text-transform: uppercase;
    }

    iframe {
      border: none;
      width: 100%;
      display: block;
      min-height: 500px;
      max-height: 800px;
    }

    /* Animaciones */
    @keyframes fadeInUp {
      from { opacity: 0; transform: translateY(30px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }

    /* Responsive */
    @media only screen and (max-width: 768px) {
      .tabs-nav {
        padding: 0 10px;
        gap: 4px;
      }
      
      .tab-button {
        padding: 12px 16px;
        font-size: 14px;
      }
      
      .comparison-view {
        flex-direction: column;
        align-items: center;
        padding: 15px;
      }
      
      .desktop-preview,
      .mobile-preview,
      .single-desktop,
      .single-mobile {
        width: 100%;
        max-width: 400px;
      }
    }
  </style>
</head>
<body>
  <div class="preview-container">
    <!-- Navegación de pestañas -->
    <div class="tabs-container">
      <nav class="tabs-nav">
        <button class="tab-button active" data-tab="comparison">
          <svg class="tab-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <rect x="3" y="4" width="7" height="16" rx="1"/>
            <rect x="14" y="4" width="7" height="16" rx="1"/>
          </svg>
          Comparación
        </button>
        <button class="tab-button" data-tab="desktop">
          <svg class="tab-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <rect x="2" y="3" width="20" height="14" rx="2" ry="2"/>
            <line x1="8" y1="21" x2="16" y2="21"/>
            <line x1="12" y1="17" x2="12" y2="21"/>
          </svg>
          Desktop
        </button>
        <button class="tab-button" data-tab="mobile">
          <svg class="tab-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <rect x="5" y="2" width="14" height="20" rx="2" ry="2"/>
            <line x1="12" y1="18" x2="12.01" y2="18"/>
          </svg>
          Móvil
        </button>
      </nav>
    </div>

    <!-- Contenido de pestañas -->
    
    <!-- Vista comparación -->
    <div class="tab-content active" id="tab-comparison">
      <div class="comparison-view">
        <div class="email-preview desktop-preview">
          <h3 class="preview-label">Desktop (680px)</h3>
          <iframe id="iframe-desktop-comp"></iframe>
        </div>
        
        <div class="email-preview mobile-preview">
          <h3 class="preview-label">Móvil (400px)</h3>
          <iframe id="iframe-mobile-comp"></iframe>
        </div>
      </div>
    </div>

    <!-- Vista solo desktop -->
    <div class="tab-content" id="tab-desktop">
      <div class="single-view">
        <div class="email-preview single-desktop">
          <h3 class="preview-label"></h3>
          <iframe id="iframe-desktop-single"></iframe>
        </div>
      </div>
    </div>

    <!-- Vista solo móvil -->
    <div class="tab-content" id="tab-mobile">
      <div class="single-view">
        <div class="email-preview single-mobile">
          <h3 class="preview-label"></h3>
          <iframe id="iframe-mobile-single"></iframe>
        </div>
      </div>
    </div>

  </div>

  @php
    // Función que construye el HTML del email (header, bloques, footer)
    function buildIframeContent($campaign, $blocks, $isMobile = false) {
        $width = $isMobile ? 400 : 680;

        $html = '<!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <style>
                body {
                    margin: 0;
                    padding: 0;
                    font-family: Arial, sans-serif;
                    background-color: '.$campaign->background.';
                    ' . ($isMobile ? 'max-width:'.$width.'px;margin:0 auto;' : '') . '
                }
                img {
                    max-width: 100%;
                    height: auto;
                    display: block;
                }
                table {
                    border-collapse: collapse;
                    width: 100%;
                }
            </style>
        </head>
        <body>';

        // Header
        if (!empty($campaign->header_template) && $campaign->header_template !== '0') {
            try {
                $html .= view('components.headers.' . $campaign->header_template, [
                    'campaign' => $campaign,
                    'blocks'   => $blocks,
                    'isMobile' => $isMobile
                ])->render();
            } catch (\Exception $e) {
                $html .= '<!-- Error header: '.$e->getMessage().' -->';
            }
        }

        // Bloques con tabla (para evitar espacios raros en Outlook y otros)
        $html .= '<table role="presentation" width="100%" height=100% cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td style="padding:5px 10px;">';

        if (!empty($blocks)) {
            $count = count($blocks);
            foreach ($blocks as $i => $b) {
                $html .= $b["html"] ?? "";

                // Agregar un separador solo entre bloques (no después del último)
                if ($i < $count - 1) {
                    $html .= '<table role="presentation" width="100%">
                                <tr><td style="height:0px;font-size:0;line-height:0;"></td></tr>
                              </table>';
                }
            }
        } else {
            $html .= '<p style="text-align:center;color:#888;padding:0px;">No hay bloques</p>';
        }

        $html .= '</td></tr></table>';

        // Footer
        if (!empty($campaign->footer_template) && $campaign->footer_template !== '0') {
            try {
                $html .= view('components.footers.' . $campaign->footer_template, [
                    'campaign' => $campaign,
                    'blocks'   => $blocks,
                    'isMobile' => $isMobile
                ])->render();
            } catch (\Exception $e) {
                $html .= '<!-- Error footer: '.$e->getMessage().' -->';
            }
        }

        $html .= '</body></html>';

        return $html;
    }

    // Generar contenido para ambas vistas
    try {
        $iframeHtmlDesktop = buildIframeContent($campaign, $blocks ?? [], false);
        $iframeHtmlMobile  = buildIframeContent($campaign, $blocks ?? [], true);
    } catch (Exception $e) {
        $iframeHtmlDesktop = '<html><body><p style="text-align:center;color:#d32f2f;padding:40px;">Error: ' . $e->getMessage() . '</p></body></html>';
        $iframeHtmlMobile  = $iframeHtmlDesktop;
    }
  @endphp

  <script>
    // Sistema de pestañas
    document.addEventListener('DOMContentLoaded', function() {
        const tabButtons = document.querySelectorAll('.tab-button');
        const tabContents = document.querySelectorAll('.tab-content');

        // Manejar clicks en pestañas
        tabButtons.forEach(button => {
            button.addEventListener('click', () => {
                const targetTab = button.getAttribute('data-tab');
                
                // Remover clase active de todos los botones y contenidos
                tabButtons.forEach(btn => btn.classList.remove('active'));
                tabContents.forEach(content => content.classList.remove('active'));
                
                // Activar pestaña seleccionada
                button.classList.add('active');
                document.getElementById(`tab-${targetTab}`).classList.add('active');
                
                // Recargar iframes si es necesario
                reloadIframesInTab(targetTab);
            });
        });

        // Cargar contenido inicial
        loadAllIframes();
    });

    function setIframeContent(id, content) {
        const iframe = document.getElementById(id);
        if (!iframe) return;

        iframe.srcdoc = content;

        iframe.onload = function() {
            try {
                const doc = iframe.contentWindow.document;
                if (doc && doc.body) {
                    const height = Math.max(
                        doc.body.scrollHeight,
                        doc.documentElement.scrollHeight,
                        500
                    );
                    iframe.style.height = height + 'px';
                }
            } catch(e) {
                iframe.style.height = '600px';
            }
        };

        // fallback si no carga la altura
        setTimeout(() => {
            if (!iframe.style.height || iframe.style.height === '0px') {
                iframe.style.height = '600px';
            }
        }, 2000);
    }

    function loadAllIframes() {
        const desktopContent = `{!! addslashes($iframeHtmlDesktop) !!}`;
        const mobileContent = `{!! addslashes($iframeHtmlMobile) !!}`;

        // Cargar todos los iframes
        setIframeContent('iframe-desktop-comp', desktopContent);
        setIframeContent('iframe-mobile-comp', mobileContent);
        setIframeContent('iframe-desktop-single', desktopContent);
        setIframeContent('iframe-mobile-single', mobileContent);
    }

    function reloadIframesInTab(tabName) {
        // Solo recargar si el iframe está vacío o tiene problemas
        const desktopContent = `{!! addslashes($iframeHtmlDesktop) !!}`;
        const mobileContent = `{!! addslashes($iframeHtmlMobile) !!}`;

        if (tabName === 'desktop') {
            const iframe = document.getElementById('iframe-desktop-single');
            if (!iframe.srcdoc) {
                setIframeContent('iframe-desktop-single', desktopContent);
            }
        } else if (tabName === 'mobile') {
            const iframe = document.getElementById('iframe-mobile-single');
            if (!iframe.srcdoc) {
                setIframeContent('iframe-mobile-single', mobileContent);
            }
        }
    }
  </script>
</body>
</html>