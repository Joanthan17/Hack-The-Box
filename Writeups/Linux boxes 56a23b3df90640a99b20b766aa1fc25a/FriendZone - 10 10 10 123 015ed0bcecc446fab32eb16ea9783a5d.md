# FriendZone - 10.10.10.123

Created: June 4, 2021 1:32 PM

nmap:

![FriendZone%20-%2010%2010%2010%20123%20015ed0bcecc446fab32eb16ea9783a5d/Untitled.png](FriendZone%20-%2010%2010%2010%20123%20015ed0bcecc446fab32eb16ea9783a5d/Untitled.png)

the cert of https:

![FriendZone%20-%2010%2010%2010%20123%20015ed0bcecc446fab32eb16ea9783a5d/Untitled%201.png](FriendZone%20-%2010%2010%2010%20123%20015ed0bcecc446fab32eb16ea9783a5d/Untitled%201.png)

zone transfer:

![FriendZone%20-%2010%2010%2010%20123%20015ed0bcecc446fab32eb16ea9783a5d/Untitled%202.png](FriendZone%20-%2010%2010%2010%20123%20015ed0bcecc446fab32eb16ea9783a5d/Untitled%202.png)

also from the mail on webpage we have another domain:

![FriendZone%20-%2010%2010%2010%20123%20015ed0bcecc446fab32eb16ea9783a5d/Untitled%203.png](FriendZone%20-%2010%2010%2010%20123%20015ed0bcecc446fab32eb16ea9783a5d/Untitled%203.png)

friendzoneportal.red

![FriendZone%20-%2010%2010%2010%20123%20015ed0bcecc446fab32eb16ea9783a5d/Untitled%204.png](FriendZone%20-%2010%2010%2010%20123%20015ed0bcecc446fab32eb16ea9783a5d/Untitled%204.png)

add all to /etc/hosts

smb share found:

![FriendZone%20-%2010%2010%2010%20123%20015ed0bcecc446fab32eb16ea9783a5d/Untitled%205.png](FriendZone%20-%2010%2010%2010%20123%20015ed0bcecc446fab32eb16ea9783a5d/Untitled%205.png)

read from general:

![FriendZone%20-%2010%2010%2010%20123%20015ed0bcecc446fab32eb16ea9783a5d/Untitled%206.png](FriendZone%20-%2010%2010%2010%20123%20015ed0bcecc446fab32eb16ea9783a5d/Untitled%206.png)

download the file:

![FriendZone%20-%2010%2010%2010%20123%20015ed0bcecc446fab32eb16ea9783a5d/Untitled%207.png](FriendZone%20-%2010%2010%2010%20123%20015ed0bcecc446fab32eb16ea9783a5d/Untitled%207.png)

creds:

![FriendZone%20-%2010%2010%2010%20123%20015ed0bcecc446fab32eb16ea9783a5d/Untitled%208.png](FriendZone%20-%2010%2010%2010%20123%20015ed0bcecc446fab32eb16ea9783a5d/Untitled%208.png)

admin:WORKWORKHhallelujah@#

cant ssh with it

found website:

![FriendZone%20-%2010%2010%2010%20123%20015ed0bcecc446fab32eb16ea9783a5d/Untitled%209.png](FriendZone%20-%2010%2010%2010%20123%20015ed0bcecc446fab32eb16ea9783a5d/Untitled%209.png)

the website runs php:

![FriendZone%20-%2010%2010%2010%20123%20015ed0bcecc446fab32eb16ea9783a5d/Untitled%2010.png](FriendZone%20-%2010%2010%2010%20123%20015ed0bcecc446fab32eb16ea9783a5d/Untitled%2010.png)

dead-end.

