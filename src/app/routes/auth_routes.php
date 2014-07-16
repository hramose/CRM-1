<?php



Route::controller('api', 'ApiAction');



Route::group(array('before'=>'group_admin'), function () {

        Route::get('/admin', array(
                'as' => 'admin_page',
                'uses' => 'ApiAdmin@index'
            )
        );


        Route::controller('api-admin', 'ApiAdmin');
});

