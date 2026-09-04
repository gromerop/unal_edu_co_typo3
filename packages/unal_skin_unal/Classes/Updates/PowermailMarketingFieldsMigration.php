<?php

declare(strict_types=1);

namespace UNAL\UnalSkinUnal\Updates;

use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Install\Attribute\UpgradeWizard;
use TYPO3\CMS\Install\Updates\UpgradeWizardInterface;

#[UpgradeWizard('unalPowermailMarketingFieldsMigration')]
final class PowermailMarketingFieldsMigration implements UpgradeWizardInterface
{
    private const TABLE = 'tx_powermail_domain_model_mail';

    private const FIELDS = [
        'marketing_referer_domain',
        'marketing_referer',
        'marketing_country',
        'marketing_browser_language',
        'marketing_page_funnel',
    ];

    public function __construct(
        private readonly ConnectionPool $connectionPool,
    ) {
    }

    public function getTitle(): string
    {
        return 'Prepare Powermail marketing fields for schema update';
    }

    public function getDescription(): string
    {
        return sprintf(
            'Replaces NULL values with empty strings in five Powermail '
            . 'marketing fields. Records requiring normalization: %d.',
            $this->countRecordsToUpdate()
        );
    }

    public function updateNecessary(): bool
    {
        return $this->countRecordsToUpdate() > 0;
    }

    public function executeUpdate(): bool
    {
        if (!$this->requiredSchemaExists()) {
            return true;
        }

        $connection = $this->connectionPool->getConnectionForTable(self::TABLE);

        $connection->transactional(
            static function (Connection $connection): void {
                foreach (self::FIELDS as $field) {
                    $quotedTable = $connection->quoteIdentifier(self::TABLE);
                    $quotedField = $connection->quoteIdentifier($field);

                    $connection->executeStatement(
                        sprintf(
                            'UPDATE %s SET %s = ? WHERE %s IS NULL',
                            $quotedTable,
                            $quotedField,
                            $quotedField
                        ),
                        ['']
                    );
                }
            }
        );

        return true;
    }

    public function getPrerequisites(): array
    {
        // This wizard must run before database:updateschema.
        return [];
    }

    private function countRecordsToUpdate(): int
    {
        if (!$this->requiredSchemaExists()) {
            return 0;
        }

        $queryBuilder = $this->connectionPool
            ->getQueryBuilderForTable(self::TABLE);

        // Deleted records must also be normalized because they participate
        // in the database schema alteration.
        $queryBuilder->getRestrictions()->removeAll();

        $nullConditions = [];
        foreach (self::FIELDS as $field) {
            $nullConditions[] = $queryBuilder->expr()->isNull($field);
        }

        return (int)$queryBuilder
            ->count('*')
            ->from(self::TABLE)
            ->where(
                $queryBuilder->expr()->or(...$nullConditions)
            )
            ->executeQuery()
            ->fetchOne();
    }

    private function requiredSchemaExists(): bool
    {
        $connection = $this->connectionPool->getConnectionForTable(self::TABLE);
        $schemaManager = $connection->createSchemaManager();

        if (!$schemaManager->tablesExist([self::TABLE])) {
            return false;
        }

        $columns = $schemaManager->listTableColumns(self::TABLE);

        foreach (self::FIELDS as $field) {
            if (!isset($columns[$field])) {
                return false;
            }
        }

        return true;
    }
}