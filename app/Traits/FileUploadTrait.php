<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Aws\S3\MultipartUploader;
use Aws\Exception\MultipartUploadException;
use Aws\Exception\AwsException;
use Aws\S3\S3Client;

trait FileUploadTrait
{
    /**
     * upLoadObjectToS3
     *
     * @param  UploadedFile $objectFile
     * @param  string $directoryName
     * @return array
     */
    public function upLoadObjectToS3(string $folder, UploadedFile $objectFile, string $directoryName): array
    {
        $initial = [
            'status' => false,
            'fileName' => '',
            'filePath' => ''
        ];
        if ($objectFile) {
            $fileName = $this->getFileName($objectFile);
            $path = $folder . '/' . $directoryName . '/' . $fileName;
            Storage::disk('s3')->put($path, file_get_contents($objectFile), 's3');
            $initial = [
                'status' => true,
                'fileName' => $fileName,
                'filePath' => $this->getObjectUrlFromS3($path),
            ];
        }
        return $initial;
    }

    /**
     * multipartUploaderToS3
     * 
     * use this function if uploading file size 100MB to 5GB
     * @param  UploadedFile $objectFile
     * @param  string $directoryName
     * @return array
     */
    public function multipartUploaderToS3(string $folder, UploadedFile $objectFile, string $directoryName): array
    {
        $initial = [
            'status' => false,
            'fileName' => '',
            'filePath' => ''
        ];
        if ($objectFile) {
            $fileName = $this->getFileName($objectFile);
            $path = $folder . '/' . $directoryName . '/' . $fileName;
            $contents = fopen($objectFile, 'rb');

            $s3 = new S3Client([
                'version' => 'latest',
                'region'  => env('AWS_DEFAULT_REGION')
            ]);

            // Use MultipartUploader to upload files to S3
            $uploader = new MultipartUploader($s3, $contents, [
                'bucket' => env('AWS_BUCKET'),
                'key'    => $path,
            ]);

            try {
                $result = $uploader->upload();
                $initial = [
                    'status' => true,
                    'fileName' => $fileName,
                    'filePath' => $result['ObjectURL'],
                ];
                return $initial;
            } catch (MultipartUploadException $e) {
                $initial['message'] = 'Failed to upload file';
            } catch (AwsException $e) {
                $initial['message'] = 'AWS error: ' . $e->getMessage();
            }
        }

        return $initial;
    }

    /**
     * getUrlFromS3
     *
     * @param string|array $pathFile
     * @return void
     */
    public function getObjectUrlFromS3(string|array $pathFile): string|array
    {
        $initial = [
            'status' => true,
            'filePath' => null
        ];
        if (empty($pathFile)) {
            return '';
        }
        if (is_array($pathFile)) {
            $arrPathExist = [];
            foreach ($pathFile as $item) {
                if (Storage::disk('s3')->exists($item)) {
                    $arrPathExist[] = Storage::disk('s3')->url($item);
                }
            }

            if(!empty($arrPathExist)) {
                $initial['filePath'] = $arrPathExist;
                return $initial;
            }
        }
        if (is_string($pathFile) && Storage::disk('s3')->exists($pathFile)) {
            $url = Storage::disk('s3')->url($pathFile);
            $initial['filePath'] = $url;
            return $initial;
        }
    }

    /**
     * deleteObjectS3
     *
     * @param string|array $pathFile
     * @return void
     */
    public function deleteObjectS3(string|array $pathFile): array
    {
        $initial = [
            'status' => false,
        ];
        if (empty($pathFile)) {
            return $initial;
        }
        if (is_array($pathFile)) {
            $arrPathExist = [];
            foreach ($pathFile as $item) {
                if (Storage::disk('s3')->exists($item)) {
                    $arrPathExist[] = $item;
                }
            }
            if (!empty($arrPathExist)) {
                $data = Storage::disk('s3')->delete($arrPathExist);
                $initial['status'] = $data;
            }
        }
        if (is_string($pathFile) && (Storage::disk('s3')->exists($pathFile))) {
            $data = Storage::disk('s3')->delete($pathFile);
            $initial['status'] = $data;
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
