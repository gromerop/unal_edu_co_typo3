<?php
namespace Unal\Unal160\Service;

use TYPO3\CMS\Core\Cache\CacheManager;
use TYPO3\CMS\Core\Http\RequestFactory;
use TYPO3\CMS\Core\Log\LogManager;
use TYPO3\CMS\Core\Utility\GeneralUtility;

final class CircularEvents
{
    private $deadline;
    private $refreshIn = 900;

    public function refreshIn(): int { return $this->refreshIn; }

    public function forMonth(string $month): array
    {
        $cache = GeneralUtility::makeInstance(CacheManager::class)->getCache('unal160_circular');
        $key = 'events_v2_38_' . str_replace('-', '_', $month);
        $stored = $cache->get($key);
        $now = time();
        if (is_array($stored) && $stored['freshUntil'] > $now) {
            $this->refreshIn = min($this->refreshIn, $stored['freshUntil'] - $now);
            return $stored['items'];
        }
        if ($this->deadline === null) { $this->deadline = microtime(true) + 8; }
        if ($cache->has('retry_after') || microtime(true) >= $this->deadline) {
            $this->refreshIn = min($this->refreshIn, 60);
            return is_array($stored) ? $stored['items'] : [];
        }
        try {
            $items = [];
            $offset = 0;
            do {
                $remaining = $this->deadline - microtime(true);
                if ($remaining <= 0) { throw new \RuntimeException('Circular consultation time exceeded.'); }
                $url = 'https://circular.unal.edu.co/?' . http_build_query([
                    'circular_api'=>'events', 'category'=>38, 'month'=>$month, 'limit'=>100, 'offset'=>$offset
                ]);
                $response = GeneralUtility::makeInstance(RequestFactory::class)->request($url, 'GET', [
                    'timeout'=>min(3, $remaining), 'connect_timeout'=>min(2, $remaining),
                    'allow_redirects'=>false, 'headers'=>['Accept'=>'application/json']
                ]);
                if ($response->getStatusCode() !== 200) { throw new \RuntimeException('Circular HTTP ' . $response->getStatusCode()); }
                $page = json_decode((string)$response->getBody(), true, 512, JSON_THROW_ON_ERROR);
                if (!is_array($page) || ($page['mes'] ?? '') !== $month || (int)($page['categoria'] ?? 0) !== 38
                    || !isset($page['eventos']) || !is_array($page['eventos']) || !array_key_exists('siguiente_offset', $page)) {
                    throw new \RuntimeException('Unexpected Circular response.');
                }
                foreach ($page['eventos'] as $event) {
                    if (!is_array($event) || !isset($event['nombre'], $event['sesiones']) || !is_array($event['sesiones'])) {
                        throw new \RuntimeException('Invalid Circular event.');
                    }
                    $eventUrl = trim((string)($event['url'] ?? ''));
                    $validUrl = filter_var($eventUrl, FILTER_VALIDATE_URL)
                        && in_array(strtolower((string)parse_url($eventUrl, PHP_URL_SCHEME)), ['https', 'http'], true);
                    $items[] = ['title'=>(string)$event['nombre'], 'dateLabel'=>$this->dateLabel($event['sesiones']),
                        'place'=>is_array($event['lugar'] ?? null) ? $event['lugar'] : [],
                        'room'=>(string)($event['direccion'] ?? ''), 'image'=>null, 'url'=>$validUrl ? $eventUrl : ''];
                }
                $next = $page['siguiente_offset'];
                if ($next !== null && (!is_int($next) || $next <= $offset || $next > 1000000)) {
                    throw new \RuntimeException('Invalid Circular pagination.');
                }
                $offset = $next;
            } while ($offset !== null);
            // Vacíos válidos también se guardan. Nunca guardar respuestas parciales.
            $cache->set($key, ['freshUntil'=>$now + 900, 'items'=>$items], ['circular_events'], 86400);
            return $items;
        } catch (\Throwable $error) {
            $cache->set('retry_after', true, ['circular_events'], 60);
            GeneralUtility::makeInstance(LogManager::class)->getLogger(self::class)->warning(
                'Unable to refresh Circular events.', ['month'=>$month, 'reason'=>$error->getMessage()]
            );
            $this->refreshIn = min($this->refreshIn, 60);
            return is_array($stored) ? $stored['items'] : [];
        }
    }

    private function dateLabel(array $sessions): string
    {
        $zone = new \DateTimeZone('America/Bogota');
        $first = null;
        $last = null;
        foreach ($sessions as $session) {
            if (!is_array($session) || empty($session['inicio'])) {
                throw new \RuntimeException('Circular session has no start date.');
            }
            $start = (new \DateTimeImmutable($session['inicio']))->setTimezone($zone);
            $end = !empty($session['fin'])
                ? (new \DateTimeImmutable($session['fin']))->setTimezone($zone) : $start;
            if ($end < $start) { $end = $start; }
            if ($first === null || $start < $first) { $first = $start; }
            if ($last === null || $end > $last) { $last = $end; }
        }
        if ($first === null) { return ''; }
        if ($first->format('Y-m-d') === $last->format('Y-m-d')) {
            return $first->format('d/m/Y H:i');
        }
        return $first->format('d/m/Y') . ' - ' . $last->format('d/m/Y');
    }
}
