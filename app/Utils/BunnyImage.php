<?php

namespace App\Mapping;

use App\Models\ProfileImage;
use Bunny\Storage\Client;
use Illuminate\Support\Str;
use App\Mapping\FieldsMapping;

trait BunnyImage
{
    use FieldsMapping;

    private function generateUniqueHash(): string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $hash       = '';

        for ($i = 0; $i < 6; $i++) {
            $hash .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $hash;
    }

    private function generateImageFileName($imageId, $imageType): string
    {
        $hash = $this->generateUniqueHash();
        return "{$imageId}_{$hash}.{$imageType}";
    }

    public function uploadRegister(
        $user,
        $images
    ) {
        $bunnyCDNStorage = new Client(
            env('BUNNY_CLIENT_API_KEY'),
            env('BUNNY_CLIENT_STORAGE_ZONE_NAME'),
            env('BUNNY_CLIENT_STORAGE_ZONE_REGION')
        );

        foreach ($images as $imageId => $image) {
            $image = preg_replace('/data:image\/\s*(\w+)\s*;/', 'data:image/$1;', $image);

            if (!is_numeric($imageId) || $imageId < 0 || $imageId > 5) {
                continue;
            }

            if (!preg_match('/^data:image\/(jpeg|jpg|png);base64,/', $image)) {
                continue;
            }

            try {

                $data = preg_replace('/\s+/', '', $image);
                preg_match('/^data:image\/(jpeg|jpg|png);base64,/', $data, $matches);

                if (!isset($matches[1])) {
                    continue;
                }

                $imageType    = $matches[1];
                $base64_image = substr($data, strpos($data, ',') + 1);
                $imageData    = base64_decode($base64_image);

                $newFileName = $this->generateImageFileName($imageId, $imageType);

                if (!file_put_contents($newFileName, $imageData)) {
                    throw new \Exception('Could not save temporary file');
                }

                $pathInBunnyCDN = $user->{self::ID}.'/'.$newFileName;
                if (!$bunnyCDNStorage->upload($newFileName, $pathInBunnyCDN)) {
                    unlink($newFileName);
                    throw new \Exception('Failed to upload to BunnyCDN');
                }

                unlink($newFileName);

                ProfileImage::create([
                    self::PROFILE_ID => $user->{self::ID},
                    self::TITLE      => $newFileName,
                    self::URL        => env('BUNNY_CLIENT_APP_CDN_URL').'/'.$pathInBunnyCDN
                ]);

            } catch (\Exception $e) {
                continue;
            }
        }
    }

    public function updateImages($user, $images)
    {
        $bunnyCDNStorage = new Client(
            env('BUNNY_CLIENT_API_KEY'),
            env('BUNNY_CLIENT_STORAGE_ZONE_NAME'),
            env('BUNNY_CLIENT_STORAGE_ZONE_REGION')
        );

        $existingImages = $user->images()->orderBy('id')->get();

        foreach ($images as $index => $image) {
            if (!is_numeric($index) || $index < 0 || $index > 5) {
                continue;
            }

            if (!preg_match('/^data:image\/(jpeg|jpg|png);base64,/', $image)) {
                continue;
            }

            try {
                if ($index < $existingImages->count()) {
                    $existingImage = $existingImages[$index];
                    try {
                        $bunnyCDNStorage->delete("{$user->{self::ID}}/{$existingImage->{self::TITLE}}");
                    } catch (\Exception $e) {
                        \Log::error('Error deleting old image from BunnyCDN: '.$e->getMessage());
                    }
                    $existingImage->delete();
                }

                $data           = preg_replace('/\s+/', '', $image);
                preg_match('/^data:image\/(jpeg|jpg|png);base64,/', $data, $matches);

                if (!isset($matches[1])) {
                    throw new \Exception('Invalid image format');
                }

                $imageType    = $matches[1];
                $base64_image = substr($data, strpos($data, ',') + 1);
                $imageData    = base64_decode($base64_image);
                $newFileName  = $this->generateImageFileName($index, $imageType);

                if (!file_put_contents($newFileName, $imageData)) {
                    throw new \Exception('Could not save temporary file');
                }

                $pathInBunnyCDN = "{$user->{self::ID}}/{$newFileName}";
                if (!$bunnyCDNStorage->upload($newFileName, $pathInBunnyCDN)) {
                    unlink($newFileName);
                    throw new \Exception('Failed to upload to BunnyCDN');
                }

                unlink($newFileName);

                ProfileImage::create([
                    self::PROFILE_ID => $user->{self::ID},
                    self::TITLE      => $newFileName,
                    self::URL        => env('BUNNY_CLIENT_APP_CDN_URL').'/'.$pathInBunnyCDN
                ]);

            } catch (\Exception $e) {
                \Log::error('Error in updateImages: '.$e->getMessage());
                continue;
            }
        }
    }

    public function deleteImagesByIndex($user, $imageIndexes)
    {
        $bunnyCDNStorage = new Client(
            env('BUNNY_CLIENT_API_KEY'),
            env('BUNNY_CLIENT_STORAGE_ZONE_NAME'),
            env('BUNNY_CLIENT_STORAGE_ZONE_REGION')
        );

        $images = $user->images()->orderBy('id')->get();

        foreach ($imageIndexes as $index) {
            if (!is_numeric($index) || $index < 0 || $index >= $images->count()) {
                continue;
            }

            $image = $images[$index];

            if ($image) {
                try {
                    $path = "{$user->{self::ID}}/{$image->{self::TITLE}}";
                    $bunnyCDNStorage->delete($path);
                } catch (\Exception $e) {
                    \Log::error('Error deleting image from BunnyCDN: '.$e->getMessage());
                }

                $image->delete();
            }
        }
    }
}
