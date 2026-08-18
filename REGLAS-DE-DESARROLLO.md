# CANOA Nautical Sport — Reglas de Desarrollo

**Documento vinculante · Versión 1.0 · Entregable de la Fase 0.2**
Ubicación en el repositorio: `docs/REGLAS-DE-DESARROLLO.md`

---

## 0. Regla madre

Ninguna decisión contenida en este documento puede modificarse durante una fase posterior sin autorización explícita del responsable del proyecto. Si durante una fase surge la necesidad de romper una regla, se detiene el desarrollo, se plantea el caso y se decide antes de escribir código.

Toda fase que produzca código debe cumplir este documento en su totalidad. Un entregable que lo incumpla no se aprueba, aunque funcione.

---

## 1. Stack y decisiones bloqueadas

| Ámbito | Decisión |
|---|---|
| Framework | Laravel 13.x (13.26.0) |
| PHP | 8.3.30 (migración prevista a 8.4) |
| Servidor local | Laragon · Apache 2.4.66 |
| Base de datos | MySQL 8.4.3 · `utf8mb4_unicode_ci` |
| Interfaz pública | Blade + Tailwind CSS + Alpine.js |
| Panel administrativo | Livewire 3 sobre Blade + Tailwind |
| Roles y permisos | `spatie/laravel-permission` |
| Auditoría | `owen-it/laravel-auditing` + tabla propia de eventos de negocio |
| Imágenes | `intervention/image` |
| Backups | `spatie/laravel-backup` |
| Idioma del código | Inglés |
| Idioma de la interfaz | Español (archivos de traducción) |
| Identificadores públicos | ID interno autoincremental + código público legible |
| Valores monetarios | `decimal(10,2)` sin signo |
| Zona horaria | `America/Lima` |

No se incorpora ningún paquete adicional sin autorización previa. Cada dependencia nueva es superficie de ataque, deuda de mantenimiento y riesgo de abandono.

---

## 2. Convenciones de nombres

### Base de datos
- Tablas: plural, `snake_case` — `bookings`, `departures`, `equipment_items`
- Pivotes: singular, orden alfabético — `activity_guide`
- Columnas: `snake_case` — `total_amount`, `deposit_amount`, `scheduled_at`
- Claves foráneas: `{singular}_id` — `customer_id`, `guide_id`
- Booleanos: prefijo `is_` o `has_` — `is_active`, `has_support`
- Fechas: sufijo `_at` para timestamps, `_date` para fechas sin hora
- Índices: `idx_{tabla}_{columnas}` · Foráneas: `fk_{tabla}_{columna}`

### PHP
- Modelos: singular, `PascalCase` — `Booking`, `Departure`
- Controladores: plural + sufijo — `BookingController`
- Form Requests: `{Acción}{Modelo}Request` — `StoreBookingRequest`
- Policies: `{Modelo}Policy` · Services: `{Dominio}Service` — `BookingService`
- Eventos: verbo en pasado — `BookingConfirmed`, `DepartureCancelled`
- Jobs: verbo imperativo — `SendBookingConfirmation`
- Enums: singular, `PascalCase` — `BookingStatus`, `PaymentMethod`
- Métodos y variables: `camelCase`

### Rutas y vistas
- Nombres de ruta con notación de punto — `admin.bookings.index`, `public.reservation.create`
- Vistas Blade en `kebab-case` — `booking-form.blade.php`
- Componentes con prefijo de marca — `<x-canoa.button>`, `<x-canoa.card>`

### Git
- Ramas: `fase/{numero}-{slug}` — `fase/1.1-arquitectura`
- Commits en español, con prefijo tipo: `feat:`, `fix:`, `refactor:`, `chore:`, `docs:`, `test:`
- Un commit por unidad lógica de trabajo, nunca un commit por fase completa

---

## 3. Estructura de carpetas

```
app/
├── Enums/                      Estados y catálogos cerrados
├── Events/                     Eventos de dominio
├── Exceptions/Domain/          Excepciones de negocio propias
├── Http/
│   ├── Controllers/Admin/      Panel administrativo
│   ├── Controllers/Public/     Sitio público
│   ├── Middleware/
│   └── Requests/               Validación de entrada
├── Jobs/
├── Listeners/
├── Livewire/                   Componentes del panel
├── Models/
├── Notifications/
├── Policies/
├── Services/                   Lógica de negocio
├── Support/                    Helpers y utilidades transversales
└── View/Components/            Componentes Blade de clase

resources/
├── views/
│   ├── admin/                  Panel
│   ├── public/                 Sitio público
│   ├── components/canoa/       Sistema de componentes
│   └── layouts/
├── css/
└── js/

routes/
├── web.php                     Sitio público
├── admin.php                   Panel (prefijo /admin, middleware auth)
└── console.php

lang/es/                        Todos los textos de interfaz
database/migrations|seeders|factories/
docs/                           Este documento y los de cada fase
tests/Feature|Unit/
```

