<?php
require_once __DIR__ . '/wrapper.php';
$userMenu = [
    ['title' => 'Home', 'icon' => '', 'url' => '/'],
    ['title' => 'About', 'icon' => '', 'url' => 'site/abouts'],
    ['title' => 'Services', 'icon' => '', 'url' => 'site/services'],
     ['title' => 'FAQs', 'icon' => '', 'url' => 'site/faq'],
    ['title' => 'Contact', 'icon' => '', 'url' => 'site/contact'],
   
    // ['title' => 'Contact', 'icon' => 'Services', 'url' => 'home/contact'],

];
return array_merge($userMenu);
