<?php require APPROOT . "/views/inc/header.php"; ?>
<link rel="stylesheet" href="../public/css/upload.css">
<form action="<?php echo URLROOT; ?>/items/addNewItem" method="post" enctype="multipart/form-data">
  <div class="row">
    <div class="col-md-4 order-md-2 mb-4">
      <h4 class="d-flex justify-content-between align-items-center mb-3">Upload Image</h4>
      <hr class="mb-4">
      <div class="form-group text-center" style="position: relative;" >
        <span class="img-div">
          <div class="text-center img-fluid img-placeholder" onClick="triggerClick()">
            <h4>Select Image</h4>
          </div>
          <img src="../public/img/upload.png" class="img-fluid" onClick="triggerClick()" id="itemDisplay">
        </span>
        <input type="file" name="itemImage" onChange="displayImage(this)" id="itemImage" class="form-control <?php echo (!empty($data['itemImage_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $_FILES['itemImage']; ?>" style="display: none;">
        <span class="invalid-feedback"><?php echo $data['itemImage_err']; ?></span>
      </div>
    </div>

    <div class="col-md-8 order-md-1">
      <h4 class="mb-3">Create Auction Listing</h4>
      <hr class="mb-4">
      <div class="form-group">
        <label for="title">Title <sup class="text-danger font-weight-bolder">*</sup></label>
        <input type="text" name="title" class="form-control form-control-md <?php echo (!empty($data['title_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['title']; ?>">
        <span class="invalid-feedback"><?php echo $data['title_err']; ?></span>
      </div>

      <div class="form-group">
        <label for="subtitle">Subtitle</label>
        <input type="text" name="subtitle" class="form-control form-control-md" value="<?php echo $data['subtitle']; ?>">
      </div>

      <div class="form-group">
        <label for="description">Description <sup class="text-danger font-weight-bolder">*</sup></label>
        <textarea name="description" class="form-control form-control-md <?php echo (!empty($data['description_err'])) ? 'is-invalid' : ''; ?>" rows=3><?php echo $data['description']; ?></textarea>
        <span class="invalid-feedback"><?php echo $data['description_err']; ?></span>
      </div>

      <div class="row">
        <div class="col">
          <div class="form-group">
            <label for="startingBid">Starting Bid <sup class="text-danger font-weight-bolder">*</sup></label>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">$</span>
              </div>
              <input type="text" name="startingBid" class="form-control form-control-md <?php echo (!empty($data['startingBid_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['startingBid']; ?>">
              <span class="invalid-feedback"><?php echo $data['startingBid_err']; ?></span>
            </div>
          </div>
        </div>

        <div class="col">
          <div class="form-group">
            <!-- <label for="reserveBid">Reserve Bid <sup class="text-danger font-weight-bolder">*</sup></label> -->
            <div class="input-group">
              <div class="input-group-prepend">
                <!-- <span class="input-group-text">$</span> -->
              </div>
              <!-- <input type="text" name="reserveBid" class="form-control form-control-md <?php echo (!empty($data['reserveBid_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['reserveBid']; ?>"> -->
              <!-- <span class="invalid-feedback"><?php echo $data['reserveBid_err']; ?></span> -->
            </div>
          </div>
        </div>        
      </div>
      <hr class="mb-4">
      
      <h4 class="mb-3 pt-3">Add Pickup Address</h4>
      <hr class="mb-4">

      <div class="form-group">
        <label for="address">Address <sup class="text-danger font-weight-bolder">*</sup></label>
        <input type="text" name="address" class="form-control form-control-md <?php echo (!empty($data['address_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['address']; ?>">
        <span class="invalid-feedback"><?php echo $data['address_err']; ?></span>
      </div>

      <div class="form-group">
        <label for="address2">Address 2 <span class="text-muted">(Optional)</span></label>
        <input type="text" name="address2" class="form-control form-control-md" value="<?php echo $data['address2']; ?>">
      </div>

      <div class="row">
        <div class="col-md-4 mb-3">
        <label for="country">Country <sup class="text-danger font-weight-bolder">*</sup></label>
          <select name="country" id="country" style="background-image: none;" class="form-control form-control-md <?php echo (!empty($data['country_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['country']; ?>">
          <option value="Select">Select</option>
            <?php foreach($data['countries'] as $country) { ?>
              <option value="<?php echo $country->country ?>" <?php if($data['country']==$country->country): ?> selected="selected" <?php endif; ?>><?php echo $country->country ?></option>
            <?php } ?>
          </select>
          <span class="invalid-feedback"><?php echo $data['country_err']; ?></span>
        </div>

        <div class="col-md-4 mb-3">
        <label for="state">State <sup class="text-danger font-weight-bolder">*</sup></label>
          <select name="state" id="state" style="background-image: none;" class="form-control form-control-md <?php echo (!empty($data['state_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['state']; ?>">
            <option value="Select">Select Country</option>
          </select>
          <span class="invalid-feedback"><?php echo $data['state_err']; ?></span>
        </div>
        
        <div class="col-md-4 mb-3">
          <label for="zip">Zip <sup class="text-danger font-weight-bolder">*</sup></label>
          <input type="text" name="zip" class="form-control form-control-md <?php echo (!empty($data['zip_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['zip']; ?>" >
          <span class="invalid-feedback"><?php echo $data['zip_err']; ?></span>
        </div>
      </div>
      <hr class="mb-4">
      <button class="btn btn-info btn-lg btn-block" type="submit">Add Item for Auction</button>
    </div>
  </div>
</form>
<script src="../public/js/upload.js"></script>
<?php require APPROOT . "/views/inc/footer.php"; ?>

<script>
  $(document).ready(function() {
    $('#country').on('change', function() {
      var country = this.value;
      $.ajax({
        url: "<?php echo URLROOT; ?>/items/getStatesForCountry",
        type: "POST",
        data: {
        country: country
        },
        cache: false,
        success: function(result){
          $("#state").html(result);
        }
      });
    });
  });

  window.onload = function() {
    var country = $("#country").val();
    var state = "<?php echo $data['state'] ?>";
      $.ajax({
        url: "<?php echo URLROOT; ?>/items/getStatesForCountry",
        type: "POST",
        data: {
        state: state,
        country: country
        },
        cache: false,
        success: function(result){
          $("#state").html(result);
        }
      });
    }
</script>

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
        document.getElementById('userID').value = <?php echo $_SESSION['user_id'] ?>;
        document.getElementById('all-notifications').submit();
    }
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