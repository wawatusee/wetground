<?php
class Config
{
    private array $data;

    public function __construct(string $jsonPath)
    {
        if (!file_exists($jsonPath)) {
            throw new Exception("Config file not found: " . $jsonPath);
        }

        $json = file_get_contents($jsonPath);
        $array = json_decode($json, true);

        if ($array === null) {
            throw new Exception("Invalid JSON in config file");
        }

        $this->data = $array['config'] ?? [];
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $this->data[$key] ?? $default;
    }

    public function all(): array
    {
        return $this->data;
    }
}
