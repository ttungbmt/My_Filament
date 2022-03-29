<?php

namespace App\Providers;

use App\Filament\Pages\ManageAccount;
use App\Filament\Pages\ManageAppearance;
use App\Filament\Pages\ManageEmail;
use App\Filament\Pages\ManageGeneral;
use App\Filament\Pages\ManageSocialLogin;
use App\Filament\Resources\HcPhuongResource;
use App\Filament\Resources\HcQuanResource;
use App\Filament\Resources\HcTinhResource;
use App\Filament\Resources\PostResource;
use Filament\Facades\Filament;
use Filament\Navigation\NavigationBuilder;
use Filament\Navigation\NavigationItem;
use Filament\Navigation\UserMenuItem;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\HtmlString;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {


        Builder::macro('toRawSql', function() {
            return array_reduce($this->getBindings(), function($sql, $binding) {
                return preg_replace('/\?/', is_numeric($binding)
                    ? $binding
                    : "'".$binding."'", $sql, 1);
            }, $this->toSql());
        });

        \Filament\Tables\Filters\SelectFilter::macro('columnSpan', function ($string) {
//            return $prefix . $string;
            return $this;
        });

        Filament::serving(function () {
            Filament::registerTheme(mix('css/app.css'));

            Filament::registerStyles([
                'https://cdn.jsdelivr.net/gh/ttungbmt/typeface-poppins/index.css',
            ]);

            Filament::pushMeta([
                new HtmlString('<meta name="description" content="'.env('APP_NAME').'">'),
            ]);

            Filament::registerScripts([
                'https://cdn.jsdelivr.net/npm/lodash@4.17.21/lodash.min.js',
            ], true);

            Filament::registerUserMenuItems([
                'settings' => UserMenuItem::make()->label('Settings')->url(route('filament.pages.dashboard'))->icon('heroicon-s-cog'),
            ]);

            Filament::navigation(function (NavigationBuilder $builder): NavigationBuilder {
                return $builder
                    ->item(
                        NavigationItem::make()
                            ->label('Dashboard')
                            ->icon('heroicon-o-home')
                            ->isActiveWhen(fn (): bool => request()->routeIs('filament.pages.dashboard'))
                            ->url(route('filament.pages.dashboard')),
                    )
                    ->items(PostResource::getNavigationItems())

                    ->group('Danh mục', [
                        ...HcTinhResource::getNavigationItems(),
                        ...HcQuanResource::getNavigationItems(),
                        ...HcPhuongResource::getNavigationItems(),
                    ])
                    ->group('Settings', [
                        ...ManageGeneral::getNavigationItems(),
                        ...ManageEmail::getNavigationItems(),
                        ...ManageSocialLogin::getNavigationItems(),
//                        ...ManageAccount::getNavigationItems(),
                        ...ManageAppearance::getNavigationItems(),
                    ]);
            });
        });



    }
}
