<?php

class Admin extends BaseController {

    public function __construct()
    {
        // Filter for this class
        // $this->beforeFilter(function () {
            //
        // });
    }

    public function index()
    {
        $data = array('name'=>'avil');

        return View::make('admin.index', $data)
                    ->with('title', 'Это админка, поздравляю!!!');
    }




    public function missingMethod($id)
    {
        return "<h1>". __METHOD__ . "</h1>\n<pre>" . var_dump( func_get_args() );
    }

}