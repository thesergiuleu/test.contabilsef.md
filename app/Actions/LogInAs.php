<?php


namespace App\Actions;


use TCG\Voyager\Actions\AbstractAction;

class LogInAs extends AbstractAction
{

    public function getTitle()
    {
        return 'Logheazate ca ' . $this->data->name;
    }

    public function getIcon()
    {
        return 'voyager-params';
    }

    public function getDefaultRoute()
    {
        return route('log-in-as', $this->data->id);
    }


    public function getAttributes()
    {
        return [
            'class' => 'btn btn-sm btn-danger pull-right danger',
        ];
    }

    public function shouldActionDisplayOnDataType()
    {
        return $this->dataType->slug == 'users';
    }
}
