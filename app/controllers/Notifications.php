<?php
    class Notifications extends Controller{
        public function __construct(){
            $this->notificationModel = $this->model('Notification');
        }

        public function getNotifications(){

            if($_SERVER['REQUEST_METHOD'] == 'POST'){
            
                // sanitize post data
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                $userID = trim($_POST['userID']);
                $isSeen = trim($_POST['isSeen']);

                if($isSeen == 1){

                    //mark notificaton read
                    $data = $this->notificationModel->setCommentsRead($userID);
                }
                else{

                    // get notifications' count and notifications
                    $data = [
                        "count" => $this->notificationModel->getUnseenCount($userID),
                        "records" => $this->notificationModel->getNotifications($userID),
                    ];
                    $this->view('notifications/notificationDropdown', $data);
                }
            }
        }

        public function getAllNotifications(){

            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                // sanitize post data
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                $userID = trim($_POST['notificationUserID']);
                $data = ["records" => $this->notificationModel->getAllNotifications($userID)];
                $this->view('notifications/allNotifications', $data);
            }
        }
    }