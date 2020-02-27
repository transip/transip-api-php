<?php

namespace Transip\Api\Library\Entity\Domain;

use Transip\Api\Library\Entity\AbstractEntity;

class Branding extends AbstractEntity
{
    /**
     * @var string $companyName
     */
    protected $companyName;

    /**
     * @var string $supportEmail
     */
    protected $supportEmail;

    /**
     * @var string $companyUrl
     */
    protected $companyUrl;

    /**
     * @var string $termsOfUsageUrl
     */
    protected $termsOfUsageUrl;

    /**
     * @var string $bannerLine1
     */
    protected $bannerLine1;

    /**
     * @var string $bannerLine2
     */
    protected $bannerLine2;

    /**
     * @var string $bannerLine3
     */
    protected $bannerLine3;

    public function getCompanyName(): string
    {
        return $this->companyName;
    }

    public function setCompanyName(string $companyName): Branding
    {
        $this->companyName = $companyName;
        return $this;
    }

    public function getSupportEmail(): string
    {
        return $this->supportEmail;
    }

    public function setSupportEmail(string $supportEmail): Branding
    {
        $this->supportEmail = $supportEmail;
        return $this;
    }

    public function getCompanyUrl(): string
    {
        return $this->companyUrl;
    }

    public function setCompanyUrl(string $companyUrl): Branding
    {
        $this->companyUrl = $companyUrl;
        return $this;
    }

    public function getTermsOfUsageUrl(): string
    {
        return $this->termsOfUsageUrl;
    }

    public function setTermsOfUsageUrl(string $termsOfUsageUrl): Branding
    {
        $this->termsOfUsageUrl = $termsOfUsageUrl;
        return $this;
    }

    public function getBannerLine1(): string
    {
        return $this->bannerLine1;
    }

    public function setBannerLine1(string $bannerLine1): Branding
    {
        $this->bannerLine1 = $bannerLine1;
        return $this;
    }

    public function getBannerLine2(): string
    {
        return $this->bannerLine2;
    }

    public function setBannerLine2(string $bannerLine2): Branding
    {
        $this->bannerLine2 = $bannerLine2;
        return $this;
    }

    public function getBannerLine3(): string
    {
        return $this->bannerLine3;
    }

    public function setBannerLine3(string $bannerLine3): Branding
    {
        $this->bannerLine3 = $bannerLine3;
        return $this;
    }
}
