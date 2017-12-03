<?php
$menu_category = array();
$menu_manufacture=array();
$menuresult_category =$db->select("Select * from categories order by categories_name " );
$menuresult_manufacture =$db->select("Select manufacturers_id,manufacturers_name from manufacturers order by manufacturers_name " );
while($row = mysqli_fetch_assoc($menuresult_manufacture))
{
$menu_manufacture[] = $row;
}
while($row = mysqli_fetch_assoc($menuresult_category))
{
$menu_category[] = $row;
}
function bootstrap_menu($array,$parent_id = 0,$parents = array())
{
if($parent_id==0)
{
foreach ($array as $element) {
if (($element['parent_id'] != 0) && !in_array($element['parent_id'],$parents)) {
$parents[] = $element['parent_id'];
}
}
}
$menu_html = '';
foreach($array as $element)
{
if($element['parent_id']==$parent_id)
{
if(in_array($element['categories_id'],$parents))
{
$menu_html .= '<li class="menu-item dropdown dropdown-submenu">';
$menu_html .= '<a href="/'.strtolower(preg_replace('#[ -]+#', '-',preg_replace("/[^a-zA-Z0-9\s]/", "",  $element['categories_name']))).'-c-'.$element['categories_id'] .'.html"class="dropdown-toggle disabled" data-toggle="dropdown"  ><h7>'.strtoupper($element['categories_name']).'</h7></a>';
}
else {
$menu_html .= '<li class="menu-item ">';
$menu_html .= '<a href="/'.strtolower(preg_replace('#[ -]+#', '-',preg_replace("/[^a-zA-Z0-9\s]/", "",  $element['categories_name']))).'-c-'.$element['categories_id'] .'.html"><h7>' . strtoupper($element['categories_name']) . '</h7></a>';
}
if(in_array($element['categories_id'],$parents))
{
$menu_html .= '<ul class="dropdown-menu"  >';
$menu_html .= bootstrap_menu($array, $element['categories_id'], $parents);
$menu_html .= '</ul>';
}
$menu_html .= '</li>';
}
}
return $menu_html;
}
function buildManufactureMenu($array) {
$html = "";
foreach($array as $elementt){
$html .= '<li class="menu-item ">';
$html .= '<a href="/'.strtolower(preg_replace('#[ -]+#', '-',preg_replace("/[^a-zA-Z0-9\s]/", "",  $elementt['manufacturers_name']))).'-m-'.$elementt['manufacturers_id']. '.html"><h7>' . strtoupper($elementt['manufacturers_name']) . '</h7></a>';
}
return $html;
}	?>
<!-- Navigation -->

<div class="navbar  bs-docs-nav " role="banner" >
  <div class="container">
    <div class="navbar-header">
      <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".bs-navbar-collapse"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
    </div>
    <nav class="collapse navbar-collapse bs-navbar-collapse" role="navigation">
      <ul class="nav navbar-nav">
        <li class=" dropdown"> <a href="/index.html" ><span class="fa fa-home"></span> Home </b></a> </li>
        <!----start--------------->
        <!--end ------------------>
        <li class="dropdown"><a href="/categories.html" class="dropdown-toggle" data-toggle="dropdown" > Categories <b class="caret"></b></a>
          <ul class='dropdown-menu'>
            <?php
//$top_menu = bootstrap_menu($menu);
echo bootstrap_menu($menu_category);
?>
          </ul>
        </li>
        <li class="dropdown"><a href="/manufacturers.html" class="dropdown-toggle" data-toggle="dropdown" > Publishers <b class="caret"></b></a>
          <ul class='dropdown-menu'>
            <?php
//$top_menu = bootstrap_menu($menu);
echo buildManufactureMenu($menu_manufacture);
?>
          </ul>
        </li>
        <!------------------->
        <li><a href="../support.html">Support</a></li>
        <li><a href="../contact.html">Contact</a></li>
        <a href="../sitemap.html"style="color:#5eb2d9">sitemap</a>
		  <li><a href="../search.html">Search</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <?php
if(isset($_SESSION['logged_in'])) {
echo '<li class="dropdown">
<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="fa fa-user 2X"></span>  Account <b class="caret"></b></a>
<ul class="dropdown-menu">
<li><a href="../myaccount.html"><h7>My Account</h7></a></li>
<li><a href="../checkout.html"><h7>Checkout</h7></a></li>
<!--<li><a href="../view-cart.php">View Cart</a></li>
<li><a href="../wish-list.php">Wish List</a></li>
<li><a href="../order-history.php">Order History</a></li>-->
<li><a href="../myprofile.html"><h7>Edit Profile</h7></a></li>
</ul>
</li> <li ><a href="../logout.html" ><span class="fa fa-sign-out"></span> Log Out </a></li>' ;
}
else{
echo'<li ><a href="../signup.html" data-toggle="modal"><span class="fa fa-user-plus"></span> Sign Up</a></li>
<li><a href="../login.html?camefrom='.$actual_link.'"><span class="fa fa-sign-in"></span>  Login</a></li>';
}
?>
      </ul>
    </nav>
  </div>
</div>
<!--/ Navigation End -->
