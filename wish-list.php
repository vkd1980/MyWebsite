<?php
//Maha ganapathaye Namah!
//Bookstore FrontEnd V 1.0
//© I biz Info Solutions
include(__DIR__.'/includes/header.php');
?>
<!-- My Account page -->

<div class="items">
  <div class="container">
    <div class="row">

      <!-- Sidebar navigation -->
      <div class="col-md-3 col-sm-3 hidden-xs">

        <h5 class="title">Pages</h5>
        <!-- Sidebar navigation -->
          <nav>
            <ul id="navi">
              <li><a href="myaccount.php">My Account</a></li>
              <li><a href="wish-list.php">Wish List</a></li>
              <li><a href="order-history.php">Order History</a></li>
              <li><a href="edit-profile.php">Edit Profile</a></li>
            </ul>
          </nav>

      </div>

      <div class="col-md-9 col-sm-9">

        <!-- Main content -->
          <h5 class="title">Wish List</h5>
          
            <table class="table table-striped tcart">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Name</th>
                  <th>Price</th>
                  <th>Quantity</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>1</td>
                  <td><a href="product.php">HTC One</a></td>
                  <td>$530</td>
                  <td>1</td>
                </tr>
                <tr>
                  <td>2</td>
                  <td><a href="product.php">Sony Xperia</a></td>
                  <td>$330</td>
                  <td>2</td>
                </tr>
                <tr>
                  <td>3</td>
                  <td><a href="product.php">Nokia Asha</a></td>
                  <td>$230</td>
                  <td>6</td>
                </tr>  
                <tr>
                  <td>4</td>
                  <td><a href="product.php">Xperia Tipo</a></td>
                  <td>$330</td>
                  <td>2</td>
                </tr>
                <tr>
                  <td>5</td>
                  <td><a href="product.php">Apple iPhone</a></td>
                  <td>$730</td>
                  <td>1</td>
                </tr>
                <tr>
                  <td>6</td>
                  <td><a href="product.php">Windows Mobile</a></td>
                  <td>$130</td>
                  <td>3</td>
                </tr>
                <tr>
                  <td>7</td>
                  <td><a href="product.php">Galaxy SIII</a></td>
                  <td>$430</td>
                  <td>2</td>
                </tr>                                                                                                             
              </tbody>
            </table>

      </div>                                                                    



    </div>
  </div>
</div>
<?php
include(__DIR__.'/includes/footer.php');
?>