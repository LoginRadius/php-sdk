<?php

    function getProfileForm($data) {
        $output = '<center><h5>------------<b>User Profile</b>------------</h5></center>';
        $output .= '<div id="lr-form"  class="form-signin" style="width: 70%">';
        foreach ($data as $key => $value) {
            if (in_array($key, array('FirstName', 'LastName', 'BirthDate', 'Country', 'City'))) {
                $date = $disabled = '';
                if ($key == "BirthDate") {
                    $date = 'class = "loginradius-raas-birthdate"';
                }
                elseif ($key == 'Country') {
                     $value = isset($data->Country->Name) ? $data->Country->Name : '';
                }
                if (!empty($key)) {
                    $output .= '<label class="lr-input-frame lr-inline"> <span class="lr-input-label">' . $key . '</span></label>';
                    $output .= '<input class="form-control" type = "text"  name = "' . trim($key) . '" id = "' . trim($key) . '" value = "' . (($value == 'unknown')?'':$value) . '" ' . $date . ' ' . $disabled . '>';
                    $output .= '<br/>';
                }
            }
        }

        $output .= '<div class="lr-submit-frame lr-align-right">';
        $output .= '<button class="btn btn-block bt-login" name="update_profile" type="submit" value="update" style ="width: 60%;">Save</button>';
        $output .= '</div>';
        $output .= '</div>';
        return $output;
    }
       
    function showMessage($msg){
       return '<div class="messagediv"><ul><li class="top-tootip" style="width:96%"><p id="messageinfo">'.$msg.'</p><span> </span></li><div class="clear"></div></ul></div>';

    }   
    
    
    
    