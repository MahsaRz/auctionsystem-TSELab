<?php
    class Auctions extends Controller{
        public function __construct(){
            $this->auctionModel = $this->model('Auction');
        }

        public function reviseAuctionStatus(){

            // get all auction items' status
            $items = $this->auctionModel->getActiveItemsAndBids();

            // initialize current date and time
            $dateNow = new DateTime();
            $dateNow = $dateNow->format('Y-m-d H:i:s');

            foreach($items as $item){
                
                // derive time elapsed since auction creation
                $date  = new DateTime($item->startingDate);
                $date = $date->format('Y-m-d H:i:s');
                $dateDiff = abs(strtotime($dateNow) - strtotime($date));
                
                if($dateDiff > 300){
                    $updateStatus = $this->auctionModel->markSoldAndUpdateDetails($item) ;
                    if($updateStatus){
                        $this->auctionModel->generateSoldNotifications($item);
                    }
                }
            }

            redirect('');
        }
    }