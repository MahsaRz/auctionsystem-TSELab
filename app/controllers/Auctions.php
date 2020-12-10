<?php
    class Auctions extends Controller{

        public function __construct(){
            $this->auctionModel = $this->model('Auction');
            $this->itemModel = $this->model('Item');
        }

        public function index(){

            // get all auction products
            $items = $this->itemModel->getItems();

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
                'title' => 'Auction System',
                'description' => 'Auction Your Products. Bid And Buy.',
                'items' => $items,
                'timers' => $timers
            ];
            
            $this->view('auctions/reviseAuctionStatus', $data);
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