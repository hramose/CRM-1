<?php

class ApiAdmin extends \BaseController {

    /**
     * Главная страница
     */
    public function index() {
        return View::make('account.admin');
    }

    /**
     * метод для получения данных о клиенте
     */
    private function getGroup() {
        $data = array();

        $data['not_group'] = User::where('group_id', '=', '0')->get()->toArray();

        $data['group'] = User::where('group_id', '=', Auth::user()->group_id)
            ->where('id', '!=', Auth::user()->id)->get()->toArray();

        return $data;
    }


    /**
     * метод для получения данных о клиенте
     */
    public function postGetgroup() {
        $data = $this->getGroup();

        return Response::json($data)->header('Content-Type', 'application/json');
    }


    /**
     * метод для получения данных о клиенте
     */
    public function postRemove() {
        if(Input::get('id')){
            $user = User::find(Input::get('id'));
            $user->group_id = 0;
            $user->save();
        }

        $data = $this->getGroup();

        return Response::json($data)->header('Content-Type', 'application/json');
    }


    /**
     * метод для получения данных о клиенте
     */
    public function postAdd() {
        if(Input::get('id')){
            $user = User::find(Input::get('id'));
            $user->group_id = Auth::user()->group_id;
            $user->save();
        }

        $data = $this->getGroup();

        return Response::json($data)->header('Content-Type', 'application/json');
    }

}