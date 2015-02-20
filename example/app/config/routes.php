<?php

//return array(
//    'user' => array(
//        'regex' => '/^user-(\d)-test-(\d)$/',
//        'method' => 'get',
//        'action' => 'view',
//        'controller' => 'User\\Controller\\Profile',
//    )
//);

Route::entry('/^user-(\d)-test-(\d)$/')
    ->mappedBy('view@User\Controller\Profile')->get()
    ->mappedBy(function() {
        
    })->post()
    ->mappedBy('item@User\Controller\Profile')->put()
;