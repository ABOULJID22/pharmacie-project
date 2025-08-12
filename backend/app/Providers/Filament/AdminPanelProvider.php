<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Leandrocfe\FilamentApexCharts\FilamentApexChartsPlugin;
use Jeffgreco13\FilamentBreezy\BreezyCore;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('/admin')
           /*  ->login() */
            ->colors([
                'primary' => Color::hex('#3a5a8f'),
            ])
            // ->brandLogo(fn() => view('filament.admin.logo'))
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                //Pages\Dashboard::class,
                \App\Filament\Pages\Profile::class,
            ])
            //->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                \App\Filament\Widgets\StatsOverview::class,
                //\App\Filament\Widgets\Stats::class,
                \App\Filament\Widgets\DocumentChart::class,
                \App\Filament\Widgets\PharmacienInvoicesWidget::class,
                \App\Filament\Widgets\AuditChart::class,
               
            ])

             ->plugins([
                FilamentApexChartsPlugin::make(),
                BreezyCore::make()
                    ->myProfile(
                        shouldRegisterUserMenu: true, // Sets the 'account' link in the panel User Menu (default = true)
                        shouldRegisterNavigation: false, // Adds a main navigation item for the My Profile page (default = false)
                        navigationGroup: 'Settings', // Sets the navigation group for the My Profile page (default = null)
                        hasAvatars: true, // Enables the avatar upload form component (default = false)
                        slug: 'my-profile' // Sets the slug for the profile page (default = 'my-profile')
                    ),
/*                      \BezhanSalleh\FilamentShield\FilamentShieldPlugin::make(),
 */                     
            ])

             ->navigationGroups([
                NavigationGroup::make('Gestion des audits')
                    ->label(fn(): string => __('Gestion des audits'))
                    ->icon('heroicon-o-clipboard-document-check')
                    ->extraTopbarAttributes([
                        'style' => 'order: 1;',
                    ]),
                NavigationGroup::make('Gestion de fichiers')
                    ->label(fn(): string => __('Gestion de fichiers'))
                    ->icon('heroicon-o-folder-open')
                    ->extraTopbarAttributes([
                        'style' => 'order: 2;',
                    ]),
                 NavigationGroup::make('settings')
                    ->label(fn(): string => __('all.settings'))
                    ->icon('heroicon-o-cog-6-tooth')
                    ->extraTopbarAttributes([
                        'style' => 'order: 4;',
                    ]),

          ])
            
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->sidebarCollapsibleOnDesktop()
            ->sidebarWidth('16rem')
            ->databaseNotifications()
            ->authMiddleware([
                Authenticate::class,
            ]);

    }
}
