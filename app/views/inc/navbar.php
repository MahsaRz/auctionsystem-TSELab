<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-3">
    <a class="navbar-brand" href="<?php echo URLROOT ?>"><?php echo SITENAME; ?></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="<?php echo URLROOT ?>">Home</a>
            </li>
            <?php if(isset($_SESSION['user_id'])) : ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo URLROOT; ?>/items/addNewItem">Sell</a>
                </li>
                <li class="nav-item">
                    <form id="my-auctions" action="<?php echo URLROOT; ?>/users/getMyAuctions" method="post">
                        <input id="myAuctionUserID" name="myAuctionUserID" type="hidden">
                        <a class="nav-link" href="#" onclick="getMyAuctions()">My Auctions</a>
                    </form>
                </li>
                <li class="nav-item">
                    <form id="my-bids" action="<?php echo URLROOT; ?>/users/getMyBids" method="post">
                        <input id="myBidUserID" name="myBidUserID" type="hidden">
                        <a class="nav-link" href="#" onclick="getMyBids()">My Bids</a>
                    </form>
                </li>
                
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Notifications <span class="notification-count text-white"></span>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dropdown01">
                        <form id="all-notifications" action="<?php echo URLROOT; ?>/notifications/getAllNotifications" method="post">
                            <input id="notificationUserID" name="notificationUserID" type="hidden">
                            <a class="dropdown-item text-primary" href="#" onclick="getAllNotifications()">See all notifications</a>
                        </form>
                    </ul>
                </li>
            <?php endif; ?>
        </ul>

        <ul class="navbar-nav ml-auto">
            <?php if(isset($_SESSION['user_id'])) : ?>
                
      
                <li class="nav-item">
                    <a class="nav-link" style="color:white;">Welcome <?php echo ($_SESSION['user_name'])?> </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo URLROOT; ?>/users/logout">Logout</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" onclick="return confirm('Are you sure you want to delete your account?');" href="<?php echo URLROOT; ?>/users/deregistration">Delete My Account</a>
  
                </li>
            <?php else : ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo URLROOT; ?>/users/register">Register</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo URLROOT; ?>/users/login">Login</a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>