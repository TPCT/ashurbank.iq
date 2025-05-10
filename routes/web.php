<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::prefix('{locale?}')
    ->middleware([
        \App\Http\Middleware\SetLocale::class,
        \App\Http\Middleware\StatusChecker::class
    ])
    ->group(function(){
        Route::resource('news', \App\Http\Controllers\NewsController::class)->only([
            'show', 'index'
        ]);

        Route::controller(\App\Http\Controllers\InvestorRelations::class)
            ->prefix('investor-relations')
            ->group(function(){
                Route::get('/', 'index')->name('index');
                Route::get('/financial-statements', 'financialStatements')->name('investor-relations.financial-statements');
                Route::get('/annual-generals', 'annualGenerals')->name('investor-relations.annual-generals');
                Route::get('/shareholders', 'shareholders')->name('investor-relations.shareholders');
            });

        Route::controller(\App\Http\Controllers\BranchesController::class)
            ->prefix('branches')
            ->group(function(){
                Route::get('/', 'index')->name('branches.index');
        });

        Route::controller(\App\Http\Controllers\CareersController::class)
            ->prefix('careers')
            ->group(function(){
                Route::get('/', 'index')->name('careers.index');
                Route::get('/{career}', 'show')->name('careers.show');
                Route::any('/{career}/apply/step-1', 'applyStep1')->name('careers.apply-step-1');
                Route::any('/{career}/apply/step-2', 'applyStep2')->name('careers.apply-step-2');
                Route::any('/{career}/apply/step-3', 'applyStep3')->name('careers.apply-step-3');
            });


        Route::controller(\App\Http\Controllers\SiteController::class)
            ->group(function(){
                Route::get('/', 'index')->name('site.index');
                Route::get('/about-us', 'aboutUs')->name('site.about-us');
                Route::get('/faqs', 'faqs')->name('site.faqs');
                Route::get('/sitemap', 'sitemap')->name('site.sitemap');
                Route::any('/contact-us', 'contactUs')->name('site.contact-us');
                Route::any('/currency-exchange', 'currencyExchange')->name('site.currency-exchange');
                Route::any('/filter', 'filter')->name('site.filter');
            });

        Route::controller(\App\Http\Controllers\OffersController::class)
            ->prefix('offers')
            ->group(function(){
                Route::get('/', 'index')->name('offers.index');
                Route::get('/{page}', 'show')->name('offers.show');
            });

        Route::get('/{page}', [\App\Http\Controllers\SiteController::class, 'show'])->name('page.show');


        Route::controller(\App\Http\Controllers\TransferController::class)
            ->prefix('/{section}/transfers')
            ->group(function(){
                Route::get('/', 'index')->name('transfers.index');
                Route::get('/{transfer}', 'show')->name('transfers.show');
            });

        Route::controller(\App\Http\Controllers\LoansController::class)
            ->prefix('/{section}/loans')
            ->group(function(){
                Route::get('/', 'index')->name('loans.index');
                Route::get('/{loan}', 'show')->name('loans.show');
                Route::any('/{loan}/apply/step-1', 'applyStep1')->name('loans.apply-step-1');
                Route::any('/{loan}/apply/step-2', 'applyStep2')->name('loans.apply-step-2');
                Route::any('/{loan}/apply/step-3', 'applyStep3')->name('loans.apply-step-3');
            });

        Route::controller(\App\Http\Controllers\AccountsController::class)
            ->prefix('/{section}/accounts')
            ->group(function(){
                Route::get('/', 'index')->name('accounts.index');
                Route::get('/{account}', 'show')->name('accounts.show');
                Route::any('/{account}/apply/step-1', 'applyStep1')->name('accounts.apply-step-1');
                Route::any('/{account}/apply/step-2', 'applyStep2')->name('accounts.apply-step-2');
                Route::any('/{account}/apply/step-3', 'applyStep3')->name('accounts.apply-step-3');
                Route::any('/{account}/apply/step-4', 'applyStep4')->name('accounts.apply-step-4');
                Route::any('/{account}/apply/step-5', 'applyStep5')->name('accounts.apply-step-5');
                Route::any('/{account}/apply/step-6', 'applyStep6')->name('accounts.apply-step-6');
            });

        Route::controller(\App\Http\Controllers\CardsController::class)
            ->prefix('/{section}/cards')
            ->group(function(){
                Route::get('/', 'index')->name('cards.index');
                Route::get('/{card}', 'show')->name('cards.show');
                Route::any('/{card}/apply', 'apply')->name('cards.apply');
                Route::any('/{card}/apply/step-1', 'applyStep1')->name('cards.apply-step-1');
                Route::any('/{card}/apply/step-2', 'applyStep2')->name('cards.apply-step-2');
                Route::any('/{card}/apply/step-3', 'applyStep3')->name('cards.apply-step-3');
            });

        Route::controller(\App\Http\Controllers\CalculatorsController::class)
            ->prefix('/internet-banking/calculators')
            ->group(function(){
                Route::any('/', 'index')->name('calculators.index');
                Route::any('/deposits', 'deposits')->name('calculators.deposits');
                Route::any('/{section}/loans', 'loans')->name('calculators.loans');
            });

        Route::fallback([\App\Http\Controllers\SiteController::class, 'show']);
    });
