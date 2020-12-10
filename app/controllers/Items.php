<?php
    class Items extends Controller{
        public function __construct(){
            $this->itemModel = $this->model('Item');
            $this->userModel = $this->model('User');
            // $this->bidModel = $this->model('Bid');
            $this->countries = $this->itemModel->getCountries();
        }

        public function addNewItem(){
            // check for post
            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                // sanitize post data
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                // initialize data
                $data = [
                    'title' => trim($_POST['title']),
                    'subtitle' => trim($_POST['subtitle']),
                    'description' => trim($_POST['description']),
                    'startingBid' => trim($_POST['startingBid']),
                    // 'reserveBid' => trim($_POST['reserveBid']),
                    'address' => trim($_POST['address']),
                    'address2' => trim($_POST['address2']),
                    'country' => trim($_POST['country']),
                    'state' => trim($_POST['state']),
                    'zip' => trim($_POST['zip']),
                    'imageFileName' => '',
                    'title_err' => '',
                    'description_err' => '',
                    'startingBid_err' => '',
                    // 'reserveBid_err' => '',
                    'address_err' => '',
                    'country_err' => '',
                    'state_err' => '',
                    'zip_err' => '',
                    'countries' => $this->countries,
                    'itemImageError' => '',
                ];

                // validate title
                if(empty($data['title'])){
                    $data['title_err'] = 'Please enter title for the item';
                }

                // validate description
                if(empty($data['description'])){
                    $data['description_err'] = 'Please enter description for the item';
                }
                else{
                    if(strlen($data['description']) < 100){
                        $data['description_err'] = 'Description should be at leat 100 characters';
                    }
                }

                // validate starting bid
                if(empty($data['startingBid'])){
                    $data['startingBid_err'] = 'Please enter starting bid';
                }

                // validate reserve bid
                // if(empty($data['reserveBid'])){
                //     $data['reserveBid_err'] = 'Please enter reserve bid';
                // }
                
                // validate address
                if(empty($data['address'])){
                    $data['address_err'] = 'Please enter pickup address';
                }

                // validate country
                if($data['country'] == 'Select'){
                    $data['country_err'] = 'Please select country';
                }

                // validate state
                if($data['state'] == 'Select Country' or $data['state'] == 'Select'){
                    $data['state_err'] = 'Please select state';
                }

                // validate zip
                if(empty($data['zip'])){
                    $data['zip_err'] = 'Please enter zip code';
                }

                // validate file
                if(empty($_FILES["itemImage"]["name"])){
                    $data['itemImage_err'] = 'Please select an image for the item';
                }
                else{
                    if($_FILES['itemImage']['size'] > 500000) {
                        $data['itemImage_err'] = "Image size should not be greated than 500Kb";
                      }
                      else{
                        $data['imageFileName'] = time() . '-' . $_FILES["itemImage"]["name"];
                      }
                }

                // make sure errors are empty
                if(empty($data['title_err']) && empty($data['description_err']) && empty($data['startingBid_err']) &&  empty($data['address_err']) && empty($data['country_err']) && empty($data['state_err']) && empty($data['zip_err']) && empty($data['itemImage_err'])){
                    if(move_uploaded_file($_FILES["itemImage"]["tmp_name"], PROJECTROOT . '/public/img/' . $data['imageFileName'])) {
                        if($this->itemModel->addNewItem($data)){
                            flash('listing_success', 'The item has been added for auction.');
                            redirect('');
                        }
                        else{
                            die('Something went wrong');
                        }
                    }
                }
                else{

                    // load view with errors
                    $this->view('/items/addNewItem', $data);
                }
            }
            else {
                // initialize data
                $data = [
                    'title' => '',
                    'subtitle' => '',
                    'description' => '',
                    'startingBid' => '',
                    // 'reserveBid' => '',
                    'address' => '',
                    'address2' => '',
                    'country' => '',
                    'state' => '',
                    'zip' => '',
                    'imageFileName' => '',
                    'title_err' => '',
                    'description_err' => '',
                    'startingBid_err' => '',
                    // 'reserveBid_err' => '',
                    'address_err' => '',
                    'country_err' => '',
                    'state_err' => '',
                    'zip_err' => '',
                    'countries' => $this->countries,
                    'itemImageError' => '',
                ];

                // load view
                $this->view('/items/addNewItem', $data);
            }
        }
      
        public function getStatesForCountry(){
            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                // sanitize post data
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                $country = trim($_POST['country']);
                $data = [
                    'state' => trim($_POST['state']),
                    'states' => $this->itemModel->getStatesForCountry($country)
                ];
                $this->view('/items/stateList', $data); 
            }
        }

        public function getItemStatus(){

            // get all auction items' status
            $items = $this->itemModel->getItemStatus();
            $data = $items;
            $this->view('/items/getItemStatus', $data);
        }

        public function createUserSession($user){
            $_SESSION['user_id'] = $user->userID;
            $_SESSION['user_email'] = $user->email;
            $_SESSION['user_name'] = $user->name;
            redirect('');       
        }
        
        public function showItem($id){
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $this->addNewBid($id);}
            $items = $this->itemModel->getItemById($id);
            $user = $this->userModel->getUserById($items->sellerID);
            // $bids = $this->itemModel->findBidByauctionID($id);
            $bids = $this->itemModel->getBids($id);
            $items2 = $this->itemModel->getItems();
            $timers = [];
            $dateNow = new DateTime();
            $dateNow = $dateNow->format('Y-m-d H:i:s');
            foreach($items2 as $item){
                $date  = new DateTime($item->startingDate);
                $date = $date->format('Y-m-d H:i:s');
                $dateDiff = 300 - (abs((strtotime($dateNow) - strtotime($date))) % 300);
                array_push($timers, $dateDiff);
            }
            $data = [
              'items' => $items,
              'user' => $user,
              'bids' => $bids,
              'timers' => $timers
            ];
            $this->view('items/showItem', $data);
          }

          public function addNewBid($id){
            $items = $this->itemModel->getItemById($id);
            $rows=$this->itemModel->findBidByauctionID($id);
            $flag=0;
            // check for post
            if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_name'])){
                if(trim($_POST['amount']) > $items->startingBid){
                    // sanitize post data
                    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                    // var_dump ($_POST);
                    // initialize data
                    $data = [
                        'amount' => trim($_POST['amount']),
                        'items' => $items,
                    ];
                    
                foreach($rows as $row) :
                    
                    if( $row -> amount == trim($_POST['amount'] ) ||  
                    ($row -> amount == trim($_POST['amount'] ) && $row -> Name == $_SESSION['user_name'])){
                        $flag = 1;
                    }
                    if($row -> amount > trim($_POST['amount'])){
                        $flag = -1;
                        
                    }
                    if(  ($row -> amount < trim($_POST['amount'] ) && $row -> Name == $_SESSION['user_name'] && $row -> bidderID == $_SESSION['user_id']) ){
                        $flag = 2;
                    }
                            
                endforeach;
                        
                if ($flag == 0) {
                    echo "<script type='text/javascript'>alert('Successful')</script>";
                    $this->itemModel->addNewBid($data);
                }
                elseif($flag == 1){
                    echo "<script type='text/javascript'>alert('Already Exist!')</script>";

                }
                elseif($flag == -1 ){
                    echo "<script type='text/javascript'>alert('Amount is less then current price!')</script>";

                }
                elseif($flag == 2 ){
                    echo "<script type='text/javascript'>alert('Your new bid is saved!')</script>";
                    $this->itemModel->updateNewBid($data);

                }
                
                
            }
            else{ 
                echo "<script type='text/javascript'>alert('Amount is less then current price!')</script>";
            }
            }

            elseif ($_SERVER['REQUEST_METHOD'] == 'POST' &&!isset($_SESSION['user_name'])) {
                echo "<script type='text/javascript'>alert('Please login first!')</script>";
            }
            else {
                // initialize data
                $data = [
                    'amount' => '',
                    'amount_err' => '',
                    
                ];
    
                // load view
                $this->view('/items/showItem', $data);
            }
          
            }
       
}