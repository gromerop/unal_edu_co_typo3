<?php

declare(strict_types=1);

namespace UNAL\UnalNews\Api;

use Psr\Log\LoggerInterface;
use Throwable;
use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Resource\ResourceFactory;
use TYPO3\CMS\Core\Resource\StorageRepository;

final class NewsApiFalResolver
{
    private const FILE_STORAGE_UID = 1;
    private const DEFAULT_IMAGE_IDENTIFIER = '/user_upload/logo_tv.svg';

    public function __construct(
        private readonly ConnectionPool $connectionPool,
        private readonly ResourceFactory $resourceFactory,
        private readonly StorageRepository $storageRepository,
        private readonly LoggerInterface $logger,
    ) {
    }

    /**
     * Resuelve los archivos necesarios para el resumen de una colección.
     *
     * @param int[] $newsUids
     *
     * @return array<int, array{
     *     image: string,
     *     video: string,
     *     duration: string
     * }>
     */
    public function resolveSummaryAssets(array $newsUids): array
    {
        $newsUids = array_values(
            array_unique(
                array_filter(
                    array_map('intval', $newsUids),
                    static fn(int $uid): bool => $uid > 0
                )
            )
        );

        if ($newsUids === []) {
            return [];
        }

        $defaultImageUrl = $this->resolveDefaultImageUrl();
        $assets = [];

        foreach ($newsUids as $newsUid) {
            $assets[$newsUid] = [
                'image' => $defaultImageUrl,
                'video' => '',
                'duration' => '',
            ];
        }

        foreach ($this->findFileReferenceRows($newsUids) as $row) {
            $newsUid = (int)$row['uid_foreign'];
            $fieldName = (string)$row['fieldname'];

            if (!isset($assets[$newsUid])) {
                continue;
            }

            try {
                /*
                 * La fila ya fue consultada y filtrada. El tercer parámetro
                 * evita que ResourceFactory vuelva a aplicar overlays.
                 */
                $fileReference = $this->resourceFactory
                    ->getFileReferenceObject(
                        (int)$row['uid'],
                        $row,
                        true
                    );

                $publicUrl = $fileReference->getPublicUrl() ?? '';
                if ($publicUrl === '') {
                    continue;
                }

                if (
                    $fieldName === 'fal_media'
                    && $assets[$newsUid]['image'] === $defaultImageUrl
                    && str_starts_with(
                        strtolower($fileReference->getMimeType()),
                        'image/'
                    )
                ) {
                    $assets[$newsUid]['image'] = $publicUrl;
                    continue;
                }

                if (
                    $fieldName === 'fal_related_files'
                    && $assets[$newsUid]['video'] === ''
                    && str_starts_with(
                        strtolower($fileReference->getMimeType()),
                        'video/'
                    )
                ) {
                    $assets[$newsUid]['video'] = $publicUrl;

                    /*
                     * La duración se resolverá posteriormente sin ejecutar
                     * comandos del sistema desde la solicitud web.
                     */
                    $assets[$newsUid]['duration'] = '';
                }
            } catch (Throwable $exception) {
                $this->logger->warning(
                    'Could not resolve a FAL reference for the UNAL News API.',
                    [
                        'newsUid' => $newsUid,
                        'fileReferenceUid' => (int)$row['uid'],
                        'exception' => $exception,
                    ]
                );
            }
        }

        return $assets;
    }

