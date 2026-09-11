<?php

declare(strict_types=1);

namespace UNAL\UnalNews\Api;

use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;

final class NewsApiCategoryResolver
{
    private const CATEGORY_GROUPS = [
        1 => 'sede',
        2 => 'areaConvergencia',
        3 => 'especial',
    ];

    public function __construct(
        private readonly ConnectionPool $connectionPool,
    ) {
    }

    /**
     * @param int[] $newsUids
     *
     * @return array<
     *     int,
     *     array<string, array<int, array{uid: int, name: string}>>
     * >
     */
    public function resolveSummaryCategories(array $newsUids): array
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

        $categories = [];
        $registeredCategories = [];

        foreach ($newsUids as $newsUid) {
            $categories[$newsUid] = [];
        }

        foreach ($this->findCategoryRows($newsUids) as $row) {
            $newsUid = (int)$row['news_uid'];
            $categoryUid = (int)$row['category_uid'];
            $parentUid = (int)$row['parent_uid'];

            $group = self::CATEGORY_GROUPS[$parentUid] ?? null;
            if ($group === null || !isset($categories[$newsUid])) {
                continue;
            }

            /*
             * Evita categorías duplicadas si la tabla de relaciones contiene
             * accidentalmente más de una relación equivalente.
             */
            if (
                isset(
                    $registeredCategories[$newsUid][$group][$categoryUid]
                )
            ) {
                continue;
            }

            $categories[$newsUid][$group][] = [
                'uid' => $categoryUid,
                'name' => (string)$row['category_title'],
            ];

            $registeredCategories[$newsUid][$group][$categoryUid] = true;
        }

        return $categories;
    }

    /**
     * Resuelve las categorías utilizadas por las exportaciones de convergencia.
     *
     * @param int[] $newsUids
     *
     * @return array<
     *     int,
     *     array{
     *         categories: array<
     *             string,
     *             array<int, array{uid: int, name: string}>
     *         >,
     *         recordCategory: string[]
     *     }
     * >
     */
    public function resolveConvergenceCategories(array $newsUids): array
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

        $resolved = [];
        $registeredAreaCategories = [];
        $registeredRecordCategories = [];

        foreach ($newsUids as $newsUid) {
            $resolved[$newsUid] = [
                'categories' => [],
                'recordCategory' => [],
            ];
        }

        foreach ($this->findCategoryRows($newsUids) as $row) {
            $newsUid = (int)$row['news_uid'];
            $categoryUid = (int)$row['category_uid'];
            $parentUid = (int)$row['parent_uid'];
            $categoryTitle = (string)$row['category_title'];

            if (!isset($resolved[$newsUid])) {
                continue;
            }

            /*
            * El padre 2 se utiliza tanto en categories.areaConvergencia
            * como en recordCategory.
            */
            if (
                $parentUid === 2
                && !isset(
                    $registeredAreaCategories[$newsUid][$categoryUid]
                )
            ) {
                $resolved[$newsUid]['categories']['areaConvergencia'][] = [
                    'uid' => $categoryUid,
                    'name' => $categoryTitle,
                ];

                $registeredAreaCategories[$newsUid][$categoryUid] = true;
            }

            /*
            * Los padres 2 y 11 forman parte de recordCategory.
            */
            if (
                in_array($parentUid, [2, 11], true)
                && !isset(
                    $registeredRecordCategories[$newsUid][$categoryUid]
                )
            ) {
                $resolved[$newsUid]['recordCategory'][] = $categoryTitle;

                $registeredRecordCategories[$newsUid][$categoryUid] = true;
            }
        }

        return $resolved;
    }

    /**
     * @param int[] $newsUids
     *
     * @return array<int, array<string, mixed>>
     */
    private function findCategoryRows(array $newsUids): array
    {
        $queryBuilder = $this->connectionPool
            ->getQueryBuilderForTable('sys_category_record_mm');

        $queryBuilder->getRestrictions()->removeAll();

        $now = time();
        $expression = $queryBuilder->expr();

        return $queryBuilder
            ->select(
                'relation.uid_foreign AS news_uid',
                'category.uid AS category_uid',
                'category.parent AS parent_uid',
                'category.title AS category_title',
                'relation.sorting_foreign AS relation_sorting'
            )
            ->from('sys_category_record_mm', 'relation')
            ->innerJoin(
                'relation',
                'sys_category',
                'category',
                $expression->eq(
                    'category.uid',
                    'relation.uid_local'
                )
            )
            ->where(
                $expression->eq(
                    'relation.tablenames',
                    $queryBuilder->createNamedParameter(
                        'tx_news_domain_model_news'
                    )
                ),
                $expression->eq(
                    'relation.fieldname',
                    $queryBuilder->createNamedParameter('categories')
                ),
                $expression->in(
                    'relation.uid_foreign',
                    $queryBuilder->createNamedParameter(
                        $newsUids,
                        Connection::PARAM_INT_ARRAY
                    )
                ),
                $expression->eq(
                    'category.deleted',
                    $queryBuilder->createNamedParameter(
                        0,
                        Connection::PARAM_INT
                    )
                ),
                $expression->eq(
                    'category.hidden',
                    $queryBuilder->createNamedParameter(
                        0,
                        Connection::PARAM_INT
                    )
                ),
                $expression->eq(
                    'category.t3ver_wsid',
                    $queryBuilder->createNamedParameter(
                        0,
                        Connection::PARAM_INT
                    )
                ),
                $expression->or(
                    $expression->eq(
                        'category.starttime',
                        $queryBuilder->createNamedParameter(
                            0,
                            Connection::PARAM_INT
                        )
                    ),
                    $expression->lte(
                        'category.starttime',
                        $queryBuilder->createNamedParameter(
                            $now,
                            Connection::PARAM_INT
                        )
                    )
                ),
                $expression->or(
                    $expression->eq(
                        'category.endtime',
                        $queryBuilder->createNamedParameter(
                            0,
                            Connection::PARAM_INT
                        )
                    ),
                    $expression->gt(
                        'category.endtime',
                        $queryBuilder->createNamedParameter(
                            $now,
                            Connection::PARAM_INT
                        )
                    )
                ),
                $expression->in(
                    'category.fe_group',
                    $queryBuilder->createNamedParameter(
                        ['', '0'],
                        Connection::PARAM_STR_ARRAY
                    )
                )
            )
            ->orderBy('relation.uid_foreign', 'ASC')
            ->addOrderBy('relation.sorting_foreign', 'ASC')
            ->addOrderBy('category.uid', 'ASC')
            ->executeQuery()
            ->fetchAllAssociative();
    }
}