<?php

namespace App\Traits;

trait CheckStaffParent{
    public function CheckParent($user){
        if ($user->parent_id == null || $user->parent_id == 0){
            return $user;
        }else{
            $Users = $user->ancestors;
            foreach ($Users as $user){
                if ($user->parent_id == null || $user->parent_id == 0){
                    return $user;
                }
            }
        }
    }
}
