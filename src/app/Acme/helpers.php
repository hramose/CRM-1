<?php

function isActive($name){
    return URL::current()===URL::route($name) ? ' class="active"' : '';
}

function error_for($attribute, $errors){
    if($errors->has($attribute)){
        return $errors->first($attribute, '<span class="red">:message</span>');
    }
}


/**
 * Проверка на права
 */
function checkRight() {
    if(!Auth::guest()){
        $user = User::find(Auth::user()->id);

        $admin = 11111 & intval($user->group->rule);

        if(substr($admin, 0, 1)==1){
            // Админ
            return true;
        }
    }

    return false;
}
