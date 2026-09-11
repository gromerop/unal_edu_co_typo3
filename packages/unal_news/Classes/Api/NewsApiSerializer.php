<?php

declare(strict_types=1);

namespace UNAL\UnalNews\Api;

use DateTimeImmutable;
use DateTimeZone;

final class NewsApiSerializer
{

    /**
     * @param array<string, mixed> $row
     * @param array<string, array<int, array{uid: int, name: string}>> $categories
     *
     * @return array<string, mixed>
     */
    public function summary(
        array $row,
        string $siteBaseUrl,
        ?string $imagePath = null,
        ?string $videoPath = null,
        string $duration = '',
        array $categories = [],
    ): array {
        $siteBaseUrl = $this->normalizeBaseUrl($siteBaseUrl);
        $imagePath = $imagePath ?: '';
        $videoPath = $videoPath ?: '';

        return [
            'id' => (int)$row['uid'],
            'title' => (string)($row['title'] ?? ''),
            'alternativeTitle' => (string)($row['alternative_title'] ?? ''),
            'teaser' => (string)($row['teaser'] ?? ''),
            'date' => $this->formatTimestamp((int)($row['datetime'] ?? 0)),
            'imagen' => $this->absoluteUrl($siteBaseUrl, $imagePath),
            'video' => $this->absoluteUrl($siteBaseUrl, $videoPath),
            'duration' => $videoPath !== '' ? $duration : '',
            'vistas' => (int)($row['counter'] ?? 0),
            'url' => $siteBaseUrl,
            'domain' => $siteBaseUrl,
            'categories' => $categories,
        ];
    }

    /**
     * Serializa una noticia para las exportaciones de convergencia.
     *
     * @param array<string, mixed> $row
     * @param array{
     *     primaryImage?: string,
     *     images?: array<int, array<string, mixed>>,
     *     audio?: array<int, array<string, mixed>>,
     *     video?: array<int, array<string, mixed>>
     * } $media
     * @param array{
     *     categories?: array<
     *         string,
     *         array<int, array{uid: int, name: string}>
     *     >,
     *     recordCategory?: string[]
     * } $categoryData
     *
     * @return array<string, mixed>
     */
    public function convergenceNews(
        array $row,
        string $siteBaseUrl,
        array $media = [],
        array $categoryData = [],
    ): array {
        $siteBaseUrl = $this->normalizeBaseUrl($siteBaseUrl);
        $date = $this->formatTimestamp((int)($row['datetime'] ?? 0));

        $images = $this->mediaUrls(
            $media['images'] ?? [],
            $siteBaseUrl
        );

        $audio = $this->mediaUrls(
            $media['audio'] ?? [],
            $siteBaseUrl
        );

        $video = $this->mediaUrls(
            $media['video'] ?? [],
            $siteBaseUrl
        );

        return [
            'id' => (int)$row['uid'],
            'title' => (string)($row['title'] ?? ''),
            'alternativeTitle' => (string)(
                $row['alternative_title'] ?? ''
            ),
            'teaser' => (string)($row['teaser'] ?? ''),
            'date' => $date,
            'recordDate' => $date,
            'imagen' => $this->absoluteUrl(
                $siteBaseUrl,
                (string)($media['primaryImage'] ?? '')
            ),
            'vistas' => (int)($row['counter'] ?? 0),
            'media' => [
                'imagesCount' => count($images),
                'audioCount' => count($audio),
                'videoCount' => count($video),
                'images' => $images,
                'audio' => $audio,
                'video' => $video,
            ],
            /*
            * La implementación histórica calculaba una URL de detalle,
            * pero finalmente devolvía siempre la base del sitio.
            */
            'url' => $siteBaseUrl,
            'domain' => $siteBaseUrl,
            'categories' => $categoryData['categories'] ?? [],
            'recordCategory' => $categoryData['recordCategory'] ?? [],
        ];
    }

    /**
     * Serializa los archivos individuales para las exportaciones
     * all/image, all/video y all/audio.
     *
     * @param array<string, mixed> $row
     * @param array{
     *     images?: array<int, array<string, mixed>>,
     *     audio?: array<int, array<string, mixed>>,
     *     video?: array<int, array<string, mixed>>
     * } $media
     * @param array{recordCategory?: string[]} $categoryData
     *
     * @return array<int, array<string, mixed>>
     */
    public function convergenceMediaRecords(
        array $row,
        string $siteBaseUrl,
        string $type,
        array $media = [],
        array $categoryData = [],
    ): array {
        $mediaKey = match ($type) {
            'image' => 'images',
            'audio' => 'audio',
            'video' => 'video',
            default => null,
        };

        if ($mediaKey === null) {
            return [];
        }

        $siteBaseUrl = $this->normalizeBaseUrl($siteBaseUrl);
        $date = $this->formatTimestamp((int)($row['datetime'] ?? 0));
        $newsUid = (int)$row['uid'];
        $results = [];

        foreach ($media[$mediaKey] ?? [] as $mediaItem) {
            $referenceUid = (int)($mediaItem['referenceUid'] ?? 0);
            $fileUrl = (string)($mediaItem['url'] ?? '');

            if ($referenceUid < 1 || $fileUrl === '') {
                continue;
            }

            $results[] = [
                /*
                * Se conserva la forma histórica del identificador porque puede
                * estar indexada por consumidores externos.
                */
                'id' => $referenceUid . $newsUid . 'television',
                'id_new' => $newsUid,
                'title' => (string)($row['title'] ?? ''),
                'product' => 'television_unal',
                'recordCategory' => $categoryData['recordCategory'] ?? [],
                'alternativeTitle' => (string)(
                    $row['alternative_title'] ?? ''
                ),
                'teaser' => (string)($row['teaser'] ?? ''),
                'date' => $date,
                'recordDate' => $date,
                'vistas' => (int)($row['counter'] ?? 0),

                /*
                * La captura histórica devolvía una cadena vacía.
                * Se conserva hasta definir una URL pública de detalle.
                */
                'url' => '',
                'baseUrl' => $siteBaseUrl,
                'file' => $this->absoluteUrl(
                    $siteBaseUrl,
                    $fileUrl
                ),
            ];
        }

        return $results;
    }

    /**
     * @param array<int, array<string, mixed>> $mediaItems
     *
     * @return string[]
     */
    private function mediaUrls(
        array $mediaItems,
        string $siteBaseUrl,
    ): array {
        $urls = [];

        foreach ($mediaItems as $mediaItem) {
            $url = (string)($mediaItem['url'] ?? '');

            if ($url === '') {
                continue;
            }

            $urls[] = $this->absoluteUrl(
                $siteBaseUrl,
                $url
            );
        }

        return $urls;
    }

    private function formatTimestamp(int $timestamp): string
    {
        $date = new DateTimeImmutable('@' . $timestamp);

        return $date
            ->setTimezone(new DateTimeZone(date_default_timezone_get()))
            ->format(DATE_ATOM);
    }

    private function normalizeBaseUrl(string $baseUrl): string
    {
        return rtrim($baseUrl, '/') . '/';
    }

    private function absoluteUrl(string $baseUrl, string $path): string
    {
        if ($path === '') {
            return '';
        }

        if (preg_match('#^https?://#i', $path) === 1) {
            return $path;
        }

        return $baseUrl . ltrim($path, '/');
    }
}