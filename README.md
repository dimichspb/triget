# Triget test assignment

## Installation

1. Clone repo

```
git clone https://github.com/dimichspb/triget
```

2. Change directory

```
cd triget
```

3. Install dependenies

```
composer install
```

## Configuration

1. Setup apache configuration

```
<VirtualHost *:80>
    DocumentRoot "C:/Projects/PHP/sixt/web"
    ServerName sixt.localhost
    <Directory "C:/Projects/PHP/sixt/web">
        Options -Indexes +FollowSymLinks
        AllowOverride All
        Require all Granted
    </Directory>
</VirtualHost>
```

2. Restart apache service

```
apachectl restart
```

3. Configure database connection:

```
config\db.php
```

4. Apply migrations:

```
php yii migrate
```

## Usage

1. Web GUI

```
http://triget.localhost
```

## Tests

**TODO**
