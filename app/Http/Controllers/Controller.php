<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Storage;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function UploadFile($request,$name,$exts,$size = '6 mb',$require = true,$file_replace='',$dir=''){
        $response['status'] = false; 
        $file = NULL;

        try { 
                if ($require == true && !$request->hasFile($name)) {
                    throw new \Exception("El archivo es requerido");
                }
                if ($request->hasFile($name)) {
                    $file = $request->file($name);
                    $size = $this->sizeFile($size);
                    $ext_permitidas = explode(',',strtolower($exts)); 
                    
                    if (count($this->object_to_array($file),COUNT_RECURSIVE) - count($this->object_to_array($file))) {
                        foreach ($file as $key => $fil) {
                            $res = $this->upload($fil,$ext_permitidas,$size,$file_replace,$dir);
                            if ($res['status'] == false) {
                                throw new \Exception($res['message']);
                            }
                        }
                    }
                    else{   
                            $res = $this->upload($file,$ext_permitidas,$size,$file_replace,$dir);
                            if ($res['status'] == false) {
                                throw new \Exception($res['message']);
                            }
                    }   
                } 
                $response['name'] = $file == NULL ? NULL : $file->hashName();
                $response['status'] = true;
        } catch (\Exception $e) {
            $response['message'] = $e->getMessage();
        }
        return $response;
    }
    public function sizeFile($size){
        $size = strtolower(str_replace(' ', '', $size));
        $numeros = intval(preg_replace('/[^0-9]+/', '', $size), 10); 
        $indicad = substr($size,strlen($size)-2,2);
        switch ($indicad) {
            case 'kb': $size = $numeros*1000;    break;
            case 'mb': $size = $numeros*1000000; break;
            default: $size = $numeros*1000000;   break;
        }
        return $size;
    }
    public function upload($file,$ext_permitidas,$size,$file_replace,$dir){
        $response['status'] = false;
        try {
                $result = array_search($file->guessExtension(), $ext_permitidas);
                if ($result == false) {
                    throw new \Exception("Error, la extensión del archivo no es permitida"); 
                } 
                if ($size < $file->getSize()) {
                    $size_mb = $size / 1000000; 
                    throw new \Exception("Error, el archivo supera el tamaño máximo: ".$size_mb.' MB');
                } 

                $dir = $this->isFileDirectory($file->getMimeType()); 
                
                if ($file_replace != '') {
                        $file->storeAs('public/'.$dir,$file_replace);
                }else{
                        $file->store('public/'.$dir); 
                } 
                $response['status'] = true;
        } catch (\Exception $e) {
            $response['message'] = $e->getMessage();
        }
        return $response;
    }
    public function isFileDirectory($file_mime){  
        $result = 'varios';
        $types = array('documents' => 'document,word,pdf,doc,xls,csv,txt,rtf,ai,sql',
                       'images' => 'image,tif,jpg,jpeg,png,swf,bmp,gif,raw,psd',
                       'presents' => 'presentation,pptx,ppt',
                       'videos' => 'video,mp4,avi,mkv,mpg,mpg2',
                       'music' => 'audio,wav,flac,mp3,wma',
                      );
        foreach ($types as $key => $value) {
            $info = explode(',',$value);
            foreach ($info as $kinfo => $valinfo) {
                $pos = strstr($file_mime, $valinfo);
                if ($pos === $file_mime) {
                    $result = $key; break;
                } 
            } 
        }
        if (!is_dir('public/'.$result))
        {   //Crear directorio
            Storage::makeDirectory('public/'.$result); 
        }
        return $result;
    }
    public function object_to_array($obj) {
        //only process if it's an object or array being passed to the function
        if(is_object($obj) || is_array($obj)) {
            $ret = (array) $obj;
            foreach($ret as &$item) {
                //recursively process EACH element regardless of type
                $item = $this->object_to_array($item);
            }
            return $ret;
        }
        //otherwise (i.e. for scalar values) return without modification
        else {
            return $obj;
        }
    }
}