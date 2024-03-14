<?php

namespace App\Services\Api;

use App\Services\BaseService;
use Illuminate\Http\Request;

/**
 * Class AmazonS3Service
 * @package App\Services
 */
class AmazonS3Service extends BaseService
{
    public function uploadImageToS3(Request $request)
    {
        $data = $this->multipartUploaderToS3('images', $request->file('file'), 'user');
        return $data;
    }

    public function deleteImageFromS3(Request $request) {
        $filePath = [
            'images/user/image113_1710387787.png',
            'images/user/pations_1710388990.png'
        ];
        $data = $this->deleteObjectS3($filePath);
        return $data;
    }
}
