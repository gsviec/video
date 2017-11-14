
#Change class

- channel to channels
- single-video to posts
#Edit http://gsviec.phanbook.com/watch?v=Qg

##Config
nginx.conf client_max_body_size 50M;
php.ini upload file

Connfig 4 option in file php.ini

upload_max_filesize = 2M
post_max_size = 8M


#Config viddeo laccky

ALTER TABLE `users` ADD `facebook` VARCHAR(50) NULL AFTER `user_notifications_unread`; 

## Fix long text
SET @@global.sql_mode= '';

##GIT PATCH
https://ariejan.net/2009/10/26/how-to-create-and-apply-a-patch-with-git/
git format-patch -1 HEAD --stdout > 0001-last-10-commits.patch
