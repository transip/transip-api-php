CHANGELOG
=========

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
