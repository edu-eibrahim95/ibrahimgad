<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Requests\CrudRequest;
class MomentCrudController extends CrudController
{
    public function setup() {
        $this->crud->setModel('App\Moment');
        $this->crud->setRoute(config('backpack.base.route_prefix')  . '/moment');
        $this->crud->setEntityNameStrings('moment', 'moments');

        $this->crud->setColumns(['title', 'caption', 'video']);
        $this->crud->addField([
			'name' => 'title',
			'label' => 'Title'
			]);
        $this->crud->addField([
			'name' => 'caption',
			'label' => 'Caption'
			]);
        $this->crud->addField([
			'name' => 'video',
			'label' => 'Video',
			'type' => 'upload',
			'upload' => true,
			]);
    }
    public function store(CrudRequest $request)
	{
		return parent::storeCrud();
	}

	public function update(CrudRequest $request)
	{
		return parent::updateCrud();
	}
}
