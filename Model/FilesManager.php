<?php

namespace Model;

class FilesManager
{
    public function upload($pic)
    {
        $uploaddir = './uploads/';
        $uploadfile = $uploaddir . basename($pic);
        move_uploaded_file($_FILES['picture']['tmp_name'], $uploadfile);
    }
}
