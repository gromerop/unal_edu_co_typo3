<?php

namespace UNAL\UnalNews\Utility;

class FirstMediaImage
{
    public static function getPath($falMedia)
    {
        $media_path = 'fileadmin/user_upload/logo_tv.svg';
        foreach ($falMedia as $media) {
            $pos = strpos($media->getOriginalResource()->getOriginalFile()->getProperties()['mime_type'], 'image');
            if ($pos !== false) {
                $media_path = $media->getOriginalResource()->getPublicUrl();
                break;
            }
        }
        return $media_path;
    }
}