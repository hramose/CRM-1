<?php

class ApiAction extends \BaseController {

    public function postShow() {

        $data = array(
                'items' => array()
            );




        // $clients = Client::where('user_id', '=', '1');

        $filter = array(
              'page'   => (int)Input::get('page'),
              'curator'=> (int)Input::get('curator'),
              'status' => (int)Input::get('status'),
              );


        $clients = DB::table('clients')->where(function ($query) use ($filter) {
            // if($filter['page'])
                // $query->where('', '=', $filter['page']);

            if($filter['curator'])
                $query->where('user_id', '=', $filter['curator']);

            if($filter['status'])
                $query->where('status_id', '=', $filter['status']);

        })->get();


        foreach ($clients as $v) {

            $data['items'][] = array(
                    'name' => $v->name,
                    'url' => $v->url,
                    'contact' => '123 123',
                    'page' => Input::get('page')
                );
        }


        return Response::json($data)->header('Content-Type', 'application/json');
    }


    public function postStatuses() {
        $data = array('items' => Client_status::all()->toJson());

        return Response::json($data)->header('Content-Type', 'application/json');
    }


    public function postCurators() {
        $data = array('items' => User::all()->toJson());

        return Response::json($data)->header('Content-Type', 'application/json');
    }

}
