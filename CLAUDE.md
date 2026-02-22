# Instrucciones para Claude Code

## Idioma y Estilo

- **Responde SIEMPRE en español rioplatense argentino**
- Usá voseo (vos, tenés, podés, sos, etc.)
- Sé directo, claro y profesional

## Sobre el Proyecto

Plataforma web para conectar **fotógrafos** y **cosplayers** en Argentina.

- Fotógrafos: suben álbumes con thumbnails y links de Google Drive
- Cosplayers: suben fotos individuales a su galería personal
- Ambos tienen portfolios públicos en `/@username`

### Stack

- **Backend:** PHP 8.1, Laravel 8.83
- **Frontend:** Blade, Tailwind CSS 3.1, Alpine.js
- **BD:** PostgreSQL (Railway), MySQL (local)
- **Assets:** Laravel Mix | **Uploads:** FilePond

## Arquitectura

### Modelos

- `User` → roles: `fotografo` | `cosplayer`
- `PhotographerProfile` / `CosplayerProfile` → perfiles con colores personalizables, avatar, cover
- `Album` → álbumes del fotógrafo (thumbnail, drive_url, featured_photo_urls JSON)
- `Photo` → fotos individuales cosplayer (sort_order, is_public)
- `Favorite` → User ↔ Album
- `ContactMessage` → mensajes de contacto (rate limiting por IP)
- `ShopItem` → ítems de venta (photos JSON, status enum)

### Rutas clave

- `/@{username}` → portfolio público dinámico
- `/fotografos` → listado fotógrafos
- `/albumes` → álbumes con búsqueda avanzada
- `/shop` → shop público
- `/mi-shop` → gestión ítems (auth, ambos roles)

### Controllers

| Namespace | Controller | Función |
|---|---|---|
| `Fotografo/` | `AlbumController` | CRUD álbumes |
| `Fotografo/` | `ProfileController` | Perfil fotógrafo |
| `Fotografo/` | `FeaturedPhotosController` | Fotos destacadas por álbum |
| `Cosplayer/` | `MisFotosController` | Upload + reorder fotos |
| `Cosplayer/` | `CosplayerProfileController` | Perfil + visibilidad fotos |
| `Cosplayer/` | `FavoriteController` | Favoritos AJAX |
| `Public/` | `PortfolioController` | Portfolios `/@username` |
| `Public/` | `AlbumPublicController` | Listado álbumes |
| `Public/` | `ShopController` | Shop público |
| `Public/` | `ContactController` | Recibir mensajes |
| `Shop/` | `ShopItemController` | CRUD mi-shop |

## Convenciones

- Rutas: `snake_case` (ej: `fotografo.albums.index`)
- Vistas Blade: `kebab-case`
- Migraciones: clase sin return type, `foreignId()->constrained()->cascadeOnDelete()`
- Flash messages: `session('status')` (no `session('success')`)
- Forms con upload: `enctype="multipart/form-data"` siempre
- Validaciones: mensajes en español, arrays de reglas

### Storage

- Álbumes: `albums/` | Cosplayer: `cosplayer-photos/` | Shop: `shop-items/`
- Avatares: `avatars/` | Portadas: `covers/`
- Patrón: `$file->store('carpeta', 'public')` / `Storage::disk('public')->delete($path)`

## Features Implementadas ✅

Auth (Breeze), CRUD álbumes, upload fotos (FilePond), portfolios públicos, landing page, Railway deploy, perfiles editables, colores personalizables, fotos destacadas, búsqueda avanzada, favoritos (AJAX), CSS refactor, paginación, botón copiar URL, Drive icon+validación, skeleton loading, reordenar fotos (SortableJS), avatar, cover, sistema de contacto (Resend API, rate limiting), dark mode, **Shop** (tabla shop_items, CRUD, FilePond, status active/sold/inactive).

## Pendiente 🚧

- **AP3**: SEO / Open Graph meta tags en `/@username` (solo vistas)
- **NH1**: Compartir álbum individual (copiar link)
- Largo plazo: Google Drive API, pagos (MercadoPago), notificaciones

## Notas Importantes

- **NO usar `cosplayer.photos.*`** → las rutas son `cosplayer.fotos.*`
- Email: API de Resend directo (`\Resend::client()`), **NO** instalar `resend/resend-laravel` (requiere L9+)
- Alpine.js: botones con `@click` necesitan estar dentro de un scope `x-data`
- `AppServiceProvider` fuerza HTTPS en producción
- Railway usa PostgreSQL, local usa MySQL

## Comandos

```bash
php artisan serve
php artisan migrate
php artisan storage:link
npm run dev / npm run build
git push origin master   # deploy Railway
```
