<?php

namespace App\Providers;

use App\Models\Education;
use App\Models\Experience;
use App\Models\Project;
use App\Models\Skill;
use App\Models\SocialLink;
use App\Policies\EducationPolicy;
use App\Policies\ExperiencePolicy;
use App\Policies\ProjectPolicy;
use App\Policies\SkillPolicy;
use App\Policies\SocialLinkPolicy;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }

    protected function registerPolicies(): void
    {
        \Illuminate\Support\Facades\Gate::policy(Skill::class, SkillPolicy::class);
        \Illuminate\Support\Facades\Gate::policy(Experience::class, ExperiencePolicy::class);
        \Illuminate\Support\Facades\Gate::policy(Education::class, EducationPolicy::class);
        \Illuminate\Support\Facades\Gate::policy(Project::class, ProjectPolicy::class);
        \Illuminate\Support\Facades\Gate::policy(SocialLink::class, SocialLinkPolicy::class);
    }
}
