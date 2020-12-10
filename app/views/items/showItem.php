<?php require APPROOT . "/views/inc/header.php"; ?>

<!DOCTYPE html>
<html>
	<head>
		<style>
			table, th, td {
                /* border: 2px solid black; */
                
                padding: 5px;}
		</style>
	
	</head>
	<body>

<!-- Show all the information about the selected auction in table -->

<h3 style="font-size: 50px"> <?php echo $data['items']->title; ?> </h3>

<div class="container-fluid">

<div class="row">
	<div class="col-md-7">
				<table class="table table-striped table-bordered table-hover table-condensed" style= "width: 100%;" >

				<tr><th>Start Biding:</th><td><?php echo $data['items']->startingBid ?>$</td><td rowspan=4><img style="width: 230px; height:280px" src="<?php echo URLROOT; ?>/img/<?php echo $data['items']->imageFileName;?>"></td></tr>
				<tr><th>Description:</th><td style="word-wrap: break-word"><?php echo $data['items']->description ?></td></tr>
				<tr><th>Owner:</th><td><span style="word-break:break-all;"><?php echo $data['user']-> name?></span></td></tr>
                <tr><th>Email:</th><td> <span style="word-break:break-all;"><?php echo $data['user']-> email?></span></td></tr>
				
				</table>
    </div>
    
	<div class="col-md-5">
		<dl class="dl-horizontal">
			<dt>
				<h4><b>Time Remaining:</b></h4>
			</dt>
			<dd>
            <?php if ($data['items']->isActive == 1) { ?>
				<h4><small class="timerSlot text-muted" id="<?php $data['items']->auctionID ?>Timer"></small></h4>
            <?php }
            else{
                echo "0 Min 0 Sec";
            }?>
			</dd>
            <?php if($data['items']-> isActive ==1){?>
		<dt><form method="post">
        <div class="input-group">
        <div class="input-group-prepend">
                <span class="input-group-text">$</span>
              </div>
			<input name="amount" type="text" required class="form-control" placeholder="Bidding Amount"></dt> 
		<dd><input class="btn btn-success btn-default btn-block" type="submit" name="submit" value="Submit Bid" />
        
        
		
		</dd>
        </form>
            <?php } ?>
        <br>
		<?php 
	


		?>  
		<?php if (isset($_SESSION['user_id']) && $data['items']-> isActive ==1){?>
		<dt>
				<h4><b>Current Price:</b></h4>
			</dt>
			<dd>
				<h4>
				<?php
					$id = $data['items']->auctionID;
					$bidderid = $_SESSION['user_id'];
					$count = 1;

             
                        echo '
                        
				<table class="table table-striped table-bordered table-hover table-condensed" style="width:100%">
					<tr class="info">
						<th>S.No.</th>
						<th>UserID</th>
						<th>USER</th>
						<th>PRICE</th>
					</tr>';

					foreach($data['bids'] as $bid):  

							echo "
								<tr>
									<td>" . $count . "</td><td>" . $bid -> bidderID . "</td><td>" . $bid -> Name . "</td><td>" . $bid -> amount  . "</td>
								</tr>";
							$count++;
					endforeach; 

						echo "
				</table>
				";
               
				?>
				</h4>
			</dd> </dl>
			 <?php }?>
	</div>
</div>
</div>		

</div>

<?php require APPROOT . "/views/inc/footer.php"; ?>
	</body>

</html>







<script>
    var timers = <?php echo json_encode($data['timers']); ?>;
    console.log(timers);
    $( document ).ready( function() {
        $("small.timerSlot").each(function(index, value){

            // Update the count down every 1 second
            setInterval(function() {
            
                timers[index] = timers[index] - 1;

                // Time calculations for days, hours, minutes and seconds
                var minutes = Math.floor(timers[index] / 60);
                var seconds = timers[index] % 60;

                // Display the result in the element with id="demo"
                document.getElementById(value.id).innerHTML = minutes + " min " + seconds + " sec ";
                
                // If the count down is finished, restart window
                if (timers[index] == 0) {
                    timers[index] = 300;
                }
            }, 1000);
        });
    });
</script>

<script>
    $(document).ready(function() {
        setInterval(function() {
            $.ajax({
                url: "<?php echo URLROOT; ?>/items/getItemStatus",
                type: "POST",
                data: {},
                cache: false,
                success: function(result){
                    var result = $.parseJSON(result);
                    $.each(result, function(index, value){
                        if(value[2] == 1){
                            $('#'.concat(value[0]).concat("Card")).show();
                            document.getElementById((value[0]).concat("Amount")).innerHTML = "Highest Bid: $".concat(value[5]);
                        }
                        else{
                            $('#'.concat(value[0]).concat("Card")).hide();
                        }
                    });
                }
            });
        }, 5000);
    });
</script>

<script>
    $(document).ready(function() {
        refreshNotifications(0);
        setInterval(function() {
            refreshNotifications(0);
        }, 1000);
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