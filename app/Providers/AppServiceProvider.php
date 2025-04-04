<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Bill;
use App\Models\Expense;
use App\Policies\BillPolicy;
use App\Policies\ExpensePolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Bill::class => BillPolicy::class,
        Expense::class => ExpensePolicy::class,
    ];

    public function boot()
{
    \Blade::directive('getContrastColor', function($hexcolor) {
        return "<?php echo App\Http\Controllers\CategoryController::getContrastColor($hexcolor); ?>";
    });
}
}
