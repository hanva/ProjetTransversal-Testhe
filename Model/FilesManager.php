<?php

namespace Model;

class FilesManager
{
    public function upload($pic)
    {
        $uploaddir = './uploads/';
        $uploadfile = $uploaddir . basename($pic);
        var_dump(move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile));
    }
}
