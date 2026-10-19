# AGENTS.md

PHP client library for the TransIP REST API v6 (`https://api.transip.nl/v6`), published on Packagist as `transip/transip-api-php`. Repo type: library (no backend/frontend app); `TransipAPI` exposes one repository object per API resource and talks to the API over Guzzle or an HTTPlug/PSR-18 client.

## Tech stack

- PHP `^7.4 || ^8.0` (`composer.json`); CI runs PHPUnit on 7.4, 8.0, 8.1, 8.2, 8.3, 8.4 and 8.5. Required extensions: `ext-json`, `ext-openssl`.
- Guzzle 6/7, `php-http/client-common` + `php-http/discovery`, PSR-6 cache (`symfony/cache` is dev-only/suggested).
- Dev tools: PHPUnit 9, PHPStan 1 (level 8), php-cs-fixer 3, php-parallel-lint.

## Setup

```bash
composer config --global --auth http-basic.packeton.teamblue-ops.net token "$PACKETON_TOKEN"
composer config --no-plugins allow-plugins.php-http/discovery true
composer install --prefer-dist --no-progress --no-interaction --optimize-autoloader
```

`composer.lock` is in `.gitignore`, so every install (and every CI job) resolves the newest versions allowed for that PHP version.

## Commands

All of these run in CI (`.gitlab-ci.yml`, job name in brackets) and pass on `master`:

```bash
./vendor/bin/parallel-lint --exclude vendor/ .                        # [lint php-parallel-lint]
./vendor/bin/php-cs-fixer fix -v --dry-run --using-cache=no           # [lint php-cs-fixer]
./vendor/bin/phpstan --no-progress --memory-limit="2G"                # [lint phpstan]
composer validate --no-interaction --strict                           # [lint composer]
./vendor/bin/phpunit --coverage-text --testdox                        # [test phpunit], matrix over PHP versions
```

- Auto-fix style: `./vendor/bin/php-cs-fixer fix` (rules in `.php-cs-fixer.dist.php`: `@PSR2` + short array syntax, applied to every `*.php` outside `vendor/`, so `examples/`, `tests/` and `ci/` too).
- PHPStan only analyses `src/` (`phpstan.neon`, level 8, no baseline); `tests/` and `examples/` are only linted and style-checked.
- Single test: `./vendor/bin/phpunit --filter FirewallTest`.
- Without Xdebug, `--coverage-text` prints `No code coverage driver available` but still exits 0 (CI sets `PHP_XDEBUG=1`, `XDEBUG_MODE=coverage`).
- parallel-lint only checks the syntax of the local PHP version. To catch PHP 7.4 breakage (e.g. trailing commas in parameter lists) before CI does:

```bash
docker run --rm -v $PWD:/app -w /app php:7.4-cli sh -c 'for f in $(find src tests examples ci -name "*.php"); do php -l $f >/dev/null || echo FAIL $f; done'
```

- `[lint secretsscan]` runs `ci/scan_secrets.sh`: trufflehog v2 (`--regex --entropy=True -x .secretsignore`) over the whole git history. Local equivalent:

```bash
python -m venv /tmp/th && /tmp/th/bin/pip -q install trufflehog
/tmp/th/bin/trufflehog --regex --entropy=True -x .secretsignore file://$PWD
```

High-entropy strings fail it; files that legitimately contain them are listed in `.secretsignore` (e.g. `src/TransipAPI.php` for `TRANSIP_API_DEMO_TOKEN`, `src/Entity/OpenStackToken.php`).

## Layout

