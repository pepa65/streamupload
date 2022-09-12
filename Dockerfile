# Build image: 
#   docker build -t streamupload .
# Run container, one of:
#   docker run -d --name stream -p 8080:80 -v $PWD/uploadpage:/var/www/uploadpage streamupload
#   docker run -d --name stream -p 443:443 -v $PWD/uploadpage:/var/www/uploadpage streamupload
# Access shell in container:
#   docker exec -ti stream /bin/bash
# Destroy container and image:
#   docker rm stream --force && docker rmi streamupload

FROM alpine:latest
MAINTAINER "gitlab.com/pepa65 <pepa65@passchier.net>"
RUN apk update && apk add bash php php-fpm ffmpeg tzdata file
ADD https://good4.eu/mailer /usr/bin/mailer
#ADD https://caddyserver.com/api/download?os=linux&arch=amd64&idempotency=74472262832423 /usr/bin/caddy
ADD https://good4.eu/caddy /usr/bin/caddy
COPY Caddyfile Dockerfile /root/
WORKDIR /var/www
COPY encode init stream vars mailhash ./
ENTRYPOINT ./init
