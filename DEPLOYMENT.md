# Guide de Déploiement - artiscode-registrations

## Mise en place initiale

### 1. Cloner et installer les dépendances
```bash
git clone https://github.com/tchioffouosamuel-coder/api-reg.git
cd artiscode-registrations
composer install
```

### 2. Configuration de l'environnement
```bash
cp .env.example .env
php artisan key:generate
```

### 3. Configuration de la base de données
Modifiez les variables d'environnement dans `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=artiscode_registrations
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Exécuter les migrations et les seeders
```bash
php artisan migrate
php artisan db:seed
```

Cela crée automatiquement:
- **Admin user**: `admin@artiscode.agency` / `admin123` (ou variable ADMIN_PASSWORD)
- **Test user**: `test@example.com` / `password123`

## Utilisateurs créés automatiquement

| Email | Password | Rôle |
|---|---|---|
| `admin@artiscode.agency` | `admin123` (ou ADMIN_PASSWORD env) | Admin Principal |
| `test@example.com` | `password123` | Test/Développement |

## Variables d'environnement importantes

```env
# Base de données
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=artiscode_registrations
DB_USERNAME=root
DB_PASSWORD=

# Admin password (optionnel - défaut: admin123)
ADMIN_PASSWORD=your_secure_password_here

# Sanctum (JWT)
SANCTUM_STATEFUL_DOMAINS=localhost,localhost:5173,127.0.0.1
```

## Démarrage du serveur

### Développement
```bash
php artisan serve
```

Le serveur démarrera sur `http://localhost:8000`

### Production
```bash
php artisan serve --host=0.0.0.0 --port=8001
```

## Tests

### Tester l'authentification
```bash
# Login
curl -X POST http://localhost:8000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{"email":"test@example.com","password":"password123"}'

# Résultat attendu: token Sanctum
```

### Tester les endpoints CRUD
```bash
# Remplacez TOKEN par le token reçu du login
curl -X GET http://localhost:8000/api/events \
  -H "Authorization: Bearer TOKEN"
```

## Points importants

- Les seeders créent les utilisateurs automatiquement avec `firstOrCreate`, donc ils ne seront pas doublonnés si exécutés plusieurs fois
- Le password du user admin peut être contrôlé via la variable d'environnement `ADMIN_PASSWORD`
- Les tokens Sanctum sont générés à la première connexion
- La validation des tokens est effectuée via le guard `auth:sanctum`

## Intégration Frontend

Le frontend se connecte à l'API avec:
- **Login endpoint**: `POST /api/auth/login`
- **API base**: défini par `VITE_API_URL` dans le frontend `.env`
- **Authentication**: Bearer token envoyé dans le header `Authorization`

Exemple `.env` frontend:
```env
VITE_API_URL=http://localhost:8001
```
