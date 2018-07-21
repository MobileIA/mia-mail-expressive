# MobileIA Email Expressive
Libreria para enviar email usando Sendgrid.

1. Incluir libreria:
```bash
composer require mobileia/mia-mail-expressive
```
2. Incluir configuración en el archivo: "config/config.php"
```php
// Configurar modulo de emails
\Mobileia\Expressive\Mail\ConfigProvider::class,

// Default App module config
//App\ConfigProvider::class,
```
3. Crear archivo de configuracion: "config/autoload/email.global.php":
```php
return [
    'sendgrid' => [
        'api_key' => 'SG233.4asklajsd_asSkjhakjhss_No',
        'from' => 'no-reply@test.com',
        'name' => 'Test name',
        'reply_to' => 'admin@test.com',
        'template_folder' => __DIR__ . '/../../src/App/templates/email/',
        'base_url' => 'https://testserver.com/'
    ],
];
```