<?php

namespace App\Http\Controllers;

use App\Support\AtelierCuisiniers;
use Illuminate\View\View;

/**
 * Site of "Atelier Ivoirien Des Cuisiniers": static pages, sample content, no database.
 */
class SiteController extends Controller
{
    public function __construct(private AtelierCuisiniers $site) {}

    public function page(string $page = ''): View
    {
        abort_unless(isset(AtelierCuisiniers::PAGES[$page]), 404);

        return $this->render($page, AtelierCuisiniers::PAGES[$page]);
    }

    public function training(string $slug): View
    {
        $training = $this->site->training($slug);

        abort_if($training === null, 404);

        return $this->render('formations', [
            'view' => 'formation',
            'title' => $training['title'],
            'description' => $training['summary'],
        ], ['training' => $training, 'pagePhoto' => $training['image']]);
    }

    /**
     * @param  array{view: string, title: string, description: string}  $meta
     * @param  array<string, mixed>  $data
     */
    private function render(string $page, array $meta, array $data = []): View
    {
        return view('site.'.$meta['view'], [
            'site' => $this->site,
            'business' => $this->site->business(),
            'currentPage' => $page,
            'pageTitle' => $meta['title'],
            'pageDescription' => $meta['description'],
            'pagePhoto' => AtelierCuisiniers::PAGE_PHOTOS[$page] ?? null,
            ...$data,
        ]);
    }
}
