## Ejecución de contenedores docker

### Copiar archivo de ambiente
```bash
cp .env.example .env
```

### Armado y ejecución de contenedores docker
```bash
docker up -d
```

### ejecución de migraciones y comandos para arrancar proyecto
```bash

# Ingreso a contenedor de aplicación
docker exec -it  merqueo_app bash

# Ejecución de migraciones y configuraciones iniciales
php artisan key:generate
php artisan migrate --seed

```
