<?php



/*
|--------------------------------------------------------------------------
| ECOMMERCE Module Web Routes
|--------------------------------------------------------------------------
*/
require __DIR__ . '/../app/Modules/ECOMMERCE/Routes/Web.php';

/*
|--------------------------------------------------------------------------
| CRM Module Web Routes
|--------------------------------------------------------------------------
*/



//auth routes
require __DIR__ . '/authRoutes.php';

//dashboard routes 
require __DIR__ . '/dashboardRoutes.php';



require __DIR__ . '/../app/Modules/CRM/Routes/Web.php';

// payment routes
require __DIR__ . '/paymentRoutes.php';



//inventory routes
require __DIR__ . '/inventoryRoutes.php';

//accounts routes
require __DIR__ . '/accountRoutes.php';



//role and permission routes
require __DIR__ . '/rolePermissionRoutes.php';

//website config routes
require __DIR__ . '/WebConfigRoutes.php';

//cms routes
require __DIR__ . '/cmsRoutes.php';

//clear cache routes
require __DIR__ . '/cache.php';

//general routes
require __DIR__ . '/generalRoutes.php';
//mlm routes
require_once __DIR__ . '/../app/Modules/MLM/Settings/Routes/Index.php';
