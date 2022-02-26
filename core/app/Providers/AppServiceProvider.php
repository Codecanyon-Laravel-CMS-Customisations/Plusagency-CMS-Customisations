<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\BasicSetting as BS;
use App\BasicExtended as BE;
use App\Social;
use App\Ulink;
use App\Page;
use App\Scategory;
use App\Language;
use App\Menu;
use App\Popup;
use App\Service;

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

    $socials = Social::orderBy('serial_number', 'ASC')->get();
    $langs = Language::all();
    
    //Reduced average querys from 245 to 190
    $this->app->singleton('currentLang', function($app){
      return Language::where('code', session()->get('lang'))->first(); 
    });

    view()->composer('*', function ($view) {
      if (session()->has('lang')) {
        $currentLang = $this->app->make('currentLang');
      } else {
        $currentLang = Language::where('is_default', 1)->first();
      }

      $bs   = $currentLang->basic_setting;
      $be   = $currentLang->basic_extended;
      $bex  = $currentLang->basic_extra;

      $ulinks = $currentLang->ulinks;
      $apopups = $currentLang->popups()->where('status', 1)->orderBy('serial_number', 'ASC')->get();

      if (serviceCategory()) {
        $scats = $currentLang->scategories()->where('status', 1)->orderBy('serial_number', 'ASC')->get();
      }
      $menu = Menu::where('language_id', $currentLang->id)->get();
      if ($menu->count() > 0) {
        $menus = $menu->first()->menus;
      } else {
        $menus = json_encode([]);
      }

      if ($currentLang->rtl == 1) {
        $rtl = 1;
      } else {
        $rtl = 0;
      }

      $view->with('bs', $bs);
      $view->with('be', $be);
      $view->with('bex', $bex);
      if (serviceCategory()) {
        $view->with('scats', $scats);
      }
      $view->with('apopups', $apopups);
      $view->with('ulinks', $ulinks);
      $view->with('menus', $menus);
      $view->with('currentLang', $currentLang);
      $view->with('rtl', $rtl);
    });

    View::share('socials', $socials);
    View::share('langs', $langs);
  }
}
