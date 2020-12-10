<?php require APPROOT . "/views/inc/header.php"; ?>

<main role="main" class="container">
  <div class="d-flex align-items-center p-3 mt-4 mb-3 text-white bg-info rounded shadow-sm">
      <h6 class="mb-0 text-white">Notifications</h6>
  </div>

  <?php foreach($data['records'] as $record) : ?>

  <div class="my-3 p-3 bg-white rounded shadow-sm">
    <div class="media text-muted pt-3">
      <p class="media-body pb-3 mb-0">
        <strong class="d-block text-gray-dark"><?php echo $record->type.": ".$record->title ?></strong>

        <?php if ($record->type == "Item Sold") {?>
            <?php echo "Sold to: ".$record->buyerName; ?>
            <br>
            <?php echo "Selling Price: $".$record->buyPrice; ?>
            <br>
            <?php echo "Buyer's Email Address: ".$record->buyerEmail; ?>
            <br>
            <small class="float-right"><?php echo $record->soldAt; ?></small>
        <?php } elseif ($record->type == "Bid Won") {?>
            <?php echo "Final Bid Price: $".$record->buyPrice; ?>
            <br>
            <?php echo "Seller's Name: ".$record->sellerName; ?>
            <br>
            <?php echo "Seller's Email Address: ".$record->sellerEmail; ?>
            <br>
            <?php echo "Item Pickup Address: ".$record->pickupAddress1.", " ?>
            <?php echo $record->pickupAddress2 == "" ? "" : $record->pickupAddress2.", " ; ?>
            <?php echo $record->pickupState.", ".$record->pickupCountry." - ".$record->pickupZip; ?>
            <br>
            <small class="float-right"><?php echo $record->soldAt; ?></small>
        <?php } ?> 
      </p>
    </div>
  </div>

  <?php endforeach; ?>

</main>

<?php require APPROOT . "/views/inc/footer.php"; ?>

<script>
    $(document).ready(function() {
        refreshNotifications(0);
        setInterval(function() {
            refreshNotifications(0);
        }, 10000);
    });

    function refreshNotifications(isSeen){
        $.ajax({
                url: "<?php echo URLROOT; ?>/notifications/getNotifications",
                type: "POST",
                data: {
                    userID:"<?php echo $_SESSION['user_id']?>",
                    isSeen:isSeen
                    },
                dataType:"json",
                cache: false,
                success: function(result){
                    $(".dropdown-menu").html(result.output);
                    $(".notification-count").html(result.outputLen);
                }
            });
    }

    $('.dropdown-toggle').on("click", function (){
        console.log("click run")
        $('.notification-count').html('');
        refreshNotifications(1);
    });

</script>

<script>
    function getAllNotifications(){
        document.getElementById('notificationUserID').value = <?php echo $_SESSION['user_id'] ?>;
        document.getElementById('all-notifications').submit();
    }
    function getMyAuctions(){
        document.getElementById('myAuctionUserID').value = <?php echo $_SESSION['user_id'] ?>;
        document.getElementById('my-auctions').submit();
    }
    function getMyBids(){
        document.getElementById('myBidUserID').value = <?php echo $_SESSION['user_id'] ?>;
        document.getElementById('my-bids').submit();
    }
</script>