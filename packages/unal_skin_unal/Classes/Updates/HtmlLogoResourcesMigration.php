<?php

declare(strict_types=1);

namespace UNAL\UnalSkinUnal\Updates;

use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\PathUtility;
use TYPO3\CMS\Install\Attribute\UpgradeWizard;
use TYPO3\CMS\Install\Updates\DatabaseUpdatedPrerequisite;
use TYPO3\CMS\Install\Updates\RepeatableInterface;
use TYPO3\CMS\Install\Updates\UpgradeWizardInterface;

#[UpgradeWizard('unalHtmlLogoResourcesMigration')]
final class HtmlLogoResourcesMigration implements UpgradeWizardInterface, RepeatableInterface
{
    private const FILES = [
        'logo-rectoria.svg',
        'logo-agencia-unal.svg',
        'logo-periodico-unal.svg',
        'logo-circular-unal.svg',
    ];

    private const PATTERN = <<<'REGEX'
~(?<prefix><img\b[^>]*?\s+src\s*=\s*)(?<quote>["'])(?:/?typo3conf/ext/unal_skin_unal/Resources/Public|/?_assets/[a-f0-9]{32})/Images/(?<name>logo-(?:rectoria|agencia-unal|periodico-unal|circular-unal)\.svg)\k<quote>~i
REGEX;

    public function __construct(private readonly ConnectionPool $connectionPool)
    {
    }

    public function getTitle(): string
    {
        return 'Publish UNAL HTML logos through Composer assets';
    }

    public function getDescription(): string
    {
        return sprintf(
            'Updates the src of four UNAL SVG logos in %d HTML records, including deleted history. Other markup is preserved.',
            count($this->getUpdates())
        );
    }

    public function updateNecessary(): bool
    {
        return $this->getUpdates() !== [];
    }

    public function getPrerequisites(): array
    {
        return [DatabaseUpdatedPrerequisite::class];
    }

    public function executeUpdate(): bool
    {
        $updates = $this->getUpdates();
        $connection = $this->connectionPool->getConnectionForTable('tt_content');
        $connection->transactional(static function (Connection $connection) use ($updates): void {
            foreach ($updates as $row) {
                $affected = $connection->update(
                    'tt_content',
                    ['bodytext' => $row['after']],
                    ['uid' => $row['uid'], 'bodytext' => $row['before']]
                );
                if ($affected !== 1) {
                    throw new \RuntimeException('HTML changed concurrently; migration rolled back. UID ' . $row['uid']);
                }
            }
        });
        return true;
    }

    private function getUpdates(): array
    {
        $urls = [];
        foreach (self::FILES as $file) {
            $resource = 'EXT:unal_skin_unal/Resources/Public/Images/' . $file;
            if (!is_file(GeneralUtility::getFileAbsFileName($resource))) {
                throw new \RuntimeException('Missing source logo: ' . $file);
            }
            $webPath = '/' . ltrim(PathUtility::getPublicResourceWebPath($resource), '/');
            if (!is_file(Environment::getPublicPath() . $webPath)) {
                throw new \RuntimeException('Logo not published by Composer: ' . $file);
            }
            $urls[$file] = $webPath;
        }

        // Include deleted and hidden records without changing their status.
        $rows = $this->connectionPool->getConnectionForTable('tt_content')->fetchAllAssociative(
            'SELECT uid, bodytext FROM tt_content WHERE CType = ? ORDER BY uid',
            ['html']
        );
        $updates = [];
        foreach ($rows as $row) {
            $before = (string)($row['bodytext'] ?? '');
            $after = $this->migrateHtml($before, $urls);
            if ($after !== $before) {
                $updates[] = ['uid' => (int)$row['uid'], 'before' => $before, 'after' => $after];
            }
        }
        return $updates;
    }

    private function migrateHtml(string $html, array $urls): string
    {
        $result = preg_replace_callback(self::PATTERN, static function (array $match) use ($urls): string {
            $url = $urls[strtolower($match['name'])] ?? null;
            return $url === null ? $match[0] : $match['prefix'] . $match['quote'] . $url . $match['quote'];
        }, $html);
        if ($result === null) {
            throw new \RuntimeException('Could not parse HTML logo references.');
        }
        return $result;
    }
}
