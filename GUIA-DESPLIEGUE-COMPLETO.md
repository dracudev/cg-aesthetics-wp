# Guía Completa de Despliegue - CG Aesthetics

**Fecha**: 18 de noviembre de 2025  
**Arquitectura**: WordPress (Hostinger) + Astro (Netlify)  
**Tiempo estimado**: 45-60 minutos

---

## 📋 Requisitos Previos

- ✅ Cuenta Hostinger activa
- ✅ Cuenta Netlify activa
- ✅ Dominio: `carmeng-beauty.com` (comprado en Hostinger)
- ✅ Backup: `wordpress-content-20251112.zip`
- ✅ Backup: `database-20251112-210921.sql`
- ✅ Repositorio Git local limpio

---

## 🎯 Arquitectura Final

```
Frontend (Astro):
├─ URL: https://carmeng-beauty.com
├─ URL: https://www.carmeng-beauty.com (redirect a carmeng-beauty.com)
└─ Hosting: Netlify

Backend (WordPress):
├─ URL: https://admin.carmeng-beauty.com
├─ Hosting: Hostinger
└─ Base de datos: MySQL en Hostinger
```

---

## PARTE 1: PREPARAR REPOSITORIO LOCAL

### 1.1 Resetear al commit anterior al despliegue roto

```bash
cd /home/dracudev/dev/cg-aesthetics-wp

# Ver commits recientes
git log --oneline -10

# Identificar el commit del 12 de noviembre (antes del despliegue)
# Ejemplo: 80b5a32 feat: add booking hero image support

# Resetear a ese commit (CUIDADO: perderás cambios no commiteados)
git reset --hard 80b5a32

# Crear backup del estado actual por si acaso
git branch backup-antes-reset

# Verificar que estás en el commit correcto
git log -1
```

### 1.2 Verificar archivos críticos

```bash
# Verificar functions.php está limpio
cat wordpress/wp-content/themes/cg-aesthetics-headless/functions.php | head -50

# Verificar frontend .env
cat frontend/.env
```

**El `.env` debe tener:**

```env
PUBLIC_WORDPRESS_URL=http://localhost:8000
PUBLIC_GRAPHQL_ENDPOINT=https://admin.carmeng-beauty.com/graphql
```

---

## PARTE 2: CONFIGURAR HOSTINGER - BACKEND WORDPRESS

### 2.1 Eliminar sitio actual (si existe)

1. **hPanel → Websites**
2. Busca `admin.carmeng-beauty.com`
3. Click en **⋮ (tres puntos)** → **Delete website**
4. Confirma eliminación

### 2.2 Eliminar subdominio actual

1. **hPanel → Dominios → carmeng-beauty.com**
2. **Subdominios**
3. Busca `admin.carmeng-beauty.com`
4. **Eliminar** o **Delete**

### 2.3 Crear nueva instalación WordPress

1. **hPanel → Websites → "Add Website"**
2. Selecciona **"WordPress"**
3. Configuración:
   - **Domain**: Selecciona "Create subdomain"
   - **Subdomain**: `admin`
   - **Domain**: `carmeng-beauty.com`
   - **Website title**: "CG Aesthetics Admin"
   - **Admin username**: `admin` (o tu usuario)
   - **Admin password**: [tu contraseña segura]
   - **Admin email**: tu email
4. Click **"Install"**
5. **Espera 2-3 minutos** a que termine la instalación

### 2.4 Verificar instalación

```bash
curl -I https://admin.carmeng-beauty.com/wp-admin/
```

Deberías ver: `HTTP/2 302` (redirect a login) ✅

### 2.5 Configurar wp-config.php

1. **File Manager → public_html/** (del sitio admin.carmeng-beauty.com)
2. Edita **wp-config.php**
3. **ANTES de la línea** `/* That's all, stop editing! */` añade:

```php
// Force correct URLs
define('WP_HOME', 'https://admin.carmeng-beauty.com');
define('WP_SITEURL', 'https://admin.carmeng-beauty.com');

