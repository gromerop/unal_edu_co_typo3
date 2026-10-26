<?php

declare(strict_types=1);

namespace UNAL\UnalNews\Service;

use GeorgRinger\News\Domain\Model\Dto\NewsDemand;
use TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface;
use UNAL\UnalNews\Domain\Model\UnalNews;
use UNAL\UnalNews\Domain\Repository\UnalNewsRepository;

final class NewsApiService
{
    private const PAGE_SIZE = 9;
    private const CONVERGENCE_PAGE_SIZE = 100;

    public function __construct(
        private readonly UnalNewsRepository $unalNewsRepository,
        private readonly PersistenceManagerInterface $persistenceManager,
    ) {
    }

    public function list(int $page, string $endpointBaseUrl): array
    {
        $totalElements = (int)$this->unalNewsRepository->total();
        $totalPages = (int)ceil($totalElements / self::PAGE_SIZE);
        $page = max(1, $page);

        $previousPage = $page > 1
            ? $endpointBaseUrl . '/page/' . ($page - 1)
            : '';
        $nextPage = $page < $totalPages
            ? $endpointBaseUrl . '/page/' . ($page + 1)
            : '';

        return [
            'info' => [
                'count' => $totalElements,
                'pages' => $totalPages,
                'next' => $nextPage,
                'prev' => $previousPage,
            ],
            'results' => $this->serializeNewsCollection(
                $this->unalNewsRepository->paginated($page, self::PAGE_SIZE)
            ),
        ];
    }

    public function show(int $uid): ?array
    {
        $news = $this->unalNewsRepository->findByUid($uid);

        return $news instanceof UnalNews ? $news->parsedArray() : null;
    }

    public function related(int $size): array
    {
        $size = max(1, min(100, $size));

        return $this->serializeNewsCollection(
            $this->unalNewsRepository->getRelated($size)
        );
    }

    public function autocomplete(string $search): array
    {
        $search = trim($search);

        return $search === '' ? [] : $this->unalNewsRepository->getData($search);
    }

    public function all(string $type, int $page): array
    {
        $demand = new NewsDemand();
        $demand->setOffset((max(1, $page) - 1) * self::CONVERGENCE_PAGE_SIZE);
        $demand->setLimit(self::CONVERGENCE_PAGE_SIZE);
        $demand->setOrder('datetime desc');
        $demand->setOrderByAllowed('datetime');
        $demand->setStoragePage('');

        $results = [];
        foreach ($this->unalNewsRepository->findDemanded($demand) as $news) {
            if (!$news instanceof UnalNews) {
                continue;
            }

            $serializedNews = $news->parsedArrayElastic(false, $type);
            if ($type === 'new') {
                $results[] = $serializedNews;
                continue;
            }

            foreach ($serializedNews ?? [] as $media) {
                if (is_array($media)) {
                    $results[] = $media;
                }
            }
        }

        return $results;
    }

    public function deletedSinceYesterday(): array
    {
        return $this->unalNewsRepository->findDeletedUidsSince(time() - 86400);
    }

    public function editedSinceYesterday(): array
    {
        $results = [];
        foreach ($this->unalNewsRepository->findEditedUidsSince(time() - 86400) as $uid) {
            $news = $this->unalNewsRepository->findByUid($uid);
            if ($news instanceof UnalNews) {
                $results[] = $news->parsedArrayElastic(false, 'new');
            }
        }

        return $results;
    }

    public function registerVisit(int $newsUid): bool
    {
        $news = $this->unalNewsRepository->findByUid($newsUid);
        if (!$news instanceof UnalNews) {
            return false;
        }

        $news->actualizarVisita();
        $this->unalNewsRepository->update($news);
        $this->persistenceManager->persistAll();

        return true;
    }

    private function serializeNewsCollection(iterable $newsCollection): array
    {
        $results = [];
        foreach ($newsCollection as $news) {
            if ($news instanceof UnalNews) {
                $results[] = $news->parsedArray();
            }
        }

        return $results;
    }
}
