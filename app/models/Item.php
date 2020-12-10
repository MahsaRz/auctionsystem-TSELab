<?php
    class Item{
        private $db;

        public function __construct(){
            $this->db = new Database;
        }

        // get all items
        public function getAllItems(){
            $this->db->query("SELECT * FROM auctions");
            return $this->db->resultSet();            
          }

        // add item
        public function addNewItem($data){

            $this->db->query('INSERT INTO auctions (sellerID, title, subtitle, description, startingBid, address, address2, country, state, zip, imageFileName) 
            VALUES(:sellerID, :title, :subtitle, :description, :startingBid, :address, :address2, :country, :state, :zip, :imageFileName)');
            
            // bind values
            $this->db->bind(':sellerID', $_SESSION['user_id']);
            $this->db->bind(':title', $data['title']);
            $this->db->bind(':subtitle', $data['subtitle']);
            $this->db->bind(':description', $data['description']);
            $this->db->bind(':startingBid', $data['startingBid']);
            // $this->db->bind(':reserveBid', $data['reserveBid']);
            $this->db->bind(':address', $data['address']);
            $this->db->bind(':address2', $data['address2']);
            $this->db->bind(':country', $data['country']);
            $this->db->bind(':state', $data['state']);
            $this->db->bind(':zip', $data['zip']);
            $this->db->bind(':imageFileName', $data['imageFileName']);
            
            // execute
            if($this->db->execute()){
                return true;
            }
            else{
                return false;
            }
        }

        public function getCountries(){
            $this->db->query('SELECT DISTINCT country FROM countries');

            // execute
            $countries = $this->db->resultSet();

            // check rows
            if($this->db->rowCount() > 0){
                return $countries;
            }
            else{
                return false;
            }
        }

        public function getStatesForCountry($country){
            $this->db->query('SELECT state FROM countries WHERE country = :country');
            
            // bind values
            $this->db->bind(':country', $country);
            
            // execute  
            $states = $this->db->resultSet();

            // check rows
            if($this->db->rowCount() > 0){
                return $states;
            }
            else{
                return false;
            }
        }

        public function getItems(){
            $this->db->query("SELECT auctions.auctionID, auctions.title, auctions.description, auctions.startingDate, auctions.imageFileName, IFNULL(bids.amount, auctions.startingBid) AS amount
                                FROM
                                    auctions as auctions
                                LEFT OUTER JOIN
                                    (SELECT auctionID, amount
                                    FROM
                                        (SELECT *, RANK() OVER (PARTITION BY auctionID ORDER BY amount DESC, bidTime DESC) AS rank
                                        FROM bids) as bids
                                    WHERE rank = 1) as bids
                                ON
                                    auctions.auctionID = bids.auctionID
                                WHERE
                                    auctions.isActive = 1");
            return $this->db->resultSet();
          }

        public function getItemStatus(){
            $this->db->query("SELECT auctions.auctionID, auctions.sellerID, auctions.isActive, bids.bidID, bids.bidderID, IFNULL(bids.amount, auctions.startingBid) AS amount
                                FROM
                                    auctions as auctions
                                LEFT OUTER JOIN
                                    (SELECT bidId, bidderID, auctionID, amount
                                    FROM
                                        (SELECT *, RANK() OVER (PARTITION BY auctionID ORDER BY amount DESC, bidTime DESC) AS rank
                                        FROM bids) as bids
                                    WHERE rank = 1) as bids
                                ON
                                    auctions.auctionID = bids.auctionID");
            return $this->db->resultSetAsArray();
        }
        
        public function getItemById($id){
            $this->db->query('SELECT * FROM auctions WHERE auctionid = :id');
            $this->db->bind(':id', $id);
      
            $row = $this->db->single();
      
            return $row;
          }

          public function addNewBid($data){

            // define query
            $this->db->query("INSERT INTO bids (bidderID,auctionID, amount, Name) VALUES (:bidderID,:auctionID,:amount,:Name)");
            
            
            // bind values
            $this->db->bind(':bidderID', $_SESSION['user_id']);
            $this->db->bind(':auctionID', $data ['items'] -> auctionID);
            $this->db->bind(':amount', $data ['amount']);
            $this->db->bind(':Name', $_SESSION['user_name']);
            // execute
            if($this->db->execute()){
                
                return true;
            }
            else{
                return false;
            }
          }

          public function updateNewBid($data){

            // define query
            $this->db->query("UPDATE bids SET amount=:amount WHERE bidderID = :bidderID and auctionID = :auctionID ");
            
            // bind values
            $this->db->bind(':bidderID', $_SESSION['user_id']);
            $this->db->bind(':auctionID', $data ['items'] -> auctionID);
            $this->db->bind(':amount', $data ['amount']);
       
            // execute
            if($this->db->execute()){
                
                return true;
            }
            else{
                return false;
            }
          }

          public function findBidByauctionID($id){
            $this->db->query("SELECT bidderID,amount,Name FROM bids WHERE auctionID= :id ");
            
            // bind values
            $this->db->bind(':id', $id);
            
            // execute
            $row = $this->db->resultSet();

      
            return $row;
        }

        public function getBids($id){

            // define query
            $this->db->query("SELECT Name,amount, bidderID FROM bids WHERE auctionID= :id ORDER BY amount DESC");
            // bind values
            $this->db->bind(':id', $id);
            $row = $this->db->resultSet();
      
            return $row;
          }
        
        public function getMyAuctions($userID){
            $this->db->query("SELECT auctions.auctionID, auctions.title, auctions.isActive, auctions.description, auctions.startingDate, auctions.imageFileName, IFNULL(bids.amount, auctions.startingBid) AS amount
                                FROM
                                    (SELECT *
                                    FROM auctions
                                    WHERE auctions.sellerID = :sellerID) as auctions
                                LEFT OUTER JOIN
                                    (SELECT auctionID, amount
                                    FROM
                                        (SELECT *, RANK() OVER (PARTITION BY auctionID ORDER BY amount DESC, bidTime DESC) AS rank
                                        FROM bids) as bids
                                    WHERE rank = 1) as bids
                                ON
                                    auctions.auctionID = bids.auctionID
                                ORDER BY
                                    isActive DESC, startingDate DESC");
            $this->db->bind(':sellerID', $userID);    
            return $this->db->resultSet();            
        }
        
        public function getMyBids($userID){
            $this->db->query("SELECT
                                        userBids.auctionID, auctions.title, auctions.isActive, auctions.description, auctions.startingDate, auctions.imageFileName, userBids.bidAmount, auctions.highestBidder, auctions.highestBid
                                    FROM
                                        (SELECT bidderID, auctionID, amount as bidAmount
                                            FROM
                                                (SELECT *, RANK() OVER (PARTITION BY auctionID ORDER BY amount DESC, bidTime DESC) AS rank FROM bids WHERE bidderID = :bidderID) as bids
                                            WHERE
                                                rank = 1) as userBids
                                    LEFT OUTER JOIN
                                        (SELECT auctions.auctionID, auctions.title, auctions.isActive, auctions.description, auctions.startingDate, auctions.imageFileName, bids.highestBidder, bids.highestBid AS highestBid
                                        FROM
                                            auctions
                                        LEFT OUTER JOIN
                                            (SELECT auctionID, bidderID as highestBidder, amount as highestBid
                                                FROM
                                                    (SELECT *, RANK() OVER (PARTITION BY auctionID ORDER BY amount DESC, bidTime DESC) AS rank
                                                    FROM bids) as bids
                                                WHERE rank = 1) as bids
                                        ON
                                            auctions.auctionID = bids.auctionID) as auctions
                                    ON
                                        userBids.auctionID = auctions.auctionID
                                    ORDER BY
                                        isActive DESC, startingDate DESC");
            $this->db->bind(':bidderID', $userID);    
            return $this->db->resultSet();            
        }


        public function findBidBybidderID($id){
            // $this->db->query("SELECT * FROM bids WHERE bidderID= :id ");
            $this->db->query( "SELECT auctions.isActive, bids.bidderID
                                FROM
                                    auctions as auctions
                                LEFT OUTER JOIN
                                    (SELECT bidID, bidderID, auctionID
                                    FROM bids as bids
                                    WHERE bidderID= :id) as bids
                                    ON
                                        auctions.auctionID = bids.auctionID
                                    WHERE
                                        auctions.isActive = 1  and bids.bidderID= :id");
            // bind values
            $this->db->bind(':id', $id);
            
            $bid = $this->db->resultSet();

            // check rows
            if($this->db->rowCount() > 0){
                return $bid;
            }
            else{
                return false;
            }
        }

        public function getItemBysellerId($id){
            $this->db->query('SELECT * FROM auctions WHERE sellerID = :id and isActive=1' );
            $this->db->bind(':id', $id);
        
            $auction = $this->db->resultSet();
                return $auction;
    
            }

    }