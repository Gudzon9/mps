<?php

return [
    'adminEmail' => 'admin@example.com',
    'aposada' => ['1'=>'директор', '2'=>'менеджер'],
    'atable' => array(1=>'user', 2=>'kagent'),
    'astatusEmp' => array(1 => "В штате", 2 => "Внештатник"),
    'isDirector' => false,
    //'aatr' => array(1 => "phone", 2 => "email", 3 => "link"),
    'aatr' => array(
        1=>array('atrName'=>'phone','atrDescr'=>'Телефон','atrMask'=>'+38(999)9999999'), 
        2=>array('atrName'=>'email','atrDescr'=>'Email','atrMask'=>''), 
        3=>array('atrName'=>'link','atrDescr'=>'Link','atrMask'=>'')
    ),
    'akindKagent' => array(1 => "Человек", 2 => "Компания"),
    'atypeKagent' => array(1 => "Клиент", 2 => "Конкурент"),
];
