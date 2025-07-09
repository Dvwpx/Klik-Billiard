<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CloudinaryController extends Controller
{
    /**
     * Generate signed upload parameters untuk direct upload
     */
    public function getSignedUploadParams(Request $request): JsonResponse
    {
        $timestamp = time();
        $cloudName = config('cloudinary.cloud_name');
        $apiKey = config('cloudinary.api_key');
        $apiSecret = config('cloudinary.api_secret');

        // Parameter untuk upload
        $params = [
            'timestamp' => $timestamp,
            'folder' => 'uploads', // folder di Cloudinary
            'resource_type' => 'auto', // auto detect image/video
            'public_id' => uniqid('img_'), // unique ID untuk file
        ];

        // Optional: tambahkan transformasi
        if ($request->has('transformation')) {
            $params['transformation'] = $request->input('transformation');
        }

        // Optional: tambahkan tags
        if ($request->has('tags')) {
            $params['tags'] = $request->input('tags');
        }

        // Generate signature
        $signature = $this->generateSignature($params, $apiSecret);

        return response()->json([
            'success' => true,
            'data' => [
                'url' => "https://api.cloudinary.com/v1_1/{$cloudName}/image/upload",
                'params' => array_merge($params, [
                    'signature' => $signature,
                    'api_key' => $apiKey
                ])
            ]
        ]);
    }

    /**
     * Generate signature untuk Cloudinary
     */
    private function generateSignature(array $params, string $apiSecret): string
    {
        // Sort parameters
        ksort($params);

        // Build string to sign
        $stringToSign = '';
        foreach ($params as $key => $value) {
            if (!empty($value)) {
                $stringToSign .= $key . '=' . $value . '&';
            }
        }

        // Remove trailing &
        $stringToSign = rtrim($stringToSign, '&');

        // Add API secret
        $stringToSign .= $apiSecret;

        return sha1($stringToSign);
    }

    /**
     * Handle success callback dari frontend
     */
    public function uploadSuccess(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'public_id' => 'required|string',
            'secure_url' => 'required|url',
            'format' => 'required|string',
            'resource_type' => 'required|string',
            'bytes' => 'required|integer',
            'width' => 'nullable|integer',
            'height' => 'nullable|integer',
        ]);

        // Simpan data ke database jika perlu
        // $image = new Image();
        // $image->cloudinary_id = $validated['public_id'];
        // $image->url = $validated['secure_url'];
        // $image->format = $validated['format'];
        // $image->size = $validated['bytes'];
        // $image->width = $validated['width'];
        // $image->height = $validated['height'];
        // $image->save();

        return response()->json([
            'success' => true,
            'message' => 'Upload berhasil',
            'data' => $validated
        ]);
    }

    /**
     * Handle error callback dari frontend
     */
    public function uploadError(Request $request): JsonResponse
    {
        $error = $request->input('error');

        // Log error jika perlu
        \Log::error('Cloudinary upload failed: ' . json_encode($error));

        return response()->json([
            'success' => false,
            'message' => 'Upload gagal',
            'error' => $error
        ], 400);
    }

    /**
     * Get upload widget configuration
     */
    public function getUploadConfig(): JsonResponse
    {
        return response()->json([
            'cloudName' => config('cloudinary.cloud_name'),
            'uploadPreset' => config('cloudinary.upload_preset', 'ml_default'), // buat preset di dashboard
            'folder' => 'uploads',
            'maxFileSize' => 50000000, // 50MB
            'maxImageFileSize' => 10000000, // 10MB
            'maxVideoFileSize' => 50000000, // 50MB
            'allowedFormats' => ['jpg', 'jpeg', 'png', 'gif', 'svg', 'webp'],
            'cropping' => true,
            'multiple' => false,
            'resourceType' => 'auto',
            'clientAllowedFormats' => ['images', 'videos'],
            'maxImageWidth' => 2000,
            'maxImageHeight' => 2000,
            'sources' => ['local', 'url', 'camera'],
            'showAdvancedOptions' => false,
            'cropping' => 'server',
            'croppingAspectRatio' => 1,
            'croppingShowDimensions' => true,
            'language' => 'id',
            'text' => [
                'id' => [
                    'or' => 'Atau',
                    'back' => 'Kembali',
                    'advanced' => 'Lanjutan',
                    'close' => 'Tutup',
                    'no_results' => 'Tidak ada hasil',
                    'search_placeholder' => 'Cari file',
                    'about_uw' => 'Tentang Upload Widget',
                ]
            ]
        ]);
    }
}
