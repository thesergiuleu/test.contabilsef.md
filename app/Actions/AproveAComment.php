<?php


namespace App\Actions;


use TCG\Voyager\Actions\AbstractAction;

class AproveAComment extends AbstractAction
{

    public function getTitle()
    {
        return $this->data->is_approved == 1 ? 'Ascunde' : 'Afiseaza';
    }

    public function getIcon()
    {
        return 'voyager-params';
    }

    public function getDefaultRoute()
    {
        return route('comment.change_status', $this->data->id);
    }


    public function getAttributes()
    {
        return [
            'class' => $this->data->is_approved == 1 ? 'btn btn-sm btn-warning pull-right warning' : 'btn btn-sm btn-info pull-right edit',
        ];
    }

    public function shouldActionDisplayOnDataType()
    {
        return $this->dataType->slug == 'comments';
    }
}
