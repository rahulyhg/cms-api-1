# Docker containers
This is a docker boiler plate for all my php project which run on Ubuntu 18.04 (LAMP)

1. Run a dev environment in docker
    - Apache2/PHP
    - MySQL
    - Redis (mainly for cache)
2. Create our image by using Dockerfile
3. Combine our image file with pre-made images (MySQL/Redis)
4. Assemble all to gather in (docker-compose.yml)
5. Create a shortcut way to build or run docker 

To build docker image: 
```docker build -t main/app -f ./docker/app/Dockerfile .```
To run image and create container:
```docker run -itd --rm --name app -p 8080:80 -v $(pwd)/application:/var/www/html main/app```
To track all logs which are sent to the docker output:
```docker logs -f app```