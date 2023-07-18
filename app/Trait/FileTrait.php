<?php

namespace App\Trait;

use Illuminate\Http\UploadedFile;

trait FileTrait
{
    public function upload(UploadedFile $file, $path)
    {
        $fileName = time().'.'.$file->getClientOriginalExtension();
        $result = $file->storeAs($path, $fileName, 'public');

        return $result;
    }
}
