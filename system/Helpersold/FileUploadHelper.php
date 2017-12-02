<?php
namespace System\Helpers;


class FileUploadHelper {
    
    public function doMultiUpload($upload_dir,$field){
        if(isset($_FILES[$field])){
            $files=array();
            $fdata=$_FILES[$field];
            if(is_array($fdata['name'])){
                for($i=0;$i<count($fdata['name']);++$i){
                    $files[]=array(
                        'name'     => $fdata['name'][$i],
                        'tmp_name' => $fdata['tmp_name'][$i],
                    );
                }
            }else
                $files[]=$fdata;
            $oldumask = umask(0); 
            if(! is_dir($upload_dir)){
                mkdir($upload_dir, 0777,true);
            }
            foreach ($files as $file) {
                move_uploaded_file($file['tmp_name'],$upload_dir.$file['name']);
            }
            umask($oldumask);
        }
    }
    
    public function doSingleUpload($upload_dir,$field,$filename=null){
        if(isset($_FILES[$field])){
            $files = array();
            $files[]=$_FILES[$field];
            $oldumask = umask(0); 
            if(! is_dir($upload_dir)){
                mkdir($upload_dir, 0777,true);
            }
            if($filename==null)
                $filename = $files['name'];
            foreach ($files as $file) {
                move_uploaded_file($file['tmp_name'],$upload_dir.$filename);
            }
            umask($oldumask);
        }
    }

}