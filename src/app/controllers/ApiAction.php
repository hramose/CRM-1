<?php

class ApiAction extends \BaseController {

    /**
     * Показываем клиентов в зависимости от фильтра
     *
     */
    public function postShow() {

        $data = array(
                'page' => (int)Input::get('page'),
                'items' => array()
            );

        $filter = array(
              'curator'=> (int)Input::get('curator'),
              'status' => (int)Input::get('status'),
              'search' => Input::get('search'),
              );


        // Запрос к БД
        $where = function ($query) use ($filter) {

                if($filter['curator']){
                    $query->where('user_id', '=', $filter['curator']);
                }

                if($filter['status']){
                    $query->where('status_id', '=', $filter['status']);
                }

                if( !empty($filter['search']) && strlen($filter['search'])>2 ){

                    $query->where(function ($query) use ($filter) {

                        $query->where('name', 'LIKE', "%$filter[search]%");

                        $cont_arr = Client_contacts::where('name', 'LIKE', "%$filter[search]%")->select('client_id')->get()->toArray();
                        $cont_id = array();

                        foreach ($cont_arr as $v) {
                            $cont_id[] = $v['client_id'];
                        }

                        if(count($cont_id)){
                            $query->orWhereIn('id', $cont_id);
                        }
                    });
                } // end search


                // Видим группы пользователя или те которые могут видеть все
                $query->where(function ($query) {
                    $query->where('group_id', '=', Auth::user()->group_id )->orWhere('see_all', '=', '1');
                });
            };


        $data['count'] = ceil( Client::where($where)->count() / 100 );


        $clients = Client::where($where)
            ->select(array('id', 'created_at', 'name', 'url', 'user_id'))
            ->skip(($data['page']-1)*100)->take(100)
            ->orderBy('created_at', 'DESC')
            ->get();


        # Debug SQL
        // $queries = DB::getQueryLog();
        // $last_query = end($queries);
        // $data['sql'] = $last_query;

            $user_id =  Auth::user()->id;
            $group_admin =  Auth::user()->group_admin;


        foreach ($clients as $v) {

            $data['items'][] = array(
                    'edit'       => (($group_admin===1 || $user_id===$v->user_id) ? 1 : 0),
                    'id'         => $v->id,
                    'name'       => $v->name,
                    'url'        => explode(' ', $v->url),
                    'created_at' => date("d.m.Y", strtotime( $v->created_at)),
                    'contact'    => $v->contacts->toArray(),
                );
        }


        return Response::json($data)->header('Content-Type', 'application/json');
    }



    /**
     * Список статусов
     *
     */
    public function postStatuses() {
        $data = array('items' => Client_status::all()->toJson());

        return Response::json($data)->header('Content-Type', 'application/json');
    }



    /**
     * Список кураторов
     *
     */
    public function postCurators() {
        $data = array('items' => User::all()->toJson());

        return Response::json($data)->header('Content-Type', 'application/json');
    }



