<?php

declare(strict_types=1);

namespace Transip\Api\MCP;

use Transip\Api\MCP\Handler\ToolHandler;

class Server
{
    private const PROTOCOL_VERSION = '2024-11-05';
    private const SERVER_NAME = 'transip-mcp-server';
    private const SERVER_VERSION = '1.0.0';

    private ToolHandler $toolHandler;
    private bool $initialized = false;

    public function __construct(ToolHandler $toolHandler)
    {
        $this->toolHandler = $toolHandler;
    }

    public function run(): void
    {
        $stdin = fopen('php://stdin', 'r');
        if ($stdin === false) {
            throw new \RuntimeException('Could not open stdin');
        }

        while (($line = fgets($stdin)) !== false) {
            $line = trim($line);
            if ($line === '') {
                continue;
            }

            $request = json_decode($line, true);
            if (!is_array($request)) {
                $this->sendError(null, -32700, 'Parse error');
                continue;
            }

            $this->handleRequest($request);
        }

        fclose($stdin);
    }

    private function handleRequest(array $request): void
    {
        $id = $request['id'] ?? null;
        $method = $request['method'] ?? '';
        $params = $request['params'] ?? [];

        switch ($method) {
            case 'initialize':
                $this->handleInitialize($id, $params);
                break;

            case 'initialized':
                // Notification, no response needed
                break;

            case 'tools/list':
                $this->handleToolsList($id);
                break;

            case 'tools/call':
                $this->handleToolsCall($id, $params);
                break;

            case 'ping':
                $this->sendResult($id, []);
                break;

            default:
                $this->sendError($id, -32601, "Method not found: {$method}");
                break;
        }
    }

    private function handleInitialize(mixed $id, array $params): void
    {
        $this->initialized = true;

        $this->sendResult($id, [
            'protocolVersion' => self::PROTOCOL_VERSION,
            'capabilities' => [
                'tools' => [
                    'listChanged' => false,
                ],
            ],
            'serverInfo' => [
                'name' => self::SERVER_NAME,
                'version' => self::SERVER_VERSION,
            ],
        ]);
    }

    private function handleToolsList(mixed $id): void
    {
        $tools = $this->toolHandler->getToolDefinitions();
        $this->sendResult($id, ['tools' => $tools]);
    }

    private function handleToolsCall(mixed $id, array $params): void
    {
        $toolName = $params['name'] ?? '';
        $arguments = $params['arguments'] ?? [];

        try {
            $result = $this->toolHandler->executeTool($toolName, $arguments);
            $this->sendResult($id, [
                'content' => [
                    [
                        'type' => 'text',
                        'text' => is_string($result) ? $result : json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES),
                    ],
                ],
            ]);
        } catch (\InvalidArgumentException $e) {
            $this->sendResult($id, [
                'content' => [
                    [
                        'type' => 'text',
                        'text' => 'Error: ' . $e->getMessage(),
                    ],
                ],
                'isError' => true,
            ]);
        } catch (\Throwable $e) {
            $this->sendResult($id, [
                'content' => [
                    [
                        'type' => 'text',
                        'text' => 'Error: ' . $e->getMessage(),
                    ],
                ],
                'isError' => true,
            ]);
        }
    }

    private function sendResult(mixed $id, array $result): void
    {
        $response = [
            'jsonrpc' => '2.0',
            'id' => $id,
            'result' => $result,
        ];
        $this->send($response);
    }

    private function sendError(mixed $id, int $code, string $message): void
    {
        $response = [
            'jsonrpc' => '2.0',
            'id' => $id,
            'error' => [
                'code' => $code,
                'message' => $message,
            ],
        ];
        $this->send($response);
    }

    private function send(array $response): void
    {
        $json = json_encode($response, JSON_UNESCAPED_SLASHES);
        fwrite(STDOUT, $json . "\n");
        fflush(STDOUT);
    }
}
