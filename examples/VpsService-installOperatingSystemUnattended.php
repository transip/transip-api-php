<?php

/**
 * This example installs a operating on Vps
 * Note: if the operating system requires a licence, it will be billed automatically
 *
 * @copyright Copyright 2016 TransIP BV
 * @author TransIP BV <support@transip.nl>
 */

// Include vpsservice
require_once('Transip/VpsService.php');

try {
    $base64InstallText = base64_encode('
## Mirror settings
d-i mirror/country string manual
d-i mirror/http/hostname string mirror.transip.net
d-i mirror/http/directory string /debian/debian

## Automatically choose keymapping, since VNC client will translate to the clients one
d-i keymap select us

## Automatically select the networking interface
d-i netcfg/choose_interface select auto

## Install ACPId so the machine is responsive to Ctrl+Alt+Del etc
d-i pkgsel/include string acpid

# Any hostname and domain names assigned from dhcp take precedence over
# values set here. However, setting the values still prevents the questions
# from being shown, even if values come from dhcp.
d-i netcfg/get_hostname string test-vps
d-i netcfg/get_domain string example.com

# Controls whether or not the hardware clock is set to UTC.
d-i clock-setup/utc boolean true

# You may set this to any valid setting for $TZ; see the contents of
# /usr/share/zoneinfo/ for valid values.
d-i time/zone string Europe/Amsterdam

# Controls whether to use NTP to set the clock during the install
d-i clock-setup/ntp boolean true
');

    Transip_VpsService::installOperatingSystemUnattended('vps-name','debian-8',$base64InstallText);
    echo 'Operating system install in progress';
} catch (SoapFault $f) {
    // It is possible that an error occurs when connecting to the TransIP Soap API,
    // those errors will be thrown as a SoapFault exception.
    echo 'An error occurred: ' . $f->getMessage(), PHP_EOL;
}
