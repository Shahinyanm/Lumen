<?php

namespace App\Repositories;

use App\Interfaces\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Application;

 class BaseRepository  implements BaseRepositoryInterface
{
	// model property on class instances
	protected $model;
//	protected $app;
	// Constructor to bind model to repo
	public function __construct(Application $app)
	{
		$this->model = (new $this->model);
	}

//	abstract public function model();
//
//
//	public function makeModel(){
//		$model = $this->app->make($this->model());
//
//		if (!$model instanceof Model) {
//			return response()->json(['failed',$model.' is not instanceof Model']);
//		}
//
//		return $this->model = $model;
//	}

	public function all()
	{
		return $this->model->all();
	}

	// create a new record in the database
	public function create(array $data)
	{
		return $this->model->create($data);
	}

	// update record in the database
	public function update($id,array $data)
	{
		$record = $this->show($id);
		$record->update($data);
		return  $record;
	}

	// remove record from the database
	public function destroy($id)
	{
		return $this->model->destroy($id);
	}

	// show the record with the given id
	public function show($id)
	{
		return $this->model->findOrFail($id);
	}

	public function findBy($data)
	{
	return $this->model->where($data)->get();
	}

	// Get the associated model
	public function getModel()
	{
		return $this->model;
	}

	// Set the associated model
	public function setModel($model)
	{
		$this->model = $model;
		return $this;
	}

	// Eager load database relationships
	public function with($relations)
	{
		return $this->model->with($relations);
	}
}