---

## 4. Arquitectura

### Flujo obligatorio

```
Ruta → Middleware → FormRequest → Controller → Service → Model → BD
                                       ↓
                                    Event → Listener → Notification / Job
```

### Reglas no negociables

1. **Controladores delgados.** Reciben una petición validada, llaman a un servicio y devuelven una respuesta. Máximo orientativo: 15 líneas por método. Nada de reglas de negocio.
2. **Cero lógica de negocio en las vistas.** Ninguna consulta Eloquent, ningún cálculo de precios, ningún `if` sobre reglas de negocio dentro de Blade.
3. **Los servicios contienen la lógica de negocio** y son la única puerta de escritura para operaciones complejas (reservas, salidas, pagos, asignaciones).
4. **Toda operación que escriba en más de una tabla va dentro de `DB::transaction()`.** Una reserva que crea cliente, reserva, participantes y pago debe ser atómica o no existir.
5. **Las verificaciones de cupo usan bloqueo pesimista** (`lockForUpdate()`) dentro de la transacción. Sin esto, dos reservas simultáneas pueden sobrepasar la capacidad de una salida.
6. **Los estados se modelan con Enums de PHP**, nunca con cadenas sueltas ni enteros mágicos.
7. **Los efectos secundarios se disparan con eventos**, no encadenando llamadas dentro del servicio. Confirmar una reserva emite `BookingConfirmed`; los listeners se encargan de notificar, auditar y actualizar la salida.
8. **Ningún modelo usa `$fillable = ['*']` ni `$guarded = []`.** Los campos asignables se declaran uno por uno.

---

## 5. Manejo de errores

- Excepciones de dominio propias en `app/Exceptions/Domain/` — `CapacityExceededException`, `GuideUnavailableException`, `InvalidPaymentAmountException`.
- Nunca se devuelve al usuario el mensaje crudo de una excepción de sistema. Se registra completo en el log y se muestra un mensaje comprensible en español.
- Páginas de error personalizadas con la identidad visual: 403, 404, 419, 429, 500, 503.
- Errores de negocio en el panel: mensaje `flash` con color semántico correspondiente.
- `APP_DEBUG=true` únicamente en local. Su presencia en producción se considera incidente de seguridad.
- Todo bloque `try/catch` registra el error antes de manejarlo. Prohibido el `catch` vacío.

---

## 6. Validaciones

Cuatro niveles, todos obligatorios:

1. **HTML** — `required`, `type`, `min`, `max`. Solo experiencia de usuario, jamás seguridad.
2. **Form Request** — validación de entrada. Toda ruta que reciba datos usa un Form Request dedicado. No se permite `$request->validate()` dentro del controlador.
3. **Service** — reglas de negocio que la validación de entrada no puede conocer: cupo disponible, guía libre, anticipo mínimo, coherencia entre fecha y horario.
4. **Base de datos** — restricciones `NOT NULL`, `UNIQUE`, claves foráneas. Última línea de defensa.

Detalles:
- Mensajes en español en `lang/es/validation.php`. Nunca escritos a mano en el Form Request.
- Reglas complejas y reutilizables como objetos `Rule` en `app/Rules/`.
- Los datos que llegan del cliente en la reserva pública se normalizan antes de validar (espacios, mayúsculas, formato de teléfono).

---

## 7. Seguridad

- Token CSRF en todos los formularios y peticiones Livewire.
- Escapado por defecto con `{{ }}`. El uso de `{!! !!}` requiere autorización caso por caso y justificación escrita.
- Prohibido concatenar entrada del usuario en `DB::raw()`, `whereRaw()` o similares. Siempre parámetros enlazados.
- Limitación de intentos: login, recuperación de contraseña y formulario de reserva pública.
- Contraseñas con el hash por defecto de Laravel. Mínimo 10 caracteres. Nunca en logs, nunca en correos.
- Sesiones con driver `database`, regeneración de ID en cada login, expiración por inactividad.
- Subida de archivos: validación del tipo MIME real, límite de tamaño, nombre generado aleatoriamente, almacenamiento fuera de `public/`, extensiones ejecutables rechazadas.
- Cabeceras de seguridad mediante middleware: `X-Frame-Options`, `X-Content-Type-Options`, `Referrer-Policy`, `Content-Security-Policy`.
- La autorización se resuelve siempre en el servidor. Ocultar un botón en la vista no es un control de acceso.
- Ninguna credencial, clave de API o token en el código fuente. Todo en `.env`.
- Los datos personales de clientes y turistas se tratan como información sensible: no se exponen en URLs, no se envían por canales no cifrados, no se registran completos en logs.

