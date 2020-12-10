<?php
        $count = $data["count"]->count;
        $records = $data["records"];

        $output = '';
        $outputLen = '';
        if($count > 0){
            $outputLen = '<span class="notification-count text-white">' . $count . '</span>';
        }
    
        foreach($records as $record){
            if($record->type == 'Item Sold'){
                $text = "Item Sold! " . $record->title . ' sold to ' . $record->buyerName . ' at $' . $record->buyPrice;
                $output .= '<li class="dropdown-item">' . $text . '</li>';
            }
            elseif($record->type == 'Bid Won'){
                $text = "Congratulations! " . $record->title . ' by ' . $record->sellerName . ' goes to you at $' . $record->buyPrice;
                $output .= '<li class="dropdown-item">' . $text . '</li>';
            }
        }
    
        $output .= '<div class="dropdown-divider"></div>';
        $output .= '<form id="all-notifications" action="'.URLROOT.'/notifications/getAllNotifications" method="post">';
        $output .= '<input id="notificationUserID" name="notificationUserID" type="hidden">';
        $output .= '<a class="dropdown-item text-primary" href="#" onclick="getAllNotifications()">See all notifications</a>';
        $output .= '</form>';
        $data = [
            "output" => $output,
            "outputLen" => $outputLen,
        ];
    
        echo json_encode($data);
?>