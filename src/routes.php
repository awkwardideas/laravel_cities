<?php

Route::group(['prefix' => 'api/geo', 'middleware' => 'api'], function(){
	Route::get('search/{name}/{parent_id?}', 	'AwkwardIdeas\LaravelCities\GeoController@search');
	Route::get('item/{id}', 		'AwkwardIdeas\LaravelCities\GeoController@item');
	Route::get('children/{id}', 	'AwkwardIdeas\LaravelCities\GeoController@children');
	Route::get('parent/{id}', 		'AwkwardIdeas\LaravelCities\GeoController@parent');
	Route::get('country/{code}', 	'AwkwardIdeas\LaravelCities\GeoController@country');
	Route::get('countries', 		'AwkwardIdeas\LaravelCities\GeoController@countries');
});

