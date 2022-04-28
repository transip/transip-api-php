<?php

namespace Transip\Api\Library\Repository\Vps;

use Transip\Api\Library\Entity\Vps\Setting;
use Transip\Api\Library\Repository\ApiRepository;
use Transip\Api\Library\Repository\VpsRepository;

class SettingRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'settings';

    /**
     * @return string[]
     */
    protected function getRepositoryResourceNames(): array
    {
        return [VpsRepository::RESOURCE_NAME, self::RESOURCE_NAME];
    }

    /**
     * @param string $vpsName
     * @return Setting[]
     */
    public function getByVpsName(string $vpsName): array
    {
        $settings = [];
        $response      = $this->httpClient->get($this->getResourceUrl($vpsName));
        $settingArray  = $this->getParameterFromResponse($response, 'settings');

        foreach ($settingArray as $setting) {
            $settings[] = new Setting($setting);
        }

        return $settings;
    }

    /**
     * @param string $vpsName
     * @param string $settingName
     * @return Setting
     */
    public function getByVpsNameSettingName(string $vpsName, string $settingName): Setting
    {
        $response  = $this->httpClient->get($this->getResourceUrl($vpsName, $settingName));
        $setting = $this->getParameterFromResponse($response, 'setting');

        return new Setting($setting);
    }

    public function update(string $vpsName, Setting $setting): void
    {
        $url = $this->getResourceUrl($vpsName, $setting->getName());
        $this->httpClient->put($url, ['setting' => $setting]);
    }
}
