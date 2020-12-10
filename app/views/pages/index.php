<?php require APPROOT . "/views/inc/header.php"; ?>
    <!-- Custom styles for this view -->
    <link href="css/album.css" rel="stylesheet">

    <div class = "jumbotron jumbotron-flud text-center">
        <div class="container">
            <?php flash('register_success') ?>
            <h1 class = "display-3"><?php echo $data['title'];?></h1>
            <p class="lead"><?php echo $data['description']; ?></p>  
        </div>
    </div>

    <main role="main">
        <div class="album py-5 bg-light">
            <div class="container">
                <div class="row">
                    <?php foreach($data['items'] as $item) : ?>
                    <div class="col-md-4" id="<?php echo $item->auctionID ?>Card">
                        <div class="card mb-4 shadow-sm">
                            <div class="text-center">
                                <img style="height: 250px; width: auto;" class="mx-auto m-3 rounded img-thumbnail" src="img/<?php echo $item->imageFileName; ?>">
                            </div>
                            <hr class="m-1">
                            <div class="card-body">
                                <h6 class="card-title"><?php echo $item->title; ?></h6>
                                <!-- <p class="card-text text-secondary text-justify" style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical;"> 
                                    <?php echo $item->description; ?>
                                </p> -->
                                <p class="amountSlot text-info" id="<?php echo $item->auctionID ?>Amount">Highest Bid: $<?php echo $item->amount; ?></p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="btn-group">
                                    <a class="btn btn-sm btn-outline-secondary" href="<?php echo URLROOT; ?>/items/showItem/<?php echo $item->auctionID;?>">Visit Auction</a>
                                    </div>
                                    <small class="timerSlot text-muted" id="<?php echo $item->auctionID ?>Timer"></small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </main>

<?php require APPROOT . "/views/inc/footer.php"; ?>

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