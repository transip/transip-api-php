<?php

declare(strict_types=1);

namespace Transip\Api\MCP\Handler;

use Transip\Api\Library\TransipAPI;
use Transip\Api\MCP\Tools\ToolRegistry;

class ToolHandler
{
    private TransipAPI $api;
    private ToolRegistry $registry;

    public function __construct(TransipAPI $api)
    {
        $this->api = $api;
        $this->registry = new ToolRegistry();
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getToolDefinitions(): array
    {
        return $this->registry->getDefinitions();
    }

    /**
     * @param string $toolName
     * @param array<string, mixed> $arguments
     * @return mixed
     */
    public function executeTool(string $toolName, array $arguments): mixed
    {
        $executor = $this->registry->getExecutor($toolName);
        if ($executor === null) {
            throw new \InvalidArgumentException("Unknown tool: {$toolName}");
        }

        return $executor($this->api, $arguments);
    }
}
