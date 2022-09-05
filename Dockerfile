# Build image: 
#   docker build -t streamupload .
# Run container, one of:
#   docker run -d --name stream -p 8080:80 -v uploadpage:/var/www/uploadpage streamupload
#   docker run -d --name stream -p 443:443 -v uploadpage:/var/www/uploadpage streamupload
# Access shell in container:
#   docker exec -ti stream /bin/bash
# Destroy container and image:
#   docker rm stream --force && docker rmi streamupload

FROM alpine:latest
MAINTAINER "gitlab.com/pepa65 <pepa65@passchier.net>"
RUN apk update && apk add bash php php-fpm ffmpeg tzdata file
COPY Caddyfile Dockerfile encode init stream vars /var/www/
WORKDIR /var/www
ENTRYPOINT /var/www/init
