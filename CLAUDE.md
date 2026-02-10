# Instrucciones para Claude Code

## Idioma y Estilo

- **Responde SIEMPRE en español rioplatense argentino**
- Usá voseo (vos, tenés, podés, sos, etc.)
- Sé directo, claro y profesional
- No uses lenguaje corporativo innecesario

## Sobre el Proyecto

### Descripción

Plataforma web para conectar **fotógrafos** y **cosplayers** en Argentina.

- Los fotógrafos suben álbumes de eventos con links de Google Drive
- Los cosplayers suben fotos individuales a su galería personal
- Ambos tienen portfolios públicos accesibles vía `/@username`

### Stack Tecnológico

- **Backend:** PHP 8.1, Laravel 8.83
- **Frontend:** Blade templates, Tailwind CSS 3.1, Alpine.js
- **Base de datos:** PostgreSQL (producción), MySQL (local)
- **Hosting:** Railway (con PostgreSQL incluido)
- **Assets:** Laravel Mix, Vite
- **File uploads:** FilePond (multi-upload), Storage local

### Estructura de Roles

- **Fotógrafo:** Crea álbumes con thumbnails, links de Drive, fecha/ubicación del evento
- **Cosplayer:** Sube fotos individuales con descripción opcional

## Arquitectura

### Modelos Principales

- `User` → roles: 'fotografo' o 'cosplayer'
- `PhotographerProfile` → perfil público del fotógrafo (con colores personalizables)
- `CosplayerProfile` → perfil público del cosplayer (con colores personalizables)
- `Album` → álbumes de fotógrafos (con thumbnail, drive_url, y featured_photo_urls)
- `Photo` → fotos individuales de cosplayers (con is_public)
- `Favorite` → sistema de favoritos (relación User-Album)

### Rutas Públicas Importantes

- `/` → Landing page
- `/@{username}` → Portfolio público (dinámico según rol)
- `/fotografos` → Listado de fotógrafos
- `/albumes` → Álbumes públicos recientes

### Controllers Clave

**Fotógrafos:**
- `Fotografo/AlbumController` → CRUD álbumes
- `Fotografo/ProfileController` → Editar perfil fotógrafo
- `Fotografo/FeaturedPhotosController` → Gestión de fotos destacadas por álbum

**Cosplayers:**
- `Cosplayer/MisFotosController` → Upload/gestión de fotos
- `Cosplayer/CosplayerProfileController` → Editar perfil + visibilidad de fotos
- `Cosplayer/FavoriteController` → Sistema de favoritos (AJAX)

**Públicos:**
- `Public/PortfolioController` → Portfolios públicos dinámicos `/@username`
- `Public/AlbumPublicController` → Listado álbumes con búsqueda avanzada
- `HomeController` → Landing page con stats

## Convenciones del Proyecto

### Código

- Nombres de rutas: `snake_case` (ej: `fotografo.albums.index`)
- Nombres de variables: `camelCase` en PHP, `snake_case` en BD
- Vistas Blade: `kebab-case` (ej: `mis-fotos.blade.php`)
- Clases CSS custom: usar las del archivo `resources/css/app.css`

### Base de Datos

- Migraciones descriptivas: `YYYY_MM_DD_HHMMSS_accion_tabla.php`
- Relaciones: usar `foreignId()->constrained()->cascadeOnDelete()`
- Campos de fechas: usar `timestamp` o `date` según corresponda

### Validaciones

- Mensajes en español
- Usar arrays para reglas de validación
- Separar mensajes custom con segundo parámetro

### Archivos

- Thumbnails de álbumes: `storage/app/public/albums/`
- Fotos de cosplayers: `storage/app/public/cosplayer-photos/`
- Assets compilados: `public/build/`

## Features Completadas ✅

### Core del Sistema
1. Sistema de autenticación con Breeze (roles separados: fotógrafo/cosplayer)
2. CRUD de álbumes para fotógrafos (con thumbnails y links de Drive)
3. Multi-upload de fotos con FilePond para cosplayers
4. Portfolios públicos dinámicos (`/@username`)
5. Landing page profesional con stats en vivo
6. Deploy en Railway con PostgreSQL
7. Fix TrustProxies para HTTPS en Railway

### Perfiles y Personalización
8. Sistema de perfiles públicos para fotógrafos y cosplayers
9. **Perfil de cosplayer editable** (formulario completo con datos, redes y selector de fotos públicas)
10. **Customización de colores del portfolio** (color picker con preview en vivo + variables CSS dinámicas)

### Features Avanzadas
11. **Fotos destacadas** (hasta 5 fotos destacadas por álbum con preview)
12. **Búsqueda avanzada** (filtros por evento, fecha, ubicación, texto + ordenamiento)
13. **Sistema de favoritos** (cosplayers pueden guardar álbumes con corazón animado)

### UI/UX
14. Refactorización CSS (clases custom en `app.css`)
15. Alpine.js para interactividad (toggle filters, color pickers, AJAX favoritos)
16. Paginación en listados públicos
17. Validaciones en español con mensajes custom

## Pendiente de Implementar 🚧

