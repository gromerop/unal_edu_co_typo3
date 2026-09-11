<?php

declare(strict_types=1);

namespace UNAL\UnalNews\Api;

use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;

final class NewsApiReadRepository
{
    private const TABLE = 'tx_news_domain_model_news';
    private const NEWS_TYPE = 'Tx_UnalNews_UnalNews';

    public function __construct(
        private readonly ConnectionPool $connectionPool,
    ) {
    }

    public function countVisible(): int
    {
        $queryBuilder = $this->createQueryBuilder();

        return (int)$queryBuilder
            ->count('uid')
            ->from(self::TABLE)
            ->executeQuery()
            ->fetchOne();
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function findPage(int $page, int $pageSize): array
    {
        $page = max(1, $page);
        $pageSize = max(1, $pageSize);

        $queryBuilder = $this->createQueryBuilder();

        return $queryBuilder
            ->select(
                'uid',
                'pid',
                'title',
                'alternative_title',
                'teaser',
                'datetime',
                'counter',
                'sorting'
            )
            ->from(self::TABLE)
            ->orderBy('sorting', 'ASC')
            ->addOrderBy('uid', 'ASC')
            ->setFirstResult(($page - 1) * $pageSize)
            ->setMaxResults($pageSize)
            ->executeQuery()
            ->fetchAllAssociative();
    }

    /**
     * Obtiene noticias para la exportación de convergencia.
     *
     * @return array<int, array<string, mixed>>
     */
    public function findConvergencePage(
        int $page,
        int $pageSize,
    ): array {
        $page = max(1, $page);
        $pageSize = max(1, min(1000, $pageSize));

        $queryBuilder = $this->createQueryBuilder();

        return $queryBuilder
            ->select(
                'uid',
                'pid',
                'title',
                'alternative_title',
                'teaser',
                'datetime',
                'counter',
                'sorting'
            )
            ->from(self::TABLE)
            ->orderBy('datetime', 'DESC')
            ->addOrderBy('uid', 'DESC')
            ->setFirstResult(($page - 1) * $pageSize)
            ->setMaxResults($pageSize)
            ->executeQuery()
            ->fetchAllAssociative();
    }

    /**
     * @return array<string, mixed>|null
     */
    public function findVisibleByUid(int $uid): ?array
    {
        if ($uid < 1) {
            return null;
        }

        $queryBuilder = $this->createQueryBuilder();

        $row = $queryBuilder
            ->select(
                'uid',
                'pid',
                'title',
                'alternative_title',
                'teaser',
                'datetime',
                'counter',
                'sorting'
            )
            ->from(self::TABLE)
            ->andWhere(
                $queryBuilder->expr()->eq(
                    'uid',
                    $queryBuilder->createNamedParameter(
                        $uid,
                        Connection::PARAM_INT
                    )
                )
            )
            ->setMaxResults(1)
            ->executeQuery()
            ->fetchAssociative();

        return is_array($row) ? $row : null;
    }

    /**
     * @return array<int, array{title: string}>
     */
    public function findAutocompleteTitles(
        string $search,
        int $limit = 10,
    ): array {
        $search = trim($search);
        $limit = max(1, min(50, $limit));

        if ($search === '') {
            return [];
        }

        $queryBuilder = $this->connectionPool
            ->getQueryBuilderForTable(self::TABLE);

        $queryBuilder->getRestrictions()->removeAll();

        $now = time();
        $expression = $queryBuilder->expr();
        $searchPattern = '%'
            . $queryBuilder->escapeLikeWildcards($search)
            . '%';

        return $queryBuilder
            ->select('title')
            ->from(self::TABLE)
            ->where(
                $expression->like(
                    'title',
                    $queryBuilder->createNamedParameter($searchPattern)
                ),
                $expression->eq(
                    'deleted',
                    $queryBuilder->createNamedParameter(
                        0,
                        Connection::PARAM_INT
                    )
                ),
                $expression->eq(
                    'hidden',
                    $queryBuilder->createNamedParameter(
                        0,
                        Connection::PARAM_INT
                    )
                ),
                $expression->eq(
                    't3ver_wsid',
                    $queryBuilder->createNamedParameter(
                        0,
                        Connection::PARAM_INT
                    )
                ),
                $expression->or(
                    $expression->eq(
                        'starttime',
                        $queryBuilder->createNamedParameter(
                            0,
                            Connection::PARAM_INT
                        )
                    ),
                    $expression->lte(
                        'starttime',
                        $queryBuilder->createNamedParameter(
                            $now,
                            Connection::PARAM_INT
                        )
                    )
                ),
                $expression->or(
                    $expression->eq(
                        'endtime',
                        $queryBuilder->createNamedParameter(
                            0,
                            Connection::PARAM_INT
                        )
                    ),
                    $expression->gt(
                        'endtime',
                        $queryBuilder->createNamedParameter(
                            $now,
                            Connection::PARAM_INT
                        )
                    )
                ),
                $expression->in(
                    'fe_group',
                    $queryBuilder->createNamedParameter(
                        ['', '0'],
                        Connection::PARAM_STR_ARRAY
                    )
                )
            )
            ->orderBy('uid', 'ASC')
            ->setMaxResults($limit)
            ->executeQuery()
            ->fetchAllAssociative();
    }

    /**
     * Devuelve noticias eliminadas u ocultadas desde el momento indicado.
     *
     * No se restringe por NEWS_TYPE porque el endpoint histórico notificaba
     * cambios de cualquier tipo de registro de tx_news.
     *
     * @return int[]
     */
    public function findDeletedUidsSince(int $timestamp): array
    {
        $queryBuilder = $this->connectionPool
            ->getQueryBuilderForTable(self::TABLE);

        /*
        * DeletedRestriction debe eliminarse porque precisamente necesitamos
        * consultar registros cuyo campo deleted puede ser 1.
        */
        $queryBuilder->getRestrictions()->removeAll();

        $expression = $queryBuilder->expr();

        $uids = $queryBuilder
            ->select('uid')
            ->from(self::TABLE)
            ->where(
                $expression->gte(
                    'tstamp',
                    $queryBuilder->createNamedParameter(
                        $timestamp,
                        Connection::PARAM_INT
                    )
                ),
                $expression->eq(
                    't3ver_wsid',
                    $queryBuilder->createNamedParameter(
                        0,
                        Connection::PARAM_INT
                    )
                ),
                $expression->or(
                    $expression->eq(
                        'deleted',
                        $queryBuilder->createNamedParameter(
                            1,
                            Connection::PARAM_INT
                        )
                    ),
                    $expression->eq(
                        'hidden',
                        $queryBuilder->createNamedParameter(
                            1,
                            Connection::PARAM_INT
                        )
                    )
                )
            )
            ->orderBy('uid', 'ASC')
            ->executeQuery()
            ->fetchFirstColumn();

        return array_map('intval', $uids);
    }

    /**
     * Obtiene noticias públicas editadas desde el momento indicado.
     *
     * @return array<int, array<string, mixed>>
     */
    public function findEditedSince(int $timestamp): array
    {
        $queryBuilder = $this->createQueryBuilder();

        return $queryBuilder
            ->select(
                'uid',
                'pid',
                'title',
                'alternative_title',
                'teaser',
                'datetime',
                'counter',
                'sorting'
            )
            ->from(self::TABLE)
            ->andWhere(
                $queryBuilder->expr()->gte(
                    'tstamp',
                    $queryBuilder->createNamedParameter(
                        $timestamp,
                        Connection::PARAM_INT
                    )
                )
            )
            ->orderBy('uid', 'ASC')
            ->executeQuery()
            ->fetchAllAssociative();
    }

    private function createQueryBuilder(): QueryBuilder
    {
        $queryBuilder = $this->connectionPool
            ->getQueryBuilderForTable(self::TABLE);

        /*
         * Las restricciones se expresan aquí deliberadamente para que la API
         * no dependa del contexto frontend ni de la configuración de Extbase.
         */
        $queryBuilder->getRestrictions()->removeAll();

        $now = time();
        $expression = $queryBuilder->expr();

        $queryBuilder->andWhere(
            $expression->eq(
                'type',
                $queryBuilder->createNamedParameter(self::NEWS_TYPE)
            ),
            $expression->eq(
                'deleted',
                $queryBuilder->createNamedParameter(0, Connection::PARAM_INT)
            ),
            $expression->eq(
                'hidden',
                $queryBuilder->createNamedParameter(0, Connection::PARAM_INT)
            ),
            $expression->eq(
                't3ver_wsid',
                $queryBuilder->createNamedParameter(0, Connection::PARAM_INT)
            ),
            $expression->or(
                $expression->eq(
                    'starttime',
                    $queryBuilder->createNamedParameter(
                        0,
                        Connection::PARAM_INT
                    )
                ),
                $expression->lte(
                    'starttime',
                    $queryBuilder->createNamedParameter(
                        $now,
                        Connection::PARAM_INT
                    )
                )
            ),
            $expression->or(
                $expression->eq(
                    'endtime',
                    $queryBuilder->createNamedParameter(
                        0,
                        Connection::PARAM_INT
                    )
                ),
                $expression->gt(
                    'endtime',
                    $queryBuilder->createNamedParameter(
                        $now,
                        Connection::PARAM_INT
                    )
                )
            )
        );

        return $queryBuilder;
    }
}