<?php

declare(strict_types=1);

namespace UNAL\UnalSocialMedia\Updates;

use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Service\FlexFormService;
use TYPO3\CMS\Install\Attribute\UpgradeWizard;
use TYPO3\CMS\Install\Updates\DatabaseUpdatedPrerequisite;
use TYPO3\CMS\Install\Updates\UpgradeWizardInterface;

#[UpgradeWizard('unalSocialMediaPluginMigration')]
final class SocialMediaPluginMigration implements UpgradeWizardInterface
{
    private const TABLE = 'tt_content';
    private const LEGACY_LIST_TYPE = 'unalsocialmedia_unsmd';
    private const FILTER_LIST_TYPE = 'unalsocialmedia_filter';
    private const LIST_LIST_TYPE = 'unalsocialmedia_list';

    public function __construct(
        private readonly ConnectionPool $connectionPool,
        private readonly FlexFormService $flexFormService,
    ) {
    }

    public function getTitle(): string
    {
        return 'Migrate legacy UNAL Social Media plugins';
    }

    public function getDescription(): string
    {
        return sprintf(
            'Migrates %d legacy unalsocialmedia_unsmd content elements '
            . 'to the filter or list plugin according to their FlexForm.',
            count($this->getLegacyRecords())
        );
    }

    public function updateNecessary(): bool
    {
        return $this->getLegacyRecords() !== [];
    }

    public function executeUpdate(): bool
    {
        $updates = [];

        foreach ($this->getLegacyRecords() as $record) {
            $targetListType = $this->resolveTargetListType(
                (string)($record['pi_flexform'] ?? '')
            );

            // Do not perform a partial migration when an unknown
            // configuration is found.
            if ($targetListType === null) {
                return false;
            }

            $updates[(int)$record['uid']] = $targetListType;
        }

        $connection = $this->connectionPool->getConnectionForTable(self::TABLE);

        $connection->transactional(
            static function (Connection $connection) use ($updates): void {
                foreach ($updates as $uid => $targetListType) {
                    $connection->update(
                        self::TABLE,
                        ['list_type' => $targetListType],
                        [
                            'uid' => $uid,
                            'CType' => 'list',
                            'list_type' => self::LEGACY_LIST_TYPE,
                        ]
                    );
                }
            }
        );

        return true;
    }

    public function getPrerequisites(): array
    {
        return [
            DatabaseUpdatedPrerequisite::class,
        ];
    }

    private function getLegacyRecords(): array
    {
        $connection = $this->connectionPool->getConnectionForTable(self::TABLE);

        return $connection->fetchAllAssociative(
            'SELECT uid, pi_flexform
             FROM tt_content
             WHERE CType = ?
               AND list_type = ?
             ORDER BY uid',
            ['list', self::LEGACY_LIST_TYPE]
        );
    }

    private function resolveTargetListType(string $flexFormContent): ?string
    {
        if (trim($flexFormContent) === '') {
            // The default action of the former plugin was Medio->search.
            return self::FILTER_LIST_TYPE;
        }

        $flexForm = $this->flexFormService
            ->convertFlexFormContentToArray($flexFormContent);

        $actions = trim(
            (string)($flexForm['switchableControllerActions'] ?? '')
        );

        return match (true) {
            $actions === '',
            str_contains($actions, 'Medio->search')
                => self::FILTER_LIST_TYPE,

            str_contains($actions, 'Dependencia->list')
                => self::LIST_LIST_TYPE,

            default => null,
        };
    }
}