# UserSpice

UserSpice is an open-source PHP user management framework designed to get out of your way so you can focus on building your project.

Unlike other PHP frameworks, UserSpice doesn't force you into specific rewriting rules, template engines, or architectural patterns. You use as much or as little as you need. In most cases, you can control access to your existing pages with a single line of code.

Built on Bootstrap, UserSpice provides a rich set of PHP classes and functions while keeping things modular through a plugin system.

## Key Features

- **User & Permission Management** -- Role-based access control, group permissions, and a full admin dashboard
- **Security Dashboard** -- Detects and recommends security improvements to your configuration
- **Passkey / WebAuthn Support** -- Passwordless authentication using modern browser-based credentials
- **TOTP Two-Factor Authentication** -- Time-based one-time passwords for an extra layer of login security
- **OAuth / Social Login** -- Google login and other OAuth provider integrations
- **Rate Limiting** -- Built-in rate limiting with a dedicated management dashboard
- **Encryption Helpers** -- AES-256-GCM encryption functions (`spiceEncrypt` / `spiceDecrypt`) with automatic key management
- **Plugin System** -- Extend functionality through a modular plugin architecture with a built-in plugin manager
- **Toast Notifications** -- System messages displayed as customizable, positioned toast alerts
- **Passwordless Login** -- Email-based magic-link style login flow
- **Maintenance Mode** -- Lock down your site while keeping admin access, compatible with passkeys/TOTP/OAuth
- **One-Click Updates** -- Built-in update system to keep your installation current

## Recent Highlights (2025 - 2026)

- **6.0.x** -- Security dashboard with auto-detection of config improvements, PHP 8.4/8.5 compatibility, HMAC-encrypted verification codes, WebAuthn CVE mitigation, force password reset, and installer hardening
- **5.9.x** -- Encryption API, Server class for `$_SERVER` sanitization, nonce support, server-side DataTables processing, transaction support, and system messages converted to toasts

## Requirements

- PHP 8.1+ (8.2+ recommended for passkey/TOTP support)
- MySQL / MariaDB
- A web server (Apache, Nginx, etc.)

## Installation

Download the latest release from [UserSpice.com](https://userspice.com) for a properly packaged build, then follow the built-in installer.

## Links

- [Website](https://userspice.com)
- [Bug Tracker / Changelog](https://bugs.userspice.com)
- [Documentation](https://userspice.com/docs)

## License

UserSpice is released under the [GNU General Public License v3.0](https://www.gnu.org/licenses/gpl-3.0.html).
