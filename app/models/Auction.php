<?php
    class Auction{
        private $db;

        public function __construct(){
            $this->db = new Database;
        }

        public function getActiveItemsAndBids(){

            // define query
            $this->db->query("SELECT auctions.auctionID, auctions.sellerID, auctions.title, auctions.startingDate, bids.bidID, bids.bidderID, bids.amount
                                FROM
                                    auctions as auctions
                                LEFT OUTER JOIN
                                    (SELECT bidID, bidderID, auctionID, amount
                                    FROM
                                        (SELECT *, RANK() OVER (PARTITION BY auctionID ORDER BY amount DESC, bidTime DESC) AS rank
                                        FROM bids) as bids
                                    WHERE rank = 1) as bids
                                    ON
                                        auctions.auctionID = bids.auctionID
                                    WHERE
                                        auctions.isActive = 1  and bids.bidID IS NOT NULL");
            
            // execute
            return $this->db->resultSet();
          }

          public function markSoldAndUpdateDetails($item){

            // define query
            $this->db->query("UPDATE auctions
                                SET buyerID = :buyerID, buyPrice = :buyPrice, endingDate = NOW(), isActive = 0
                                WHERE auctions.auctionID = :auctionID");

            // bind values
            $this->db->bind(':buyerID', $item->bidderID);
            $this->db->bind(':buyPrice', $item->amount);
            $this->db->bind(':auctionID', $item->auctionID);

            // execute
            if($this->db->execute()){
                
                return true;
            }
            else{
                return false;
            }
          }

          public function generateSoldNotifications($item){

            // define query
            $this->db->query("INSERT INTO notifications (type, auctionID, receiverID) VALUES(:type, :auctionID, :receiverID)");
            
            // bind values for seller
            $this->db->bind(':type', 'Item Sold');
            $this->db->bind(':auctionID', $item->auctionID);
            $this->db->bind(':receiverID', $item->sellerID);
            
            // execute to generate notification for seller
            $this->db->execute();

            // bind values for seller
            $this->db->bind(':type', 'Bid Won');
            $this->db->bind(':auctionID', $item->auctionID);
            $this->db->bind(':receiverID', $item->bidderID);
            
            // execute to generate notification for buyer
            $this->db->execute();
                      
          }
    }