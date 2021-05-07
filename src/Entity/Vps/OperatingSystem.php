<?php

namespace Transip\Api\Library\Entity\Vps;

use Transip\Api\Library\Entity\AbstractEntity;

class OperatingSystem extends AbstractEntity
{
    public const INSTALL_FLAVOUR_INSTALLER      = 'installer';
    public const INSTALL_FLAVOUR_PREINSTALLABLE = 'preinstallable';
    public const INSTALL_FLAVOUR_CLOUDINIT      = 'cloudinit';

    /**
     * @var string $name
     */
    protected $name;

    /**
     * @var string $description
     */
    protected $description;

    /**
     * @var string $version
     */
    protected $version;

    /**
     * @var int $price
     */
    protected $price;

    /**
     * @var string[]
     */
    protected $installFlavours = [];

    /**
     * @var LicenseProduct[]
     */
    protected $licenses = [];

    public function __construct(array $valueArray = [])
    {
        $licenses = $valueArray['licenses'] ?? [];
        foreach ($licenses as $license) {
            $this->licenses[] = new LicenseProduct($license);
        }
        unset($valueArray['licenses']);
        parent::__construct($valueArray);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @deprecated use getInstallFlavours() instead
     * @return bool
     */
    public function isPreinstallableImage(): bool
    {
        return in_array(self::INSTALL_FLAVOUR_PREINSTALLABLE, $this->getInstallFlavours(), true);
    }

    public function getVersion(): string
    {
        return $this->version;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getInstallFlavours(): array
    {
        return $this->installFlavours;
    }

    /**
     * @return LicenseProduct[]
     */
    public function getLicenses(): array
    {
        return $this->licenses;
    }
}
