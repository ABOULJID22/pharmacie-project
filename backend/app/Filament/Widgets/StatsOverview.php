<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Audit;
use App\Models\User;
use App\Models\FilsDiscussions;
use App\Models\Document;

class StatsOverview extends BaseWidget
{
    protected function getColumns(): int
    {
        return 4;
    }

    protected function getStats(): array
    {
        $user = auth()->user();
        $filterByUser = $user->isAdmin() ? null : $user->id_user;

        // Prépare les requêtes filtrées
        $documentsQuery = Document::query();
        $auditsQuery = Audit::query();
        $usersQuery = User::query();

        if ($filterByUser) {
            $documentsQuery->where('id_uploader', $filterByUser);
            $auditsQuery->where('id_demandeur', $filterByUser);
        }

        $totalDocuments = $documentsQuery->count();
        $totalAudits = $auditsQuery->count();
        $pendingAudits = (clone $auditsQuery)->where('statut', 'en_attente')->count();
        $validatedAudits = (clone $auditsQuery)->where('statut', 'termine')->count();
        $rejectedAudits = (clone $auditsQuery)->where('statut', 'rejected')->count();

        $totalActiveUsers = User::where('is_active', true)->count();
        $totalAudits = Audit::count();
        $totalDiscussions = FilsDiscussions::count();        $stats = [];

        $stats[] = Stat::make(__('all.documents'), number_format($totalDocuments))
            ->description(__('all.documents_description'))
            ->descriptionIcon('heroicon-o-document-text')
            ->color('primary');

       /*  $stats[] = Stat::make(__('all.Audits'), number_format($totalAudits))
            ->description(__("En attente : $pendingAudits | Terminés : $validatedAudits | Rejetés : $rejectedAudits")
            ->descriptionIcon('heroicon-o-clipboard-document-check')
            ->color($totalAudits === 0 ? 'gray' : ($pendingAudits > 0 ? 'warning' : 'success'));
 */
        $stats[] = Stat::make(__('all.active_users'), number_format($totalActiveUsers))
            ->description(__('all.active_users_description'))
            ->descriptionIcon('heroicon-o-users')
            ->color('info');
          $stats[] = Stat::make(__('all.audits'), number_format($totalAudits))
            ->description(__('all.audits_description'))
            ->descriptionIcon('heroicon-o-clipboard-document-check')
            ->color('info');

        $stats[] = Stat::make(__('all.discussions'), number_format($totalDiscussions))
            ->description(__('all.discussions_description'))
            ->descriptionIcon('heroicon-o-chat-bubble-left-ellipsis')
            ->color('primary');

        // Statistique spécifique pour les pharmaciens
        if ($user->isPharmacien()) {
            $totalPharmaciens = User::onlyPharmaciens()->count();
            $stats[] = Stat::make(__('all.pharmacists'), number_format($totalPharmaciens))
                ->description(__('all.pharmacists_description'))
                ->descriptionIcon('heroicon-o-user-group')
                ->color('info');
        }

        // Statistique spécifique pour les admins
        if ($user->isAdmin()) {
            $totalUsers = User::count();
            $stats[] = Stat::make(__('all.registered_users'), number_format($totalUsers))
                ->description(__('all.registered_users_description'))
                ->descriptionIcon('heroicon-o-user')
                ->color('secondary');
        }

        return $stats;
    }

    public static function canAccess(): bool
    {
        return auth()->user()->isAdmin() || auth()->user()->isConseiller();
    }
}