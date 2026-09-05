<?php

declare(strict_types=1);

namespace UNAL\UnalSkinUnal\Updates;

use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Install\Attribute\UpgradeWizard;
use TYPO3\CMS\Install\Updates\DatabaseUpdatedPrerequisite;
use TYPO3\CMS\Install\Updates\RepeatableInterface;
use TYPO3\CMS\Install\Updates\UpgradeWizardInterface;

#[UpgradeWizard('unalStaticTemplateIncludesMigration')]
final class StaticTemplateIncludesMigration implements
    UpgradeWizardInterface,
    RepeatableInterface
{
    private const TABLE = 'sys_template';

    /**
     * Legacy static-template paths and their TYPO3 12 replacements.
     */
    private const REPLACEMENTS = [
        'EXT:gridelements/Configuration/TypoScript/'
            => 'EXT:gridelements/Configuration/TypoScript/DataProcessingLibContentElement',

        'EXT:gridelements/Configuration/TypoScript/DataProcessingLibContentElement/'
            => 'EXT:gridelements/Configuration/TypoScript/DataProcessingLibContentElement',

        'EXT:bootstrap_grids/Configuration/TypoScript/'
            => 'EXT:bootstrap_grids/Configuration/TypoScript/Frontend/',

        'EXT:bootstrap_grids/Configuration/TypoScript/DataProcessingLibContentElement'
            => 'EXT:bootstrap_grids/Configuration/TypoScript/Frontend/',

        'EXT:bootstrap_grids/Configuration/TypoScript/DataProcessingLibContentElement/'
            => 'EXT:bootstrap_grids/Configuration/TypoScript/Frontend/',
    ];

    public function __construct(
        private readonly ConnectionPool $connectionPool,
    ) {
    }

    public function getTitle(): string
    {
        return 'Migrate legacy Gridelements static template includes';
    }

    public function getDescription(): string
    {
        return sprintf(
            'Updates obsolete Gridelements and Bootstrap Grids static '
            . 'template paths in %d sys_template records.',
            count($this->getTemplatesToUpdate())
        );
    }

    public function updateNecessary(): bool
    {
        return $this->getTemplatesToUpdate() !== [];
    }

    public function executeUpdate(): bool
    {
        $templates = $this->getTemplatesToUpdate();

        if ($templates === []) {
            return true;
        }

        $connection = $this->connectionPool
            ->getConnectionForTable(self::TABLE);

        $connection->transactional(
            static function (Connection $connection) use ($templates): void {
                foreach ($templates as $template) {
                    $connection->update(
                        self::TABLE,
                        [
                            'include_static_file'
                                => $template['migrated_include_static_file'],
                        ],
                        [
                            'uid' => (int)$template['uid'],
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

    /**
     * @return array<int, array{
     *     uid: int|string,
     *     include_static_file: string,
     *     migrated_include_static_file: string
     * }>
     */
    private function getTemplatesToUpdate(): array
    {
        if (!$this->requiredSchemaExists()) {
            return [];
        }

        $connection = $this->connectionPool
            ->getConnectionForTable(self::TABLE);

        $templates = $connection->fetchAllAssociative(
            'SELECT uid, include_static_file
             FROM sys_template
             WHERE deleted = 0
             ORDER BY uid'
        );

        $templatesToUpdate = [];

        foreach ($templates as $template) {
            $currentIncludes = (string)$template['include_static_file'];
            $migratedIncludes = $this->migrateIncludes($currentIncludes);

            if ($migratedIncludes === $currentIncludes) {
                continue;
            }

            $template['migrated_include_static_file'] = $migratedIncludes;
            $templatesToUpdate[] = $template;
        }

        return $templatesToUpdate;
    }

    private function migrateIncludes(string $includeStaticFile): string
    {
        if ($includeStaticFile === '') {
            return '';
        }

        $includes = explode(',', $includeStaticFile);

        foreach ($includes as &$include) {
            $include = trim($include);
            $include = self::REPLACEMENTS[$include] ?? $include;
        }

        unset($include);

        return implode(',', $includes);
    }

    private function requiredSchemaExists(): bool
    {
        $connection = $this->connectionPool
            ->getConnectionForTable(self::TABLE);

        $schemaManager = $connection->createSchemaManager();

        if (!$schemaManager->tablesExist([self::TABLE])) {
            return false;
        }

        $columns = $schemaManager->listTableColumns(self::TABLE);

        return isset(
            $columns['uid'],
            $columns['deleted'],
            $columns['include_static_file']
        );
    }
}