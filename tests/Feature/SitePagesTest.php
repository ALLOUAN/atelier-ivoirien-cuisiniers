<?php

namespace Tests\Feature;

use App\Support\AtelierCuisiniers;
use Tests\TestCase;

class SitePagesTest extends TestCase
{
    public function test_every_page_renders_without_being_indexed(): void
    {
        foreach (AtelierCuisiniers::PAGES as $slug => $page) {
            $this->get(route('page', $slug === '' ? [] : ['page' => $slug]))
                ->assertOk()
                ->assertSee('<meta name="robots" content="noindex, nofollow">', false)
                ->assertSeeText($page['title']);
        }
    }

    public function test_training_page_shows_its_programme(): void
    {
        $this->get(route('training', 'cuisinier-professionnel'))
            ->assertOk()
            ->assertSeeText('Cuisinier professionnel')
            ->assertSeeText('Stage en restaurant partenaire et examen final');
    }

    public function test_every_photo_used_by_the_site_exists(): void
    {
        $site = new AtelierCuisiniers;
        $photos = collect([
            ...array_column($site->trainings(), 'image'),
            ...collect($site->menu())->flatten(1)->pluck('image')->filter(),
            ...array_column($site->cateringPackages(), 'image'),
            ...array_column($site->successes(), 'image'),
            ...array_column($site->gallery(), 'image'),
            ...array_column($site->banners(), 'image'),
            ...AtelierCuisiniers::PAGE_PHOTOS,
            'salle', 'cuisiniere2', 'sauce-graine1',
        ])->unique();

        foreach ($photos as $photo) {
            $this->assertFileExists(public_path("images/{$photo}.jpg"));
        }

        $this->get(route('page'))->assertSee($site->photo('banniere-formation'), false);
    }

    public function test_unknown_pages_are_not_found(): void
    {
        $this->get('/inconnue')->assertNotFound();
        $this->get(route('training', 'inconnue'))->assertNotFound();
    }
}
