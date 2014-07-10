<?php

class ApiAction extends \BaseController {


    /**
     * Показываем клиентов в зависимости от фильтра
     *
     */
    public function postShow() {

        $data = array(
                'items' => array()
            );

        $filter = array(
              'page'   => (int)Input::get('page'),
              'curator'=> (int)Input::get('curator'),
              'status' => (int)Input::get('status'),
              );



        $clients = Client::where(function ($query) use ($filter) {

            if($filter['curator'])
                $query->where('user_id', '=', $filter['curator']);

            if($filter['status'])
                $query->where('status_id', '=', $filter['status']);

        })->orderBy('created_at', 'DESC')->get();


        foreach ($clients as $v) {

            $data['items'][] = array(
                    'name'       => $v->name,
                    'url'        => explode(' ', $v->url),
                    'created_at' => date("d.m.Y", strtotime( $v->created_at)),
                    'contact'    => $v->contacts->toArray(),
                    'page'       => Input::get('page')
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

}