| Path | What |
| --- | --- |
| `src/TransipAPI.php` | Entry point: constructor (login, private key, cache, client) and one accessor per repository, e.g. `vps()`, `kubernetesNodePools()` |
| `src/Repository/` | One `ApiRepository` subclass per API resource; sub-resources in subdirectories, e.g. `Repository/Kubernetes/Cluster/NodePoolRepository.php` |
| `src/Entity/` | Response/request models extending `AbstractEntity` |
| `src/HttpClient/` | `HttpClientInterface`, abstract `HttpClient`, `GuzzleClient`, `HttpMethodsClient`, `Builder/ClientBuilder`, `Plugin/` (`ExceptionThrowerPlugin`, `TokenAuthenticationPlugin`), `Middleware/TokenAuthorization` |
| `src/Exception/` | `ApiException`, `ApiClientException`, `HttpClientException`, `HttpRequestException`, `HttpBadResponseException`; one class per HTTP error in `Exception/HttpRequest/` |
| `examples/` | Runnable usage samples; they `require_once` `examples/Authenticate.php` |
| `tests/` | PHPUnit tests, namespace `Transip\Api\Library\Tests\` |
| `ci/` | CI scripts: secrets scan, tag checks, GitHub mirror/release |
| `CHANGELOG.md` | Per-version change list, newest on top |

## Conventions

- New repository: extend `Transip\Api\Library\Repository\ApiRepository`, set `RESOURCE_NAME` (URL path, e.g. `'node-pools'`) and `RESOURCE_PARAMETER_SINGULAR` / `RESOURCE_PARAMETER_PLURAL` (JSON keys), then add an accessor to `TransipAPI` (import with an alias if the class name is already used, e.g. `NodePoolRepository as KubernetesNodePoolRepository`).
- Nested resources override `getRepositoryResourceNames()`; `getResourceUrl(...$ids)` interleaves names and ids. `NodePoolRepository` returns `[ClusterRepository::RESOURCE_NAME, self::RESOURCE_NAME]`, so `getResourceUrl($clusterName, $uuid)` is `/kubernetes/clusters/{clusterName}/node-pools/{uuid}`.
- Read response keys with `getParameterFromResponse()`, which throws `ApiClientException::parameterMissingInResponse()` instead of returning null.
- Optional parameters default to `null` and are only added to the request body when set (see `NodePoolRepository::add()`). Actions are `patch()` calls with an `action` key, e.g. `['action' => 'remove_nodes', 'nodes' => $nodeUuids]` in `NodePoolRepository::removeNodes()`.
- Entities extend `AbstractEntity`: `protected` properties with `@var` docblocks and getters/setters. The constructor copies array keys onto matching properties (`property_exists`); nested objects are hydrated in an overridden constructor (`NodePool` builds `Node` objects from `nodes`). `jsonSerialize()` returns all properties, which is what `put()` sends when an entity is passed as body.
- Keep PHP 7.4 syntax: no trailing comma after the last method parameter (fixed in `VpsRepository::cloneVps()`), no PHP 8-only features. Check with the `php:7.4-cli` command above.
- `HttpClient` has two implementations: `GuzzleClient` (default in `TransipAPI`) and `HttpMethodsClient` (HTTPlug, built from `ClientBuilderInterface`). A new method on `HttpClientInterface` must work in both; see the `setTimeZone()` override in `HttpMethodsClient`.
- Every release bumps `TransipAPI::TRANSIP_API_LIBRARY_VERSION` (also sent in the User-Agent by `HttpClient::getUserAgent()`) and adds a `CHANGELOG.md` entry; recent feature commits do both in the same commit.

## Tests

- Plain `PHPUnit\Framework\TestCase` classes; there are no HTTP fixtures or repository tests. Existing tests: `tests/Entity/FirewallTest.php`, `FirewallRuleTest.php`, `SslCertificateRepositoryTest.php` (tests `CertificateRequestData`), `tests/Exception/HttpBadResponseExceptionTest.php`, `tests/HttpClient/ClientBuilderTest.php` (mocks `ClientBuilder::addPlugin` / `removePlugin`) and `tests/HttpClient/Plugin/ExceptionThrowerPluginTest.php`.
- HTTP status to exception mapping is covered by `ExceptionThrowerPluginTest::responsesDataProvider()`; add a case there when adding a class in `src/Exception/HttpRequest/`.
- `phpunit.xml.dist` sets `failOnWarning="true"` and writes reports to `build/` (ignored).

## Git / MRs

- Default branch: `master`. Work on a feature branch and merge via MR; no staging branches.
- Commit subjects are short and imperative, with a Jira key when there is one: `[NL8VPS4-800] Fixed PHP 7 compatibility`, `Add description to licences`.
- Releases are tags named after the version (e.g. `6.54.10`). Tag pipelines run `validate tag-message` (`ci/validate_tag_message.sh`: the tag message must not be the default merge text), `validate tag-version-consistency` (`ci/ValidateTagVersionConsistency.php`: tag, with any leading `v` stripped, must equal `TRANSIP_API_LIBRARY_VERSION`), then `deploy deploy-to-github` and `release release-to-github`.
- `ci/deploy_to_github.sh` pushes all GitLab branches and tags to the public `github.com/transip/transip-api-php` mirror, so anything pushed to a branch here becomes public on the next release.
