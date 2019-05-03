<?php

namespace App\Repositories;

use Illuminate\Support\Facades\App;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\Contracts\RepositoryInterface;
use Illuminate\Database\Query\Builder;

/**
 * Class BaseRepository
 *
 * @package App\Repositories
 */
class BaseRepository implements RepositoryInterface
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * BaseRepository constructor.
     *
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * get Model
     *
     * @return Model
     */
    public function model()
    {
        return get_class($this->model);
    }

    /**
     * make new Model
     *
     * @return Model
     */
    public function makeModel()
    {
        $this->model = App::make($this->model());

        return $this->model;
    }
    /**
     * reset model query
     *
     * @return void
     */
    public function resetModel()
    {
        $this->makeModel();
    }

    /**
     * @inheritdoc
     */
    public function find(array $conditions = [])
    {
        return $this->model->where($conditions)->get();
    }

    /**
     * @inheritdoc
     */
    public function findOne(array $conditions)
    {
        return $this->model->where($conditions)->first();
    }

    /**
     * @inheritdoc
     */
    public function findById(int $id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * @inheritdoc
     */
    public function create(array $attributes)
    {
        return $this->model->create($attributes);
    }

    /**
     * @inheritdoc
     */
    public function update(Model $model, array $attributes = [])
    {
        return $model->update($attributes);
    }

    /**
     * @inheritdoc
     */
    public function save(Model $model)
    {
        return $model->save();
    }

    /**
     * @inheritdoc
     */
    public function delete(Model $model)
    {
        return $model->delete();
    }

    /**
     * @inheritdoc
     */
    public function get($query)
    {
        return $query->get();
    }

    /**
     * @inheritdoc
     */
    public function destroy(array $ids)
    {
        return $this->model->destroy($ids);
    }

    /**
     * @inheritdoc
     */
    public function findCount(array $conditions)
    {
        return $this->model->where($conditions)->count();
    }

    public function toBase($query)
    {
        return $query->toBase();
    }

    public function updateMultiple(Builder $query, array $attributes = [])
    {
        return $query->update($attributes);
    }

    public function updateOrCreate(array $attributes, array $values)
    {
        return $this->model->updateOrCreate($attributes, $values);
    }

    /**
     * @inheritdoc
     */
    public function findAll($columns = ['*'])
    {
        return $this->model->all($columns);
    }

    /**
     * @inheritdoc
     */
    public function findByIds(array $ids, $columns = ['*'])
    {
        return $this->model->whereIn('id', $ids)->get($columns);
    }
}
