## Ejecución de contenedores docker

### Construcción y ejecución de contenedores docker
**Nota**: el usuario debe tener permisos de ejecución para ``docker compose`` de lo contrario ejecutar como superadministrador

```bash
docker compose up -d --build
```

### ejecución de setup del proyecto
```bash
cat ./.docker/setup.sh | docker exec -i merqueo_app bash
```

### Notas:

Configuración de conexión a mysql esto con el objetivo de ver desde la máquina anfitrión la base de datos

![img.png](./docs/mysql_connect_service.png)
