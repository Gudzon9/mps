<?php

return [
    'adminEmail' => 'admin@example.com',
    'aposada' => ['1'=>'директор', '2'=>'менеджер'],
    'atable' => array(1=>'user', 2=>'kagent'),
    'astatusEmp' => array(1 => "В штате", 2 => "Внештатник"),
    'isDirector' => false,
    //'aatr' => array(1 => "phone", 2 => "email", 3 => "link"),
    'aatr' => array(
        1=>array('atrId'=>'1','atrName'=>'phone','atrDescr'=>'Телефон','atrMask'=>'+38(999)9999999'), 
        2=>array('atrId'=>'2','atrName'=>'email','atrDescr'=>'Email','atrMask'=>''), 
        3=>array('atrId'=>'3','atrName'=>'link','atrDescr'=>'Link','atrMask'=>''),
    ),
    'satr' => array(
        1=>array('atrId'=>'1','atrName'=>'typeKag','atrType'=>'one','atrDescr'=>'Тип клиента'),
        2=>array('atrId'=>'2','atrName'=>'statKag','atrType'=>'one','atrDescr'=>'Статус'),
        3=>array('atrId'=>'3','atrName'=>'actiKag','atrType'=>'one','atrDescr'=>'Вид деятельности'),
        4=>array('atrId'=>'4','atrName'=>'chanKag','atrType'=>'one','atrDescr'=>'Канал привлечения'),
        5=>array('atrId'=>'5','atrName'=>'prodKag','atrType'=>'many','atrDescr'=>'Продукция'),
        6=>array('atrId'=>'6','atrName'=>'refuKag','atrType'=>'one','atrDescr'=>'Причина отказа'),
        7=>array('atrId'=>'7','atrName'=>'regiKag','atrType'=>'one','atrDescr'=>'Область'),
        8=>array('atrId'=>'8','atrName'=>'townKag','atrType'=>'one','atrDescr'=>'Город'),
        9=>array('atrId'=>'9','atrName'=>'tpayKag','atrType'=>'many','atrDescr'=>'Форма расчета'),
        10=>array('atrId'=>'10','atrName'=>'grouKag','atrType'=>'many','atrDescr'=>'Группы'),
    ),
    'akindKagent' => array(1 => "Человек", 2 => "Компания"),
    //'atypeKagent' => array(1 => "Клиент", 2 => "Конкурент"),
    'atypeEvent' => [
        ['id'=>'1','type'=>'Звонок','color'=>'#A0CB29'],
        ['id'=>'2','type'=>'Встреча','color'=>'#F0AD4E'],
        ['id'=>'3','type'=>'Дело','color'=>'#337AB7'],
        //['id'=>'4','type'=>'Праздник','color'=>'#5CB85C'],
    ],

];
