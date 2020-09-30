<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/login', 'UsuariosController@login')->name('login');
Route::get('/logout', 'UsuariosController@logout');
Route::get('/cadastro', 'UsuariosController@cadastro')->name('cadastro');
Route::post('/login/send', 'UsuariosController@ajax');

Route::get('/', 'ContatosController@index')->name('contatos');
Route::get('/contatos', 'ContatosController@index')->name('contatos');
Route::get('/contatos/favoritos', 'ContatosController@favoritos')->name('favoritos');
Route::get('/contatos/novo', 'ContatosController@novo');
Route::get('/contatos/editar/{id}', 'ContatosController@editar');
Route::get('/contatos/detalhe/{id}', 'ContatosController@detalhe');
Route::post('/contatos/send', 'ContatosController@ajax');
