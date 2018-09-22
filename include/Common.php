<?php
class Common{
    public $imageType;
    public function uploadImage(){
        $target = "";

        $error = $_FILES['image']['error'];
        if ($error == 0) {
            $type = $_FILES['image']['type'];
            if (in_array($type, $this->imageType)) {
                $imgType = substr(basename($_FILES['image']['name']), -3, 3);
                $imagename = time() . ".".$imgType;
                $target = CAT_IMAGEPATH . $imagename;
                $tmp = $_FILES['image']['tmp_name'];
                if (move_uploaded_file($tmp, $target)) {
                    return $target;
                }else{
                    return $target;
                }
            }
        }else{
            return $target;
        }
    }

    public function deleteFile($path){
        if($path){
            unlink($path);
        }
        return true;
    }
}