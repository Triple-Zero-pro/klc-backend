<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\AdminRepositoryRepository;
use App\Entities\AdminRepository;
use App\Validators\AdminRepositoryValidator;

/**
 * Class AdminRepositoryRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class AdminRepositoryRepositoryEloquent extends BaseRepository implements AdminRepositoryRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return AdminRepository::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
