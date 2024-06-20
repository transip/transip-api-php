CHANGELOG
=========

6.51.4
---
* Upgrade/Downgrade acronis products

6.51.3
---
* Order and cancel acronis products

6.51.2
---
* Add acronisTenantId field to operating system install

6.51.1
---
* Add IsSelfManaged field to Acronis Tenant

6.51.0
---
* Added the `reboot` function in the KubernetesNodeRepository

6.50.1
---
* Add Description field to Acronis Tenant

6.50.0
---
* Add Acronis API Resources

6.49.10
---
* Add connectedVpses field to PrivateNetwork information

6.49.9
---
* Decode the JWT payload with URL-safe Base64

6.49.8
---
* Added the `createdAt` field to the VPS model 

6.49.7
---
* Added the `getByIdentifier` function in the VPS repository 

6.49.6
---
* Add contact key endpoint

6.49.5
---
* Added `installFields` field in operating systems endpoint

6.49.4
---
* Add compatibility for Symfony 7.x (https://github.com/transip/transip-api-php/pull/30)

6.49.3
---
* Added the `hashedPassword` property to installs and new VPS orders

6.49.2
---
* Added the `region` property and getter to the OpenStackProject entity

6.49.1
---
* Renamed block storage diskSize parameters to size

6.49.0
---
* Added ability to fetch Action from Operating Install

6.48.9
---
* Added `retentionType` backups property and getter

6.48.8
---
* Fix Kubernetes Cluster release endpoint

6.48.7
---
* Added `updateField` method for mailboxes endpoint

6.48.6
---
* Added block storage offsite backups property and getter

6.48.5
---
* Added block storage product type getter

6.48.4
---
* Added new block storage resource. Deprecated big storage methods.

6.48.3
---
* Fixed naming convention totp tokens.

6.48.2
---
* Allowed the possibility to order a VPS without an Operating System.

6.48.1
---
* Totp identification status key added for the user.

6.48.0
---
* Totp Enabled/Disabled functionality added.

6.47.1
---
* Altered Operating System resource to also show the basename

6.47.0
----
* Add resource to list available releases for upgrade of a Kubernetes cluster (experimental)
* Add resource action to upgrade a Kubernetes cluster (experimental)

6.46.0
----
* Fixed price information in Kubernetes products endpoint (experimental)

6.45.0
----
* Added ssh key support to rescue images

6.44.0
----
* Added Kubernetes releases endpoint (experimental)

6.43.0
----
* Added pvc and service naming to BlockStorage and LoadBalancer (experimental)

6.42.0
----
* Added domain property to openstack

6.41.0
----
* Added Kubernetes cluster reset (experimental)

6.40.0
----
* Added Kubernetes events (experimental)

6.39.0
----
* Added Kubernetes Labels and Taints (experimental)

6.38.0
----
* Add status-reports subresource for Kubernetes load balancers (experimental)

6.37.2
----
* Get multiple nodes by UUID (experimental)

6.37.1
----
* Get Kubernetes load balancers by UUID (experimental)

6.37.0
----
* Added more info for the Kubernetes loadbalancer (experimental)

6.36.0
----
* Added stats for Kubernetes block storages (experimental)

6.35.2
----
* Fixed typos in the Kubernetes product entities (experimental)

6.35.1
----
* Removed broken/missing methods from experimental Kubernetes load balancers repository (experimental)

6.35.0
----
* Added Kubernetes alpha load balancers endpoint (experimental)

6.34.0
----
* Implemented Kubernetes alpha product endpoint (experimental)

6.33.0
----
* Added the Action resource
* Added example of how to use the Action resource
* Added util function that allows to fetch the action from responses
* Changed the return type of currently available actions to Response

6.32.0
----
* Relocated a number of resources related to the Kubernetes alpha (experimental)

6.31.0
----
* Implement Kubernetes alpha node statistics resource (experimental)

6.30.1
----
* Fixed naming convention assignable users

6.30.0
----
* Added Assignable Openstack Users Repository

6.29.3
----
* Add Kubernetes alpha resources (experimental)

6.29.2
----
* Fixed getEntries in certain conditions on mailLists.

6.29.1
-----
* Added type to the Openstack Project entity

6.29.0
-----
* Changed used resource parameter name in MailListRepository
* Changed behaviour of MailListRepository::update, now expects MailList entity

6.28.0
-----
* Implemented Object Store functionality
* Added token endpoint to Openstack

6.27.1
-----
* Fixed action on ssl reissue

6.27.0
-----
* Added domain auth-code endpoint
* Updated Mailbox entity to include webmail url
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
