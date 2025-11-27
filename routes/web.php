<?php

/*
|--------------------------------------------------------------------------
| AUTHENTICATION ROUTES
|--------------------------------------------------------------------------
| Handles user authentication: login, registration, password resets
| and other auth-related endpoints.
*/

require __DIR__ . '/authRoutes.php';

/*
|--------------------------------------------------------------------------
| ECOMMERCE MODULE WEB ROUTES
|--------------------------------------------------------------------------
| Loads the ECOMMERCE module routes (product listing, cart,
| checkout, product details and storefront endpoints).
*/

require __DIR__ . '/../app/Modules/ECOMMERCE/Routes/Web.php';

/*
|--------------------------------------------------------------------------
| INVENTORY MODULE WEB ROUTES
|--------------------------------------------------------------------------
| Loads inventory management routes (stock, warehouses,
| product variants and inventory operations).
*/

require __DIR__ . '/../app/Modules/INVENTORY/Routes/Web.php';

/*
|--------------------------------------------------------------------------
| CRM MODULE WEB ROUTES
|--------------------------------------------------------------------------
| Loads CRM module routes (customers, leads, contacts,
| and related CRM functionality).
*/

require __DIR__ . '/../app/Modules/CRM/Routes/Web.php';


/*
|--------------------------------------------------------------------------
| ACCOUNTS MODULE ROUTES
|--------------------------------------------------------------------------
| Loads accounting-related routes (vouchers, transactions,
| reports and account management endpoints).
*/

require __DIR__ . '/../app/Modules/ACCOUNTS/Routes/Web.php';

/*
|--------------------------------------------------------------------------
| MLM MODULE ROUTES
|--------------------------------------------------------------------------
| Loads MLM module routes (network, commissions,
| agent management and related endpoints).
*/

require_once __DIR__ . '/../app/Modules/MLM/Routes/Web.php';

/*
|--------------------------------------------------------------------------
| PAYMENT ROUTES
|--------------------------------------------------------------------------
| Payment gateway callbacks, checkout processing and
| payment-related webhooks and endpoints.
*/

require __DIR__ . '/paymentRoutes.php';

/*
|--------------------------------------------------------------------------
| GENERAL ROUTES
|--------------------------------------------------------------------------
| Miscellaneous application routes: backups, SMS services,
| and other general-purpose endpoints.
*/

require __DIR__ . '/generalRoutes.php';


/*
|--------------------------------------------------------------------------
| CLEAR CACHE ROUTES
|--------------------------------------------------------------------------
| Utility routes to view and clear application cache and
| other maintenance helpers (development use only).
*/

require __DIR__ . '/cache.php';