---

## 8. Autenticación

- Autenticación nativa de Laravel. **Sin registro público**: el sistema no tiene formulario de alta de usuarios.
- Los usuarios los crea el superadministrador desde el panel, o un administrador con permiso explícito.
- Recuperación de contraseña por correo, con enlace de un solo uso y caducidad.
- Cambio de contraseña obligatorio en el primer acceso de un usuario nuevo.
- Cierre de sesión invalida la sesión y regenera el token.
- El cliente turista **no tiene cuenta**. La reserva pública funciona sin registro (Etapa 8.3).

---

## 9. Autorización

- Roles fijos: `superadmin`, `admin`, `reservas`, `guia`, `soporte`.
- Permisos con formato `recurso.acción` — `bookings.create`, `departures.assign_guide`, `payments.refund`.
- Los permisos se asignan a roles, nunca directamente a usuarios, salvo excepción autorizada y auditada.
- `Gate::before()` concede todo al `superadmin`. Ningún otro rol tiene atajos.
- Cada modelo con acceso restringido tiene su Policy. Las Policies se invocan desde el controlador o el componente Livewire, nunca desde la vista.
- Regla de alcance: el rol `guia` accede únicamente a sus propias salidas; `soporte`, a las suyas. Ninguno de los dos ve información financiera.

---

## 10. Auditoría

Dos capas complementarias:

**Capa 1 — cambios de datos.** `owen-it/laravel-auditing` sobre los modelos sensibles: reservas, pagos, salidas, precios, paquetes, usuarios, guías, soportes.

**Capa 2 — eventos de negocio.** Tabla propia con: actor, acción, entidad afectada, motivo, valores anteriores y nuevos, IP, agente de usuario y marca temporal. Registra lo que un diff de columnas no explica.

Eventos de registro obligatorio (Etapa 2.3): creación, modificación y eliminación de registros; cambios de estado; cambio de guía; cambio de soporte; cambio de precio; pagos; cancelaciones; reprogramaciones; autorización de excepciones de capacidad.

- Los registros de auditoría son **inmutables**: no se actualizan ni se eliminan desde la aplicación.
- Toda acción que altere dinero o capacidad exige un motivo escrito por el operador.
- El panel de auditoría es de solo lectura y accesible únicamente a `superadmin`.

---

## 11. Manejo de imágenes

- Almacenamiento en `storage/app/public` con enlace simbólico. Nunca directamente en `public/`.
- Nombres generados con UUID. Se descarta el nombre original del archivo.
- Conversión a WebP con respaldo en JPEG.
- Tamaños derivados generados al subir: miniatura, tarjeta y cabecera. La imagen original se conserva.
- Límite de 5 MB por archivo. Tipos permitidos: JPEG, PNG, WebP.
- Atributo `alt` obligatorio en toda imagen de contenido; vacío en las decorativas.
- Carga diferida en todas las imágenes salvo la primera visible de cada página.
- Al eliminar un registro se eliminan sus archivos asociados.

---

## 12. Logs

- Canal diario con retención de 30 días en local y 90 en producción.
- Canales separados: `reservations`, `payments`, `security`.
- Niveles: `debug` solo en local · `info` para operaciones de negocio relevantes · `warning` para situaciones anómalas recuperables · `error` para fallos · `critical` para caídas de servicio.
- **Nunca se registran**: contraseñas, tokens, números de documento completos, datos de tarjeta, contenido íntegro de `.env`.
- Todo pago y toda cancelación generan una entrada de log además del registro de auditoría.

---

## 13. Variables de entorno

- `.env` nunca se versiona. `.env.example` sí, y se actualiza en el mismo commit que introduce una variable nueva.
- **Prohibido llamar a `env()` fuera de los archivos de `config/`.** Rompe `config:cache` y provoca fallos silenciosos en producción.
- El código accede a la configuración exclusivamente mediante `config()`.
- Toda configuración de negocio parametrizable (porcentaje de anticipo, capacidades por defecto, horarios de cierre) vive en base de datos y se administra desde el panel, no en `.env`.

---

## 14. Política de migraciones

