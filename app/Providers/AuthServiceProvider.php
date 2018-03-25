<?php

namespace EmergencyExplorer\Providers;

use EmergencyExplorer\Models\Image;
use EmergencyExplorer\Models\Invitation;
use EmergencyExplorer\Models\Project;
use EmergencyExplorer\Models\Release;
use EmergencyExplorer\Models\User;
use EmergencyExplorer\Policies\ImagePolicy;
use EmergencyExplorer\Policies\InvitationPolicy;
use EmergencyExplorer\Policies\ProjectPolicy;
use EmergencyExplorer\Policies\ReleasePolicy;
use EmergencyExplorer\Policies\UserPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Invitation::class => InvitationPolicy::class,
        Project::class => ProjectPolicy::class,
        Release::class => ReleasePolicy::class,
        Image::class => ImagePolicy::class,
        User::class => UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
