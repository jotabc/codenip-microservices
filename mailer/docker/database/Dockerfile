FROM mysql:8.0

# Todos los sql que coloquemos dentro de esta carpeta docker-entrypoint-initdb.d
# all sql se ejecutará despúes que termine de crear el contenedor
# podemos colocar cualquier query para crear tablas etc etc.
COPY ./testing.sql /docker-entrypoint-initdb.d/testing.sql
