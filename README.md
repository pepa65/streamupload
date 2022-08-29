# streamupload
**Upload videos to be re-encoded and scheduled for streaming**

## Install
* Prepare a server, set its timezone to the users' timezone
  (on deb-based systems: `dpkg-reconfigure tzdata`)
* On the server, `cd` to the place where you want the files
* Clone repo: `git clone https://gitlab.com/pepa65/streamupload`
* `cd streamupload`
* Change the value of the `repopath` variable in `stream` and `encode`
  to the output of `echo $PWD`
* Run a php/webserver on $PWD/uploadpage
  - Get it to restart on reboot
  - Setting up basicauth on the page is a good idea if others can get access!
  - Change the relevant `php.ini` to allow large file uploads:
    * `post_max_size` - Upper limit of uploaded video sizes, say `10G`
    * `upload_max_filesize` - same value as `post_max_size`
* Make a crontab-entry: "* * * * *  $PWD/encode" (replace $PWD with its value!)

## Usage
* Get a streamkey for the target by scheduling a stream
  (supported are: Restream.io, YouTube.com, Facebook.com)
* Go to the server's IP address in the browser: `http://$ipaddress`
* Fill in the form, click "Schedule Stream"
