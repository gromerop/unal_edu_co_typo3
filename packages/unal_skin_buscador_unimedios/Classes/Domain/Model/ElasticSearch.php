<?php

declare(strict_types=1);

namespace UNAL\UnalSkinBuscadorUnimedios\Domain\Model;

final class ElasticSearch
{
    private string $domain = '';
    private string $port = '';
    private string $user = '';
    private string $password = '';
    private string $newIndex = '';
    private string $imageIndex = '';
    private string $videoIndex = '';
    private string $audioIndex = '';

    public function getDomain(): string
    {
        return $this->domain;
    }

    public function setDomain(string $domain): void
    {
        $this->domain = rtrim($domain, '/');
    }

    public function getPort(): string
    {
        return $this->port;
    }

    public function setPort(string $port): void
    {
        $this->port = $port;
    }

    public function getBaseUrl(): string
    {
        if ($this->domain === '' || $this->port === '') {
            return '';
        }

        return $this->domain . ':' . $this->port . '/';
    }

    public function getUser(): string
    {
        return $this->user;
    }

    public function setUser(string $user): void
    {
        $this->user = $user;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getAuth(): string
    {
        if ($this->user === '' || $this->password === '') {
            return '';
        }

        return $this->user . ':' . $this->password;
    }

    public function getNewIndex(): string
    {
        return $this->newIndex;
    }

    public function setNewIndex(string $newIndex): void
    {
        $this->newIndex = $newIndex;
    }

    public function getImageIndex(): string
    {
        return $this->imageIndex;
    }

    public function setImageIndex(string $imageIndex): void
    {
        $this->imageIndex = $imageIndex;
    }

    public function getVideoIndex(): string
    {
        return $this->videoIndex;
    }

    public function setVideoIndex(string $videoIndex): void
    {
        $this->videoIndex = $videoIndex;
    }

    public function getAudioIndex(): string
    {
        return $this->audioIndex;
    }

    public function setAudioIndex(string $audioIndex): void
    {
        $this->audioIndex = $audioIndex;
    }
}