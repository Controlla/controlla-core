<?php

namespace Controlla\Core\Services;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Controlla\Core\Repositories\BaseRepositoryInterface;

class BaseService implements BaseServiceInterface
{
    /**
     * @var BaseRepositoryInterface
     */
    protected $repository;

    /**
     * Get paginated results
     *
     * @param Request $request
     * @param int $pageSize
     * @return mixed
     */
    public function getAllPaginated(Request $request, int $pageSize = 20): mixed
    {
        return $this->repository->getAllPaginated($request, $pageSize);
    }

    /**
     * Find an item by id
     *
     * @param  mixed  $id
     * @return Model|null
     */
    public function find($id)
    {
        return $this->repository->find($id);
    }

    /**
     * Find an item by id or fail
     *
     * @param  mixed  $id
     * @return Model|null
     */
    public function findOrFail($id)
    {
        return $this->repository->findOrFail($id);
    }

    /**
     * Return all items
     *
     * @return Collection|null
     */
    public function all()
    {
        return $this->repository->all();
    }

    /**
     * Create an item
     *
     * @return Model|null
     */
    public function create(array $data)
    {
        $this->repository->create($data);
    }

    /**
     * Update a model
     *
     * @param  int|mixed  $id
     * @return void
     */
    public function update($id, array $data)
    {
        $this->repository->update($id, $data);
    }

    /**
     * Delete a model
     *
     * @param  int|Model  $id
     * @return void
     */
    public function delete($id)
    {
        $this->repository->delete($id);
    }

    /**
     * multiple delete
     *
     * @return void
     */
    public function destroy(array $id)
    {
        $this->repository->destroy($id);
    }
}
