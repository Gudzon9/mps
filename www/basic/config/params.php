<?php

return [
    'adminEmail' => 'admin@example.com',
    'aposada' => ['1'=>'директор', '2'=>'менеджер'],
    'atable' => array(1=>'user', 2=>'kagent'),
    'astatusEmp' => array(1 => "В штате", 2 => "Внештатник"),
    'isDirector' => false,
    //'aatr' => array(1 => "phone", 2 => "email", 3 => "link"),
    'aatr' => array(
        1=>array('atrName'=>'phone','atrDescr'=>'телефон','atrMask'=>'+38(999)9999999'), 
        2=>array('atrName'=>'email','atrDescr'=>'email','atrMask'=>''), 
        3=>array('atrName'=>'link','atrDescr'=>'link','atrMask'=>'')
    ),
];
