<?php

use App\Http\Controllers\documentController;
use App\Http\Controllers\successStoryController;
use Illuminate\Support\Facades\Route;

Route::get('/index', [documentController::class,'show_all']);
Route::get('/', [documentController::class,'show_all']);

// return the upload form
Route::get('/upload', [documentController::class,'upload']);

// store the uploaded content
Route::post('/store', [documentController::class,'store']);

// show success page
Route::get('/success', [documentController::class,'success']);

// show document
Route::get('/show/{id}', [documentController::class,'show']);

// delete document
Route::delete('/delete/{id}', [documentController::class,'destroy']);

// show all stories
Route::get('/successStory',[successStoryController::class,'index']);

// show single
Route::get('/story/{id}',[successStoryController::class,'show']);

// create story
Route::get('/makeStory',[successStoryController::class,'create']);

// store story
Route::post('/storeStory',[successStoryController::class,'store']);

// charts view
Route::get('/charts',function(){return view('components.charts.chart-renderer');});
Route::get('/all',function(){return view('components.charts.all');});
