<?php

namespace Controlla\Core\Services;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

interface BaseServiceInterface
{
    /**
     * Get paginated results
     *
     * @param Request $request
     * @param int $pageSize
     * @return mixed
     */
    public function getAllPaginated(Request $request, int $pageSize = 20): mixed;

    /**
     * Find models by attributes
     *
     * @param  mixed  $id
     * @return Model|null
     */
    public function find($id);

    /**
     * Find or fail the model
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
     * Create model
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
