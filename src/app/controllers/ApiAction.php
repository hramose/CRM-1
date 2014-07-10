<?php

class ApiAction extends \BaseController {

    public function postShow() {

        $data = array(
                'items' => array()
            );

        $clients = Client::all();


        foreach ($clients as $v) {

            $data['items'][] = array(
                    'name' => $v->name,
                    'url' => $v->url,
                    'contact' => '123 123',
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
