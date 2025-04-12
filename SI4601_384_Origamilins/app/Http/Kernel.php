protected $routeMiddleware = [
    ...
    'role' => \App\Http\Middleware\RoleMiddleware::class,
    'admin' => \App\Http\Middleware\AdminMiddleware::class
];
