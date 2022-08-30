# streamupload
**Upload videos to be re-encoded and scheduled for streaming**

## Install
* Prepare a server, set its timezone to the users' timezone
  (on deb-based systems: `dpkg-reconfigure tzdata`).
* On the server, `cd` to the place where you want the files.
* Clone repo: `git clone https://gitlab.com/pepa65/streamupload`.
* `cd streamupload`.
* Run a php/webserver on $PWD/uploadpage:
  - Get it to restart on reboot.
  - Setting up basicauth on the page is a good idea if others can get access!
  - Change the relevant `php.ini` to allow large file uploads:
    * `post_max_size` - Upper limit of uploaded video sizes, say `10G`.
    * `upload_max_filesize` - same value as `post_max_size`.
* Make a crontab-entry: "* * * * *  $PWD/encode" (replace $PWD with its value!).
* Install the `mailer` binary by downloading it from the repo at
  https://https://github.com/pepa65/mailer/releases/latest and moving it to
  `/usr/local/bin` and make it executable: `chmod +x /usr/local/bin/mailer`.
  If it's not installed, everything except the email will still work.
* Copy `_mailvars` to `mailvars` and set the variables
  `to`, `user`, `password`, `smtp` and `port` in it in order to
  receive mail notifications when the encodes are finished.

## Usage
* Get a streamkey for the target by scheduling a stream
  (supported are: Restream.io, YouTube.com, Facebook.com)
* Go to the server's IP address in the browser: `http://$ipaddress`
* Fill in the form, click "Schedule Stream"
