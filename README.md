# streamupload
**Upload videos to be re-encoded and scheduled for streaming**

## Install
* Prepare a Linux server, set its timezone to the users' timezone
  (on deb-based systems: `dpkg-reconfigure tzdata`).
* On the server, `cd` to the place where you want the files.
* Clone repo: `git clone https://gitlab.com/pepa65/streamupload`.
* `cd streamupload`. Now the output of `pwd` is the value for `$repopath`.
* Copy `_mailvars` to `mailvars` and set the variables
  `to`, `user`, `password`, `smtp` and `port` in it in order to
  receive mail notifications when the encodes are finished.
* Make a crontab-entry: "* * * * *  $repopath/encode" (replace `$repopath`!).
* Install the `mailer` binary by downloading it from the repo at
  https://https://github.com/pepa65/mailer/releases/latest and moving it to
  `/usr/local/bin` and make it executable: `chmod +x /usr/local/bin/mailer`.
  If it's not installed, everything except the email will still work.
* Run a php/webserver on `$repopath/uploadpage`:
  - Get it to restart on reboot.
  - Setting up basicauth on the page is a good idea if others can get access!
  - Change the relevant `php.ini` to allow large file uploads:
    * `post_max_size` - Upper limit of uploaded video sizes, say `10G`.
    * `upload_max_filesize` - same value as `post_max_size`.

### Webserver
If no webserver has been installed, an easy way to get going is to use Caddy
from https://caddyserver.com/download and place the `caddy` binary in
`/usr/local/bin` and make it executable: `chmod +x /usr/local/bin/caddy`.
For php functionality, install `php-fpm` (on deb-based systems:
`apt install php-fpm`) and make the config file `/root/Caddyfile` with:
```
$ipaddress:80 {
	basicauth {
		$user $hashpassword
	}
	php_fastcgi unix//run/php/php-fpm.sock
	root * $repopath/uploadpage
	file_server
}
```
* Replace `$ipaddress` with the server's IP address. Alternatively, if the
  server has an DNS A record pointing to it, `$ipaddress:80` can be replaced
  by the domainname that the A record lists.
* Replace `$user` with the desired username for authentication.
* Replace `$hashpassword` with the output of `caddy hash-password` which will
  ask for the password to be used for authentication.
* Replace `$repopath` (see above in Install).
* The value of `/run/php/php-fpm.sock` might need to be adjusted, depending
  on the system used, it needs to be the socket for php.
* Caddy can be started at boottime by including `@reboot /root/Caddy` as a
  line in root's crontab: `crontab -e` and make the file /root/Caddy` with:
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

## Usage
* Get a streamkey for the target by scheduling a stream
  (supported are: Restream.io, YouTube.com, Facebook.com).
* Go to the server's IP address in the browser: `http://$ipaddress` or to the
  domainname if available: `https://$domainname`.
* Fill in the form, and click "Schedule Stream".
