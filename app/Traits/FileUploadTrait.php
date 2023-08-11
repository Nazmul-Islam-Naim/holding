<?php

namespace App\Traits;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
            

trait FileUploadTrait
{
 
    public function storeFile($data, $folder){
        
        if(Arr::has($data, 'avatar')){
            $data['avatar'] = (Arr::pull($data, 'avatar'));
            $data['avatar'] = (Arr::pull($data, 'avatar'))->store($folder);
        }

        if(Arr::has($data, 'nid')){
            $data['nid'] = (Arr::pull($data, 'nid'));
            $data['nid'] = (Arr::pull($data, 'nid'))->store($folder);
        }

        return $data;
    }

    public function updateFile($object, $data, $folder){


        if(Arr::has($data, 'avatar')){
            
            if (Storage::exists($object->avatar)) {
                Storage::delete($object->avatar);
            }

            $data['avatar'] = (Arr::pull($data, 'avatar'));
            $data['avatar'] = (Arr::pull($data, 'avatar'))->store($folder);
        }

        if(Arr::has($data, 'nid')){

            if (Storage::exists($object->nid)) {
                Storage::delete($object->nid);
            }

            $data['nid'] = (Arr::pull($data, 'nid'));
            $data['nid'] = (Arr::pull($data, 'nid'))->store($folder);
        }

        return $data;
           
    }

    public function destroyFile($object):void{
        if(Arr::has($object, 'avatar')){
            
            if (Storage::exists($object->avatar)) {
                Storage::delete($object->avatar);
            }
        }
        if(Arr::has($object, 'nid')){

            if (Storage::exists($object->nid)) {
                Storage::delete($object->nid);
            }
        }
    }
}