    /**
     * Resuelve todas las imágenes, audios y videos utilizados por las
     * exportaciones de convergencia.
     *
     * @param int[] $newsUids
     *
     * @return array<
     *     int,
     *     array{
     *         primaryImage: string,
     *         images: array<int, array{
     *             referenceUid: int,
     *             fileUid: int,
     *             url: string,
     *             mimeType: string,
     *             extension: string
     *         }>,
     *         audio: array<int, array{
     *             referenceUid: int,
     *             fileUid: int,
     *             url: string,
     *             mimeType: string,
     *             extension: string
     *         }>,
     *         video: array<int, array{
     *             referenceUid: int,
     *             fileUid: int,
     *             url: string,
     *             mimeType: string,
     *             extension: string
     *         }>
     *     }
     * >
     */
    public function resolveConvergenceMedia(array $newsUids): array
    {
        $newsUids = array_values(
            array_unique(
                array_filter(
                    array_map('intval', $newsUids),
                    static fn(int $uid): bool => $uid > 0
                )
            )
        );

        if ($newsUids === []) {
            return [];
        }

        $defaultImageUrl = $this->resolveDefaultImageUrl();
        $resolved = [];

        foreach ($newsUids as $newsUid) {
            $resolved[$newsUid] = [
                'primaryImage' => $defaultImageUrl,
                'images' => [],
                'audio' => [],
                'video' => [],
            ];
        }

        foreach ($this->findFileReferenceRows($newsUids) as $row) {
            $newsUid = (int)$row['uid_foreign'];
            $fieldName = (string)$row['fieldname'];

            if (!isset($resolved[$newsUid])) {
                continue;
            }

            try {
                $fileReference = $this->resourceFactory
                    ->getFileReferenceObject(
                        (int)$row['uid'],
                        $row,
                        true
                    );

                $publicUrl = $fileReference->getPublicUrl() ?? '';
                if ($publicUrl === '') {
                    continue;
                }

                $mimeType = strtolower($fileReference->getMimeType());
                $extension = strtolower($fileReference->getExtension());

                $media = [
                    'referenceUid' => (int)$row['uid'],
                    'fileUid' => (int)$fileReference
                        ->getOriginalFile()
                        ->getUid(),
                    'url' => $publicUrl,
                    'mimeType' => $mimeType,
                    'extension' => $extension,
                ];

                /*
                * Los elementos de fal_media pueden ser imágenes, audios
                * o videos.
                */
                if ($fieldName === 'fal_media') {
                    if (str_starts_with($mimeType, 'image/')) {
                        $resolved[$newsUid]['images'][] = $media;

                        if (
                            $resolved[$newsUid]['primaryImage']
                            === $defaultImageUrl
                        ) {
                            $resolved[$newsUid]['primaryImage'] = $publicUrl;
                        }

                        continue;
                    }

                    if (str_starts_with($mimeType, 'audio/')) {
                        $resolved[$newsUid]['audio'][] = $media;
                        continue;
                    }

                    if (str_starts_with($mimeType, 'video/')) {
                        $resolved[$newsUid]['video'][] = $media;
                    }

                    continue;
                }

                /*
                * Solo se consideran videos reales. Esto evita interpretar como
                * video las imágenes mal almacenadas en fal_related_files.
                */
                if (
                    $fieldName === 'fal_related_files'
                    && str_starts_with($mimeType, 'video/')
                ) {
                    $resolved[$newsUid]['video'][] = $media;
                }
            } catch (Throwable $exception) {
                $this->logger->warning(
                    'Could not resolve convergence media for the UNAL News API.',
                    [
                        'newsUid' => $newsUid,
                        'fileReferenceUid' => (int)$row['uid'],
                        'exception' => $exception,
                    ]
                );
            }
        }

        return $resolved;
    }

    /**
     * @param int[] $newsUids
     *
     * @return array<int, array<string, mixed>>
     */
    private function findFileReferenceRows(array $newsUids): array
    {
        $queryBuilder = $this->connectionPool
            ->getQueryBuilderForTable('sys_file_reference');

        $queryBuilder->getRestrictions()->removeAll();

        return $queryBuilder
            ->select('*')
            ->from('sys_file_reference')
            ->where(
                $queryBuilder->expr()->eq(
                    'tablenames',
                    $queryBuilder->createNamedParameter(
                        'tx_news_domain_model_news'
                    )
                ),
                $queryBuilder->expr()->in(
                    'fieldname',
                    $queryBuilder->createNamedParameter(
                        ['fal_media', 'fal_related_files'],
                        Connection::PARAM_STR_ARRAY
                    )
                ),
                $queryBuilder->expr()->in(
                    'uid_foreign',
                    $queryBuilder->createNamedParameter(
                        $newsUids,
                        Connection::PARAM_INT_ARRAY
                    )
                ),
                $queryBuilder->expr()->eq(
                    'deleted',
                    $queryBuilder->createNamedParameter(
                        0,
                        Connection::PARAM_INT
                    )
                ),
                $queryBuilder->expr()->eq(
                    'hidden',
                    $queryBuilder->createNamedParameter(
                        0,
                        Connection::PARAM_INT
                    )
                ),
                $queryBuilder->expr()->eq(
                    't3ver_wsid',
                    $queryBuilder->createNamedParameter(
                        0,
                        Connection::PARAM_INT
                    )
                )
            )
            ->orderBy('uid_foreign', 'ASC')
            ->addOrderBy('fieldname', 'ASC')
            ->addOrderBy('sorting_foreign', 'ASC')
            ->addOrderBy('uid', 'ASC')
            ->executeQuery()
            ->fetchAllAssociative();
    }

    private function resolveDefaultImageUrl(): string
    {
        try {
            $storage = $this->storageRepository->findByUid(
                self::FILE_STORAGE_UID
            );

            if (
                $storage === null
                || !$storage->hasFile(self::DEFAULT_IMAGE_IDENTIFIER)
            ) {
                return '';
            }

            return $storage
                ->getFile(self::DEFAULT_IMAGE_IDENTIFIER)
                ->getPublicUrl() ?? '';
        } catch (Throwable $exception) {
            $this->logger->warning(
                'Could not resolve the default image for the UNAL News API.',
                [
                    'storageUid' => self::FILE_STORAGE_UID,
                    'identifier' => self::DEFAULT_IMAGE_IDENTIFIER,
                    'exception' => $exception,
                ]
            );

            return '';
        }
    }
}