### Backlog largo plazo
1. **Google Drive API con cuenta del propietario** (actualmente son links manuales que ingresan los fotógrafos)
2. **Sistema de suscripciones/pagos** (Mercado Pago o Stripe para planes premium)
3. **Notificaciones** (alertas cuando un fotógrafo sube álbum de evento específico)

## Próximo a Realizar 🗓️

### Quick Wins (empezar por acá, bajo esfuerzo)
| # | Feature | Detalle |
|---|---|---|
| QW1 | **Botón "Copiar URL del portfolio"** | En el dashboard de ambos roles. JS puro, sin tocar BD |
| QW2 | **Ícono de Google Drive + validación del link** | Mostrar ícono de Drive en álbumes, validar que el link sea realmente de Drive |
| QW3 | **Skeleton loading en galerías** | Placeholder animado mientras cargan imágenes en portfolios |
| QW4 | **Reordenar fotos del cosplayer** | Drag & drop para cambiar el orden de la galería personal |

### Alta Prioridad (impacto directo en calidad del producto)
| # | Feature | Detalle |
|---|---|---|
| AP1 | **Foto de perfil / avatar** | Upload de imagen para reemplazar la inicial del nombre. Requiere migración + storage |
| AP2 | **Foto de portada en portfolio** | Imagen de banner en el hero section (además del gradiente). Requiere migración + storage |
| AP3 | **SEO / Open Graph meta tags** | Preview al compartir `/@username` en redes sociales. Solo vistas, sin tocar BD |
| AP4 | **Sistema de contacto** | Botón "Contactar" en portfolios que envía un email sin exponer datos. Requiere config de mail |

### Nice to Have
| # | Feature | Detalle |
|---|---|---|
| NH1 | **Compartir álbum individual** | Botón para copiar/compartir link directo de un álbum específico |
| NH2 | **Modo oscuro** | Toggle en la UI que afecta todo el CSS. Persistido con Alpine + localStorage |

### Orden sugerido de implementación
1. QW1 → QW2 → QW3 (los más simples, no tocan BD)
2. QW4 (drag & drop, requiere JS)
3. AP3 (SEO, solo vistas)
4. AP1 + AP2 juntos (comparten lógica de upload de imágenes)
5. AP4 (contacto, requiere configurar mail)
6. NH1 (muy simple)
7. NH2 (modo oscuro, el más complejo por impacto en CSS global)

## Comandos Útiles

### Desarrollo

```bash
php artisan serve                 # Servidor local
php artisan migrate               # Ejecutar migraciones
php artisan migrate:fresh --seed  # Reset BD con datos de prueba
php artisan storage:link          # Link simbólico storage
npm run dev                       # Compilar assets en desarrollo
npm run build                     # Compilar para producción
```

### Railway

```bash
git push origin master            # Deploy automático a Railway
```

## Notas Importantes

- **NO uses `cosplayer.photos.*`**, las rutas son `cosplayer.fotos.*`
- Las thumbnails se guardan en `storage/app/public/albums/`
- Los portfolios detectan automáticamente el rol del usuario
- El `AppServiceProvider` fuerza HTTPS en producción
- Railway usa PostgreSQL, local usa MySQL (ajustar conexión según ambiente)

## Para Tareas Comunes

### Crear un nuevo controller

```bash
php artisan make:controller Namespace/NombreController
```

### Crear una migración

```bash
php artisan make:migration nombre_descriptivo_de_la_accion
```

### Crear un modelo con migración

```bash
php artisan make:model NombreModelo -m
```

### Limpiar caché

```bash
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

---

## Historial de Actualizaciones

**2026-02-09:** Auditoría completa del codebase. Se movieron 5 features de "Pendiente" a "Completadas":
- Perfil de cosplayer editable (vista completa con 410 líneas)
- Customización de colores del portfolio (con color picker y preview)
- Fotos destacadas (hasta 5 por álbum)
- Búsqueda avanzada (filtros múltiples + ordenamiento)
- Sistema de favoritos (AJAX con corazón animado)

Total features implementadas: **17/20** (85% del roadmap original completado)

**2026-02-09 (sesión de fixes):**

*Fixes realizados:*
- **Bug crítico `layouts/app.blade.php`**: faltaba `@stack('styles')` en el `<head>`. Las vistas que usan `@push('styles')` (como los portfolios) no inyectaban sus estilos CSS. Efecto: el texto blanco del hero section era invisible al no tener el gradiente de fondo. También se movió `@stack('scripts')` al final del `<body>` donde corresponde.
- **Bug layout `cosplayer/perfil/edit.blade.php`**: la sección "Personalización de colores" estaba anidada dentro de la card de "Redes sociales". Se la movió como card independiente fuera del grid de 2 columnas.
- **Fix UX botones de acción**: los botones "Volver al Dashboard" y "Guardar cambios" tenían una card completa que ocupaba mucho espacio. Se reemplazó por un `flex` compacto con `pt-4`.
- **Fix portfolio cosplayer**: datos del perfil (ubicación, redes sociales) no se mostraban. La causa raíz era el bug del `@stack('styles')` mencionado arriba.
- **CLAUDE.md actualizado**: se corrigió el listado de features completadas vs pendientes.

---

**Fin de instrucciones. Cualquier duda, preguntá en español rioplatense.**
