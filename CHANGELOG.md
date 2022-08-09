CHANGELOG
=========
6.27.1
-----
* Fixed action on ssl reissue

6.27.0
-----
* Added domain auth-code endpoint
* Updated Mailbox entity to inclue webmail url
* Fixed missing (re)issue functionality for SSL certificates

6.26.0
-----
* Added Domain.hasDnsSec
* Added Domain.canEditDns

6.24.0
-----
* Added an endpoint for operating system filtering on specs
* Added isDefault option to the SSH keys endpoint.

6.23.0
-----
* Added ssl certificate install/uninstall endpoint

6.22.0
-----
* Added domain handover
* Fixed incorrect type on MailList.setId

6.21.0
-----
* Added default domain contacts endpoint

6.19.0
-----
* Added includes to Domain

6.18.0
-----
* Added colocation access request endpoint

6.17.0
-----
* Added vps settings and rescue image endpoints

6.16.3
-----
* Removed unneeded composer.lock

6.16.2
-----
* Added status to domain entity

6.16.1
-----
* Added IMAP, SMTP and POP3 information to mailbox resource

6.16.0
-----
* Added ssl certificate details endpoint

6.15.1
-----
* bump symfony/cache to 6.0 compatibility

6.15.0
-----
* Added ssl endpoints
* Added email endpoints

6.14.0
-----
* Added licenses parameter to vps order resource

6.13.0
-----
* You can now provide a license to override the default license of a preinstallable operating system when invoking a reinstall

6.12.1
-----
* Fixed a json serializable return datatype deprecation that occurred when running on PHP 8.1

6.12.0
-----
* Added OpenStack resource

6.11.0
-----
* Added destination big storage name for backup restore

6.10.0
-----
* Added support for Domain AutoDNS

6.9.2
-----
* Fixed a bug where a custom Guzzle Client will always get overridden.
* Fixed an issue where you were only able to use the Guzzle http client implementation.

6.9.1
-----
* Added support for ALIAS DNS resource record

6.9.0
-----
* Added support for NAPTR DNS resource record

6.8.0
-----
* Added getByVpsName method to the OperatingSystem resource
* Added minQuantity to the LicenceProduct
* Deprecated Traffic endpoint in favor of TrafficPool endpoint

6.7.2
-----
* Access token automatically renews when it is revoked

6.7.1
-----
* Added getRdata function in DnsEntry

6.7.0
-----
* Fixed minor bug in getAll for vpsOperatingSystems
* Added a reset function for the VpsFirewall 

6.6.3
-----
* Added support for using your own GuzzleClient and HttpClient

6.6.2
-----
* Added isDefault property to SshKey 

6.6.1
-----
* Enabled PHP 8.0 support 

6.6.0
-----
* Added VPS license resource

6.5.0
-----
* Added isLocked property to HA-IP

6.4.0
-----
* Added UUID property to VPS

6.3.0
-----
* Added tls mode property to HA-IP

6.2.0
-----
- Added the serial property to BigStorage

6.1.0
-----
- Added SSH Keys resource
- Added CloudInit installation functionality to order and install VPS resource
- Deprecated isPreinstallableImage getter in OperatingSystem Entity
- Added Bigstorage description argument to order resource

6.0.3
-----
- You can optionally set a token expiry time
- Fix in PrivateNetwork attach/detach methods

6.0.2
-----
- Merged v6.0 restapi-php-library into v5.18 transip-api-php repository
- Changed entity properties to protected

6.0.1
-----
- Added search by tag for domain(s) and VPS(s)
- Added test and demo mode
- Added access to rate limit statistics

6.0.0 PHP RestAPI Library
-----

- API is now RESTful
- Token based authentication
- IP Ranges are now allowed in the whitelist

- Added new functionality for:
    - Bigstorage
        - order/cancel/upgrade
        - backups
    - Haip
        - Lets Encrypt wildcard support
    - Invoices
        - invoiceItems
        - PDF
    - Products
        - specifications
    - Vps
        - firewall
        - VNC
        - statistics (cpu, io, network)
        - TCP Monitoring
        - tags
        - mailservice

- discontinued:
    - webhosting
    
    
5.x and older
-----

This changelog is a continuance of the SOAP API PHP Library. To see further back on features implemented in the past, see the changelog in the v5.x tag.