1. **Una migración ejecutada en `develop` o `main` no se edita jamás.** Cualquier corrección se hace con una migración nueva.
2. `migrate:fresh` y `migrate:refresh` quedan prohibidos desde el momento en que exista un solo dato real. En producción, prohibidos siempre.
3. Toda clave foránea declara explícitamente su comportamiento en borrado (`cascade`, `restrict`, `set null`). El valor por defecto no se asume.
4. Índices obligatorios en claves foráneas y en toda columna usada para filtrar, ordenar o buscar.
5. Toda migración implementa `down()` de forma funcional.
6. Valores monetarios en `decimal(10,2) unsigned`. Prohibido `float` y `double`.
7. `timestamps()` en todas las tablas. `softDeletes()` en catálogos (actividades, paquetes, guías, equipamiento); **no** en movimientos (reservas, pagos, salidas), que se anulan con estado y motivo, no con borrado.
8. Seeders separados: datos maestros idempotentes (roles, permisos, actividades base) y datos de demostración, que nunca se ejecutan en producción.
9. Los nombres de migración describen el cambio: `2026_03_10_add_deposit_percentage_to_packages_table`.

---

## 15. Política de backups

**Local**
- Copia de la base de datos antes de cada migración que altere estructura de tablas con datos.
- Copia semanal, retención de 4 semanas.

**Producción (a partir de la Etapa 25)**
- Base de datos: diaria, retención de 30 días.
- Archivos de `storage`: semanal, retención de 8 semanas.
- Al menos una copia almacenada fuera del servidor de producción.
- Copia manual obligatoria antes de cada despliegue.
- **Prueba de restauración mensual.** Un backup que nunca se ha restaurado no es un backup, es una suposición.
- El proceso de backup notifica su resultado; un fallo silencioso es peor que la ausencia de backup.

---

## 16. Código reutilizable

- Regla de las tres repeticiones: a la tercera aparición de la misma lógica, se extrae.
- Toda la interfaz se construye con componentes Blade en `resources/views/components/canoa/`. Ninguna vista escribe HTML de botón, tarjeta, tabla, badge o formulario a mano.
- Lógica compartida entre modelos en Traits; utilidades sin estado en `app/Support/`.
- Prohibido duplicar cálculos de precio, cupo o disponibilidad. Existe un único servicio responsable de cada uno.
- Las consultas repetidas se encapsulan en scopes de Eloquent.

---

## 17. Identidad visual

Bloqueada desde la Fase 0.2. Ningún valor hexadecimal se escribe literal en vistas, componentes o clases; todo se consume mediante tokens definidos en variables CSS y `tailwind.config.js`.

| Token | Valor | Uso |
|---|---|---|
| `brand` | `#72D5F8` | Acento, fondos de sección, estados hover. Nunca texto ni fondo de botón primario |
| `deep` | `#0B3954` | Botón primario, encabezados, navegación |
| `teal` | `#087E8B` | Botón secundario, enlaces, iconos, gráficas |
| `ink` | `#17212B` | Texto principal |
| `muted` | `#5A6B75` | Texto secundario |
| `border` | `#6B7C86` | Bordes, iconos inactivos, placeholders |
| `surface` | `#FFFFFF` | Tarjetas, modales, tablas |
| `base` | `#F4F9FB` | Fondo de aplicación |
| `success` | `#0B7A50` | Solo semántico |
| `warning` | `#9A5B00` | Solo semántico |
| `danger` | `#B3261E` | Solo semántico |
| `info` | `#087E8B` | Solo semántico |

Reglas: el texto sobre `brand` va siempre en `ink` o `deep` (el blanco sobre `brand` da 1.67:1 y es ilegible); todo texto de cuerpo cumple contraste mínimo 4.5:1; cualquier tono nuevo se deriva de un token existente y requiere autorización.

Carácter de la interfaz: aventura, naturaleza, agua, confianza, modernidad, minimalismo. Panel administrativo orientado a escritorio y responsive; sitio público concebido primero para celular.

---

## 18. Flujo de trabajo por fases

```
Rama fase/X.Y → desarrollo → pruebas → correcciones → aprobación
     → merge a develop → merge a main al cerrar la etapa
```

Al terminar cada fase se entrega:
1. Resumen de lo construido.
2. Lista de archivos creados y modificados.
3. Cambios en base de datos.
4. Instrucciones de prueba.
5. Limitaciones conocidas y deuda técnica generada.
6. Qué queda explícitamente fuera de alcance.

Ninguna fase adelanta trabajo de fases posteriores.

---

## 19. Requiere autorización explícita

- Instalar cualquier paquete de Composer o npm.
- Modificar una decisión de este documento.
- Editar una migración ya ejecutada.
- Cambiar la estructura de una tabla con datos.
- Introducir un color, tipografía o componente fuera del sistema de diseño.
- Usar `{!! !!}` en una vista.
- Ejecutar cualquier comando destructivo sobre la base de datos.
- Modificar código de una fase ya aprobada.

---

*Fin del documento — Fase 0.2*
