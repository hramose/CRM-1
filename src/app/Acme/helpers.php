<?php

function isActive($name){
    return URL::current()===URL::route($name) ? ' class="active"' : '';
}

function error_for($attribute, $errors){
    if($errors->has($attribute)){
        return $errors->first($attribute, '<span class="red">:message</span>');
    }
}
