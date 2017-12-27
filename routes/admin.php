<?php 
CRUD::resource('moment', 'MomentCrudController');
Route::get('register',function () {return redirect("/admin");})->name('backpack.auth.register');