<?php
    class Pages extends Controller {
        public function __construct(){
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

            $this->view('pages/index', $data);
        }

        public function about(){
            $data = [
                'title' => 'About Us',
                'description' => 'Application to put items auction'
            ];
            $this->view('pages/about', $data);
        }
    }