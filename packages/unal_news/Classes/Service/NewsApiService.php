<?php

declare(strict_types=1);

namespace UNAL\UnalNews\Service;

use UNAL\UnalNews\Api\NewsApiCategoryResolver;
use UNAL\UnalNews\Api\NewsApiFalResolver;
use UNAL\UnalNews\Api\NewsApiReadRepository;
use UNAL\UnalNews\Api\NewsApiSerializer;
use UNAL\UnalNews\Api\NewsApiVisitRepository;

final class NewsApiService
{
    private const PAGE_SIZE = 9;
    private const CONVERGENCE_PAGE_SIZE = 100;

    public function __construct(
        private readonly NewsApiReadRepository $newsApiReadRepository,
        private readonly NewsApiFalResolver $newsApiFalResolver,
        private readonly NewsApiCategoryResolver $newsApiCategoryResolver,
        private readonly NewsApiSerializer $newsApiSerializer,
        private readonly NewsApiVisitRepository $newsApiVisitRepository,
    ) {
    }

    public function list(
        int $page,
        string $endpointBaseUrl,
        string $siteBaseUrl,
    ): array {
        $page = max(1, $page);
        $endpointBaseUrl = rtrim($endpointBaseUrl, '/');

        $totalElements = $this->newsApiReadRepository->countVisible();
        $totalPages = (int)ceil($totalElements / self::PAGE_SIZE);

        $rows = $this->newsApiReadRepository->findPage(
            $page,
            self::PAGE_SIZE
        );

        $results = $this->serializeDatabaseRows(
            $rows,
            $siteBaseUrl
        );

        return [
            'info' => [
                'count' => $totalElements,
                'pages' => $totalPages,
                'next' => $page < $totalPages
                    ? $endpointBaseUrl . '/page/' . ($page + 1)
                    : '',
                'prev' => $page > 1
                    ? $endpointBaseUrl . '/page/' . ($page - 1)
                    : '',
            ],
            'results' => $results,
        ];
    }

    public function show(int $uid, string $siteBaseUrl): ?array
    {
        $row = $this->newsApiReadRepository->findVisibleByUid($uid);

        if ($row === null) {
            return null;
        }

        return $this->serializeDatabaseRows(
            [$row],
            $siteBaseUrl
        )[0] ?? null;
    }

    public function related(
        int $size,
        string $siteBaseUrl,
    ): array {
        $size = max(1, min(100, $size));

        $rows = $this->newsApiReadRepository->findPage(1, $size);

        return $this->serializeDatabaseRows(
            $rows,
            $siteBaseUrl
        );
    }

    public function autocomplete(string $search): array
    {
        return $this->newsApiReadRepository
            ->findAutocompleteTitles($search, 10);
    }

    public function all(
        string $type,
        int $page,
        string $siteBaseUrl,
    ): array {
        $page = max(1, $page);

        $rows = $this->newsApiReadRepository
            ->findConvergencePage(
                $page,
                self::CONVERGENCE_PAGE_SIZE
            );

        if ($type === 'new') {
            return $this->serializeConvergenceRows(
                $rows,
                $siteBaseUrl
            );
        }

        return $this->serializeConvergenceMediaRows(
            $rows,
            $siteBaseUrl,
            $type
        );
    }

    public function deletedSinceYesterday(): array
    {
        return $this->newsApiReadRepository
            ->findDeletedUidsSince(time() - 86400);
    }

    public function editedSinceYesterday(
        string $siteBaseUrl,
    ): array {
        $rows = $this->newsApiReadRepository
            ->findEditedSince(time() - 86400);

        return $this->serializeConvergenceRows(
            $rows,
            $siteBaseUrl
        );
    }

    public function registerVisit(int $newsUid): bool
    {
        return $this->newsApiVisitRepository
            ->registerVisit($newsUid);
    }

    /**
     * @param array<int, array<string, mixed>> $rows
     *
     * @return array<int, array<string, mixed>>
     */
    private function serializeConvergenceMediaRows(
        array $rows,
        string $siteBaseUrl,
        string $type,
    ): array {
        if ($rows === []) {
            return [];
        }

        $newsUids = array_map(
            static fn(array $row): int => (int)$row['uid'],
            $rows
        );

        $mediaByNewsUid = $this->newsApiFalResolver
            ->resolveConvergenceMedia($newsUids);

        $categoriesByNewsUid = $this->newsApiCategoryResolver
            ->resolveConvergenceCategories($newsUids);

        $results = [];

        foreach ($rows as $row) {
            $newsUid = (int)$row['uid'];

            $serializedMedia = $this->newsApiSerializer
                ->convergenceMediaRecords(
                    $row,
                    $siteBaseUrl,
                    $type,
                    $mediaByNewsUid[$newsUid] ?? [
                        'primaryImage' => '',
                        'images' => [],
                        'audio' => [],
                        'video' => [],
                    ],
                    $categoriesByNewsUid[$newsUid] ?? [
                        'categories' => [],
                        'recordCategory' => [],
                    ],
                );

            foreach ($serializedMedia as $mediaRecord) {
                $results[] = $mediaRecord;
            }
        }

        return $results;
    }

    /**
     * @param array<int, array<string, mixed>> $rows
     *
     * @return array<int, array<string, mixed>>
     */
    private function serializeConvergenceRows(
        array $rows,
        string $siteBaseUrl,
    ): array {
        if ($rows === []) {
            return [];
        }

        $newsUids = array_map(
            static fn(array $row): int => (int)$row['uid'],
            $rows
        );

        $mediaByNewsUid = $this->newsApiFalResolver
            ->resolveConvergenceMedia($newsUids);

        $categoriesByNewsUid = $this->newsApiCategoryResolver
            ->resolveConvergenceCategories($newsUids);

        $results = [];

        foreach ($rows as $row) {
            $newsUid = (int)$row['uid'];

            $results[] = $this->newsApiSerializer->convergenceNews(
                $row,
                $siteBaseUrl,
                $mediaByNewsUid[$newsUid] ?? [
                    'primaryImage' => '',
                    'images' => [],
                    'audio' => [],
                    'video' => [],
                ],
                $categoriesByNewsUid[$newsUid] ?? [
                    'categories' => [],
                    'recordCategory' => [],
                ],
            );
        }

        return $results;
    }

    /**
     * @param array<int, array<string, mixed>> $rows
     *
     * @return array<int, array<string, mixed>>
     */
    private function serializeDatabaseRows(
        array $rows,
        string $siteBaseUrl,
    ): array {
        if ($rows === []) {
            return [];
        }

        $newsUids = array_map(
            static fn(array $row): int => (int)$row['uid'],
            $rows
        );

        $assetsByNewsUid = $this->newsApiFalResolver
            ->resolveSummaryAssets($newsUids);

        $categoriesByNewsUid = $this->newsApiCategoryResolver
            ->resolveSummaryCategories($newsUids);

        $results = [];

        foreach ($rows as $row) {
            $newsUid = (int)$row['uid'];

            $assets = $assetsByNewsUid[$newsUid] ?? [
                'image' => '',
                'video' => '',
                'duration' => '',
            ];

            $results[] = $this->newsApiSerializer->summary(
                $row,
                $siteBaseUrl,
                $assets['image'],
                $assets['video'],
                $assets['duration'],
                $categoriesByNewsUid[$newsUid] ?? [],
            );
        }

        return $results;
    }
}
