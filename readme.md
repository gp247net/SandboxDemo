# SandboxDemo - User Guide (English)

The SandboxDemo plugin provides a “sandbox” mechanism to prevent dangerous write/delete operations in demo environments within the GP247 ecosystem.

## 1. Plugin Information
- **Name**: SandboxDemo module
- **Author**: GP247
- **Core Requirement**: >=1.2
- **Path**: `app/GP247/Plugins/SandboxDemo`

## 2. Installation and Activation
1. Ensure the source code is located at `app/GP247/Plugins/SandboxDemo`.
2. Go to the admin Extensions page, find the SandboxDemo plugin and click Install.
3. After installation, click Enable to activate it.
4. When enabled, the `sandbox-demo` middleware will be automatically applied to the following groups: `admin`, `api.extend`, `partner`, `pmo`.

## 3. Sandbox Middleware
- Alias: `sandbox-demo` (registered and attached in `Provider.php`).
- Preconditions: A valid login session (admin/partner/pmo/vendor) and `SANDBOX_DEMO_ENABLED` is enabled.
- Allowed: `GET` requests that are not in the block lists.
- Blocked: Other request methods will return 403 or a JSON response `{ error: 1, msg: "Access denied for sandbox demo" }`.
- Always-block paths: upload delete/move/rename/crop... endpoints for admin, multivendor, partner groups (auto-built from configured prefixes).
- You can extend via:
  - `routeAlwaysAllow()`: allow by route name (highest priority).
  - `pathAlwaysAllow()`: allow by path (highest priority).
  - `routeAlwaysBlock()`: add route names to block.
  - `pathAlwaysBlock()`: add specific paths to block.
  (Allow-list has higher priority than block-list.)

## 4. Development Notes
- Sandbox is designed to protect demo environments by restricting dangerous write/delete behaviors.
- To quickly disable the plugin behavior, set `SANDBOX_DEMO_ENABLED=0` in your .env (you can add the variable if it doesn’t exist).
Note: `SANDBOX_DEMO_ENABLED=0` disables the plugin even if it is enabled in admin.

## 5. Support
- Website: `https://GP247.net`
- Email: `support@gp247.net`