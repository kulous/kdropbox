kdropbox
========

A quick html5 file uploader

Installation Instructions

1. Download this repo 
 a. Download the zip on this page 
 b. git clone https://github.com/kulous/kdropbox.git

2. Place the contents of this directory in a folder served by a web server

3. Open the folder path in a web browser

If a "/d" folder does not exist, the script will automatically create one for you. 

Notes: 

- PHP has a user definable file limit, in php.ini which may need to be adjusted
- The directory "/d" should be writable by the web server (o+rwx)
- Any files uploaded are publicly accessible if the $hash is known 
- PHP Sendmail expects the linux `sendmail` application to be installed
- This script will only send email if you server is set up to send email, PHP Sendmail simply calls the `sendmail` application 

 
Operation 
- When accessing the page, a unique identifier (hash) is created for you
- All files uploaded are storedd in a directory of that hash, so noone can easily guess your hash to find your files
- Don't loose the hash! you will need someone to look through the directories on the server in order to determine which hash is yours
- - Use the email feature! Send yourself an email with links to the documents you uploaded !
