<?php

declare(strict_types=1);

namespace UNAL\UnalNews\Api;

use DateTimeImmutable;
use DateTimeZone;
use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;

final class NewsApiVisitRepository
{
    private const NEWS_TABLE = 'tx_news_domain_model_news';
    private const VISIT_TABLE =
        'tx_unalnews_domain_model_visitcounter';
    private const NEWS_TYPE = 'Tx_UnalNews_UnalNews';

    public function __construct(
        private readonly ConnectionPool $connectionPool,
    ) {
    }

    public function registerVisit(int $newsUid): bool
    {
        if ($newsUid < 1) {
            return false;
        }

        $connection = $this->connectionPool
            ->getConnectionForTable(self::NEWS_TABLE);

        return $connection->transactional(
            function (Connection $connection) use ($newsUid): bool {
                $now = time();

                /*
                 * Bloquear la noticia serializa las solicitudes concurrentes
                 * para el mismo UID.
                 */
                $news = $connection->executeQuery(
                    '
                        SELECT uid, pid
                        FROM ' . self::NEWS_TABLE . '
                        WHERE uid = ?
                          AND type = ?
                          AND deleted = 0
                          AND hidden = 0
                          AND t3ver_wsid = 0
                          AND (starttime = 0 OR starttime <= ?)
                          AND (endtime = 0 OR endtime > ?)
                          AND (fe_group = \'\' OR fe_group = \'0\')
                        FOR UPDATE
                    ',
                    [
                        $newsUid,
                        self::NEWS_TYPE,
                        $now,
                        $now,
                    ],
                    [
                        Connection::PARAM_INT,
                        Connection::PARAM_STR,
                        Connection::PARAM_INT,
                        Connection::PARAM_INT,
                    ]
                )->fetchAssociative();

                if (!is_array($news)) {
                    return false;
                }

                $timeZone = new DateTimeZone(
                    date_default_timezone_get()
                );

                $dayStart = new DateTimeImmutable(
                    'today',
                    $timeZone
                );

                $dayEnd = $dayStart->modify('+1 day');

                $visit = $connection->executeQuery(
                    '
                        SELECT uid
                        FROM ' . self::VISIT_TABLE . '
                        WHERE unalnews = ?
                          AND deleted = 0
                          AND hidden = 0
                          AND t3ver_wsid = 0
                          AND fecha_registro >= ?
                          AND fecha_registro < ?
                        ORDER BY uid ASC
                        LIMIT 1
                        FOR UPDATE
                    ',
                    [
                        $newsUid,
                        $dayStart->getTimestamp(),
                        $dayEnd->getTimestamp(),
                    ],
                    [
                        Connection::PARAM_INT,
                        Connection::PARAM_INT,
                        Connection::PARAM_INT,
                    ]
                )->fetchAssociative();

                /*
                 * No se modifica tstamp de la noticia: una visita no es una
                 * edición de contenido y no debe contaminar /edited.
                 */
                if (is_array($visit)) {
                    $connection->executeStatement(
                        '
                            UPDATE ' . self::VISIT_TABLE . '
                            SET quantity = quantity + 1,
                                tstamp = ?
                            WHERE uid = ?
                        ',
                        [
                            $now,
                            (int)$visit['uid'],
                        ],
                        [
                            Connection::PARAM_INT,
                            Connection::PARAM_INT,
                        ]
                    );

                    $connection->executeStatement(
                        '
                            UPDATE ' . self::NEWS_TABLE . '
                            SET counter = counter + 1
                            WHERE uid = ?
                        ',
                        [$newsUid],
                        [Connection::PARAM_INT]
                    );

                    return true;
                }

                $connection->insert(
                    self::VISIT_TABLE,
                    [
                        'pid' => (int)$news['pid'],
                        'tstamp' => $now,
                        'crdate' => $now,
                        'cruser_id' => 0,
                        'deleted' => 0,
                        'hidden' => 0,
                        'sys_language_uid' => 0,
                        'l10n_parent' => 0,
                        't3ver_wsid' => 0,
                        'unalnews' => $newsUid,
                        'quantity' => 1,
                        'fecha_registro' => $now,
                    ],
                    [
                        'pid' => Connection::PARAM_INT,
                        'tstamp' => Connection::PARAM_INT,
                        'crdate' => Connection::PARAM_INT,
                        'cruser_id' => Connection::PARAM_INT,
                        'deleted' => Connection::PARAM_INT,
                        'hidden' => Connection::PARAM_INT,
                        'sys_language_uid' => Connection::PARAM_INT,
                        'l10n_parent' => Connection::PARAM_INT,
                        't3ver_wsid' => Connection::PARAM_INT,
                        'unalnews' => Connection::PARAM_INT,
                        'quantity' => Connection::PARAM_INT,
                        'fecha_registro' => Connection::PARAM_INT,
                    ]
                );

                /*
                 * visitor_counter representa la cantidad de registros hijos,
                 * no la cantidad total de visitas.
                 */
                $connection->executeStatement(
                    '
                        UPDATE ' . self::NEWS_TABLE . '
                        SET counter = counter + 1,
                            visitor_counter = visitor_counter + 1
                        WHERE uid = ?
                    ',
                    [$newsUid],
                    [Connection::PARAM_INT]
                );

                return true;
            }
        );
    }
}