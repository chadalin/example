<?php
namespace App\models;

class ImageManager
{
    public $auth;

    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    public function upload()
    {
        return "метод upload class ImageManager";
    }
}