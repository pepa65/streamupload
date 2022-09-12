# streamupload
**Upload videos to be re-encoded and scheduled for streaming**

## Install

### Manual
* Prepare a Linux server, set its timezone to the users' timezone
  (on deb-based systems: `dpkg-reconfigure tzdata`).
  the webserver user (often `www-data`) has access to the location!).
* Make sure the packages `git php-fpm ffmpeg` are installed (on deb-based
  systems: `apt install git php-fpm ffmpeg`).
* Clone repo: `git clone https://gitlab.com/pepa65/streamupload`.
* Move the `streamupload` directory to a place that is accessible to the web
  server, like: `mv streamupload /var/www` and `cd` to that place. Now the
  output of `pwd` is the value for `$repopath`.
* Copy `_vars` to `vars` and `_mailhash` to `mailhash` and set the variables
  in `vars` (webserver, SMTP-server) and `mailhash` (usernames, emails and
  bcrypt-password-hashes).
* Make a crontab-entry: "* * * * *  $repopath/encode" (replace `$repopath`!).
* Install the `mailer` binary by downloading it from the repo at
  https://https://github.com/pepa65/mailer/releases/latest and moving it to
  `/usr/local/bin` and make it executable: `chmod +x /usr/local/bin/mailer`.
  If it's not installed, everything (except the emails) will still work.
* Run a php/webserver on `$repopath/uploadpage`:
  - Get it to restart on reboot.
  - Change the relevant `php.ini` to allow large file uploads:
    * `post_max_size` - Upper limit of uploaded video sizes, say `10G`.
    * `upload_max_filesize` - same value as `post_max_size`.

#### Webserver
If no webserver has been installed, an easy way to get going is to use Caddy
from https://caddyserver.com/download and place the `caddy` binary in
`/usr/local/bin` and make it executable: `chmod +x /usr/local/bin/caddy`.
Make the config file `/root/Caddyfile` like:
```
{
	email $email
}

:80 {
	log {
		output file $weblogfile
	}
	php_fastcgi unix//run/php/php-fpm.sock
	root * $repopath/uploadpage
	file_server
}
```
* If the server IP has an DNS A record pointing to it, `:80` can be replaced
  by the domainname with the A record, and it will be SSL-encrypted.
* Replace `$email` with an email for the SSL-certificates.
* Replace `$weblogfile` with a path for a webserver logfile.
* Replace `$repopath` (see above in Install).
* The value of `/run/php/php-fpm.sock` might need to be adjusted, depending
  on the system used, it needs to be the unix socket for php.
* Caddy can be started at boottime by including `@reboot  /root/Caddy` as a
  line in root's crontab: `crontab -e` and make the file `/root/Caddy` with:
```
#!/usr/bin/env bash

# Make sure internet is reachable
while ! /usr/bin/ping -q -c 1 1.1.1.1 &>/dev/null
do sleep 1
done

cd /root
/usr/local/bin/caddy stop &>/dev/null
sleep 1
/usr/bin/killall -9 caddy &>/dev/null
/usr/local/bin/caddy start &>/root/caddy.log
```
  and make it executable: `chmod +x /root/Caddy`.

### Docker
After cloning this repo, `cd streamupload`, and setting the variables in `vars` and
`mailhash`, a docker image can be built from the included `Dockerfile` by:
`docker build -t streamupload .`. In the case of running on a LAN and not having a
DNS A record, start it with:
`docker run -d -p 8080:80 -v $PWD/uploadpage:/var/www/uploadpage streamupload`.
In case of a domainname, replace `8080:80` by `443:443`.

## Usage
* Get a streamkey for the target by scheduling a stream
  (supported are: Restream.io, YouTube.com, Facebook.com).
* Go to the server's URL in the browser: `http://$ipaddress:8080` or to the
  domainname if available: `https://$domainname`.
* Log in with the username and passwors as prepared in `mailhash`.
* Fill in the form, and click "Schedule Stream".
