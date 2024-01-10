<?php

namespace Skillcraft\Core\Contracts;

final readonly class MetaBusinessApiCredentialsContract
{
    
    public function __construct(
        public ?string $appId,
        public ?string $appSecret,
        public ?string $pageId,
        public ?string $pageAccessToken,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['appId'],
            $data['appSecret'],
            $data['pageId'],
            $data['pageAccessToken'],
        );
    }

    public function toArray(): array
    {
        return [
            'appId' => $this->appId,
            'appSecret' => $this->appSecret,
            'pageId' => $this->pageId,
            'pageAccessToken' => $this->pageAccessToken,
        ];
    }

    public function validateParams(): bool
    {
        return isset($this->appId) && isset($this->appSecret) && isset($this->pageId) && isset($this->pageAccessToken);
    }

    public function __toString(): string
    {
        return json_encode($this->toArray());
    }

    public function __get(string $name):?string
    {
        return $this->$name;
    }

    public function __set(string $name, $value):void
    {
        $this->$name = $value;
    }

    public function __isset(string $name): bool
    {
        return isset($this->$name);
    }

    public function __unset(string $name): void
    {
        unset($this->$name);
    }
}
