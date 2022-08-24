# Mini framework MVC

Pour travailler sur le projet :

```bash
composer install
```

Pour lancer les migrations de BDD :

```bash
vendor/bin/phinx migrate
```

Pour les routes, vérifier le chemin dans le fichier `index.php` :

```php
define('BASE_URL', '/book-mvc/public');
```
