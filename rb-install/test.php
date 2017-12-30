<?php
function create_htaccess(){
  //Agradecimiento: http://www.dreamincode.net/forums/topic/214225-php-create-htaccess/page__view__findpost__p__1243819
  $create_name = "../.htaccess";
  // open the .htaccess file for editing
  $file_handle = fopen($create_name, 'w') or die("Error: Can't open file");
  //enter the contents
  $content_string = "# Generado automaticamente por Blackpyro\n";
  //$content_string .= "RewriteEngine On\n";
  $content_string .= "<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteBase /wordpress/
    RewriteRule ^index\.php$ - [L]
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule . /wordpress/index.php [L]
  </IfModule>\n\n";
  // Mas opciones
  $content_string .= '## EXPIRES CACHING ##
  <IfModule mod_expires.c>
  ExpiresActive On
  ExpiresByType image/jpg "access 1 year"
  ExpiresByType image/jpeg "access 1 year"
  ExpiresByType image/gif "access 1 year"
  ExpiresByType image/png "access 1 year"
  ExpiresByType text/css "access 1 month"
  ExpiresByType text/html "access 1 month"
  ExpiresByType application/pdf "access 1 month"
  ExpiresByType text/x-javascript "access 1 month"
  ExpiresByType application/x-shockwave-flash "access 1 month"
  ExpiresByType image/x-icon "access 1 year"
  ExpiresDefault "access 1 month"
  </IfModule>
  ## EXPIRES CACHING ##

  <IfModule mod_gzip.c>
  mod_gzip_on Yes
  mod_gzip_item_include file \.html$
  mod_gzip_item_include file \.php$
  mod_gzip_item_include file \.css$
  mod_gzip_item_include file \.js$
  mod_gzip_item_include mime ^application/javascript$
  mod_gzip_item_include mime ^application/x-javascript$
  mod_gzip_item_include mime ^text/.*
  mod_gzip_item_include handler ^application/x-httpd-php
  mod_gzip_item_exclude mime ^image/.*
  </IfModule>';

  fwrite($file_handle, $content_string);

  // close
  fclose($file_handle);
}
create_htaccess();
?>