// Enable debug (temporal)
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);

// Memory limit
define('WP_MEMORY_LIMIT', '256M');
```

4. **Guarda** el archivo

---

## PARTE 3: SUBIR CONTENIDO PERSONALIZADO

### 3.1 Extraer backup localmente

```bash
cd /home/dracudev/dev/cg-aesthetics-wp/backups

# Extraer en carpeta temporal
unzip wordpress-content-20251112.zip -d temp-restore/
```

### 3.2 Subir tema personalizado

**Via File Manager de Hostinger:**

1. Navega a: `public_html/wp-content/themes/`
2. **Borra** la carpeta `twentytwentyfour` (o cualquier tema por defecto)
3. **Crea carpeta**: `cg-aesthetics-headless`
4. **Entra** en esa carpeta
5. **Upload** todos los archivos de:
   ```
   temp-restore/wp-content/themes/cg-aesthetics-headless/*
   ```

**Archivos críticos a subir:**

- `functions.php` ⚠️ (versión limpia del backup)
- `style.css`
- Toda la estructura de carpetas del tema

### 3.3 Subir plugins

**En `public_html/wp-content/plugins/`** sube estas carpetas:

```
temp-restore/wp-content/plugins/advanced-custom-fields/
temp-restore/wp-content/plugins/wp-graphql/
temp-restore/wp-content/plugins/ameliabooking/ (opcional)
temp-restore/wp-content/plugins/wordpress-seo/ (opcional)
```

### 3.4 Subir uploads (imágenes)

**En `public_html/wp-content/`** sube:

```
temp-restore/wp-content/uploads/
```

Esto incluye todas las imágenes de servicios, hero images, etc.

---

## PARTE 4: RESTAURAR BASE DE DATOS

### 4.1 Acceder a phpMyAdmin

1. **hPanel → Databases → phpMyAdmin**
2. **Login** con tus credenciales de Hostinger
3. En el panel izquierdo, selecciona tu base de datos (algo como `u641806196_wp123`)

### 4.2 Vaciar tablas actuales

1. Click en tu base de datos (panel izquierdo)
2. Click **"Structure"** tab
3. Scroll abajo → **"Check All"** (selecciona todas las tablas)
4. En el dropdown "With selected:" → **"Drop"** o **"Empty"**
5. **Confirma** (esto borra todas las tablas)

### 4.3 Importar backup

1. Click **"Import"** tab
2. **"Choose File"** → Selecciona `database-20251112-210921.sql`
3. **Format**: SQL
4. Scroll abajo → **"Import"**
5. **Espera** (puede tardar 1-2 minutos)
6. Deberías ver: "Import has been successfully finished"

### 4.4 Actualizar URLs en la base de datos

En phpMyAdmin, click **"SQL"** tab y ejecuta:

```sql
-- Actualizar URLs del sitio
UPDATE wp_options
SET option_value = 'https://admin.carmeng-beauty.com'
WHERE option_name IN ('siteurl', 'home');

-- Actualizar URLs en posts (si habían referencias a localhost)
UPDATE wp_posts
SET guid = REPLACE(guid, 'http://localhost:8000', 'https://admin.carmeng-beauty.com')
WHERE guid LIKE '%localhost:8000%';

UPDATE wp_posts
SET post_content = REPLACE(post_content, 'http://localhost:8000', 'https://admin.carmeng-beauty.com')
WHERE post_content LIKE '%localhost:8000%';

-- Actualizar URLs en metadatos
UPDATE wp_postmeta
SET meta_value = REPLACE(meta_value, 'http://localhost:8000', 'https://admin.carmeng-beauty.com')
WHERE meta_value LIKE '%localhost:8000%';
```

Click **"Go"** para ejecutar.

---

## PARTE 5: CONFIGURAR WORDPRESS

### 5.1 Login y activar tema

1. Ve a: `https://admin.carmeng-beauty.com/wp-admin/`
2. **Login** con las credenciales que pusiste en la instalación
3. **Appearance → Themes**
4. Activa: **"CG Aesthetics Headless"**

### 5.2 Activar plugins necesarios

**Plugins → Installed Plugins** - Activa estos (en orden):

1. ✅ **Advanced Custom Fields** (ACF)
2. ✅ **WPGraphQL**
3. ✅ **Yoast SEO** (si lo subiste)
4. ✅ **Amelia Booking** (si lo subiste)

**Desactiva/borra** cualquier plugin que no necesites (Akismet, Hello Dolly, etc.)

### 5.3 Configurar permalinks

1. **Settings → Permalinks**
2. Selecciona: **"Post name"** (debería estar seleccionado ya)
3. Click **"Save Changes"**

Esto regenera las reglas de rewrite.

### 5.4 Configurar CORS para GraphQL

**Appearance → Theme File Editor** (o edita via File Manager):

Abre `functions.php` y **AL FINAL** añade:

```php
/**
 * CORS Headers for headless frontend
 */
