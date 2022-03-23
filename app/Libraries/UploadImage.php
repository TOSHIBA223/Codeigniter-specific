<?php namespace App\Libraries;
class UploadImage {
	   
        public function Image($img,$savepath,$old_image,$width,$height)
        {
           
                $image      = \Config\Services::image();
                if ($img->isValid() && ! $img->hasMoved()){
                    $savepath   = $savepath.$img->getRandomName();
                    $image      = \Config\Services::image('imagick')
                                    ->withFile($img->getRealPath())
                                    ->resize($width,$height, true, 'height')
                                    ->save($savepath);
                }else{
                    $savepath=$old_image;                  
                }
                return '/'.$savepath;                
        }
    
}
