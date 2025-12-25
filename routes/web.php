<?php

use App\Http\Controllers\CarController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StripePaymentController;
use App\Http\Controllers\WatchlistController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/', [HomeController::class, 'index'])->name('homepage');

Route::get('/car/search', [CarController::class, 'search'])->name('car.search');

// AUTHENTICATED and VERIFIED users
Route::middleware(['auth'])->group(callback: function () {
    Route::middleware(['verified'])->group(function () {
        Route::get('/watchlist', [WatchlistController::class, 'index'])
            ->name('watchlist.index');
        Route::post('/watchlist/{car}', [WatchlistController::class, 'storeDestroy'])
            ->name('watchlist.storeDestroy');

        Route::resource('car', CarController::class)->except(['show']);
        Route::get('/car/{car}/images', [CarController::class, 'carImages'])
            ->name('car.images');
        Route::put('/car/{car}/images', [CarController::class, 'updateImages'])
            ->name('car.updateImages');
        Route::post('/car/{car}/images', [CarController::class, 'addImages'])
            ->name('car.addImages');

        // Stripe Payment Routes
        Route::post('/stripe/checkout/{car}', [StripePaymentController::class, 'createCheckoutSession'])
            ->name('stripe.checkout');
        Route::get('/stripe/success', [StripePaymentController::class, 'success'])
            ->name('stripe.success');

        // Notification Routes
        Route::prefix('notifications')->name('notifications.')->group(function () {
            Route::get('/', [NotificationController::class, 'index'])->name('index');
            Route::get('/unread-count', [NotificationController::class, 'unreadCount'])->name('unread-count');
            Route::post('/{id}/read', [NotificationController::class, 'markAsRead'])->name('mark-read');
            Route::post('/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('mark-all-read');
            Route::delete('/{id}', [NotificationController::class, 'destroy'])->name('destroy');
            Route::delete('/clear-read/all', [NotificationController::class, 'clearRead'])->name('clear-read');
        });
    });

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])
        ->name('profile.updatePassword');
});

Route::get('/car/{car}', [CarController::class, 'show'])->name('car.show');
Route::post('/car/phone/{car}', [CarController::class, 'showPhone'])->name('car.showPhone');

// Stripe Webhook (no auth/CSRF protection)
Route::post('/stripe/webhook', [StripePaymentController::class, 'webhook'])
    ->name('stripe.webhook')
    ->withoutMiddleware(['web']);

// to download files
Route::get('/download-cv', function () {
    return Storage::download('CA-f.pdf');
})->name('download.cv');

// Legal & Compliance pages
Route::view('/privacy', 'components.legal.privacy')->name('privacy');
Route::view('/mentions-legales', 'components.legal.mentions-legales')->name('mentions-legales');
Route::view('/cookies', 'components.legal.cookies')->name('cookies');

Route::get('/docs', function () {
    return view('components.documentation');
})->name('docs');
Route::get('/docs-fr', function () {
    return view('components.documentation-fr');
})->name('docs.fr');
Route::get('erd', function () {
    return view('components.db-schema');
})->name('erd');

// Monitoring dashboards (local environment only for now)
if (app()->environment('local')) {
    Route::get('/pulse', function () {
        return view('pulse::dashboard');
    })->name('pulse');
    
    // Sentry Test Routes (local only)
    Route::prefix('sentry-test')->group(function () {
        Route::get('/exception', function () {
            throw new \Exception('Test Exception: This is a test error sent to Sentry');
        })->name('sentry.test.exception');
        
        Route::get('/error', function () {
            trigger_error('Test Error: This is a test PHP error', E_USER_ERROR);
        })->name('sentry.test.error');
        
        Route::get('/warning', function () {
            trigger_error('Test Warning: This is a test PHP warning', E_USER_WARNING);
        })->name('sentry.test.warning');
        
        Route::get('/breadcrumbs', function () {
            \Sentry\addBreadcrumb(new \Sentry\Breadcrumb(
                \Sentry\Breadcrumb::LEVEL_INFO,
                \Sentry\Breadcrumb::TYPE_USER,
                'user',
                'User visited test page'
            ));
            
            \Sentry\addBreadcrumb(new \Sentry\Breadcrumb(
                \Sentry\Breadcrumb::LEVEL_INFO,
                \Sentry\Breadcrumb::TYPE_NAVIGATION,
                'navigation',
                'Navigated to breadcrumbs test'
            ));
            
            \Sentry\captureMessage('Test Message with Breadcrumbs', \Sentry\Severity::info());
            
            return response()->json([
                'message' => 'Message with breadcrumbs sent to Sentry',
                'check' => 'View your Sentry dashboard'
            ]);
        })->name('sentry.test.breadcrumbs');
        
        Route::get('/context', function () {
            \Sentry\configureScope(function (\Sentry\State\Scope $scope): void {
                $scope->setUser([
                    'id' => auth()->id() ?? 999,
                    'username' => auth()->user()->name ?? 'Test User',
                    'email' => auth()->user()->email ?? 'test@example.com',
                ]);
                
                $scope->setTag('page.locale', 'en');
                $scope->setTag('environment', config('app.env'));
                
                $scope->setContext('character', [
                    'role' => 'tester',
                    'level' => 99,
                    'premium' => true,
                ]);
            });
            
            throw new \RuntimeException('Test Exception with Context and User Info');
        })->name('sentry.test.context');
        
        Route::get('/performance', function () {
            $transaction = \Sentry\startTransaction(
                \Sentry\Tracing\TransactionContext::make()
                    ->setName('Test Performance Transaction')
                    ->setOp('http.server')
            );
            
            \Sentry\SentrySdk::getCurrentHub()->setSpan($transaction);
            
            // Simulate some work
            $span1 = $transaction->startChild(\Sentry\Tracing\SpanContext::make()
                ->setOp('db.query')
                ->setDescription('SELECT * FROM cars LIMIT 10')
            );
            usleep(50000); // 50ms
            $span1->finish();
            
            $span2 = $transaction->startChild(\Sentry\Tracing\SpanContext::make()
                ->setOp('http.client')
                ->setDescription('GET https://api.example.com/data')
            );
            usleep(100000); // 100ms
            $span2->finish();
            
            $transaction->finish();
            
            return response()->json([
                'message' => 'Performance trace sent to Sentry',
                'transaction' => 'Test Performance Transaction',
                'check' => 'View Performance tab in Sentry'
            ]);
        })->name('sentry.test.performance');
        
        Route::get('/capture-message', function () {
            \Sentry\captureMessage('This is a test informational message', \Sentry\Severity::info());
            
            return response()->json([
                'message' => 'Info message captured',
                'check' => 'View Issues in Sentry dashboard'
            ]);
        })->name('sentry.test.message');
    });
}

require __DIR__.'/auth.php';