login to [administrator1.friendzone.red](http://administrator1.friendzone.red) with the creds:

![FriendZone%20-%2010%2010%2010%20123%20015ed0bcecc446fab32eb16ea9783a5d/Untitled%2011.png](FriendZone%20-%2010%2010%2010%20123%20015ed0bcecc446fab32eb16ea9783a5d/Untitled%2011.png)

![FriendZone%20-%2010%2010%2010%20123%20015ed0bcecc446fab32eb16ea9783a5d/Untitled%2012.png](FriendZone%20-%2010%2010%2010%20123%20015ed0bcecc446fab32eb16ea9783a5d/Untitled%2012.png)

with gobuster we enumarate the [administrator1.friendzone.red](http://administrator1.friendzone.red) folder and get:

![FriendZone%20-%2010%2010%2010%20123%20015ed0bcecc446fab32eb16ea9783a5d/Untitled%2013.png](FriendZone%20-%2010%2010%2010%20123%20015ed0bcecc446fab32eb16ea9783a5d/Untitled%2013.png)

may be useful for later.

XSS:

![FriendZone%20-%2010%2010%2010%20123%20015ed0bcecc446fab32eb16ea9783a5d/Untitled%2014.png](FriendZone%20-%2010%2010%2010%20123%20015ed0bcecc446fab32eb16ea9783a5d/Untitled%2014.png)

we can LFI with the pagename varriable in the URL:

![FriendZone%20-%2010%2010%2010%20123%20015ed0bcecc446fab32eb16ea9783a5d/Untitled%2015.png](FriendZone%20-%2010%2010%2010%20123%20015ed0bcecc446fab32eb16ea9783a5d/Untitled%2015.png)

with smbclient we can upload (put) file to the server and with the LFI we can activate it.

create reverse shell with php:

![FriendZone%20-%2010%2010%2010%20123%20015ed0bcecc446fab32eb16ea9783a5d/Untitled%2016.png](FriendZone%20-%2010%2010%2010%20123%20015ed0bcecc446fab32eb16ea9783a5d/Untitled%2016.png)

upload it to development:

![FriendZone%20-%2010%2010%2010%20123%20015ed0bcecc446fab32eb16ea9783a5d/Untitled%2017.png](FriendZone%20-%2010%2010%2010%20123%20015ed0bcecc446fab32eb16ea9783a5d/Untitled%2017.png)

activate it:

![FriendZone%20-%2010%2010%2010%20123%20015ed0bcecc446fab32eb16ea9783a5d/Untitled%2018.png](FriendZone%20-%2010%2010%2010%20123%20015ed0bcecc446fab32eb16ea9783a5d/Untitled%2018.png)

we got reverse shell as www-data:

![FriendZone%20-%2010%2010%2010%20123%20015ed0bcecc446fab32eb16ea9783a5d/Untitled%2019.png](FriendZone%20-%2010%2010%2010%20123%20015ed0bcecc446fab32eb16ea9783a5d/Untitled%2019.png)

find user creds:

![FriendZone%20-%2010%2010%2010%20123%20015ed0bcecc446fab32eb16ea9783a5d/Untitled%2020.png](FriendZone%20-%2010%2010%2010%20123%20015ed0bcecc446fab32eb16ea9783a5d/Untitled%2020.png)

friend::Agpyu12!0.213$

ssh works.

interesting files:

![FriendZone%20-%2010%2010%2010%20123%20015ed0bcecc446fab32eb16ea9783a5d/Untitled%2021.png](FriendZone%20-%2010%2010%2010%20123%20015ed0bcecc446fab32eb16ea9783a5d/Untitled%2021.png)

![FriendZone%20-%2010%2010%2010%20123%20015ed0bcecc446fab32eb16ea9783a5d/Untitled%2022.png](FriendZone%20-%2010%2010%2010%20123%20015ed0bcecc446fab32eb16ea9783a5d/Untitled%2022.png)

its being ran: 

![FriendZone%20-%2010%2010%2010%20123%20015ed0bcecc446fab32eb16ea9783a5d/Untitled%2023.png](FriendZone%20-%2010%2010%2010%20123%20015ed0bcecc446fab32eb16ea9783a5d/Untitled%2023.png)

we can re-write [os.py](http://os.py) lib and add reverse-shell to it since [reporter.py](http://reporter.py) use it in a cron job.

ended up just appending the following line to the file since i was lazy and had trouble getting full shell:

![FriendZone%20-%2010%2010%2010%20123%20015ed0bcecc446fab32eb16ea9783a5d/Untitled%2024.png](FriendZone%20-%2010%2010%2010%20123%20015ed0bcecc446fab32eb16ea9783a5d/Untitled%2024.png)