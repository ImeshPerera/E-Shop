<?php
session_start();
require "../connection.php";

$AdSearch  = $_POST["AdSearch"];
$AdCat  = $_POST["AdCat"];
$AdBrd  = $_POST["AdBrd"];
$AdMod  = $_POST["AdMod"];
$AdCon  = $_POST["AdCon"];
$AdClr  = $_POST["AdClr"];
$AdPfr  = $_POST["AdPfr"];
$AdPto  = $_POST["AdPto"];
$page =  $_POST["page"];
$offset = 2*($page-1);

if(empty($AdSearch)){
    $AdSearch = "%";
}
$Query = "SELECT * FROM `product_view` WHERE `title` LIKE '%".$AdSearch."%' "; 

if ($AdCat != 0) {
    $Query.= " AND `category_id` = '".$AdCat."' ";
}
if ($AdBrd != 0) {
    $Query.= "AND `brand_id` = '".$AdBrd."' ";
}
if ($AdMod != 0) {
    $Query.= "AND `model_id` = '".$AdMod."' ";
}
if ($AdCon != 0) {
    $Query.= "AND `condition_id` = '".$AdCon."' ";
}
if ($AdClr !== "0") {
    $Query.= "AND `color_id` = '".$AdClr."' ";
}
if ((!empty($AdPfr)) && (!empty($AdPto))) {
    $Query.= "AND `price` >= '".$AdPfr."' AND `price` <= '".$AdPto."' ";
}elseif((!empty($AdPfr)) && (empty($AdPto))){
    $Query.= "AND `price` >= '".$AdPfr."' ";
}elseif((empty($AdPfr)) && (!empty($AdPto))){
    $Query.= "AND `price` <= '".$AdPto."' ";
}

$SetQuery = $Query;
$ShowQuery = $Query.= "LIMIT 2 OFFSET ".$offset.";";
$AllResultset = Database::search($SetQuery);
$Resultset = Database::search($ShowQuery);

$showProductnm = $Resultset->num_rows;
$allProductnm = $AllResultset->num_rows;
$DividedNumber = $allProductnm/2 ;
$PageNumbers = intval($DividedNumber);
if($allProductnm%2 != 0){
    $PageNumbers = $PageNumbers+1;
}
if($page > $PageNumbers){
    $page = 1;
}

if($showProductnm > 0){
?>

<div class="row justify-content-evenly">
<?php 
    for($Value = 0; $Value < $showProductnm; $Value++){
    $dataofproduct = $Resultset->fetch_assoc(); 
    if($dataofproduct != null){
        $pimage = Database::search("SELECT * FROM `images_view` WHERE `product_id` = '".$dataofproduct["id"]."' LIMIT 1;");
        $imgrow = $pimage->fetch_assoc();
        $Pstatus = Database::search("SELECT * FROM `status` WHERE `id`='".$dataofproduct["status_id"]."';");
        $Prodstatus = $Pstatus->fetch_assoc();
        $EncryId = ((((($dataofproduct["id"]+8736)*1738)+9731)*4873)+58319);
?>
<div class="col-11 col-md-5-5 bg-white border border-2 mt-3">
    <div class="card p-2 height-xl-100">
        <div class="row g-0 height-xl-100">
            <div class="col-12 col-xl-4 d-flex justify-content-center align-items-center">
                <img src="<?php echo $imgrow['code']; ?>" class="round-image2 product-img">
            </div>
            <div class="col-12 col-xl-8 d-flex justify-content-center align-items-center">
                <div class="card-body">
                    <div class="d-flex flex-column g-1 align-items-center">
                        <h5 class="card-title"><?php echo $dataofproduct["title"]; ?></h5>
                        <span class="card-text text-primary">Rs:
                            <?php echo $dataofproduct['price']; ?>.00</span>
                        <span class="card-text text-warning"><?php echo $dataofproduct['qty']; ?> Items
                            Left</span>
                            <span class="card-text text-dark text-center">
                            <?php echo mb_strimwidth($dataofproduct['description'], 0, 82, "..."); ?></span>
                    </div>
                        <div class="row justify-content-between Prodbtn mt-3">
                            <div class="col-6 col-lg-8 offset-lg-2 col-xl-6 offset-xl-0 my-lg-1 my-xl-0 p-0 d-flex justify-content-center">
                                <a href="singleproductview.php?Product=<?php echo $dataofproduct["title"]."&Level=".$EncryId; ?>" class="btn btn-success w-90">Buy Now</a>
                            </div>
                            <div
                                class="col-6 col-lg-8 offset-lg-2 col-xl-6 offset-xl-0 my-lg-1 my-xl-0 p-0 d-flex justify-content-center">
                                <button onclick="AddToCart(<?php echo $dataofproduct['id']; ?>,1);" class="btn btn-danger w-90">Add Cart</button>
                            </div>
                            <p class="card-text text-center my-2"><small class="text-muted">Last updated 3 mins ago</small></p>
                        </div>
                    <!-- </form> -->
                </div>
            </div>
        </div>
    </div>
</div>
<?php
        }
        }
        ?>
</div>
<?php
    $PgnStart = 1;
    if($PageNumbers > 4){
        if($page > $PageNumbers-4){
            $PgnStart = $PageNumbers-4;
            $backFPage = "on" ;
        }
        if($page <= $PageNumbers-4){
            $PgnStart = $page;
        }
        $Pgnlimit = $PgnStart+4;
    }else{
        $PgnStart = 1;
        $Pgnlimit = $PageNumbers;
    }
    ?>
    <div class="row my-3 mt-4">
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center col-gap">
                <li class="page-item <?php if($page == 1){echo "disabled";}else{} ?> "><button onclick="AdvanceSearch('<?php echo $page-1; ?>');" class="page-link">&laquo;</button></li>
                <?php if((isset($backFPage)) && $page > 4){?><li class="page-item page-item-xs-none"><button class="page-link" onclick="AdvanceSearch('1');">1</button></li>
                    <li class="page-item disabled page-item-xs-none"><button class="page-link">...</button></li><?php } ?>
                <?php for($Pgn = $PgnStart; $Pgn <= $Pgnlimit; $Pgn++){ ?>
                <li class="page-item <?php if($Pgn == $page){echo "active point-none";} ?>"><button onclick="AdvanceSearch('<?php echo $Pgn; ?>');" class="page-link"><?php echo $Pgn; ?></a></li>
                <?php } ?>
                <li class="page-item <?php if($page == $PageNumbers){echo "disabled";}else{} ?>"><button onclick="AdvanceSearch('<?php echo $page+1; ?>');" class="page-link">&raquo;</button></li>
            </ul>
        </nav>
    </div>
<?php
}else{
?>
        <div class="row text-center">
            <div class="h4 mt-3 mb-5"><p class="bi bi-cart-x mb-1"></p>Sorry. There was no such product in our shop. Please try another</d>
        </div>

<?php
}