add_action('init', function() {
    $allowed_origins = [
        'https://carmeng-beauty.com',
        'https://www.carmeng-beauty.com',
        'https://cg-aesthetics-wp.netlify.app' // Netlify subdomain
    ];

    $origin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '';

    if (in_array($origin, $allowed_origins)) {
        header("Access-Control-Allow-Origin: $origin");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Authorization');
    }

    // Handle preflight requests
    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        status_header(200);
        exit;
    }
});
```

**Guarda** el archivo.

### 5.5 Verificar GraphQL funciona

```bash
curl -X POST https://admin.carmeng-beauty.com/graphql \
  -H "Content-Type: application/json" \
  -d '{"query":"{ __typename }"}'
```

**Respuesta esperada:**

```json
{ "data": { "__typename": "RootQuery" } }
```

Si ves esto: ✅ **GraphQL funciona!**

Si está vacío: ⚠️ **Problema** - revisa que WPGraphQL esté activo.

---

## PARTE 6: CONFIGURAR DNS EN HOSTINGER

### 6.1 Verificar DNS actual

**hPanel → Dominios → carmeng-beauty.com → DNS Manager**

Deberías tener estos registros:

```
Tipo    Nombre    Contenido                      TTL
A       @         75.2.60.5 (Netlify)            3600
A       admin     92.113.28.147 (Hostinger)      1800
CNAME   www       cg-aesthetics-wp.netlify.app   3600
```

### 6.2 Si faltan, añade:

**Registro para backend (admin subdomain):**

```
Tipo: A
Nombre: admin
Apunta a: 92.113.28.147
TTL: 1800
```

**Registro para frontend (dominio principal):**

```
Tipo: A
Nombre: @
Apunta a: 75.2.60.5
TTL: 3600
```

**Registro para www:**

```
Tipo: CNAME
Nombre: www
Apunta a: cg-aesthetics-wp.netlify.app
TTL: 3600
```

### 6.3 Esperar propagación

DNS puede tardar 5-30 minutos en propagar. Prueba:

```bash
# Verificar admin subdomain
curl -I https://admin.carmeng-beauty.com/

