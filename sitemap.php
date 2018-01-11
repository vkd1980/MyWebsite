<?php  
ini_set('max_execution_time', 500);
require_once (__DIR__.'/includes/classes/global.inc.php');
$limit = 10000; 
$page=1;
$filename[]='';
$sql = "SELECT COUNT(products_id) FROM products";  
$rs_result = $db->select($sql);  
$row = mysqli_fetch_row($rs_result);  
$total_records = $row[0];  
$total_pages = ceil($total_records / $limit);  

for ($i=1; $i<=$total_pages; $i++) {  
$start_from = ($i-1) * $limit;
$sqlP= "SELECT products.products_id AS prodid,products.master_categories_id,products.products_name,categories.categories_name,
categories.categories_id
FROM (products
LEFT JOIN categories ON products.master_categories_id = categories.categories_id)
ORDER BY categories.categories_name AND products.products_name LIMIT $start_from, $limit ;";
$result=$db->select($sqlP);
$xmlString = '<?xml version="1.0" encoding="UTF-8"?>
<?xml-stylesheet type="text/xsl" href="stylesheet.xsl"?>
    <urlset 
	xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" 
	xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" 
	xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" 
	xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
        <url>
            <loc>http://www.prabhusbooks.com</loc>
            <lastmod>'.date('Y-m-d').'</lastmod>
            <changefreq>never</changefreq>
            <priority>1.00</priority>
        </url>';
$dom = new DOMDocument;
$dom->preserveWhiteSpace = FALSE;
while ($row = mysqli_fetch_assoc($result)) {  
$xmlString=$xmlString.'<url><loc>http://www.prabhusbooks.com/'.strtolower(preg_replace('#[ -]+#', '-',preg_replace("/[^a-zA-Z0-9\s]/", "",  $row['categories_name']))).'-c-'.$row['master_categories_id'].'/'.strtolower(preg_replace('#[ -]+#', '-',preg_replace("/[^a-zA-Z0-9\s]/", "",  $row['products_name']))).'-p-'.$row['prodid'].'.html</loc><changefreq>never</changefreq>
</url>';

}

$dom->loadXML($xmlString.'</urlset>');
//Save XML as a file
$dom->save('sitemap/sitemap'.$i.'.xml');
$filename[] ='http://www.prabhusbooks.com/sitemap/sitemap'.$i.'.xml';
$xmlString="";
};  

$xmlString = '<?xml version="1.0" encoding="UTF-8"?>
    <sitemapindex 
	xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" 
	xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" 
	xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" 
	xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
$dom = new DOMDocument;
$dom->preserveWhiteSpace = FALSE;

foreach ($filename as $value) {
	$xmlString=$xmlString.'<sitemap><loc>'.$value.'</loc>
	<lastmod>'.date('Y-m-d').'</lastmod>
			</sitemap>';
}
$dom->loadXML($xmlString.'</sitemapindex>');
//Save XML as a file
$dom->save('sitemap.xml');
$xmlString="";
echo 'Sitemaps Saved !';
?>