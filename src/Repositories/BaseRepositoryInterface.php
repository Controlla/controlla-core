<?php

namespace Controlla\Core\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface BaseRepositoryInterface
{
    /**
     * Fin an item by id
     *
     * @param  mixed  $id
     * @return Model|null
     */
    public function find($id);

    /**
     * find or fail
     *
     * @param  mixed  $id
     * @return mixed
     */
    public function findOrFail($id);

    /**
     * Return all items
     *
     * @return Collection|null
     */
    public function all();

    /**
     * Create an item
     *
     * @return Model|null
     */
    public function create(array $data);

    /**
     * Update a model
     *
     * @param  int|mixed  $id
     * @return bool|mixed
     */
    public function update($id, array $data);

    /**
     * Delete a model
     *
     * @param  int|Model  $id
     */
    public function delete($id);

    /**
     * multiple delete
     *
     * @return mixed
     */
    public function destroy(array $id);
}