    /**
     * Метод для сохранения или обновления клиента
     */
    public function postSave(){

        $data = array('status'=>false, 'message'=>'');

        $validtor = Validator::make(Input::all(), array('name'=>'required','company_name'=>'required'));

        if($validtor->fails()){

                $data['message'] .=  "Плохо заполнили клиента.\nНе годится!!!";

        }else{

            $url = explode(' ', Input::get('url'));
            $resUrl = array();

            foreach ($url as $k => $v) {
                $v = trim($v);
                if(empty($v)) continue;
                $resUrl[] = 'http://' . strtr($v, array('http://'=>''));
            }

            $id = (int)Input::get('client_id');

            if($id==0){
                $client = new Client;
            }else{
                $client = Client::find($id);

                EventSaveClient($id);
            }

            if($client->user_id === Auth::user()->id || Auth::user()->group_admin===1){

                $client->name         = Input::get('name');
                $client->company_name = Input::get('company_name');
                $client->about        = Input::get('about');
                $client->see_all      = Input::get('see_all');
                $client->url          = implode(' ', $resUrl);
                $client->group_id     = Auth::user()->group_id;
                $client->user_id      = Input::get('user_id')? Input::get('user_id') : Auth::user()->id;
                $client->status_id    = Input::get('status_id')? Input::get('status_id') : 2; // статус Клиент


                if($client->save()){
                    $data['status'] = true;
                    $data['message'] = 'Компания успешно сохранена';
                    $data['client_id'] = $client->id;

                    // Сохранение контакта
                    $contact = Input::get('contact');

                    if(!empty($contact) && !empty($contact['contact_name'])){

                        if($contact['contact_id'] == 0){
                            $mContact = new Client_contacts;
                        }else{
                            $mContact = Client_contacts::find($contact['contact_id']);
                        }

                        $mContact->client_id = $data['client_id'];
                        $mContact->name = $contact['contact_name'];
                        $mContact->mail = empty($contact['contact_mail']) ? '' : $contact['contact_mail'];
                        $mContact->phone = empty($contact['contact_phone']) ? '' : $contact['contact_phone'];
                        $mContact->position = empty($contact['contact_position']) ? '' : $contact['contact_position'];
                        $mContact->address = empty($contact['contact_address']) ? '' : $contact['contact_address'];

                        $mContact->save();
                    }
                }else{
                    $data['message'] = 'Не удалось сохранить компанию';
                }

            }else{
                 $data['message'] = 'У вас нет прав на изменение данной компании';
            }
        }

        return Response::json($data)->header('Content-Type', 'application/json');
    }



    /**
     * метод для получения данных о клиенте
     */
    public function postGetclient() {
        $id = (int)Input::get('id');

        $data = array();

        if($id){
            $client = Client::find($id);


            $user_id =  Auth::user()->id;
            $group_admin =  Auth::user()->group_admin;

            $data['item'] = array(
                  'client_edit'   => (($group_admin===1 || $user_id===$client->user_id) ? 1 : 0),
                  'client_id'     => $client->id,
                  'about'         => $client->about,
                  'name'          => $client->name,
                  'company_name'  => $client->company_name,
                  'see_all'       => $client->see_all,
                  'url'           => $client->url,
                  'form_status'   => $client->status_id,
                  'form_curator'  => $client->user_id,
                  'form_contacts' => $client->contacts->toArray(),
                  'history'       => $client->history->toArray(),
                  );


        }

        return Response::json($data)->header('Content-Type', 'application/json');
    }



    /**
     * метод для удаления контакта компании
     * TODO: Добавить проверку прав
     */
    public function postDeletecontact() {
        $data = array('status'=>false);

        $id = (int)Input::get('contact_id');

        if($id>0){
            $contact = Client_contacts::findOrFail($id);

            $user = User::find(Auth::user()->id);

            // id группы к которой относится контакт
            $group_id = $contact->client->group_id;

            // добавить проверку прав
            $group_rule = (($user->group->id === $contact->client->group_id) && checkRight('D', $group_id)) ||
                            ($user->id === $contact->client->user_id);

            if($contact->client_id === Auth::user()->id || $group_rule){

                EventDeleteContact($id);

                if($contact->delete()){
                    $data['message'] = 'Контакт удален';
                    $data['status'] = true;
                }
            }else{
                $data['message'] = 'У вас нет прав на данное действие';
            }
        }

        return Response::json($data)->header('Content-Type', 'application/json');
    }



    /**
     * метод для удаления компании
     * TODO: Добавить проверку прав
     */
    public function postDeleteclient() {
        $data = array('status'=>false);

        $id = (int)Input::get('client_id');

        if($id>0){
            $client = Client::find($id);

            $user = User::find(Auth::user()->id);

            // добавить проверку прав
            $group_rule = (checkRight('D', $client->group_id)) ||
                            ($user->id === $client->user_id);

            if($client->client_id === Auth::user()->id || $group_rule){
                if($client->delete()){
                    $data['message'] = 'Клиент удален';
                    $data['status'] = true;

                    Client_contacts::where('client_id', '=', $id)->delete();
                }
            }else{
                $data['message'] = 'У вас нет прав на данное действие';
            }
        }

        return Response::json($data)->header('Content-Type', 'application/json');
    }



}
