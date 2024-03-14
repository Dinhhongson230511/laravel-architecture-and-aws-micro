<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\DefaultController;
use App\Services\Api\AmazonS3Service;
use Illuminate\Http\Request;

class S3ExampleController extends DefaultController
{
    protected $amazonS3Service;

    public function __construct(AmazonS3Service $amazonS3Service)
    {
        $this->amazonS3Service = $amazonS3Service;
    }

    public function uploadImageToS3(Request $request) {
        $response = $this->amazonS3Service->uploadImageToS3($request);
        if ($response['status']) {
            return $this->responseSuccess(
                $response,
                __('common.success_message')
            );
        }
        return $this->responseBadRequest();
    }

    public function deleteImageFromS3(Request $request) {
        $response = $this->amazonS3Service->deleteImageFromS3($request);
        if ($response['status']) {
            return $this->responseSuccess(
                $response,
                __('common.success_message')
            );
        }
        return $this->responseBadRequest();
    }
}
