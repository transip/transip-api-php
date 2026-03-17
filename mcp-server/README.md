# TransIP MCP Server

A [Model Context Protocol (MCP)](https://modelcontextprotocol.io/) server that exposes the TransIP REST API as tools for AI assistants.

## Requirements

- PHP 8.0 or higher
- Composer
- A TransIP account with API access (or use demo mode)

## Installation

```bash
cd mcp-server
composer install
```

## Configuration

The server is configured via environment variables:

| Variable | Required | Description |
|---|---|---|
| `TRANSIP_LOGIN` | Yes* | Your TransIP customer login |
| `TRANSIP_PRIVATE_KEY` | Yes* | Your TransIP API private key (PEM or base64-encoded) |
| `TRANSIP_TOKEN` | No | Pre-existing API token (alternative to login + private key) |
| `TRANSIP_DEMO` | No | Set to `true` to use the demo token (no credentials needed) |
| `TRANSIP_ENDPOINT` | No | Custom API endpoint URL |
| `TRANSIP_WHITELIST_ONLY` | No | Generate whitelist-only tokens (default: `true`) |
| `TRANSIP_READ_ONLY` | No | Read-only mode (default: `false`) |
| `TRANSIP_TEST_MODE` | No | Test mode (default: `false`) |

*Required unless `TRANSIP_TOKEN` or `TRANSIP_DEMO=true` is set.

## Usage

### Running the server

```bash
TRANSIP_LOGIN=your-login TRANSIP_PRIVATE_KEY="$(cat /path/to/private-key.pem)" php bin/server
```

### Demo mode

```bash
TRANSIP_DEMO=true php bin/server
```

### Claude Desktop integration

Add the following to your Claude Desktop configuration (`claude_desktop_config.json`):

```json
{
  "mcpServers": {
    "transip": {
      "command": "php",
      "args": ["/absolute/path/to/mcp-server/bin/server"],
      "env": {
        "TRANSIP_LOGIN": "your-login",
        "TRANSIP_PRIVATE_KEY": "base64-encoded-private-key"
      }
    }
  }
}
```

> **Tip:** You can base64-encode your private key for easier use in environment variables:
> ```bash
> base64 -w0 /path/to/private-key.pem
> ```

## Available Tools

The server exposes **137 tools** covering the full TransIP API:

### General
- `transip_test` - Test API connectivity
- `transip_products_get_all` - List all products
- `transip_product_elements_get` - Get product elements
- `transip_availability_zones_get_all` - List availability zones

### VPS
- `transip_vps_get_all` - List all VPS instances
- `transip_vps_get_by_name` - Get VPS by name
- `transip_vps_get_by_tags` - Get VPS by tags
- `transip_vps_order` - Order a new VPS
- `transip_vps_clone` - Clone a VPS
- `transip_vps_update` - Update VPS description/tags
- `transip_vps_start` / `stop` / `reset` - Power management
- `transip_vps_handover` / `cancel` - Transfer or cancel
- VPS sub-resources: addons, backups, firewall, IP addresses, operating systems, snapshots, usage, settings, licenses, TCP monitors, VNC, rescue images, upgrades

### Domains
- `transip_domains_get_all` - List all domains
- `transip_domain_get_by_name` - Get domain details
- `transip_domain_register` / `transfer` / `cancel` - Domain lifecycle
- DNS, DNSSEC, nameservers, contacts, WHOIS, branding, SSL, actions, auth codes, availability checks, TLDs, whitelabel

### Block Storage
- `transip_block_storages_get_all` - List block storage volumes
- `transip_block_storage_order` / `cancel` - Order or cancel
- Backups, usage statistics

### Private Networks
- `transip_private_networks_get_all` - List private networks
- `transip_private_network_order` / `cancel` - Order or cancel
- Attach/detach VPS instances

### HA-IP (High Availability IP)
- `transip_haips_get_all` - List all HA-IPs
- `transip_haip_order` / `cancel` - Order or cancel
- Certificates, IP addresses, port configurations, status reports

### Kubernetes
- `transip_kubernetes_clusters_get_all` - List clusters
- `transip_kubernetes_cluster_create` / `upgrade` / `reset` / `remove` - Cluster management
- Nodes, node pools, block storages, events, load balancers, products, releases, labels, taints, kubeconfig

### Email
- `transip_mailboxes_get` / `create` / `delete` - Mailbox management
- Mail forwards, mail lists, mail packages, mail addons

### Other Resources
- **SSH Keys**: CRUD operations
- **SSL Certificates**: List and get details
- **Invoices**: List, get details, items, PDF
- **Colocations**: List, details, IP addresses
- **OpenStack**: Projects, users, tokens
- **Traffic Pool**: Usage statistics
- **Actions**: List and get action details
- **Acronis**: Tenant management
- **Contact Keys**: Verification

## Architecture

```
bin/server              → Entry point (reads env, creates API client, starts server)
src/Server.php          → MCP protocol handler (JSON-RPC 2.0 over stdio)
src/Handler/ToolHandler.php → Delegates tool execution to registry
src/Tools/ToolRegistry.php  → Central registry of all 137 tool definitions
```

## Protocol

The server implements the [MCP specification](https://spec.modelcontextprotocol.io/) (protocol version `2024-11-05`) using JSON-RPC 2.0 over stdio. Supported methods:

- `initialize` - Handshake and capability negotiation
- `ping` - Health check
- `tools/list` - List available tools with JSON Schema input definitions
- `tools/call` - Execute a tool

## License

Apache-2.0 (same as the TransIP REST API PHP library)
