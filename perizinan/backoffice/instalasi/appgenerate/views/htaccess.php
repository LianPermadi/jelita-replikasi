<IfModule mod_rewrite.c>
#    Options +FollowSymLinks
    RewriteEngine On
    RewriteCond %{REQUEST_FILENAME} -f [OR]
    RewriteCond %{REQUEST_FILENAME} -d
    RewriteRule ^(.+) - [PT,L]
    RewriteRule ^$ <?php echo $path; ?>/index.php [L]
    RewriteRule ^(.*)$ <?php echo $path; ?>/index.php/$1 [L]
</IfModule>

<IfModule !mod_rewrite.c>
    ErrorDocument 404 /index.php
</IfModule>

AddOutputFilterByType DEFLATE text/plain
AddOutputFilterByType DEFLATE text/html
AddOutputFilterByType DEFLATE text/xml
AddOutputFilterByType DEFLATE text/css
AddOutputFilterByType DEFLATE application/xml
AddOutputFilterByType DEFLATE application/xhtml+xml
AddOutputFilterByType DEFLATE application/rss+xml
AddOutputFilterByType DEFLATE application/javascript
AddOutputFilterByType DEFLATE application/x-javascript
