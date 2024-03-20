<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\UploadedFile;

trait FileUploadTrait
{

    /**
     * upLoadObjectToS3
     *
     * @param  UploadedFile $objectFile
     * @param  string $directoryName
     * @return array
     */
   public function uploadFileLocal(string $folder, UploadedFile $objectFile, string $directoryName) {
        $initial = [
            'status' => false,
            'fileName' => '',
            'filePath' => ''
        ];
        if ($objectFile) {
            $fileName = $this->getFileName($objectFile);
            $path = $folder . '/' . $directoryName . '/' . $fileName;
            Storage::disk('public')->put($path, file_get_contents($objectFile), 'public');
            $initial = [
                'status' => true,
                'fileName' => $fileName,
                'filePath' => Storage::disk('public')->url($path),
            ];
        }
        return $initial;
   }

    /**
     * getFileName
     *
     * @param object $objectFile
     * @return string
     */
    private function getFileName(UploadedFile $objectFile): string
    {
        $originName = $objectFile->getClientOriginalName();
        $fileName = pathinfo($originName, PATHINFO_FILENAME);
        $extension = $objectFile->getClientOriginalExtension();
        $fileName = $fileName . '_' . time() . '.' . $extension;

        return $fileName;
    }
}
