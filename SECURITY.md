# Security Policy
We actively maintin the latest version of our software and back port patches to the older 4.x, 3.x and 2.x versions whenever patching the old version is more feasable than asking the user to upgrade to the latest version.  In other words, although version 4.x is no longer actively supported, if it is possible to offer an update to allow the user to continue using that software without forcing them to upgrade to 5.x, we will do so.  It is, however strongly recommended that you use the latest version.
## Supported Versions

Use this section to tell people about which versions of your project are
currently being supported with security updates.

| Version | Supported          |
| ------- | ------------------ |
| 5.x     | :white_check_mark: |
| <5.x    | :x:                |


## Reporting a Vulnerability

Please report (suspected) security vulnerabilities to mudmin@gmail.com. You will receive a response from us within 48 hours. If the issue is confirmed, we will release a patch as soon as possible depending on complexity but historically within a few days.
# Security Policy

We actively maintain the latest version of UserSpice and do not backport security patches to older versions. However, we are committed to keeping upgrade paths open — UserSpice has one of the most complete version-to-version upgrade histories available, and nearly every version can be upgraded to the current release. See [userspice.com/updates](https://userspice.com/updates/) for the full upgrade history. We strongly recommend upgrading to the latest version rather than remaining on an unsupported release.

## Supported Versions

| Version | Supported          |
| ------- | ------------------ |
| 6.x     | :white_check_mark: |
| < 6.x   | :x:                |

## Upgrading from Older Versions

Sites running **UserSpice < 5.2.6** must apply an API compatibility patch before upgrading, as the API changed in 5.2.6:

- **UserSpice 5** (any version before 5.2.6): apply the [US5 API patch](https://github.com/mudmin/releases/raw/master/hotfix/api_patch_US5.zip)
- **UserSpice 4.4**: apply the [US4.4 API patch](https://github.com/mudmin/releases/blob/master/hotfix/userspice44apipatch.zip)

After applying the appropriate patch, follow the standard upgrade path documented at [userspice.com/updates](https://userspice.com/updates/).

## Reporting a Vulnerability

Please report suspected security vulnerabilities to mudmin@gmail.com. You will receive a response within 48 hours. If the issue is confirmed, we will release a patch as soon as possible — historically within a few days depending on complexity.
