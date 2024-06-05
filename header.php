<div class="row bg-light pt-2 pb-2">
    <div class="col-12">
        <nav class="nav d-block align-content-center Head-nav">
            <div class="ms-md-2 my-2 my-md-0 d-flex justify-content-evenly">
                <button class='btn btn-light mx-md-2 m80' <?php if(isset($_SESSION["user"])){?> onclick="window.location = 'home.php';"><b>Welcome&nbsp;
                </b><?php echo mb_strimwidth($_SESSION["user"]["fname"], 0, 18, "..");}else{?>' onclick="window.location = 'index.php?Sign_In';"><a class="link4">
                    Sign In / Register</a><?php } ?></button>
                <a class="btn btn-light mx-md-2 m80" href="messages.php">Help and Contact</a>
                <button onclick="SignOut();" class="btn btn-light mx-md-2 m80">Sign Out</button>
            </div>
            <div class="me-md-2 my-2 my-md-0 d-flex justify-content-evenly">
                <button onclick="gotoAddProduct();" class="btn btn-light mx-md-2 m80">Sell</button>
                <div class="dropdown d-flex d-md-inline mx-md-2 bg-light p-0 m80">
                    <button class="btn btn-light  m-auto dropdown-toggle" type="button" id="dropdownMenuButton0"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        My eShop
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton0">
                        <li><a class="dropdown-item" href="watchlist.php">Wishlist</a></li>
                        <li><a class="dropdown-item" href="purchasehistory.php">Purchase History</a></li>
                        <li><a class="dropdown-item" href="messages.php">Massage</a></li>
                        <li><a class="dropdown-item" href="recent.php">Recent</a></li>
                        <li><a class="dropdown-item" href="userprofile.php">My Profile</a></li>
                        <li><a class="dropdown-item" href="sellproductview.php">My Sellings</a></li>
                    </ul>
                </div>
                <button class="btn btn-light mx-md-2 m-0 p-0 m80">
                    <li class="mx-md-2 list-inline-item text-dark">
                        <a class="bi bi-cart4" href="cart.php"></a>
                    </li>
                </button>
            </div>
        </nav>
    </div>
</div>