# Debería devolver HTTP/2 302 o 200
```

---

## PARTE 7: CONFIGURAR NETLIFY - FRONTEND

### 7.1 Conectar repositorio a Netlify (si no está)

1. **Netlify Dashboard → Sites → "Add new site"**
2. **Import an existing project → GitHub**
3. Selecciona: `dracudev/serenity-spa-wp`
4. **Branch to deploy**: `master`

### 7.2 Configurar build settings

```yaml
Base directory: frontend
Build command: pnpm build
Publish directory: frontend/dist
```

### 7.3 Configurar variables de entorno

**Site settings → Environment variables → Add a variable**

Añade estas variables:

```bash
PUBLIC_GRAPHQL_ENDPOINT=https://admin.carmeng-beauty.com/graphql
PUBLIC_WORDPRESS_URL=https://admin.carmeng-beauty.com
PUBLIC_SITE_URL=https://carmeng-beauty.com
RESEND_API_KEY=re_bqJpBuvw_AM1fzGvudZ6nTQb27MAcC4AR
```

### 7.4 Configurar dominio personalizado

**Site settings → Domain management → Add custom domain**

1. Añade: `carmeng-beauty.com`
2. Netlify detectará que el DNS ya está configurado
3. Click **"Verify DNS configuration"**
4. **Enable HTTPS** (Netlify genera certificado SSL automáticamente)

5. Añade también: `www.carmeng-beauty.com`
6. Configura como **"Redirect to primary domain"**

### 7.5 Deploy inicial

**Deploys → Trigger deploy → Deploy site**

Espera 2-3 minutos a que compile.

### 7.6 Verificar build

**Revisa el log de Netlify**. Debería ver:

```
✓ built in XXs
✓ Completed in XXs

Site is live at carmeng-beauty.com ✅
```

Si ves errores de GraphQL:

- Verifica que las variables de entorno estén bien
- Verifica que `admin.carmeng-beauty.com/graphql` responda

---

## PARTE 8: VERIFICACIÓN FINAL

### 8.1 Test Backend (WordPress)

```bash
# Admin funciona
curl -I https://admin.carmeng-beauty.com/wp-admin/
# → HTTP/2 302 ✅

# GraphQL funciona
curl -X POST https://admin.carmeng-beauty.com/graphql \
  -H "Content-Type: application/json" \
  -d '{"query":"{ services { nodes { title } } }"}'
# → {"data":{"services":{"nodes":[...]}}} ✅

# REST API funciona
curl -s https://admin.carmeng-beauty.com/wp-json/
# → JSON con info de WordPress ✅
```

### 8.2 Test Frontend (Netlify)

```bash
# Sitio principal carga
curl -I https://carmeng-beauty.com/
# → HTTP/2 200 ✅

# www redirect funciona
curl -I https://www.carmeng-beauty.com/
# → HTTP/2 301 (redirect a carmeng-beauty.com) ✅

# Páginas dinámicas existen
curl -I https://carmeng-beauty.com/services/
# → HTTP/2 200 ✅
```

### 8.3 Test Manual en Navegador

**Backend:**

1. ✅ `https://admin.carmeng-beauty.com/wp-admin/` → Login funciona
2. ✅ Puedes editar servicios
3. ✅ Puedes subir imágenes
4. ✅ ACF fields visible en servicios

**Frontend:**

1. ✅ `https://carmeng-beauty.com/` → Home page carga
2. ✅ Navbar funciona
3. ✅ `/services/` → Lista de servicios carga
4. ✅ `/services/[slug]/` → Página de servicio individual carga
5. ✅ Imágenes se ven correctamente
6. ✅ `/reserver/` → Página de reserva (Amelia)

### 8.4 Test GraphQL desde Frontend

Abre consola del navegador en `carmeng-beauty.com`:

```javascript
fetch('https://admin.carmeng-beauty.com/graphql', {
  method: 'POST',
  headers: { 'Content-Type': 'application/json' },
  body: JSON.stringify({ query: '{ services { nodes { title } } }' }),
})
  .then((r) => r.json())
  .then((d) => console.log(d));
```

Debería mostrar los servicios. ✅

---

## PARTE 9: LIMPIEZA Y OPTIMIZACIÓN

### 9.1 Desactivar debug en producción

Edita `wp-config.php`:

```php
define('WP_DEBUG', false);
define('WP_DEBUG_LOG', false);
define('WP_DEBUG_DISPLAY', false);
```

### 9.2 Configurar cache (opcional)

Si reactivaste LiteSpeed Cache:

1. **LiteSpeed Cache → Cache → Excludes**
2. **"Do Not Cache URIs"** → Añade:
   ```
   /wp-json/
   /graphql
   /wp-admin/
   ```
