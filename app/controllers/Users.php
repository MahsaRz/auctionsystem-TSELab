<?php
    class Users extends Controller{
        public function __construct(){
            $this->userModel = $this->model('User');
            $this->itemModel = $this->model('Item');
        }

        public function register(){
            // check for post
            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                // sanitize post data
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                // initialize data
                $data = [
                    'name' => trim($_POST['name']),
                    'email' => trim($_POST['email']),
                    'password' => trim($_POST['password']),
                    'confirm_password' => trim($_POST['confirm_password']),
                    'name_err' => '',
                    'email_err' => '',
                    'password_err' => '',
                    'confirm_password_err' => ''
                ];

                // validate email
                if(empty($data['email'])){
                    $data['email_err'] = 'Please enter email';
                }
                else{

                    // check email
                    if($this->userModel->findUserByEmail($data['email'])){
                        $data['email_err'] = 'Email is already registered';
                    }
                }

                // validate name
                if(empty($data['name'])){
                    $data['name_err'] = 'Please enter name';
                }

                // validate password
                if(empty($data['password'])){
                    $data['password_err'] = 'Please enter password';
                }
                elseif(strlen($data['password']) < 6){
                    $data['password_err'] = 'Password must be atleat 6 characters';
                }

                // validate confirm password
                if(empty($data['confirm_password'])){
                    $data['confirm_password_err'] = 'Please confirm password';
                }
                else{
                    if($data['password'] <> $data['confirm_password']){
                        $data['confirm_password_err'] = 'Passwords do not match';
                    }
                }

                // make sure errors are empty
                if(empty($data['email_err']) && empty($data['name_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])){
                    
                    // hash password
                    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
                    
                    // register user
                    if($this->userModel->register($data)){
                        flash('register_success', 'You are now registered. Please log in.');
                        redirect('/users/login');
                    }
                    else{
                        die('Something went wrong');
                    }
                }
                else{

                    // load view with errors
                    $this->view('/users/register', $data);
                }
            }
            else {
                // initialize data
                $data = [
                    'name' => '',
                    'email' => '',
                    'password' => '',
                    'confirm_password' => '',
                    'name_err' => '',
                    'email_err' => '',
                    'password_err' => '',
                    'confirm_password_err' => ''
                ];

                // load view
                $this->view('/users/register', $data);
            }
        }

        public function login(){
            // check for post
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                // process form

                // sanitize post data
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                // initialize data
                $data = [
                    'email' => trim($_POST['email']),
                    'password' => trim($_POST['password']),
                    'email_err' => '',
                    'password_err' => '',
                ];
                
                // validate email
                if(empty($data['email'])){
                    $data['email_err'] = 'Please enter email';
                }
                
                // validate password
                if(empty($data['password'])){
                    $data['password_err'] = 'Please enter password';
                }
                
                // check for user/email
                if(!$this->userModel->findUserByEmail($data['email'])){
                    $data['email_err'] = 'Email not registered';
                }

                // make sure errors are empty
                if(empty($data['email_err']) && empty($data['password_err'])){
                    // check and set logged in user
                    $loggedInUser = $this->userModel->login($data['email'], $data['password']);
                    if($loggedInUser){
                        // create session variables
                        $this->createUserSession($loggedInUser);
                    }
                    else{
                        $data['password_err'] = 'Password incorrect!';
                        $this->view('/users/login', $data);
                    }
                }
                else{

                    // load view with errors
                    $this->view('/users/login', $data);
                }
            }
            else {
                // initialize data
                $data = [
                    'email' => '',
                    'password' => '',
                    'email_err' => '',
                    'password_err' => '',
                ];

                // load view
                $this->view('/users/login', $data);
            }
        }

        public function createUserSession($user){
            $_SESSION['user_id'] = $user->userID;
            $_SESSION['user_email'] = $user->email;
            $_SESSION['user_name'] = $user->name;
            redirect('');       
        }

        public function logout(){
            unset($_SESSION['user_id']);
            unset($_SESSION['user_email']);
            unset($_SESSION['user_name']);
            session_destroy();
            redirect('/users/login');
        }
        public function deregistration(){
            if($this->itemModel -> findBidBybidderID ($_SESSION['user_id'])){
                echo '<script type="text/javascript">'; 
                echo 'alert("You cannot delete your account since you offer a bid!");'; 
                echo 'window.location.href = "../public/index.php";';
                echo '</script>';
            
                
              
            }
            elseif($this->itemModel -> getItemBysellerId ($_SESSION['user_id'])){                

              
                echo '<script type="text/javascript">'; 
                echo 'alert("You cannot delete your account since you offer an auction!");'; 
                echo 'window.location.href = "../public/index.php";';
                echo '</script>';
                
            }

            else{
     
                $this->userModel -> deleteuser ($_SESSION['user_id']);
                unset($_SESSION['user_id']);
                unset($_SESSION['user_email']);
                unset($_SESSION['user_name']);
                session_destroy();
                redirect('/users/login');

               
            }

        }
        public function isLoggedIn(){
            if(isset($_SESSION['user_id'])){
                return true;
            }
            else{
                return false;
            }
        }

        public function getMyAuctions(){

            // sanitize post data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $userID = trim($_POST['myAuctionUserID']);
            $items = $this->itemModel->getMyAuctions($userID);

            $timers = [];
            $dateNow = new DateTime();
            $dateNow = $dateNow->format('Y-m-d H:i:s');
            foreach($items as $item){
                $date  = new DateTime($item->startingDate);
                $date = $date->format('Y-m-d H:i:s');
                $dateDiff = 300 - (abs((strtotime($dateNow) - strtotime($date))) % 300);
                array_push($timers, $dateDiff);
            }

            $data = [
                'items' => $items,
                'timers' => $timers,
                'userID' => $userID
            ];

            $this->view('users/myAuctions', $data);
        }

        public function getMyBids(){

            // sanitize post data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $userID = trim($_POST['myBidUserID']);
            $items = $this->itemModel->getMyBids($userID);

            $timers = [];
            $dateNow = new DateTime();
            $dateNow = $dateNow->format('Y-m-d H:i:s');
            foreach($items as $item){
                $date  = new DateTime($item->startingDate);
                $date = $date->format('Y-m-d H:i:s');
                $dateDiff = 300 - (abs((strtotime($dateNow) - strtotime($date))) % 300);
                array_push($timers, $dateDiff);
            }

            $data = [
                'items' => $items,
                'timers' => $timers,
                'userID' => $userID
            ];

            $this->view('users/myBids', $data);
        }
    }