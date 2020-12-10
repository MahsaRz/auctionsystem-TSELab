<?php
    class Notification{
        private $db;

        public function __construct(){
            $this->db = new Database;
        }

        public function getUnseenCount($userID){

            // define query
            $this->db->query("SELECT COUNT(notificationID) AS count
                                FROM notifications
                                WHERE receiverID = :receiverID AND isSeen = 0");
            
            // bind values for current user
            $this->db->bind(':receiverID', $userID);

            // execute
            return $this->db->single();
        }

        public function getNotifications($userID){

            // define query
            $this->db->query("SELECT notifications.type, notifications.title, notifications.buyPrice, users.name AS sellerName, notifications.buyerName, soldAt
                                FROM
                                    (SELECT notifications.type, notifications.title, notifications.buyPrice, notifications.sellerID, users.name AS buyerName, notifications.dateAdded AS soldAt
                                        FROM
                                            (SELECT auctions.title, auctions.sellerID, auctions.buyerID, auctions.buyPrice, notifications.type, notifications.dateAdded
                                            FROM
                                                auctions AS auctions
                                            INNER JOIN
                                                (SELECT type, auctionID, dateAdded
                                                FROM notifications
                                                WHERE receiverID = :receiverID) AS notifications
                                            ON auctions.auctionID = notifications.auctionID) AS notifications
                                        LEFT OUTER JOIN    
                                            users AS users
                                        ON notifications.buyerID = users.userID) AS notifications
                                LEFT OUTER JOIN
                                    users AS users
                                ON notifications.sellerID = users.userID
                                ORDER BY soldAt DESC
                                LIMIT 5");
            
            // bind values for current user
            $this->db->bind(':receiverID', $userID);
            
            // execute
            return $this->db->resultSet();
            }

        public function setCommentsRead($userID){
            
            // define query
            $this->db->query("UPDATE notifications SET isSeen = 1 WHERE receiverID = :receiverID");

            // bind values
            $this->db->bind(':receiverID', $userID);

            // execute
            if($this->db->execute()){
                
                return true;
            }
            else{
                return false;
            }
        }

        public function getAllNotifications($userID){
            // define query
            $this->db->query("SELECT notifications.type, notifications.title, notifications.buyPrice, users.name AS sellerName, users.email AS sellerEmail, notifications.buyerName, notifications.buyerEmail, soldAt, notifications.address as pickupAddress1, notifications.address2  as pickupAddress2, notifications.state  as pickupState, notifications.country as pickupCountry, notifications.zip as pickupZip
                                FROM
                                    (SELECT notifications.type, notifications.title, notifications.buyPrice, notifications.sellerID,  notifications.address, notifications.address2, notifications.state, notifications.country, notifications.zip, users.name AS buyerName, users.email AS buyerEmail, notifications.dateAdded AS soldAt
                                        FROM
                                            (SELECT auctions.title, auctions.sellerID, auctions.buyerID, auctions.buyPrice, auctions.address, auctions.address2, auctions.state, auctions.country, auctions.zip , notifications.type, notifications.dateAdded
                                            FROM
                                                auctions AS auctions
                                            INNER JOIN
                                                (SELECT type, auctionID, dateAdded
                                                FROM notifications
                                                WHERE receiverID = :receiverID) AS notifications
                                            ON auctions.auctionID = notifications.auctionID) AS notifications
                                        LEFT OUTER JOIN    
                                            users AS users
                                        ON notifications.buyerID = users.userID) AS notifications
                                LEFT OUTER JOIN
                                    users AS users
                                ON notifications.sellerID = users.userID
                                ORDER BY soldAt DESC");
    
            // bind values for current user
            $this->db->bind(':receiverID', $userID);
            
            // execute
            return $this->db->resultSet();
        }
    }