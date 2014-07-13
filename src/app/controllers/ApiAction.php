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


                if($filter['curator'])
                    $query->where('user_id', '=', $filter['curator']);

                if($filter['status'])
                    $query->where('status_id', '=', $filter['status']);

                if( !empty($filter['search']) && strlen($filter['search'])>2 ){
                    $query->where('name', 'LIKE', "%$filter[search]%");

                    $cont_arr = Client_contacts::where('name', 'LIKE', "%$filter[search]%")->select('client_id')->get()->toArray();
                    $cont_id = array();

                    foreach ($cont_arr as $v) {
                        $cont_id[] = $v['client_id'];
                    }

                    if(count($cont_id)){
                        $query->orWhereIn('id', $cont_id);
                    }

                }



                $query->where(function ($query) {
                    $query->where('group_id', '=', Auth::user()->groups_id )->orWhere('see_all', '=', '1');
                });
            };


        $data['count'] = ceil( Client::where($where)->count() / 100 );


        $clients = Client::where($where)
            ->select(array('id', 'created_at', 'name', 'url'))
            ->skip(($data['page']-1)*100)->take(100)
            ->orderBy('created_at', 'DESC')
            ->get();


        # Debug SQL
        // $queries = DB::getQueryLog();
        // $last_query = end($queries);
        // $data['sql'] = $last_query;


        foreach ($clients as $v) {

            $data['items'][] = array(
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
            }

            $client->name         = Input::get('name');
            $client->company_name = Input::get('company_name');
            $client->about        = Input::get('about');
            $client->url          = implode(' ', $resUrl);
            $client->group_id     = Auth::user()->groups_id;
            $client->user_id      = Input::get('user_id')? Input::get('user_id') : Auth::user()->id;
            $client->status_id    = Input::get('status_id')? Input::get('status_id') : 2; // статус Клиент

            if($client->save()){
                $data['status'] = true;
                $data['message'] = 'Компания успешно сохранена';
                $data['client_id'] = $client->id;
            }else{
                $data['message'] = 'Не удалось сохранить компанию';
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

            $data['item'] = array(
                  'client_id'    => $client->id,
                  'about'        => $client->about,
                  'name'         => $client->name,
                  'company_name' => $client->company_name,
                  'see_all'      => $client->see_all,
                  'url'          => $client->url,
                  'form_status'  => $client->status_id,
                  'form_curator' => $client->user_id,
                  'contacts'     => $client->contacts->toArray(),
                  );


        }

        return Response::json($data)->header('Content-Type', 'application/json');
    }


}
