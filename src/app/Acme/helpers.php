<?php

function isActive($name){
    return URL::current()===URL::route($name) ? ' class="active"' : '';
}

function error_for($attribute, $errors){
    if($errors->has($attribute)){
        return $errors->first($attribute, '<span class="red">:message</span>');
    }
}


/*
 * Проверка на права
 * $act= 'C', 'R', 'U', 'D';
 * -------------------------
 |Create
 |Read
 |Update
 |Delete
 */
function checkRight($act='R', $group_id=0) {
    if(!Auth::guest()){
        $user = User::find(Auth::user()->id);

        if($user->group_admin == 1 && $user->group_id == $group_id){
            // Админ группы
            return true;
        }

        $rule = 1111 & intval($user->group->rule);

        $Action = array('C', 'R', 'U', 'D');

        $k = array_search($act, $Action);

        if(substr($rule, $k, 1)==1){
            // Имеет право на создание,
            return true;
        }
    }

    return false;
}


/**
 * History handler
 */
function EventSaveClient($client_id){
    // Client_history::create();

    // Текст сообщения
    $msg = array();

    $fields = array(
          'user_id'      => 'Изменен куратор',
          'status_id'    => 'Изменен статус',
          'see_all'      => 'Изменен общий доступ',
          'name'         => 'Изменено название',
          'company_name' => 'Изменено полное название',
          'url'          => 'Изменен URL',
          'about'        => 'Изменено описание',
          'contact'      => 'Контакты отредактированы',
          );

    $client = Client::find($client_id);

    if(Input::get('user_id')!==$client->user_id)
        $msg[] = $fields['user_id']."\n";

    if(Input::get('status_id')!==$client->status_id)
        $msg[] = $fields['status_id']."\n";

    if(Input::get('see_all')!==$client->see_all)
        $msg[] = $fields['see_all']."\n";

    if(Input::get('name')!==$client->name)
        $msg[] = $fields['name']."\n";

    if(Input::get('company_name')!==$client->company_name)
        $msg[] = $fields['company_name']."\n";

    if(Input::get('url')!==$client->url)
        $msg[] = $fields['url']."\n";

    if(Input::get('about')!==$client->about)
        $msg[] = $fields['about']."\n";

    $cont = Input::get('contact');

    if(!empty($cont['contact_name']))
        $msg[] = $fields['contact']."\n";



    if(count($msg)>0){
        Client_history::create(array(
                    'client_id' => $client_id,
                    'event' => implode(', ', $msg) .
                                '. Изменения внес: "'. Auth::user()->username .'"'
                ));
    }
}


function EventDeleteContact($contact_id){


    if(!empty($contact_id)){
        $cont = Client_contacts::find($contact_id);

        Client_history::create(array(
                    'client_id' => $cont->client_id,
                    'event' => 'Удален контакт "'. $cont->name .
                                '". Изменения внес: "'. Auth::user()->username .'"'
                ));
    }
}
