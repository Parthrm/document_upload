<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ChartAPIController;
use App\Http\Controllers\ChartReportController;
use App\Http\Controllers\documentController;
use App\Http\Controllers\successStoryController;


// document routes 
Route::get('/', [documentController::class,'show_all']);
Route::get('/upload', [documentController::class,'upload']); // return the upload form
Route::post('/store', [documentController::class,'store']); // store the uploaded content
Route::get('/success', [documentController::class,'success']);// show success page
Route::get('/show/{id}', [documentController::class,'show']); // show document
Route::delete('/delete/{id}', [documentController::class,'destroy']); // delete document

// Story routes
Route::get('/successStory',[successStoryController::class,'index']); // show all stories
Route::get('/story/{id}',[successStoryController::class,'show']); // show single
Route::get('/makeStory',[successStoryController::class,'create']); // create story
Route::post('/storeStory',[successStoryController::class,'store']); // store story

// charts routes
Route::get('/all',function(){return view('components.charts.all');}); // charts view
Route::get('/chart-editor',function(){return view('components.charts.chart-editor');}); // charts editor view
// chart apis
Route::get('/chart-data', [ChartAPIController::class, 'getData']);  // get the chart data

// report routes
Route::get('/generate-report', [ReportController::class,'reportEditor']);
Route::get('/generate-report-request', [ReportController::class,'generateReport']);

// Chart-Report routes
Route::get('/chart-report', [ChartReportController::class,'view']);
Route::get('/chart-report/schemes/{id}', [ChartReportController::class, 'getSchemes']); // get the schemes for the given department id
Route::get('/chart-report/result', [ChartReportController::class, 'generateResponse']); // get the schemes for the given department id