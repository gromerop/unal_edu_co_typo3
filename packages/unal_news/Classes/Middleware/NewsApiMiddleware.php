<?php

declare(strict_types=1);

namespace UNAL\UnalNews\Middleware;

use JsonException;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;
use Throwable;
use UNAL\UnalNews\Service\NewsApiService;

final class NewsApiMiddleware implements MiddlewareInterface
{
    private const NEWS_RESOURCES = [
        'noticias',
        'unal-unal_news-unalNews',
    ];

    private const VISIT_RESOURCES = [
        'visitas',
        'unal-unal_news-visitCounter',
    ];

    public function __construct(
        private readonly NewsApiService $newsApiService,
        private readonly ResponseFactoryInterface $responseFactory,
        private readonly StreamFactoryInterface $streamFactory,
        private readonly LoggerInterface $logger,
    ) {
    }

    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface {
        $route = $this->matchApiRoute($request->getUri()->getPath());
        if ($route === null) {
            return $handler->handle($request);
        }

        if (strtoupper($request->getMethod()) === 'OPTIONS') {
            return $this->createResponse(null, 204);
        }

        try {
            return $this->dispatch($request, $route);
        } catch (JsonException|\InvalidArgumentException $exception) {
            return $this->errorResponse(400, $exception->getMessage());
        } catch (Throwable $exception) {
            $this->logger->error(
                'UNAL News API request failed.',
                ['exception' => $exception]
            );

            return $this->errorResponse(500, 'The API request could not be processed.');
        }
    }

    private function dispatch(ServerRequestInterface $request, array $route): ResponseInterface
    {
        $method = strtoupper($request->getMethod());
        $resource = $route['resource'];
        $suffix = $route['suffix'];

        if (in_array($resource, self::NEWS_RESOURCES, true)) {
            return $this->dispatchNewsRequest($request, $method, $suffix);
        }

        if (in_array($resource, self::VISIT_RESOURCES, true)) {
            return $this->dispatchVisitRequest($request, $method, $suffix);
        }

        return $this->errorResponse(404, 'API resource not found.');
    }

    private function dispatchNewsRequest(
        ServerRequestInterface $request,
        string $method,
        string $suffix
    ): ResponseInterface {
        if ($method === 'GET' && $suffix === '') {
            return $this->createResponse(
                $this->newsApiService->list(1, $this->newsEndpointBaseUrl($request))
            );
        }

        if ($method === 'GET' && preg_match('#^/page/(?P<page>\d+)$#', $suffix, $matches)) {
            return $this->createResponse(
                $this->newsApiService->list(
                    (int)$matches['page'],
                    $this->newsEndpointBaseUrl($request)
                )
            );
        }

        if ($method === 'GET' && preg_match('#^/show/(?P<uid>\d+)$#', $suffix, $matches)) {
            $news = $this->newsApiService->show((int)$matches['uid']);

            return $news === null
                ? $this->errorResponse(404, 'News record not found.')
                : $this->createResponse($news);
        }

        if ($method === 'POST' && $suffix === '/search') {
            $payload = $this->requestPayload($request);

            return $this->createResponse(
                $this->newsApiService->related((int)($payload['size'] ?? 3))
            );
        }

        if (
            $method === 'GET'
            && preg_match('#^/all/(?P<type>new|image|video|audio)/(?P<page>\d+)$#', $suffix, $matches)
        ) {
            return $this->createResponse(
                $this->newsApiService->all($matches['type'], (int)$matches['page'])
            );
        }

        if ($method === 'GET' && preg_match('#^/autocomplete/(?P<search>.+)$#', $suffix, $matches)) {
            return $this->createResponse(
                $this->newsApiService->autocomplete(rawurldecode($matches['search']))
            );
        }

        if ($method === 'GET' && $suffix === '/deleted') {
            return $this->createResponse($this->newsApiService->deletedSinceYesterday());
        }

        if ($method === 'GET' && $suffix === '/edited') {
            return $this->createResponse($this->newsApiService->editedSinceYesterday());
        }

        return $this->errorResponse(404, 'API route not found.');
    }

    private function dispatchVisitRequest(
        ServerRequestInterface $request,
        string $method,
        string $suffix
    ): ResponseInterface {
        if ($method !== 'POST' || $suffix !== '/update') {
            return $this->errorResponse(404, 'API route not found.');
        }

        $payload = $this->requestPayload($request);
        $newsUid = filter_var($payload['news'] ?? null, FILTER_VALIDATE_INT);
        if ($newsUid === false || $newsUid < 1) {
            throw new \InvalidArgumentException('A positive news identifier is required.');
        }

        if (!$this->newsApiService->registerVisit($newsUid)) {
            return $this->errorResponse(404, 'News record not found.');
        }

        return $this->createResponse(['mesagge' => 'Se registró la visita.']);
    }

    /**
     * @return array{resource: string, suffix: string}|null
     */
    private function matchApiRoute(string $path): ?array
    {
        if (!preg_match(
            '#^/(?:[a-z]{2,3}(?:-[a-z]{2})?/)?rest/(?P<resource>[^/]+)(?P<suffix>/.*)?/?$#i',
            $path,
            $matches
        )) {
            return null;
        }

        $resource = $matches['resource'];
        if (
            !in_array($resource, self::NEWS_RESOURCES, true)
            && !in_array($resource, self::VISIT_RESOURCES, true)
        ) {
            return null;
        }

        return [
            'resource' => $resource,
            'suffix' => rtrim($matches['suffix'] ?? '', '/'),
        ];
    }

    private function newsEndpointBaseUrl(ServerRequestInterface $request): string
    {
        $path = $request->getUri()->getPath();
        $restPosition = strpos($path, '/rest/');
        $prefix = $restPosition === false ? '' : substr($path, 0, $restPosition);

        return (string)$request->getUri()
            ->withPath($prefix . '/rest/noticias')
            ->withQuery('')
            ->withFragment('');
    }

    private function requestPayload(ServerRequestInterface $request): array
    {
        $parsedBody = $request->getParsedBody();
        if (is_array($parsedBody)) {
            return $parsedBody;
        }

        $body = trim((string)$request->getBody());
        if ($body === '') {
            return [];
        }

        $payload = json_decode($body, true, 512, JSON_THROW_ON_ERROR);
        if (!is_array($payload)) {
            throw new \InvalidArgumentException('The request body must contain a JSON object.');
        }

        return $payload;
    }

    private function errorResponse(int $status, string $message): ResponseInterface
    {
        return $this->createResponse(
            [
                'error' => [
                    'status' => $status,
                    'message' => $message,
                ],
            ],
            $status
        );
    }

    private function createResponse(?array $payload, int $status = 200): ResponseInterface
    {
        $response = $this->responseFactory
            ->createResponse($status)
            ->withHeader('Content-Type', 'application/json; charset=utf-8')
            ->withHeader('Cache-Control', 'no-store')
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS')
            ->withHeader('Access-Control-Allow-Headers', 'Content-Type');

        if ($payload === null) {
            return $response;
        }

        $json = json_encode(
            $payload,
            JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
        );

        return $response->withBody($this->streamFactory->createStream($json));
    }
}
