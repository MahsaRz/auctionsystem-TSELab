<!-- <?php require APPROOT . "/views/inc/header.php"; ?> -->

<!-- Custom styles for this view -->
<link href="../public/css/album.css" rel="stylesheet">

<main role="main">
    <div class="album py-5 bg-light">
        <div class="container">
            <div class="row">
                <?php foreach($data['items'] as $product) : ?>
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">

                            <?php 
                            $filename= $product->imageFileName;?>
                            <img src="<?php echo URLROOT; ?>/img/<?php echo $filename?>">
                            
                            <!-- <svg class="bd-placeholder-img card-img-top" width="100%" height="225" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: Thumbnail"><title>Placeholder</title><rect width="100%" height="100%" fill="#55595c"/><text x="50%" y="50%" fill="#eceeef" dy=".3em">Thumbnail</text></svg> -->
                        <div class="card-body">
                            <p class="card-text">Title: <?php echo $product->title; ?></p>
                            <p class="card-text">Description: <?php echo $product->description; ?></p>
                            <p class="card-text">Start Bid: <?php echo $product->startingBid; ?></p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-outline-secondary">
        
                                <a href="<?php echo URLROOT; ?>/items/showproductdetails/<?php echo $product->auctionID;?>">Details</a>
                                
                                
                                </button>
                                </div>
                                <small class="text-muted">9 mins</small>
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