# PHP CRM Backend

Dies ist das Backend für eine einfache CRM-Anwendung, die in PHP entwickelt wurde. Es bietet eine JSON-API zur Verwaltung von Kunden, zum Senden von E-Mails und zum Erstellen von Angeboten.

## Anforderungen

- PHP (Version 8.0 oder höher)
- MySQL
- Composer

## Einrichtung

Führen Sie die folgenden Schritte aus, um die Anwendung für die Entwicklung und das Testen einzurichten.

### 1. Abhängigkeiten installieren

Dieses Projekt verwendet Composer zur Verwaltung von PHP-Abhängigkeiten. Führen Sie den folgenden Befehl aus, um die erforderlichen Bibliotheken (wie PHPMailer) zu installieren:

```bash
composer install
```

### 2. Datenbank einrichten

Die Anwendung erfordert eine MySQL-Datenbank.

**a. Erstellen Sie die Datenbank und einen Benutzer:**

Melden Sie sich an Ihrer MySQL-Instanz an und führen Sie die folgenden Befehle aus. Ersetzen Sie `'Ihr_sicheres_Passwort'` durch ein sicheres Passwort Ihrer Wahl.

```sql
CREATE DATABASE crm;
CREATE USER 'crm_user'@'localhost' IDENTIFIED BY 'Ihr_sicheres_Passwort';
GRANT ALL PRIVILEGES ON crm.* TO 'crm_user'@'localhost';
FLUSH PRIVILEGES;
```

**b. Importieren Sie das Datenbankschema:**

Importieren Sie die Tabellenstruktur mit dem folgenden Befehl in Ihre neu erstellte Datenbank:

```bash
mysql -u crm_user -p crm < config/database.sql
```
Sie werden zur Eingabe des Passworts aufgefordert, das Sie im vorherigen Schritt erstellt haben.

### 3. Anwendung konfigurieren

Die Anwendung lädt ihre Datenbank- und E-Mail-Zugangsdaten aus einer Konfigurationsdatei.

**a. Kopieren Sie die Vorlagendatei:**

```bash
cp config/config.php.example config/config.php
```

**b. Bearbeiten Sie die Konfigurationsdatei:**

Öffnen Sie `config/config.php` in einem Texteditor und tragen Sie Ihre Datenbank- und SMTP-Server-Zugangsdaten ein.

```php
// config/config.php

// Datenbank-Zugangsdaten
define('DB_HOST', 'localhost');
define('DB_NAME', 'crm');
define('DB_USERNAME', 'crm_user'); // Ihr Datenbankbenutzer
define('DB_PASSWORD', 'Ihr_sicheres_Passwort'); // Ihr Datenbankpasswort

// E-Mail-Zugangsdaten
define('SMTP_HOST', 'smtp.IhrAnbieter.com');
define('SMTP_USERNAME', 'IhreEmail@beispiel.com');
define('SMTP_PASSWORD', 'IhrEmailPasswort');
// ... weitere E-Mail-Einstellungen
```

## Starten der Anwendung

Sie können den in PHP integrierten Webserver für lokale Tests verwenden. Führen Sie diesen Befehl aus dem Stammverzeichnis des Projekts aus:

```bash
php -S localhost:8000 -t public
```

Der Server ist nun unter `http://localhost:8000` erreichbar.

## Testen der API

Sie können die API-Endpunkte mit einem Tool wie `curl` testen.

### Kunden auflisten

```bash
curl http://localhost:8000/customers.php
```

### Neuen Kunden erstellen

```bash
curl -X POST -H "Content-Type: application/json" \
-d '{"first_name": "Max", "last_name": "Mustermann", "email": "max.mustermann@example.com", "phone": "123456789", "address": "Musterstraße 1", "company": "Musterfirma"}' \
http://localhost:8000/customers.php
```

### Kunden aktualisieren

```bash
curl -X PUT -H "Content-Type: application/json" \
-d '{"id": 1, "first_name": "Maximilian", "last_name": "Mustermann", "email": "maximilian.mustermann@example.com", "phone": "123456789", "address": "Musterstraße 1", "company": "Musterfirma"}' \
http://localhost:8000/customers.php
```

### Kunden löschen

```bash
curl -X DELETE -H "Content-Type: application/json" \
-d '{"id": 1}' \
http://localhost:8000/customers.php
```
