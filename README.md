# EynonMVC - WIP
.NET style MVC for PHP

# Setup
- In **system/config.php**, update your **db_user**, **db_pass*, **db_name**, **db_server**, and your **root_url**
- If your install is somewhere other than the root directory of your website, update the *.htaccess* file in the root directory.

<table>
  <tr>
    <th>Default .htaccess</th>
    <th>Subfolder .htaccess</th>
  </tr>
  <tr>
    <td>
      # For security reasons, Option followsymlinks cannot be overridden.<br />
      #Options +FollowSymlinks -MultiViews<br />
      Options +SymLinksIfOwnerMatch -MultiViews<br />
      RewriteEngine On<br />
      RewriteBase /<br />
      <br />
      RewriteCond %{REQUEST_URI} !^/index.php<br />
      RewriteCond %{REQUEST_URI} !^/favicon.ico<br />
      RewriteRule ^(.*) /index.php?path=$1 [L,QSA]<br />
    </td>
    <td>
      # For security reasons, Option followsymlinks cannot be overridden.<br />
      #Options +FollowSymlinks -MultiViews<br />
      Options +SymLinksIfOwnerMatch -MultiViews<br />
      RewriteEngine On<br />
      RewriteBase /<br />
      <br />
      RewriteCond %{REQUEST_URI} !^/index.php<br />
      RewriteCond %{REQUEST_URI} !^/favicon.ico<br />
      RewriteRule ^(.*) /index.php?path=$1 [L,QSA]
    </td>
  </tr>
</table>

# View Controllers
View Controllers will be called according to the path on the web page. The .htaccess file will convert the path:
**MyWebsite/Home/** to **HomeViewController**. If the request was made via HTTP GET, it would call **Default_GET** on the home view controller.

# Views
Views are stored in **system/View/Templates/VIEWGROUPNAME/**.
The view that will be used is currently defined in the root view controller, although that will likely be moved shortly.

