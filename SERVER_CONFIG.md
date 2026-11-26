# Configuration du Serveur Web - Fix erreur 405

## Problème
Erreur **405 Method Not Allowed** sur les requêtes POST vers `/api/auth/login`

## Cause
Le serveur web n'est pas configuré pour rediriger les requêtes vers `index.php` de Laravel.

---

## Solution pour Apache

### 1. Vérifier que mod_rewrite est activé
```bash
sudo a2enmod rewrite
sudo systemctl restart apache2
```

### 2. Vérifier la configuration du VirtualHost
```apache
<VirtualHost *:80>
    ServerName api-reg.artischools.com
    DocumentRoot /var/www/artiscode-registrations/public

    <Directory /var/www/artiscode-registrations/public>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
        
        # Important pour Laravel
        RewriteEngine On
        RewriteCond %{REQUEST_FILENAME} !-d
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteRule ^ index.php [L]
    </Directory>

    <FilesMatch \.php$>
        SetHandler "proxy:unix:/run/php/php-fpm.sock|fcgi://localhost"
    </FilesMatch>

    ErrorLog ${APACHE_LOG_DIR}/api-reg-error.log
    CustomLog ${APACHE_LOG_DIR}/api-reg-access.log combined
</VirtualHost>
```

### 3. Activer le VirtualHost
```bash
sudo a2ensite api-reg.artischools.com
sudo systemctl reload apache2
```

---

## Solution pour Nginx

### Configuration Nginx correcte
```nginx
server {
    listen 80;
    server_name api-reg.artischools.com;
    
    root /var/www/artiscode-registrations/public;
    index index.php;

    # Rediriger tous les requests vers index.php
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    # PHP FPM
    location ~ \.php$ {
        fastcgi_pass unix:/run/php/php-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_param DOCUMENT_ROOT $realpath_root;
    }

    # Deny access to .env
    location ~ /\.env {
        deny all;
    }
}
```

### Redémarrer Nginx
```bash
sudo nginx -t  # Test config
sudo systemctl reload nginx
```

---

## Vérification

Après la configuration, testez:

```bash
# Tester le login
curl -X POST https://api-reg.artischools.com/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{"email":"test@example.com","password":"password123"}'

# Résultat attendu: JSON avec token (200 OK)
# Au lieu de: 405 Method Not Allowed
```

---

## Points importants

1. **DocumentRoot doit pointer vers `public/`** ← C'est la clé !
2. **mod_rewrite doit être activé** (Apache)
3. **Le .htaccess dans public/ doit être respecté**
4. **Les permissions doivent être correctes**: `chown -R www-data:www-data /var/www/artiscode-registrations`

## Debug

Si ça ne marche toujours pas:

```bash
# Vérifier les logs Apache/Nginx
tail -f /var/log/apache2/api-reg-error.log
tail -f /var/log/nginx/error.log

# Vérifier que public/ est accessible
ls -la /var/www/artiscode-registrations/public/

# Vérifier les permissions
ls -la /var/www/artiscode-registrations/
```

---

## Checklist

- [ ] DocumentRoot pointe vers `public/`
- [ ] mod_rewrite activé (Apache) ou try_files configuré (Nginx)
- [ ] .htaccess dans public/ existe
- [ ] Permissions correctes (www-data:www-data)
- [ ] PHP-FPM fonctionne
- [ ] SSL/HTTPS configuré (si nécessaire)
- [ ] Test curl POST retourne 200 OK
