# Setup

To build project your need exec 

```
composer install
```

```
php artisan key:generate 
```

```
composer dump-autoload
```

```
docker-compose up
```

If have problem with permission in storage log

run command
```
cd ./application
sudo chown -R www.data:www-data ./storage 
```

Link of documentation
https://documenter.getpostman.com/view/4710223/SVmvTeCZ?version=latest