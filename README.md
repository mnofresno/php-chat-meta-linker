# PHP Chat Linker

This is a server application and a javascript bookmarklet to shorten long URLs adding meta tags for chat programs 

## Pre-requisites:

* To install the application server:

Linux/windows machine with PHP > v5.0 compatible web server (with SSL domain preferably).

* To install the bookmarklet:

Linux/windows machine with a web browser (was tested in Chrome and Firefox)

## Installation of the server:

* Copy/clone the index.php file to a folder with rw permissions

* Connect via SSH to the server and issue this command:

```console
PHP -S localhost:9000 &
```

This command will keep the system up and running even if you exit the SSH console.

You can choose the port of your preference.

* Use Apache or Nginx web servers to redirect via a reverse proxy this backend service to a friendly domain with key and certificate for secure https connections.

See to get help with SSL / https certificates: https://letsencrypt.org

## Installation of the bookmarklet:

* Open the file bookmarklet.js in your favorite editor and copy all of its contents
* Replace the serverUrl variable value with the URL of the server you've just installed beforehand
* Create a new bookmark in your favorite web browser and paste the contents of the file in the field URL

![Create new bookmark](https://raw.githubusercontent.com/mnofresno/php-chat-meta-linker/master/assets/new_bookmark.png)

* Choose a fancy name like: "Create chat link"
* Save the newly created bookmark to your bookmarks bar

![Create link button](https://raw.githubusercontent.com/mnofresno/php-chat-meta-linker/master/assets/create_link_button.png)

## Usage:

* When you arrive a site you want to short link in the chat, just click the created bookmarklet in your bookmarks bar
* A window must open with a URL you need to select

![Link popup window](https://raw.githubusercontent.com/mnofresno/php-chat-meta-linker/master/assets/link_popup.png)

* Copy the link and paste it on a chat group window: WhatsApp, RocketChat, Slack or Discord.
* The title of the page will appear just below the link with a proper description of your page

## Limitations:

The system stores in a file, temporary encoded data for it's functioning and in every saving it removes entries older than an hour. Thus the links are live maximum one hour per link.
In this version this cannot be configured but is the 3600 value in the comparison that removes old entries.

## Contributions:

Feel free to contribute we can talk at mnofresno@gmail.com
