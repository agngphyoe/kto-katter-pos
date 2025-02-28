<?php

namespace App\Actions;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

trait GlobalCompanyScope
{
    protected static function bootAction()
    {
        // static::addGlobalScope('company_scope', function (Builder $builder) {
        //     $builder->where('company_id', Auth::user()?->company_id);
        // });

        static::updated(function ($model) {

            (new StoreActivityLog())->store(model: $model, title: class_basename(self::class) . ' Updated', activity: 'Update');
        });

        static::deleted(function ($model) {

            (new StoreActivityLog())->store(model: $model, title: class_basename(self::class) . ' Deleted', activity: 'Delete');
        });
    }

    protected static function bootCreatedAction()
    {
        static::creating(function ($model) {
            $model->created_by = Auth::user()?->id;
            // $model->company_id = Auth::user()?->company_id;
        });


        if (!app()->runningInConsole()) {
            static::created(function ($model) {
                (new StoreActivityLog())->store(model: $model, title: class_basename(self::class) . ' Created', activity: 'Create');
            });
        }
    }

    protected static function bootCreatedMorphAction()
    {
        static::creating(function ($model) {
            $user = Auth::user();
            $className = get_class($user);
            $model->createable_type = $className;
            $model->createable_id = Auth::user()?->id;
            // $model->company_id = Auth::user()?->company_id;
        });
        if (!app()->runningInConsole()) {
            static::created(function ($model) {

                (new StoreActivityLog())->store(model: $model, title: class_basename(self::class) . ' Created', activity: 'Create');
            });
        }
    }
}
