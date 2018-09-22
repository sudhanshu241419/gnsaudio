<?php

class Common {

    public $imageType = array('image/png', 'image/gif', 'image/jpeg', 'image/jpg');

    public function uploadImage($imagePath, $imageName, $tmp) {
        $target = "";

        $imgType = substr(basename($imageName), -3, 3);
        $imagename = time() . "." . $imgType;
        $target = $imagePath . $imagename;
       
        if (move_uploaded_file($tmp, "../" . $target)) {
            return $imagePath . $imagename;
        } else {
            return $target;
        }
    }

    public function uploadLargeImage($imagePath, $imageName, $tmp) {
        $target = "";

        $imgType = substr(basename($imageName), -3, 3);
        $imagename = "big_" . time() . "." . $imgType;
        $target = $imagePath . $imagename;
        if (move_uploaded_file($tmp, "../" . $target)) {
            return $imagePath . $imagename;
        } else {
            return $target;
        }
    }

    public function checkImageType($type) {
        if (in_array($type, $this->imageType)) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteFile($path) {
        if ($path) {
            unlink($path);
        }
        return true;
    }

}