3. **Save**
4. **LiteSpeed Cache → Purge → Purge All**

### 9.3 Backup automático en Hostinger

**hPanel → Backups**

- Verifica que backups automáticos estén activos
- Se recomienda: backup semanal

### 9.4 Commit y push cambios

```bash
cd /home/dracudev/dev/cg-aesthetics-wp

# Añadir archivos modificados (si los hay)
git add .

# Commit
git commit -m "chore: successful production deployment"

# Push
git push origin master
```

---

## 🚨 TROUBLESHOOTING

### GraphQL devuelve vacío

1. Verifica WPGraphQL está activo: **Plugins → Installed Plugins**
2. Regenera permalinks: **Settings → Permalinks → Save**
3. Verifica `.htaccess` tiene reglas de WordPress
4. Desactiva LiteSpeed Cache temporalmente

### Netlify build falla

1. Verifica variables de entorno están configuradas
2. Verifica `PUBLIC_GRAPHQL_ENDPOINT` es correcto
3. Revisa build log completo en Netlify
4. Test GraphQL endpoint manualmente con curl

### Imágenes no cargan

1. Verifica carpeta `uploads/` se subió correctamente
2. Permisos: `chmod 755` en `wp-content/uploads/`
3. Verifica URLs en base de datos apuntan a `admin.carmeng-beauty.com`

### "Cannot read properties of undefined"

- Frontend está intentando leer datos que no existen
- Verifica servicios existen en WordPress admin
- Verifica ACF fields están configurados
- Añade checks defensivos en código Astro

### Admin redirect loop

1. Edita `wp-config.php` y añade:
   ```php
   define('WP_HOME', 'https://admin.carmeng-beauty.com');
   define('WP_SITEURL', 'https://admin.carmeng-beauty.com');
   ```
2. Vacía cache del navegador
3. Prueba en ventana privada

---

## 📝 CHECKLIST FINAL

### Backend (WordPress)

- [ ] WordPress instalado en `admin.carmeng-beauty.com`
- [ ] Tema `cg-aesthetics-headless` activo
- [ ] Plugins ACF y WPGraphQL activos
- [ ] Base de datos restaurada
- [ ] URLs actualizadas en DB
- [ ] Permalinks configurados
- [ ] CORS configurado en functions.php
- [ ] GraphQL responde correctamente
- [ ] Puedes editar servicios sin errores
- [ ] Puedes subir imágenes

### Frontend (Netlify)

- [ ] Repositorio conectado
- [ ] Variables de entorno configuradas
- [ ] Build exitoso
- [ ] Dominio `carmeng-beauty.com` conectado
- [ ] SSL activo (HTTPS)
- [ ] `www` redirect configurado
- [ ] Todas las páginas cargan
- [ ] Imágenes se ven
- [ ] GraphQL queries funcionan

### DNS

- [ ] `admin.carmeng-beauty.com` → Hostinger (A record)
- [ ] `carmeng-beauty.com` → Netlify (A record)
- [ ] `www.carmeng-beauty.com` → Netlify (CNAME)
- [ ] DNS propagado (test con curl)

### Seguridad

- [ ] Debug desactivado en producción
- [ ] Contraseñas seguras en WP
- [ ] SSL activo en ambos dominios
- [ ] `wp-config.php` no tiene credenciales expuestas

---

## 🎉 LISTO

Si todos los checks están ✅, tu sitio está funcionando correctamente en producción.

**URLs finales:**

- Frontend: https://carmeng-beauty.com
- Backend: https://admin.carmeng-beauty.com/wp-admin/
- GraphQL: https://admin.carmeng-beauty.com/graphql

---

## 📞 Soporte

**Hostinger Support**: https://www.hostinger.com/contact  
**Netlify Docs**: https://docs.netlify.com  
**WPGraphQL Docs**: https://www.wpgraphql.com/docs

**Última actualización**: 18 de noviembre de 2025
